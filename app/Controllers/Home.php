<?php

namespace App\Controllers;

use App\Models\PostinganModel;

class Home extends BaseController
{
	protected $postinganModel;

	public function __construct()
	{
		$this->postinganModel = new PostinganModel();
	}

	public function index()
	{
		$data = [
			'title' => 'Ed Creative - Pelajari Hal Baru Secara Gratis',
			'post_terbaru' => $this->postinganModel->getNewestData()
		];
		return view('user/index', $data);
	}

	public function detail($slug)
	{
		$data = $this->postinganModel->getDataBySlug($slug);

		if ($data == null) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}

		$data = [
			'title' => ucwords($data['judul']) . ' - Ed Creative',
			'data_post' => $data
		];
		return view('user/postingan/detail', $data);
	}

	public function kategori($kategori)
	{
		$data = $this->postinganModel->getDataByKategori($kategori);

		$data = [
			'title' => ucwords($kategori) . ' - Ed Creative',
			'post' => $data,
			'kategori' => $kategori
		];

		return view('user/postingan/index', $data);
	}

	public function search()
	{
		$query = $this->request->getVar('query');
		$kategori = $this->request->getVar('kategori');

		if (trim($query) == "") {
			return redirect()->back();
		}

		$result = $this->postinganModel->searchData($query, $kategori);

		$data = [
			'title' => 'Hasil Pencarian : ' . $query . ' - Ed Creative',
			'query' => $query,
			'kategori' => $kategori,
			'search_result' => $result
		];

		return view('user/postingan/search', $data);
	}

	//--------------------------------------------------------------------

}
