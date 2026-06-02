<?php

namespace App\Controllers;

use App\Models\BookingModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class Booking extends BaseController
{
    // =========================
    // CREATE BOOKING
    // =========================
    public function create($event_id)
    {
        if (session()->get('role') == 'admin') {
            return redirect()->to('/admin')
                ->with('error', 'Admin tidak dapat melakukan pemesanan tiket');
        }

        $model = new BookingModel();
        $user_id = session()->get('id');

        $db = \Config\Database::connect();
        $event = $db->table('events')->where('id', $event_id)->get()->getRowArray();

        if (!$event) {
            return redirect()->back()->with('error', 'Event tidak ditemukan');
        }

        // HITUNG BOOKING APPROVED
        $totalApproved = $model->where('event_id', $event_id)
                               ->where('status', 'approved')
                               ->countAllResults();

        if ($totalApproved >= $event['quota']) {
            return redirect()->back()->with('error', 'Mohon maaf, kuota event ini sudah penuh');
        }

        // CEK DOUBLE BOOKING
        $check = $model->where('user_id', $user_id)
                       ->where('event_id', $event_id)
                       ->first();

        if ($check) {
            return redirect()->back()->with('error', 'Anda sudah memesan tiket untuk event ini sebelumnya');
        }

        // SAVE BOOKING
        $model->save([
            'user_id'  => $user_id,
            'event_id' => $event_id,
            'status'   => 'pending'
        ]);

        $booking_id = $model->getInsertID();
        $this->sendBookingEmail($booking_id);

        return redirect()->to('/my-bookings')->with('success', 'Pemesanan berhasil! Menunggu persetujuan Organizer.');
    }

    // =========================
    // MY BOOKINGS (USER)
    // =========================
    public function myBookings()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('bookings');

        $builder->select('
            bookings.id,
            bookings.status,
            bookings.created_at,
            events.title,
            events.date,
            events.location,
            events.image
        ');
    
        $builder->join('events', 'events.id = bookings.event_id');
        $builder->where('bookings.user_id', session()->get('id'));
        $builder->orderBy('bookings.id', 'DESC');

        $data['bookings'] = $builder->get()->getResultArray();

        return view('booking/bookings', $data);
    }

    // =========================
    // DELETE BOOKING (USER CANCEL)
    // =========================
    // =========================
    // DELETE BOOKING (USER CANCEL)
    // =========================
    public function delete($id)
    {
        // FIX BUG: Gunakan strtoupper() agar aman dari perbedaan format huruf bawaan server
        if (strtoupper($this->request->getMethod()) !== 'POST') {
            return redirect()->to('/my-bookings')->with('error', 'Akses ilegal diblokir!');
        }

        $model = new BookingModel();
        $booking = $model->find($id);

        if (!$booking) {
            return redirect()->to('/my-bookings')->with('error', 'Tiket tidak ditemukan');
        }

        // SECURITY VALIDATION: Hanya pemilik tiket yang bisa membatalkan
        if ($booking['user_id'] != session()->get('id')) {
            return redirect()->to('/my-bookings')->with('error', 'Akses ditolak. Ini bukan tiket Anda!');
        }

        $model->delete($id);

        return redirect()->to('/my-bookings')->with('success', 'Pemesanan tiket berhasil dibatalkan');
    }

    // =========================
    // APPROVE BOOKING (ADMIN/ORGANIZER)
    // =========================
    public function approve($id)
    {
        if (!in_array(session()->get('role'), ['admin', 'organizer'])) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $model = new BookingModel();
        $db = \Config\Database::connect();
        $builder = $db->table('bookings');

        $builder->select('bookings.*, events.owner_id, events.quota');
        $builder->join('events', 'events.id = bookings.event_id');
        $builder->where('bookings.id', $id);

        $booking = $builder->get()->getRowArray();

        if (!$booking) {
            return redirect()->back()->with('error', 'Pemesanan tidak ditemukan');
        }

        if (session()->get('role') === 'organizer') {
            if (empty($booking['owner_id']) || $booking['owner_id'] != session()->get('id')) {
                return redirect()->back()->with('error', 'Akses Ilegal: Anda tidak berhak menyetujui tiket di luar event Anda!');
            }
        }

        $totalApproved = $model->where('event_id', $booking['event_id'])
                               ->where('status', 'approved')
                               ->countAllResults();

        if ($totalApproved >= $booking['quota']) {
            return redirect()->back()->with('error', 'Gagal! Kuota event ini sudah terisi penuh.');
        }

        $model->update($id, ['status' => 'approved']);
        $this->sendBookingEmail($id);

        return redirect()->back()->with('success', 'Tiket berhasil disetujui');
    }

    // =========================
    // REJECT BOOKING (ADMIN/ORGANIZER)
    // =========================
    public function reject($id)
    {
        if (!in_array(session()->get('role'), ['admin', 'organizer'])) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $model = new BookingModel();
        $db = \Config\Database::connect();
        $builder = $db->table('bookings');

        $builder->select('bookings.*, events.owner_id');
        $builder->join('events', 'events.id = bookings.event_id');
        $builder->where('bookings.id', $id);

        $booking = $builder->get()->getRowArray();

        if (!$booking) {
            return redirect()->back()->with('error', 'Pemesanan tidak ditemukan');
        }

        if (session()->get('role') === 'organizer') {
            if (empty($booking['owner_id']) || $booking['owner_id'] != session()->get('id')) {
                return redirect()->back()->with('error', 'Akses Ilegal: Anda tidak berhak menolak tiket di luar event Anda!');
            }
        }

        $model->update($id, ['status' => 'rejected']);
        $this->sendBookingEmail($id);

        return redirect()->back()->with('success', 'Tiket telah ditolak');
    }

    // =========================
    // DOWNLOAD PDF TICKET
    // =========================
    // =========================
    // DOWNLOAD PDF TICKET
    // =========================
    public function ticket($booking_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('bookings');

        $builder->select('
            bookings.*,
            users.name,
            users.email,
            events.title,
            events.location,
            events.date
        ');

        $builder->join('users', 'users.id = bookings.user_id');
        $builder->join('events', 'events.id = bookings.event_id');
        $builder->where('bookings.id', $booking_id);

        $booking = $builder->get()->getRowArray();

        if (!$booking) {
            return redirect()->back()->with('error', 'Tiket tidak ditemukan');
        }

        if ($booking['user_id'] != session()->get('id')) {
            return redirect()->back()->with('error', 'Akses ditolak. Ini bukan tiket Anda!');
        }

        if ($booking['status'] != 'approved') {
            return redirect()->back()->with('error', 'Tiket fisik PDF hanya tersedia jika status pemesanan sudah disetujui');
        }

        $qrData = base_url('/ticket/verify/' . $booking['id']);

        // ===============================================
        // FIX BUG QR CODE: Anti-Error Lintas Versi + Fallback
        // ===============================================
        try {
            // Strategi 1: Coba pakai syntax Endroid standar (bukan Builder)
            $writer = new \Endroid\QrCode\Writer\PngWriter();
            
            // Cek apakah versi baru (menggunakan create) atau versi lama (menggunakan new)
            if (method_exists(\Endroid\QrCode\QrCode::class, 'create')) {
                $qrCode = \Endroid\QrCode\QrCode::create($qrData)->setSize(300)->setMargin(10);
            } else {
                $qrCode = new \Endroid\QrCode\QrCode($qrData);
                if(method_exists($qrCode, 'setSize')) $qrCode->setSize(300);
                if(method_exists($qrCode, 'setMargin')) $qrCode->setMargin(10);
            }
            
            $result = $writer->write($qrCode);
            $qrImage = base64_encode($result->getString());

        } catch (\Throwable $e) {
            // Strategi 2: FALLBACK API DARURAT
            // Jika pustaka Endroid di laptop kamu versinya bentrok, 
            // kita gunakan API pembuat QR otomatis agar presentasi tugas akhir tetap aman!
            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($qrData);
            $qrImage = base64_encode(file_get_contents($qrUrl));
        }

        $html = view('ticket/pdf', [
            'booking' => $booking,
            'qrImage' => $qrImage
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream('ticket-event-' . $booking['id'] . '.pdf', ['Attachment' => true]);
    }

    // =========================
    // KIRIM NOTIFIKASI EMAIL
    // =========================
    private function sendBookingEmail($booking_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('bookings');

        $builder->select('
            bookings.*,
            users.name,
            users.email,
            events.title,
            events.location,
            events.date
        ');

        $builder->join('users', 'users.id = bookings.user_id');
        $builder->join('events', 'events.id = bookings.event_id');
        $builder->where('bookings.id', $booking_id);

        $booking = $builder->get()->getRowArray();

        if (!$booking) {
            return;
        }

        $email = \Config\Services::email();
        $email->setTo($booking['email']);
        $email->setSubject('Notifikasi Status Pemesanan Event - EO Management');

        $message = view('email/booking_status', ['booking' => $booking]);
        $email->setMailType('html');
        $email->setMessage($message);

        if (!$email->send()) {
            log_message('error', $email->printDebugger(['headers']));
        }
    }

    // =========================
    // VERIFY TICKET (SCAN QR)
    // =========================
    public function verify($booking_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('bookings');

        $builder->select('
            bookings.*,
            users.name,
            events.title,
            events.date,
            events.location
        ');

        $builder->join('users', 'users.id = bookings.user_id');
        $builder->join('events', 'events.id = bookings.event_id');
        $builder->where('bookings.id', $booking_id);

        $booking = $builder->get()->getRowArray();

        if (!$booking || $booking['status'] != 'approved') {
            return view('ticket/invalid'); 
        }

        return view('ticket/verify', [
            'booking' => $booking
        ]);
    }
}