<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Authfilter {

    public function __construct() {
        $this->CI = &get_instance();
    }

    public function check_login($redirect_page) {
        if (!$this->CI->session->userdata('user_id')) {
            redirect($redirect_page);
        }
    }

    function is_login() {
        if (!$this->CI->session->userdata('user_id')) {
            return false;
        }
        return true;
      }

    function check_role($role_required, $redirect_page) {
      $CI = &get_instance();
      $role = $CI->session->userdata('role');
      if ($role != $role_required) {
          redirect($redirect_page); // Redirect ke halaman akses ditolak jika peran tidak sesuai
      }
    }  

    function is_role($role_required) {
      $CI = &get_instance();
      $role = $CI->session->userdata('role');
      if ($role != $role_required) {
          return false;
      } return true;
    }

    public function check_guest($redirect_page) {
        if ($this->CI->session->userdata('user_id')) {
            redirect($redirect_page);
        }
    }

}
