<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function check_credentials($username, $password) {
        $encrypted_password = md5($password);
        $this->db->where('username', $username);
        $this->db->where('password', $encrypted_password);
        $query = $this->db->get('tbl_users');
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function register_user($data) {
        $data['password'] = md5($data['password']);
        return $this->db->insert('tbl_users', $data);
    }

    public function change_password($user_id, $new_password) {
        $encrypted_password = md5($new_password);
        $this->db->set('password', $encrypted_password);
        $this->db->where('id_user', $user_id);
        return $this->db->update('tbl_users');
    }

    public function get_user_by_username($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('tbl_users');
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_user_by_id($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('tbl_users');
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_tbl_users_by_role($role) {
        $this->db->where('role', $role);
        $query = $this->db->get('tbl_users');
        return $query->result();
    }

    public function delete_user($user_id) {
        $this->db->where('id', $user_id);
        return $this->db->delete('tbl_users');
    }    

}