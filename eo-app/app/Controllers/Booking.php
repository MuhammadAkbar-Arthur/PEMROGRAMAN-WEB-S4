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
        $this->checkLogin();

        // ADMIN TIDAK BOLEH BOOKING
        if (session()->get('role') == 'admin') {
            return redirect()->to('/admin')
                ->with('error', 'Admin tidak dapat melakukan booking');
        }

        $model = new BookingModel();
        $user_id = session()->get('id');

        // =========================
        // CEK EVENT
        // =========================
        $db = \Config\Database::connect();
        $event = $db->table('events')
            ->where('id', $event_id)
            ->get()
            ->getRowArray();

        if (!$event) {
            return redirect()->back()
                ->with('error', 'Event tidak ditemukan');
        }

        // =========================
        // HITUNG BOOKING APPROVED
        // =========================
        $totalApproved = $model
            ->where('event_id', $event_id)
            ->where('status', 'approved')
            ->countAllResults();

        if ($totalApproved >= $event['quota']) {
            return redirect()->back()
                ->with('error', 'Kuota event sudah penuh');
        }

        // =========================
        // CEK DOUBLE BOOKING
        // =========================
        $check = $model
            ->where('user_id', $user_id)
            ->where('event_id', $event_id)
            ->first();

        if ($check) {
            return redirect()->back()
                ->with('error', 'Kamu sudah booking event ini');
        }

        // =========================
        // SAVE BOOKING
        // =========================
        $model->save([
            'user_id' => $user_id,
            'event_id' => $event_id,
            'status' => 'pending'
        ]);

        $booking_id = $model->getInsertID();

        // kirim email pending
        $this->sendBookingEmail($booking_id);

        return redirect()->to('/my-bookings')
            ->with('success', 'Booking berhasil dibuat');
    }

    // =========================
    // MY BOOKINGS
    // =========================
    public function myBookings()
    {
        $this->checkLogin();

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
    // DELETE BOOKING (DIAMANKAN DENGAN METODE POST)
    // =========================
    public function delete($id)
    {
        $this->checkLogin();

        // VALIDASI KEAMANAN: Blokir jika request dikirim lewat GET URL langsung
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/my-bookings')->with('error', 'Akses ilegal diblokir!');
        }

        $model = new BookingModel();
        $booking = $model->find($id);

        if (!$booking) {
            return redirect()->to('/my-bookings')
                ->with('error', 'Booking tidak ditemukan');
        }

        // SECURITY VALIDATION
        if ($booking['user_id'] != session()->get('id')) {
            return redirect()->to('/my-bookings')
                ->with('error', 'Akses ditolak');
        }

        $model->delete($id);

        return redirect()->to('/my-bookings')
            ->with('success', 'Booking berhasil dibatalkan');
    }

    // =========================
    // APPROVE BOOKING
    // =========================
    public function approve($id)
    {
        $this->checkLogin();

        if (!in_array(session()->get('role'), ['admin', 'organizer'])) {
            return redirect()->to('/')
                ->with('error', 'Akses ditolak');
        }

        $model = new BookingModel();
        $db = \Config\Database::connect();
        $builder = $db->table('bookings');

        $builder->select('bookings.*, events.owner_id');
        $builder->join('events', 'events.id = bookings.event_id');
        $builder->where('bookings.id', $id);

        $booking = $builder->get()->getRowArray();

        if (!$booking) {
            return redirect()->back()
                ->with('error', 'Booking tidak ditemukan');
        }

        if (session()->get('role') == 'organizer' && $booking['owner_id'] != session()->get('id')) {
            return redirect()->back()
                ->with('error', 'Bukan booking event milik kamu');
        }

        $model->update($id, [
            'status' => 'approved'
        ]);

        $this->sendBookingEmail($id);

        return redirect()->back()
            ->with('success', 'Booking approved');
    }

    // =========================
    // REJECT BOOKING
    // =========================
    public function reject($id)
    {
        $this->checkLogin();

        if (!in_array(session()->get('role'), ['admin', 'organizer'])) {
            return redirect()->to('/')
                ->with('error', 'Akses ditolak');
        }

        $model = new BookingModel();
        $db = \Config\Database::connect();
        $builder = $db->table('bookings');

        $builder->select('bookings.*, events.owner_id');
        $builder->join('events', 'events.id = bookings.event_id');
        $builder->where('bookings.id', $id);

        $booking = $builder->get()->getRowArray();

        if (!$booking) {
            return redirect()->back()
                ->with('error', 'Booking tidak ditemukan');
        }

        if (session()->get('role') == 'organizer' && $booking['owner_id'] != session()->get('id')) {
            return redirect()->back()
                ->with('error', 'Bukan booking event milik kamu');
        }

        $model->update($id, [
            'status' => 'rejected'
        ]);

        $this->sendBookingEmail($id);

        return redirect()->back()
            ->with('success', 'Booking rejected');
    }

    // =========================
    // DOWNLOAD PDF TICKET
    // =========================
    public function ticket($booking_id)
    {
        $this->checkLogin();

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
            return redirect()->back()
                ->with('error', 'Ticket tidak ditemukan');
        }

        if ($booking['user_id'] != session()->get('id')) {
            return redirect()->back()
                ->with('error', 'Akses ditolak');
        }

        if ($booking['status'] != 'approved') {
            return redirect()->back()
                ->with('error', 'Ticket hanya tersedia untuk booking approved');
        }

        $qrData = base_url('/ticket/verify/' . $booking['id']);

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrData)
            ->size(300)
            ->margin(10)
            ->build();

        $qrImage = base64_encode($result->getString());

        $html = view('ticket/pdf', [
            'booking' => $booking,
            'qrImage' => $qrImage
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream('ticket-' . $booking['id'] . '.pdf', ['Attachment' => true]);
    }

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
        $email->setSubject('Booking Event Notification');

        $message = view('email/booking_status', ['booking' => $booking]);
        $email->setMailType('html');
        $email->setMessage($message);

        if (!$email->send()) {
            log_message('error', $email->printDebugger(['headers']));
        }
    }

    // =========================
    // VERIFY TICKET
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