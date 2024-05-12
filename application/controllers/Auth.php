<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('AuthModel');
        $this->form_validation->set_error_delimiters('<li class="small text-danger text-left">', '</li>');
    }

    public function login() {
        $this->authfilter->check_guest(base_url('dashboard'));

        $data['page'] = array(
            'title' => 'Login - Cyra Fashion Galery',
            'content' => 'auth_page/login',
            'page' => 'login'
        );

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/landingpage', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->AuthModel->check_credentials($username, $password);
            if ($user) {
                $this->session->set_userdata('user_id', $user->id_user);
                $this->session->set_userdata('username', $user->username);
                $this->session->set_userdata('nama', $user->nama);
                $this->session->set_userdata('role', $user->roles);
                $this->session->set_userdata('avatar', $user->img);
                if ($this->session->userdata('pending_cart')) {
                    // Jika ada item-item dalam sesi, tambahkan item-item tersebut ke keranjang belanja pengguna yang terdaftar
                    $this->cart->insert($pending_cart);
                    $this->session->unset_userdata('pending_cart'); // Hapus data pending cart dari sesi
                }
                redirect(base_url('dashboard'));
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah!');
                $data['error'] = 'Username atau password salah';
                $this->load->view('templates/landingpage', $data);
            }
        }
    }

    public function register() {
        $this->authfilter->check_guest(base_url('dashboard'));

        $data['page'] = array(
            'title' => 'Register - Cyra Fashion Galery',
            'content' => 'auth_page/register',
            'page' => 'register'
        );

        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[tbl_users.username]');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'trim|required|matches[password]');

        $this->form_validation->set_message('is_unique', 'The Username already taken.');
        
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/landingpage', $data);
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'date_updated' => date('Y-m-d H:i:s'),
                'date_created' => date('Y-m-d H:i:s'),
            );
            if ($this->AuthModel->register_user($data)) {
                redirect(base_url('login'));
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah!');
                $data['error'] = 'Terjadi kesalahan! coba lagi';
                $this->load->view('templates/landingpage', $data);
            }
        }
    }
    

    public function logout() {
        $this->authfilter->check_login(base_url());

        $this->session->sess_destroy();
        redirect(base_url());
    }

}
