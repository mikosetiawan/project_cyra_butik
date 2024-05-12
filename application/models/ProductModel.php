<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_products() {
        return $this->db->get('tbl_produk')->result_array();
    }

    public function create_product() {
        $data = array(
            'nama_produk' => $this->input->post('nama_produk'),
            'deskripsi_produk' => $this->input->post('deskripsi_produk'),
            'jenis_produk' => $this->input->post('jenis_produk'),
            'harga_produk' => $this->input->post('harga_produk'),
            'stok' => $this->input->post('stok'),
            'img' => $this->input->post('img')
        );
        $this->db->insert('tbl_produk', $data);

        return $this->db->insert_id();
    }

    public function get_product_by_id($id) {
        return $this->db->get_where('tbl_produk', array('id' => $id))->row_array();
    }

    public function update_product($productId, $data) {
        $this->db->where('id_produk', $productId);
        $this->db->update('tbl_produk', $data);
    }

    public function update_image($productId, $fileName) {
        $data = array(
            'img' => $fileName
        );
        $this->db->where('id_produk', $productId);
        return $this->db->update('tbl_produk', $data);
    }

    public function delete_product($id) {
        $this->db->delete('tbl_produk', array('id_produk' => $id));
    }

    public function count_products($keyword = null) {
        // Hitung total produk berdasarkan kata kunci pencarian
        if (!empty($keyword)) {
            $this->db->like('product_name', $keyword);
        }
        return $this->db->count_all_results('tbl_produk');
    }

    public function get_products($limit, $offset) {
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_produk');
        return $query->result_array();
    }

    public function search_products($keyword) {
        $this->db->like('nama_produk', $keyword);
        $query = $this->db->get('tbl_produk');
        return $query->result_array();
    }

    public function get_latest_products() {
        $this->db->order_by('date_created', 'desc'); // Urutkan berdasarkan date_created descending
        $this->db->limit(10); // Batasi hasilnya menjadi 10 produk
        $query = $this->db->get('tbl_produk'); // Ambil data dari tabel produk
        return $query->result_array(); // Kembalikan hasilnya dalam bentuk array
    }


}
