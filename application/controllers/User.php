<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model UserModel
        $this->load->model('UserModel');
    }

    public function manage() {
        // Tampilkan daftar pengguna
        $this->authfilter->check_role('owner', base_url('dashboard'));
        $data['page'] = array(
            'title' => 'Manage User - Cyra Fashion Galery',
            'content' => 'owner_page/user',
            'page' => 'manage-user'
        );

        $data['users'] = $this->UserModel->get_all_users();
        $this->load->view('templates/dashboard', $data);
    }

    public function profile() {
        // Tampilkan daftar pengguna
        $this->authfilter->check_login(base_url());
        $id = $this->session->userdata('user_id');

        $data['page'] = array(
            'title' => 'Profile - Cyra Fashion Galery',
            'content' => 'dashboard_page/profile',
            'page' => 'profile'
        );

        $data['user'] = $this->UserModel->get_user_by_id($id);

        $passwordProvided = !empty($this->input->post('password'));

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('alamat', 'alamat', 'required');

        if ($passwordProvided) {
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        }

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', strip_tags(validation_errors()));
            $this->load->view('templates/dashboard', $data);
        } else {
            $userId = $id;
            $userData = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'whatsapp' => $this->input->post('whatsapp'),
                'instagram' => $this->input->post('instagram'),
            );

            // Konfigurasi validasi
            $config['upload_path'] = './assets/img/uploads/profil/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB maksimum
            $config['encrypt_name'] = TRUE;
    
            // Load library upload CodeIgniter
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('userAvatar')) {
                // Lakukan validasi upload
                $data = $this->upload->data();
                $fileName = $data['file_name'];
                $this->UserModel->update_avatar($userId, $fileName);
                $this->session->set_userdata('avatar', $fileName);
            }

            // Update user data in database
            $this->UserModel->update_user($userId, $userData);
            $this->session->set_userdata('nama', $this->input->post('nama'));

            // If password is provided, update password in database
            if ($passwordProvided) {
                $newPassword = $this->input->post('password');
                $this->UserModel->update_password($userId, $newPassword);
            }

            // Redirect to appropriate page after update
            $this->session->set_flashdata('success', 'User berhasil diupdate');
            redirect(base_url('user/profile')); // Change 'manage' to your desired page
        }
    }

    public function create() {
        // Tampilkan daftar pengguna
        $this->authfilter->check_role('owner', base_url('dashboard'));

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('alamat', 'alamat', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');


        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', strip_tags(validation_errors()));
            redirect(base_url('user/manage'));
        } else {
            $userId = $this->UserModel->create_user();

            // Konfigurasi validasi
            $config['upload_path'] = './assets/img/uploads/profil/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB maksimum
            $config['encrypt_name'] = TRUE;
    
            // Load library upload CodeIgniter
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('userAvatar')) {
                // Lakukan validasi upload
                $data = $this->upload->data();
                $fileName = $data['file_name'];
                $this->ProductModel->update_image($userId, $fileName);
            }

            // Update product data in database

            // Redirect to appropriate page after update
            $this->session->set_flashdata('success', 'User berhasil ditambahkan');
            redirect(base_url('user/manage')); // Change 'manage' to your desired page
        }
    }

    public function store() {
        // Simpan data pengguna baru
        $data = array(
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            // Tambahkan kolom lainnya sesuai kebutuhan
        );
        $this->UserModel->create_user($data);
        redirect('user/manage');
    }

    public function update($id) {
        $passwordProvided = !empty($this->input->post('password'));

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('roles', 'Roles', 'required');

        if ($passwordProvided) {
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        }

        // Update data pengguna
        if ($this->form_validation->run() == FALSE) {
            // If validation fails, reload the edit user page with validation errors
            $this->session->set_flashdata('error', strip_tags(validation_errors()));
            redirect(base_url('user/manage'));
        } else {
            $userId = $this->input->post('userid');
            $userData = array(
                'username' => $this->input->post('username'),
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'whatsapp' => $this->input->post('whatsapp'),
                'instagram' => $this->input->post('instagram'),
                'roles' => $this->input->post('roles'),
                'date_updated' => date('Y-m-d H:i:s')
            );

            // Konfigurasi validasi
            $config['upload_path'] = './assets/img/uploads/profil/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB maksimum
            $config['encrypt_name'] = TRUE;
    
            // Load library upload CodeIgniter
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('userAvatar')) {
                // Lakukan validasi upload
                $data = $this->upload->data();
                $fileName = $data['file_name'];
                $this->UserModel->update_avatar($userId, $fileName);
            }

            // Update user data in database
            $this->UserModel->update_user($userId, $userData);

            // If password is provided, update password in database
            if ($passwordProvided) {
                $newPassword = $this->input->post('password');
                $this->UserModel->update_password($userId, $newPassword);
            }
    
            // Redirect to appropriate page after update
            $this->session->set_flashdata('success', 'User berhasil diupdate');
            redirect(base_url('user/manage')); // Change 'manage' to your desired page
        }
    }

    public function delete($id) {
        // Hapus data pengguna
        $this->UserModel->delete_user($id);
        redirect(base_url('user/manage'));
    }
}
