<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

    public function get_all_users() {
        return $this->db->get('tbl_users')->result_array();
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('tbl_users', array('id_user' => $id))->row_array();
    }

    public function create_user() {
        $userData = array(
            'username' => $this->input->post('username'),
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'whatsapp' => $this->input->post('whatsapp'),
            'instagram' => $this->input->post('instagram'),
            'roles' => $this->input->post('roles'),
            'password' => md5($this->input->post('password')),
        );
        $this->db->insert('tbl_users', $userData);

        return $this->db->insert_id();
    }

    public function update_user($id, $data) {
        $this->db->where('id_user', $id);
        $this->db->update('tbl_users', $data);
    }

    public function update_password($userId, $newPassword) {
        $encryptedPassword = md5($newPassword);

        $this->db->set('password', $encryptedPassword);
        $this->db->where('id_user', $userId);
        $this->db->update('tbl_users');
        
    }

    public function update_avatar($userId, $fileName) {
        $data = array(
            'img' => $fileName
        );
        $this->db->where('id_user', $userId);
        return $this->db->update('tbl_users', $data);
    }


    public function delete_user($id) {
        $this->db->where('id_user', $id);
        $this->db->delete('tbl_users');
    }
}
