<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ProductModel');
        $this->load->library('pagination');
    }

    public function index() {
        // Ambil data pencarian dari input pengguna
        $keyword = $this->input->get('keyword');

        // Pengaturan paginasi
        $config['base_url'] = base_url('product/index');
        $config['total_rows'] = $this->ProductModel->count_products($keyword);
        $config['per_page'] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 2;
        $config['enable_query_strings'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);

        // Ambil data produk
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset = ($page - 1) * $config['per_page'];
        $data['products'] = $this->ProductModel->get_products($config['per_page'], $offset, $keyword);

        $this->load->view('product/index', $data);
    }

}
