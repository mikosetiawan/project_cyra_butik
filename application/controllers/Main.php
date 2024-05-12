<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct() {
		parent::__construct();
		// Load model ProductModel
		$this->load->model('ProductModel');
}

	public function index()
	{
		$this->authfilter->check_guest(base_url('dashboard'));
			$data['page'] = array(
					'title' => 'Home - Cyra Fashion Galery',
					'content' => 'home_page/home',
					'page' => 'home'
			);

			$data['products'] = $this->ProductModel->get_latest_products();

			$this->load->view('templates/landingpage', $data);
	}
	
	public function dashboard()
	{
		$this->authfilter->check_login(base_url());
			$data['page'] = array(
					'title' => 'Dashboard - Cyra Fashion Galery',
					'content' => 'dashboard_page/dashboard',
					'page' => 'dashboard'
			);
			$this->load->view('templates/dashboard', $data);
	}
}
