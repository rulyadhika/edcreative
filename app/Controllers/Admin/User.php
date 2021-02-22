<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class User extends BaseController
{

    protected $db, $builder, $authorize;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->authorize = \Config\Services::authorization();
    }

    public function index()
    {
        $users = $this->builder->select("users.id as user_id,email,username,name as role")->join("auth_groups_users", "users.id=auth_groups_users.user_id")
            ->join("auth_groups", "auth_groups_users.group_id = auth_groups.id")->get()->getResultArray();

        $roles = $this->db->table("auth_groups")->get()->getResultArray();

        $data = [
            'title' => 'Admin - Kelola User | Ed - Creative',
            'page' => 'List Users',
            'users' => $users,
            'roles' => json_decode(json_encode($this->authorize->groups()), true)
        ];

        return view('admin/user/index', $data);
    }

    public function getSingleData()
    {
        $id = $this->request->getVar("id");
        if ($this->request->isAJAX()) {
            $user = $this->builder->select("users.id as user_id,email,username,name as role")->join("auth_groups_users", "users.id=auth_groups_users.user_id")
                ->join("auth_groups", "auth_groups_users.group_id = auth_groups.id")->where('users.id', $id)->get()->getRowArray();

            return json_encode($user);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }

    public function update()
    {
        $request = $this->request;
        $user_id = $request->getVar('id');
        $old_role = $request->getVar('old_role');
        $new_role = $request->getVar('role');

        if ($old_role == 'dev' && (in_groups('dev') == false)) {
            // prevent change dev account if user whose input is not a dev
            session()->setFlashdata("failed", "Data User Gagal Diubah, Anda tidak memiliki ijin untuk merubah data user tersebut!");
            return redirect()->to('/admin/user');
        } elseif ($new_role == 'dev' && (in_groups('dev') == false)) {
            // prevent change an account to a dev role if user whose input is not a dev
            session()->setFlashdata("failed", "Data User Gagal Diubah, Anda tidak memiliki ijin untuk merubah data user tersebut!");
            return redirect()->to('/admin/user');
        } else {
            if ($this->authorize->removeUserFromGroup($user_id, $old_role) &&  $this->authorize->addUserToGroup($user_id, $new_role)) {
                session()->setFlashdata("sukses", "Data User Berhasil Diubah");
                return redirect()->to('/admin/user');
            }
        };
    }


    //--------------------------------------------------------------------

}
