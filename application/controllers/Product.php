<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model ProductModel
        $this->load->model('ProductModel');
        $this->load->library('pagination');
    }

    public function index() {
        $config = array();
        $config['base_url'] = base_url('product/index');
        $config['total_rows'] = $this->ProductModel->count_products();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 2;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';

        $config['full_tag_open'] = '<ul class="pagination">';        
        $config['full_tag_close'] = '</ul>';        
        $config['first_link'] = 'First';        
        $config['last_link'] = 'Last';        
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['first_tag_close'] = '</span></li>';        
        $config['prev_link'] = '&laquo';        
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['prev_tag_close'] = '</span></li>';        
        $config['next_link'] = '&raquo';        
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['next_tag_close'] = '</span></li>';        
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['last_tag_close'] = '</span></li>';        
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';        
        $config['cur_tag_close'] = '</a></li>';        
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        $offset = ($page - 1) * $config['per_page'];

        $data['products'] = $this->ProductModel->get_products($config['per_page'], $offset);
        $data['links'] = $this->pagination->create_links();

        if ($this->authfilter->is_login()) {
            $data['page'] = array(
                'title' => 'List Product - Cyra Fashion Galery',
                'content' => 'home_page/produk',
                'page' => 'list-produk'
            );

            $this->load->view('templates/dashboard', $data);
        } else {
            $data['page'] = array(
                'title' => 'List Product - Cyra Fashion Galery',
                'content' => 'home_page/produk',
                'page' => 'list-produk'
            );

            $this->load->view('templates/landingpage', $data);
        }
    }

    public function search() {
        $keyword = $this->input->post('keyword');
        $data['products'] = $this->ProductModel->search_products($keyword);

        $config = array();
        $config['base_url'] = base_url('product/index');
        $config['total_rows'] = count($data['products']);
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 2;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';

        $config['full_tag_open'] = '<ul class="pagination">';        
        $config['full_tag_close'] = '</ul>';        
        $config['first_link'] = 'First';        
        $config['last_link'] = 'Last';        
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['first_tag_close'] = '</span></li>';        
        $config['prev_link'] = '&laquo';        
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['prev_tag_close'] = '</span></li>';        
        $config['next_link'] = '&raquo';        
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['next_tag_close'] = '</span></li>';        
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['last_tag_close'] = '</span></li>';        
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';        
        $config['cur_tag_close'] = '</a></li>';        
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        $offset = ($page - 1) * $config['per_page'];

        $data['links'] = $this->pagination->create_links();

        if ($this->authfilter->is_login()) {
            $data['page'] = array(
                'title' => 'Search Product - Cyra Fashion Galery',
                'content' => 'home_page/produk',
                'page' => 'list-produk'
            );

            $this->load->view('templates/dashboard', $data);
        } else {
            $data['page'] = array(
                'title' => 'Search Product - Cyra Fashion Galery',
                'content' => 'home_page/produk',
                'page' => 'list-produk'
            );

            $this->load->view('templates/landingpage', $data);
        }
    }

    public function manage() {
        // Tampilkan daftar pengguna
        $this->authfilter->check_role('admin', base_url('dashboard'));
        $data['page'] = array(
            'title' => 'Manage Product - Cyra Fashion Galery',
            'content' => 'admin_page/manageproduct',
            'page' => 'manage-product'
        );

        $data['products'] = $this->ProductModel->get_all_products();
        $this->load->view('templates/dashboard', $data);
    }


    public function create() {
        // Tampilkan daftar pengguna
        $this->authfilter->check_role('admin', base_url('dashboard'));

        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
        $this->form_validation->set_rules('deskripsi_produk', 'Deskripsi Produk', 'required');
        $this->form_validation->set_rules('jenis_produk', 'Jenis Produk', 'required');
        $this->form_validation->set_rules('harga_produk', 'Deskripsi Produk', 'required');
        $this->form_validation->set_rules('stok', 'Deskripsi Produk', 'required');
        if (empty($_FILES['img_produk']['name']))
        {
            $this->form_validation->set_rules('img_produk', 'Image', 'required');
        }

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', strip_tags(validation_errors()));
            redirect(base_url('product/manage'));
        } else {
            $productData = array(
                'nama_produk' => $this->input->post('nama_produk'),
                'deskripsi_produk' => $this->input->post('deskripsi_produk'),
                'jenis_produk' => $this->input->post('jenis_produk'),
                'harga_produk' => $this->input->post('harga_produk'),
                'stok' => $this->input->post('stok'),
                'date_created' => date('Y-m-d H:i:s'),
            );

            $productId = $this->ProductModel->create_product($productData);

            // Konfigurasi validasi
            $config['upload_path'] = './assets/img/uploads/produk/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB maksimum
            $config['encrypt_name'] = TRUE;
    
            // Load library upload CodeIgniter
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('img_produk')) {
                // Lakukan validasi upload
                $data = $this->upload->data();
                $fileName = $data['file_name'];
                $this->ProductModel->update_image($productId, $fileName);
            }

            // Update product data in database

            // Redirect to appropriate page after update
            $this->session->set_flashdata('success', 'Product berhasil diupdate');
            redirect(base_url('product/manage')); // Change 'manage' to your desired page
        }
    }

    public function update($id) {
        $this->authfilter->check_role('admin', base_url('dashboard'));

        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
        $this->form_validation->set_rules('deskripsi_produk', 'Deskripsi Produk', 'required');
        $this->form_validation->set_rules('jenis_produk', 'Jenis Produk', 'required');
        $this->form_validation->set_rules('harga_produk', 'Deskripsi Produk', 'required');
        $this->form_validation->set_rules('stok', 'Deskripsi Produk', 'required');

        // Update data pengguna
        if ($this->form_validation->run() == FALSE) {
            // If validation fails, reload the edit product page with validation errors
            $this->session->set_flashdata('error', strip_tags(validation_errors()));
            redirect(base_url('product/manage'));
        } else {
            $productId = $this->input->post('productid');
            $productData = array(
                'nama_produk' => $this->input->post('nama_produk'),
                'deskripsi_produk' => $this->input->post('deskripsi_produk'),
                'jenis_produk' => $this->input->post('jenis_produk'),
                'harga_produk' => $this->input->post('harga_produk'),
                'stok' => $this->input->post('stok'),
            );

            $this->ProductModel->update_product($productId, $productData);

            // Konfigurasi validasi
            $config['upload_path'] = './assets/img/uploads/profil/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB maksimum
            $config['encrypt_name'] = TRUE;
    
            // Load library upload CodeIgniter
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('productAvatar')) {
                // Lakukan validasi upload
                $data = $this->upload->data();
                $fileName = $data['file_name'];
                $this->ProductModel->update_image($productId, $fileName);
            }
    
            // Redirect to appropriate page after update
            $this->session->set_flashdata('success', 'Product berhasil diupdate');
            redirect(base_url('product/manage')); // Change 'manage' to your desired page
        }
    }

    public function delete($id) {
        // Hapus data pengguna
        $this->ProductModel->delete_product($id);
        redirect(base_url('product/manage'));
    }
}
