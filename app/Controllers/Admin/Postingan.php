<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostinganModel;
use CodeIgniter\CodeIgniter;
use Exception;

class Postingan extends BaseController
{
    protected $postinganModel;
    protected $image;

    public function __construct()
    {
        $this->postinganModel = new PostinganModel();
        $this->image = \Config\Services::image();
    }

    public function index()
    {
        $data = [
            'title' => 'Admin - Kelola Postingan | Ed - Creative',
            'page' => 'List Postingan',
            'data' => $this->postinganModel->getAllData()
        ];

        return view('admin/postingan/index', $data);
    }

    public function add()
    {
        $db = db_connect();

        $data = [
            'title' => 'Admin - Tambah Postingan | Ed - Creative',
            'page' => 'Tambah Postingan',
            'data_kategori' => $db->table("tb_kategori")->select("nama_kategori,id")->get()->getResultArray()
        ];

        return view('admin/postingan/add', $data);
    }

    public function insert()
    {
        $request = $this->request;

        $validationRules = [
            'kategori' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => "Silahkan pilih kategori terlebih dahulu!"
                ]
            ],
            'judul' => [
                'rules'  => 'required|is_unique[tb_postingan.judul]',
                'errors' => [
                    'required' => 'Silahkan masukan judul terlebih dahulu!',
                    "is_unique" => "Judul sudah terdaftar, silahkan pilih judul lain!"
                ],
            ],
            'thumbnail' => [
                'rules' => 'uploaded[thumbnail]|max_size[thumbnail,1024]|mime_in[thumbnail,image/png,image/jpg,image/jpeg]|is_image[thumbnail]',
                'errors' => [
                    'uploaded' => 'Silahkan upload thumbnail terlebih dahulu!',
                    'max_size' => 'Ukuran gambar terlalu besar!',
                    "mime_in" => "Yang anda upload bukan gambar!",
                    "is_image" => "Yang anda upload bukan gambar!"
                ]
            ],
            'content' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Silahkan masukan isi konten terlebih dahulu!"
                ]
            ]
        ];
        $this->postinganModel->setValidationRules($validationRules);

        $slug = url_title($request->getVar('judul'), '-', true);
        $thumbnail = $request->getFile("thumbnail");
        $thumbnailName = $thumbnail->getRandomName();

        $data = [
            'kategori' => $this->request->getVar("kategori"),
            'judul' => $this->request->getVar("judul"),
            'slug' => $slug,
            'content' => $this->request->getVar("content"),
            'thumbnail' => $thumbnailName,
            'data_status' => 'ditampilkan'
        ];

        if (!$this->postinganModel->save($data)) {
            session()->setFlashdata("errors", $this->postinganModel->errors());
            return redirect()->back()->withInput();
        } else {

            // simpan ke folder sementara
            $thumbnail->move("src/images/thumbnail/temp", $thumbnailName);

            // dibuat copy menjadi ukuran yang lebih kecil
            $this->image->withFile('src/images/thumbnail/temp/' . $thumbnailName)
                ->resize(1024, 576, true, 'height')
                ->save('src/images/thumbnail/' . $thumbnailName);

            // hapus file pada folder sementara
            unlink("src/images/thumbnail/temp/" . $thumbnailName);

            session()->setFlashdata("sukses", "Postingan Berhasil Ditambahkan");
            return redirect()->to("/admin/postingan");
        }
    }

    public function edit($slug)
    {
        $data_postingan =  $this->postinganModel->getDataBySlug($slug);

        if ($data_postingan == null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        } else {
            $db = db_connect();

            $data = [
                'title' => 'Admin - Ubah Postingan | Ed - Creative',
                'page' => 'Ubah Postingan',
                'data_postingan' => $this->postinganModel->getDataBySlug($slug),
                'data_kategori' => $db->table("tb_kategori")->select("nama_kategori,id")->get()->getResultArray()
            ];

            return view('admin/postingan/edit', $data);
        }
    }

    public function update()
    {
        $request = $this->request;
        $oldData = $this->postinganModel->getDataBySlug($request->getVar("slug"));

        $thumbnail = $request->getFile("thumbnail");

        if ($thumbnail->getError() == 4) {
            // jika user tidak merubah thumbnail
            $rules_thumbnail = [];
            $thumbnailName = $oldData['thumbnail'];
        } else {
            // user merubah thumbnail
            $rules_thumbnail = [
                'rules' => 'max_size[thumbnail,1024]|mime_in[thumbnail,image/png,image/jpg,image/jpeg]|is_image[thumbnail]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar!',
                    "mime_in" => "Yang anda upload bukan gambar!",
                    "is_image" => "Yang anda upload bukan gambar!"
                ]
            ];

            $thumbnailName = $thumbnail->getRandomName();
        }

        if ($oldData['judul'] == $request->getVar("judul")) {
            $rules_judul = [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Silahkan masukan judul terlebih dahulu!'
                ],
            ];

            $slug = $oldData['slug'];
        } else {
            $rules_judul = [
                'rules'  => 'required|is_unique[tb_postingan.judul]',
                'errors' => [
                    'required' => 'Silahkan masukan judul terlebih dahulu!',
                    "is_unique" => "Judul sudah terdaftar, silahkan pilih judul lain!"
                ],
            ];

            $slug = url_title($request->getVar("judul"), "-", true);
        }

        $validationRules = [
            'kategori' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => "Silahkan pilih kategori terlebih dahulu!"
                ]
            ],
            'judul' => $rules_judul,
            'thumbnail' => $rules_thumbnail,
            'content' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Silahkan masukan isi konten terlebih dahulu!"
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[diarsipkan,ditampilkan]',
                'errors' => [
                    'required' => 'Silahkan masukan status postingan terlebih dahulu!',
                    'in_list' => 'Data yang anda masukan tidak sesuai ketentuan!'
                ]
            ]
        ];
        $this->postinganModel->setValidationRules($validationRules);


        $data = [
            'id' => $oldData['id'],
            'kategori' => $this->request->getVar("kategori"),
            'judul' => $this->request->getVar("judul"),
            'slug' => $slug,
            'content' => $this->request->getVar("content"),
            'thumbnail' => $thumbnailName,
            'data_status' => $request->getVar("status")
        ];

        if (!$this->postinganModel->save($data)) {
            session()->setFlashdata("errors", $this->postinganModel->errors());
            return redirect()->back()->withInput();
        } else {

            // jika user merubah thumbnail
            if ($thumbnail->getError() == null) {
                // hapus thumbnail lama
                unlink("src/images/thumbnail/" . $oldData['thumbnail']);

                // simpan gambar baru ke folder sementara
                $thumbnail->move("src/images/thumbnail/temp", $thumbnailName);

                // dibuat copy menjadi ukuran yang lebih kecil
                $this->image->withFile('src/images/thumbnail/temp/' . $thumbnailName)
                    ->resize(1024, 576, true, 'height')
                    ->save('src/images/thumbnail/' . $thumbnailName);

                // hapus file pada folder sementara
                unlink("src/images/thumbnail/temp/" . $thumbnailName);
            }

            session()->setFlashdata("sukses", "Postingan Berhasil Diubah");
            return redirect()->to("/admin/postingan");
        }
    }

    public function delete($slug)
    {
        $this->postinganModel->where('slug', $slug)->delete();
        // ->affectedRows()
        if ($this->postinganModel->errors()) {
            session()->setFlashdata("errorDelete", "Data Gagal Dihapus! Pastikan data ini tidak terhubung dengan database lain");
            return redirect()->to('/admin/postingan');
        } else {
            session()->setFlashdata("sukses", "Data Postingan Berhasil Dihapus");
            return redirect()->to('/admin/postingan');
        };
    }

    //--------------------------------------------------------------------

}
