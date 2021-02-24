<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AppSeeder extends Seeder
{
	public function run()
	{
		//authGroups
		$data = [
			[
				'name' => 'superadmin',
				'description' => 'site superadministrator'
			],
			[
				'name' => 'admin',
				'description' => 'site administrator'
			],
			[
				'name' => 'guests',
				'description' => 'site visitor'
			]
		];
		$this->db->table('auth_groups')->insertBatch($data);

		// users
		$data = [
			'email' => 'admin@gmail.com',
			'username' => 'administrator',
			'password_hash' => '$2y$10$UWHHLzb6TZgic9wQ3kHmtOyybXVE/i3x12OUIRYrZJNPdL8ENj91.',
			'reset_hash'       => null,
			'reset_at'         => null,
			'reset_expires'    => null,
			'activate_hash'    => null,
			'status'           => null,
			'status_message'   => null,
			'active'           => 1,
			'force_pass_reset' => 0,
			'created_at'       => '2021-02-24 04:54:20',
			'updated_at'       => '2021-02-24 04:54:20',
			'deleted_at'       => null,
		];
		$this->db->table('users')->insert($data);

		// auth_groups_users
		$data = [
			'group_id' => 1,
			'user_id' => 1
		];
		$this->db->table('auth_groups_users')->insert($data);

		// menu_admin_page
		$data = [
			[
				'nama' => 'Postingan',
				'urutan' => 1
			],
			[
				'nama' => 'Lainnya',
				'urutan' => 2
			]
		];
		$this->db->table('menu_admin_page')->insertBatch($data);

		// submenu_admin_page
		$data = [
			[
				'parent_id' => 1,
				'nama' => 'Tambah Postingan',
				'icon' => 'fa fa-plus',
				'url' => 'admin/postingan/add'
			],
			[
				'parent_id' => 1,
				'nama' => 'List Postingan',
				'icon' => 'far fa-newspaper',
				'url' => 'admin/postingan'
			],
			[
				'parent_id' => 1,
				'nama' => 'List Kategori',
				'icon' => 'fa fa-sticky-note',
				'url' => 'admin/kategori'
			],
			[
				'parent_id' => 2,
				'nama' => 'List Users',
				'icon' => 'fa fa-users',
				'url' => 'admin/user'
			],
			[
				'parent_id' => 2,
				'nama' => 'Homepage',
				'icon' => 'fa fa-globe',
				'url' => '/'
			],
			[
				'parent_id' => 2,
				'nama' => 'Logout',
				'icon' => 'fa fa-sign-out-alt',
				'url' => 'logout'
			]
		];
		$this->db->table('submenu_admin_page')->insertBatch($data);
	}
}
