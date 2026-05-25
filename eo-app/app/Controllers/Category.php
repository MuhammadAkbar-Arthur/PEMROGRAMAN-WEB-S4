<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class Category extends BaseController
{
    public function index()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        $model = new CategoryModel();

        return view('admin/categories', [
            'categories' => $model->orderBy('id', 'DESC')->findAll()
        ]);
    }

    public function store()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        $name = trim($this->request->getPost('name'));

        if (!$name) {
            return redirect()->back()
                ->with('error', 'Nama kategori wajib diisi');
        }

        $model = new CategoryModel();

        // CEK DUPLIKAT
        $exist = $model
            ->where('name', $name)
            ->first();

        if ($exist) {
            return redirect()->back()
                ->with('error', 'Kategori sudah ada');
        }

        $model->save([
            'name' => $name
        ]);

        return redirect()->back()
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function delete($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        $model = new CategoryModel();

        $category = $model->find($id);

        if (!$category) {
            return redirect()->back()
                ->with('error', 'Kategori tidak ditemukan');
        }

        $model->delete($id);

        return redirect()->back()
            ->with('success', 'Kategori berhasil dihapus');
    }
    public function update($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        $name = trim($this->request->getPost('name'));

        if (!$name) {
            return redirect()->back()
                ->with('error', 'Nama kategori wajib diisi');
        }

        $model = new CategoryModel();

        // CEK APAKAH KATEGORI ADA
        $category = $model->find($id);
        if (!$category) {
            return redirect()->back()
                ->with('error', 'Kategori tidak ditemukan');
        }

        // CEK DUPLIKAT (Kecuali nama kategori miliknya sendiri saat ini)
        $exist = $model->where('name', $name)
                       ->where('id !=', $id)
                       ->first();

        if ($exist) {
            return redirect()->back()
                ->with('error', 'Nama kategori sudah digunakan');
        }

        $model->update($id, [
            'name' => $name
        ]);

        return redirect()->back()
            ->with('success', 'Kategori berhasil diperbarui');
    }
}