<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PesananModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_pesanan($id_user = null, $status_pesanan = null) {
        $this->db->select('tbl_pesanan.*, tbl_users.nama AS nama_user, tbl_users.alamat AS alamat_user, tbl_users.whatsapp AS whatsapp_user, tbl_users.instagram AS instagram_user, tbl_produk.nama_produk, tbl_produk.harga_produk, tbl_produk.img AS gambar_produk');    
        $this->db->from('tbl_pesanan');
        $this->db->join('tbl_users', 'tbl_pesanan.id_user = tbl_users.id_user');
        $this->db->join('tbl_produk', 'tbl_pesanan.id_produk = tbl_produk.id_produk');
        if ($id_user !== null) {
            $this->db->where('tbl_pesanan.id_user', $id_user);
        }
        if ($status_pesanan !== null) {
            $this->db->join('tbl_tracking', 'tbl_pesanan.kd_pesanan = tbl_tracking.kd_pesanan');
            $this->db->where('tbl_tracking.status_pesanan', $status_pesanan);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_kd_pesanan($id_user = null, $status_pesanan = null) { 
        $this->db->from('tbl_tracking');
        if ($id_user !== null) {
            $this->db->where('tbl_tracking.id_user', $id_user);
        }
        if ($status_pesanan !== null) {
            $this->db->select('tbl_tracking.*, tbl_users.nama AS nama_user, tbl_users.alamat AS alamat_user, tbl_users.whatsapp AS whatsapp_user, tbl_users.instagram AS instagram_user');
            $this->db->join('tbl_users', 'tbl_tracking.id_user = tbl_users.id_user');
            $this->db->where('tbl_tracking.status_pesanan', $status_pesanan);
        }
        $this->db->order_by('tbl_tracking.date_updated', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tambah_pesanan($data) {
        $this->db->insert('tbl_pesanan', $data);
    }

    public function tambah_kd_pesanan($data) {
        $this->db->insert('tbl_tracking', $data);
    }

    public function get_pesanan_by_kd($kd_pesanan) {
        $this->db->where('kd_pesanan', $kd_pesanan);
        $query = $this->db->get('tbl_tracking');
        return $query->row_array();
    }

    public function get_pesanan_by_id($id_pesanan) {
        $this->db->where('id_pesanan', $id_pesanan);
        $query = $this->db->get('tbl_pesanan');
        return $query->row_array();
    }

    public function hapus_pesanan($kd_pesanan) {
        $this->db->where('kd_pesanan', $kd_pesanan);
        $this->db->delete('tbl_pesanan');
        $this->db->where('kd_pesanan', $kd_pesanan);
        $this->db->delete('tbl_tracking');
    }

    public function update_status_pesanan($kd_pesanan, $status_pesanan) {
        $data = array(
            'status_pesanan' => $status_pesanan,
            'date_updated' => date('Y-m-d H:i:s')
        );

        $this->db->where('kd_pesanan', $kd_pesanan);
        $this->db->update('tbl_tracking', $data);
        return $this->db->affected_rows();
    }

    public function update_bukti_pembayaran($kd_pesanan, $bukti_pembayaran) {
        $data = array(
            'bukti_pembayaran' => $bukti_pembayaran
        );

        $this->db->where('kd_pesanan', $kd_pesanan);
        $this->db->update('tbl_tracking', $data);
        return $this->db->affected_rows();
    }

    public function konfirmasi_pesanan($kd_pesanan, $status_pesanan = null, $ongkir = null, $total_tagihan = null) {
        if ($ongkir) {
            $tracking_data = array(
                'ongkir' => $ongkir,
                'total_tagihan' => $total_tagihan,
                'status_pesanan' => $status_pesanan
            );
            $this->db->where('kd_pesanan', $kd_pesanan);
            $this->db->update('tbl_tracking', $tracking_data);
        } else {
            $this->update_status_pesanan($kd_pesanan, $status_pesanan);
        }
    }
}
