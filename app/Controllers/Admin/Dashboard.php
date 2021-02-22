<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $kategori_postingan = $this->db->table('tb_kategori')->select('id,nama_kategori')->get()->getResultArray();
        $jumlah_user = $this->db->table('users')->countAll();
        $postingan_ditampilkan = $this->db->table('tb_postingan')->where('data_status', 'ditampilkan')->countAllResults();
        $postingan_diarsipkan = $this->db->table('tb_postingan')->where('data_status', 'diarsipkan')->countAllResults();
        $rincian_postingan = [];

        $i = 0;
        foreach ($kategori_postingan as $kp) {
            $rincian_postingan[$i]['nama_kategori'] = $kp['nama_kategori'];
            $rincian_postingan[$i]['ditampilkan'] = $this->db->table('tb_postingan')->where(['kategori' => $kp['id'], 'data_status' => 'ditampilkan'])->countAllResults();
            $rincian_postingan[$i]['diarsipkan'] = $this->db->table('tb_postingan')->where(['kategori' => $kp['id'], 'data_status' => 'diarsipkan'])->countAllResults();
            $rincian_postingan[$i]['total'] = $rincian_postingan[$i]['ditampilkan'] + $rincian_postingan[$i]['diarsipkan'];
            $i++;
        }

        $data = [
            'title' => 'Admin - Dashboard | Ed - Creative',
            'page' => 'Dashboard',
            'kategori_postingan' => $kategori_postingan,
            'jumlah_user' => $jumlah_user,
            'postingan_ditampilkan' => $postingan_ditampilkan,
            'postingan_diarsipkan' => $postingan_diarsipkan,
            'rincian_postingan' => $rincian_postingan
        ];

        return view('admin/dashboard', $data);
    }

    //--------------------------------------------------------------------

}
