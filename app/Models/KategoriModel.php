<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table      = 'tb_kategori';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama_kategori'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nama_kategori' => 'required|is_unique[tb_kategori.nama_kategori]'
    ];
    protected $validationMessages = [
        'nama_kategori' => [
            'required' => 'Silahkan masukan nama kategori terlebih dahulu',
            'is_unique' => 'Nama kategori sudah pernah dimasukan sebelumnya'
        ]
    ];
    protected $skipValidation = false;

    public function getAllKategori()
    {
        return $this->db->table($this->table)->get()->getResultArray();
    }

    public function getDataById($id)
    {
        return $this->db->table($this->table)->select('id,nama_kategori')->where('id', $id)->get()->getRowArray();
    }
}
