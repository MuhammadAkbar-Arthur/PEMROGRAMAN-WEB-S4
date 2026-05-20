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
        // HARUS LOGIN
        if (!session()->get('logged_in')) {

            return redirect()->to('/login');
        }

        $model = new CommentModel();

        $comment = $model->find($id);

        // COMMENT TIDAK ADA
        if (!$comment) {

            return redirect()->back()
                ->with('error', 'Komentar tidak ditemukan');
        }

        // HANYA PEMILIK KOMENTAR
        if ($comment['user_id'] != session()->get('id')) {

            return redirect()->back()
                ->with('error', 'Akses ditolak');
        }

        // DELETE COMMENT
        $model->delete($id);

        return redirect()->back()
            ->with('success', 'Komentar berhasil dihapus');
    }
}