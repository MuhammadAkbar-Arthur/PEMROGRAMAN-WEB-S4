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
        if (!session()->get('logged_in')) {

            return redirect()->to('/login');
        }

        $model = new CommentModel();

        $comment = $this->request->getPost('comment');

        if (!$comment) {

            return redirect()->back()
                ->with('error', 'Komentar tidak boleh kosong');
        }

        $model->save([

            'user_id' => session()->get('id'),

            'event_id' => $event_id,

            'comment' => $comment

        ]);

        return redirect()->back()
            ->with('success', 'Komentar berhasil ditambahkan');
    }

    // =========================
    // DELETE COMMENT
    // =========================
    public function delete($id)
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/login');
        }

        $model = new CommentModel();

        $comment = $model->find($id);

        if (!$comment) {

            return redirect()->back();
        }

        // hanya pemilik komentar
        if ($comment['user_id'] != session()->get('id')) {

            return redirect()->back()
                ->with('error', 'Akses ditolak');
        }

        $model->delete($id);

        return redirect()->back()
            ->with('success', 'Komentar berhasil dihapus');
    }
}