<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppRequiredTables extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		//menu_admin_page
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'auto_increment' => true,
			],
			'nama'       => [
				'type'       => 'VARCHAR',
				'constraint' => 25,
			],
			'urutan' => [
				'type' => 'INT',
				'constraint' => 11
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('menu_admin_page');

		// sub_menu_admin_page
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => true,
			],
			'parent_id' => [
				'type' => 'INT',
				'constraint' => 11,
			],
			'nama' => [
				'type' => 'VARCHAR',
				'constraint' => 25,
			],
			'icon' => [
				'type' => 'VARCHAR',
				'constraint' => 25
			],
			'url' => [
				'type' => 'VARCHAR',
				'constraint' => 100
			]
		]);
		$this->forge->addKey("id", true);
		$this->forge->addForeignKey('parent_id', 'menu_admin_page', 'id');
		$this->forge->createTable('submenu_admin_page');

		// tb_kategori
		$this->forge->addField([
			'id' => [
				'type' => "INT",
				'constraint' => 11,
				'auto_increment' => true
			],
			'nama_kategori' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
			],
			'created_at' => [
				'type' => 'DATETIME'
			],
			'updated_at' => [
				'type' => 'DATETIME'
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('tb_kategori');

		// tb_postingan
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => true,
			],
			'kategori' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'judul' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
			],
			'slug' => [
				'type' => 'VARCHAR',
				'constraint' => 100
			],
			'content' => [
				'type' => 'TEXT'
			],
			'thumbnail' => [
				'type' => 'VARCHAR',
				'constraint' => 255
			],
			'data_status' => [
				'type' => 'ENUM',
				'constraint' => ['ditampilkan', 'diarsipkan']
			],
			'created_at' => [
				'type' => 'DATETIME'
			],
			'updated_at' => [
				'type' => 'DATETIME'
			]
		]);
		$this->forge->addKey("id", true);
		$this->forge->addForeignKey('kategori', 'tb_kategori', 'id');
		$this->forge->createTable('tb_postingan');


		$this->db->enableForeignKeyChecks();
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
