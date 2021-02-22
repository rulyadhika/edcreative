<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Admin - Kelola Kategori | Ed - Creative',
            'page' => 'List Kategori',
            'data' => $this->kategoriModel->getAllKategori()
        ];

        return view('admin/kategori/index', $data);
    }

    public function getSingleData()
    {
        $id = $this->request->getVar("id");
        if ($this->request->isAJAX()) {
            return json_encode($this->kategoriModel->getDataById($id));
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }

    public function insert()
    {
        $request = $this->request;

        $data = [
            'nama_kategori' => $request->getVar("nama_kategori")
        ];

        if ($this->kategoriModel->save($data) === false) {
            session()->setFlashdata("errors", $this->kategoriModel->errors());
            return redirect()->to('/admin/kategori')->withInput();
        } else {
            session()->setFlashdata("sukses", "Data Kategori Berhasil Ditambahkan");
            return redirect()->to('/admin/kategori');
        }
    }

    public function update()
    {
        $request = $this->request;

        $data = [
            'id' => $request->getVar("id"),
            'nama_kategori' => $request->getVar("nama_kategori")
        ];

        if ($this->kategoriModel->save($data) === false) {
            session()->setFlashdata("errors", $this->kategoriModel->errors());
            return redirect()->to('/admin/kategori')->withInput();
        } else {
            session()->setFlashdata("sukses", "Data Kategori Berhasil Diubah");
            return redirect()->to('/admin/kategori');
        }
    }

    public function delete($id)
    {
        $this->kategoriModel->where('id', $id)->delete();
        // ->affectedRows()
        if ($this->kategoriModel->errors()) {
            session()->setFlashdata("errorDelete", "Data Gagal Dihapus! Pastikan data ini tidak terhubung dengan database lain");
            return redirect()->to('/admin/kategori');
        } else {
            session()->setFlashdata("sukses", "Data Kategori Berhasil Dihapus");
            return redirect()->to('/admin/kategori');
        };
    }

    //--------------------------------------------------------------------

}
