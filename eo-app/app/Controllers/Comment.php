<?php

namespace App\Controllers;

use App\Models\CommentModel;

class Comment extends BaseController
{
    // =========================
    // STORE COMMENT
    // =========================
    public function store($event_id)
    {
        // HARUS LOGIN
        if (!session()->get('logged_in')) {

            return redirect()->to('/login');
        }

        $model = new CommentModel();

        // AMBIL + BERSIHKAN INPUT
        $comment = trim($this->request->getPost('comment'));

        // VALIDASI KOSONG / SPASI
        if (empty($comment)) {

            return redirect()->back()
                ->with('error', 'Komentar tidak boleh kosong');
        }

        // SIMPAN COMMENT
        $model->save([

            'user_id'  => session()->get('id'),

            'event_id' => $event_id,

            'comment'  => $comment

        ]);

        return redirect()->back()
            ->with('success', 'Komentar berhasil ditambahkan');
    }

    // =========================
    // DELETE COMMENT
    // =========================
    public function delete($id)
    {
        // 1. HARUS LOGIN
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $commentModel = new CommentModel();
        $comment = $commentModel->find($id);

        // 2. COMMENT TIDAK ADA
        if (!$comment) {
            return redirect()->back()->with('error', 'Komentar tidak ditemukan');
        }

        // 3. AMBIL DATA EVENT UNTUK CEK SIAPA ORGANIZER-NYA
        // (Kita perlu tahu komentar ini ada di event milik siapa)
        $eventModel = new \App\Models\EventModel();
        $event = $eventModel->find($comment['event_id']);

        // 4. LOGIKA HAK AKSES (MODERASI)
        $isCommentOwner   = ($comment['user_id'] == session()->get('id'));
        $isAdmin          = (session()->get('role') == 'admin');
        $isEventOrganizer = ($event && $event['owner_id'] == session()->get('id'));

        // JIKA BUKAN PEMILIK KOMENTAR, BUKAN ADMIN, DAN BUKAN ORGANIZER -> TOLAK!
        if (!$isCommentOwner && !$isAdmin && !$isEventOrganizer) {
            return redirect()->back()->with('error', 'Akses ditolak. Anda tidak berhak menghapus komentar ini.');
        }

        // 5. DELETE COMMENT
        $commentModel->delete($id);

        return redirect()->back()->with('success', 'Komentar berhasil dihapus');
    }
}