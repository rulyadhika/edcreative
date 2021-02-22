<?php

namespace App\Models;

use CodeIgniter\Model;

class PostinganModel extends Model
{
    protected $table      = 'tb_postingan';
    protected $primaryKey = 'id';

    protected $allowedFields = ['kategori', 'judul', 'slug', 'content', 'thumbnail', 'data_status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $skipValidation = false;

    public function getDataBySlug($slug)
    {
        return $this->db->table($this->table)->select("tb_postingan.*,tb_kategori.nama_kategori")
        ->join("tb_kategori","tb_kategori.id=tb_postingan.kategori")
        ->where("slug", $slug)->get()->getRowArray();
    }

    public function getAllData()
    {
        return $this->db->table($this->table)->select("judul,slug,thumbnail,data_status,tb_kategori.nama_kategori")->join('tb_kategori', 'tb_kategori.id=tb_postingan.kategori')->get()->getResultArray();
    }

    public function getDataByKategori($kategori){
        return $this->db->table($this->table)->join("tb_kategori","tb_kategori.id=tb_postingan.kategori")->where(["tb_kategori.nama_kategori"=>$kategori,"tb_postingan.data_status"=>"ditampilkan"])->get()->getResultArray();
    }

    public function getNewestData(){
        return $this->db->table($this->table)->select("judul,slug,thumbnail,tb_kategori.nama_kategori")
        ->join('tb_kategori', 'tb_kategori.id=tb_postingan.kategori')
        ->where("data_status","ditampilkan")
        ->orderBy('tb_postingan.created_at',"DESC")
        ->limit(12)
        ->get()->getResultArray();
    }

    public function searchData($query,$kategori){
        $builder = $this->db->table($this->table);

        $builder->select("judul,slug,thumbnail,tb_kategori.nama_kategori")
        ->join('tb_kategori', 'tb_kategori.id=tb_postingan.kategori')
        ->where("data_status","ditampilkan");

        if($kategori!='semua'){
            $builder->where("tb_kategori.nama_kategori",$kategori);
        };

        $builder->groupStart()
        ->like("judul",$query)
        ->orLike("content",$query)
        // ->orLike("tb_kategori.nama_kategori",$query)
        ->groupEnd()
        ->orderBy("tb_postingan.created_at","DESC");

        return $builder->get()->getResultArray();
    }
}