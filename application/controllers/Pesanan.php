<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PesananModel');
        $this->load->model('UserModel');
        $this->load->library('form_validation');
        $this->load->library('cart');
    }

    public function index() {
        $this->authfilter->check_login(base_url());
        $this->authfilter->check_role('pelanggan', base_url('dashboard'));
        $user_id = $this->session->userdata('user_id');
        
        $data['page'] = array(
            'title' => 'Pesanan Saya - Cyra Fashion Galery',
            'content' => 'dashboard_page/pesanan',
            'page' => 'pesanan'
        );
        $data['pesanan'] = $this->PesananModel->get_all_pesanan($user_id);
        $data['kodepesanan'] = $this->PesananModel->get_all_kd_pesanan($user_id);

        $this->load->view('templates/dashboard', $data);

    }

    public function generateKodeGrupPesanan() {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $randomString = '';
    
        // Ambil 3 huruf kecil secara acak
        for ($i = 0; $i < 3; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        // Ambil 2 angka secara acak
        for ($i = 0; $i < 2; $i++) {
            $randomString .= $numbers[rand(0, strlen($numbers) - 1)];
        }
    
        // Acak urutan karakter
        $randomString = str_shuffle($randomString);
    
        return $randomString;
    }

    public function checkout($kdpesanan) {
        $pesanan = $this->PesananModel->get_pesanan_by_kd($kdpesanan);
        $user_id = $this->session->userdata('user_id');

        if (!$pesanan || $pesanan['id_user'] != $this->session->userdata('user_id')) {
            // Jika pesanan tidak ditemukan atau tidak dimiliki oleh pengguna yang sedang masuk
            show_error('Unauthorized access', 403); // Tampilkan pesan error 403 (Forbidden)
            return;
        }

        $data['page'] = array(
            'title' => 'Checkout - Cyra Fashion Galery',
            'content' => 'transaction_page/checkout',
            'page' => 'pesanan'
        );        

        $data['pesanan'] = $this->PesananModel->get_pesanan_by_kd($kdpesanan);
        $data['user'] = $this->UserModel->get_user_by_id($user_id);

        $this->load->view('templates/dashboard', $data);
    }

    public function process_checkout($kdpesanan) {
        $pesanan = $this->PesananModel->get_pesanan_by_kd($kdpesanan);
        $jumlah_bayar = str_replace(['.', ' '], '', $this->input->post('jumlah_bayar'));
        $userId = $this->session->userdata('user_id');

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat Lengkap', 'required');
        $this->form_validation->set_rules('whatsapp', 'No Whatsapp', 'required');
        $this->form_validation->set_rules('instagram', 'Akun Instagram', 'required');
        if ($jumlah_bayar != $pesanan['total_tagihan']) {
            // Jika jumlah_bayar tidak sama dengan total_tagihan
            $this->session->set_flashdata('error', 'Jumlah bayar tidak sama dengan total tagihan.');
            redirect(base_url('pesanan/checkout/' . $kdpesanan));
        }
        if (empty($_FILES['bukti_transfer']['name']))
        {
            $this->form_validation->set_rules('bukti_transfer', 'Bukti Transfer', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', strip_tags(validation_errors()));
            redirect(base_url('pesanan/checkout/' . $kdpesanan));
        } else {
            $userData = array(
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'whatsapp' => $this->input->post('whatsapp'),
                'instagram' => $this->input->post('instagram'),
                'date_updated' => date('Y-m-d H:i:s')
            );
            $this->UserModel->update_user($userId, $userData);
            $this->PesananModel->update_status_pesanan($kdpesanan, 2);

            // Konfigurasi validasi
            $config['upload_path'] = './assets/img/uploads/transaksi/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB maksimum
            $config['encrypt_name'] = TRUE;
    
            // Load library upload CodeIgniter
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('bukti_transfer')) {
                // Lakukan validasi upload
                $data = $this->upload->data();
                $fileName = $data['file_name'];
                $this->PesananModel->update_bukti_pembayaran($kdpesanan, $fileName);
            }

            $this->session->set_flashdata('success', 'Pembayaran berhasil dilakukan.');
            redirect(base_url('pesanan')); // Change 'manage' to your desired page
        }
    }

    public function cancel($kd) {
        // Hapus data pengguna
        $this->PesananModel->hapus_pesanan($kd);
        $this->session->set_flashdata('success', 'Berhasil membatalkan pesanan.');
        redirect(base_url('pesanan'));
    }

    public function keranjang() {
        if ($this->authfilter->is_login()) {
            $data['page'] = array(
                'title' => 'Keranjang Saya - Cyra Fashion Galery',
                'content' => 'dashboard_page/keranjang',
                'page' => 'keranjang'
            );
    
            $this->load->view('templates/dashboard', $data);
        } else {
            $data['page'] = array(
                'title' => 'Keranjang Saya - Cyra Fashion Galery',
                'content' => 'dashboard_page/keranjang',
                'page' => 'keranjang'
            );
    
            $this->load->view('templates/landingpage', $data);
        }

    }

    public function list() {
        $data['pesanan'] = $this->PesananModel->get_all_pesanan();
        $this->load->view('pesanan/index', $data);
    }

    public function tambah_pesanan() {
        if ($this->authfilter->is_login()) {
            if ($this->cart->contents()) {
                $cart_contents = $this->cart->contents();

                // Loop melalui setiap item dan tambahkan ke dalam pesanan
                $kodePesanan = $this->generateKodeGrupPesanan();
                $kddata = array(
                    'kd_pesanan' => $kodePesanan,
                    'id_user' => $this->session->userdata('user_id'),
                    'total_tagihan' => $this->cart->total(),
                    'status_pesanan' => 0 ,// Status pesanan, bisa disesuaikan
                    'date_updated' => date('Y-m-d H:i:s'),
                    'date_created' => date('Y-m-d H:i:s')
                );
                $this->PesananModel->tambah_kd_pesanan($kddata);
                foreach ($cart_contents as $item) {
                    $data = array(
                        'kd_pesanan' => $kodePesanan,
                        'id_produk' => $item['id'], // ID Produk dari item keranjang
                        'id_user' => $this->session->userdata('user_id'), // ID User dari form
                        'qty' => $item['qty'], // Jumlah barang dari item keranjang
                    );

                    // Tambahkan pesanan ke database
                    $this->PesananModel->tambah_pesanan($data);
                }

                // Setelah selesai menambahkan pesanan, kosongkan keranjang belanja
                $this->cart->destroy();

                // Redirect kembali ke halaman pesanan atau halaman lain yang sesuai
                $this->session->set_flashdata('success', 'Pesanan telah dibuat.');
                redirect(base_url('pesanan'));
            } else {
                $this->session->set_flashdata('error', 'Keranjang Kosong.');
                redirect(base_url('keranjang'));
            }
        } else {
            $this->session->set_userdata('pending_cart', $this->cart->contents());

            // Redirect ke halaman login atau pendaftaran
            redirect(base_url('login')); // Ganti dengan URL halaman login atau pendaftaran yang sesuai
        }
    }

    public function add_to_cart() {
        $data = array(
            'id'      => $this->input->post('id_produk'),
            'qty'     => $this->input->post('quantity'),
            'price'   => $this->input->post('harga'),
            'name'    => $this->input->post('nama_produk'),
        );

        // Tambahkan produk ke keranjang
        $this->cart->insert($data);

        $this->session->set_flashdata('success', 'Sukses menambahkan Produk ke Keranjang.');
        redirect(base_url('keranjang')); // Redirect kembali ke halaman keranjang
    }

    public function remove_from_cart($rowid) {
        $item = $this->cart->get_item($rowid);

        if (!$item['qty'] > 1) {
            $this->cart->remove($rowid);
        } else {
            $cart_data = array();
            $cart_data[] = array(
                'rowid' => $rowid,
                'qty'   => $item['qty'] - 1 // Ambil jumlah baru dari form
            );
            $this->cart->update($cart_data);
        }
        redirect(base_url('keranjang'));
    }

    public function add_from_cart($rowid) {
        $item = $this->cart->get_item($rowid);

        $cart_data = array();
        $cart_data[] = array(
            'rowid' => $rowid,
            'qty'   => $item['qty'] + 1 // Ambil jumlah baru dari form
        );
        $this->cart->update($cart_data);

        redirect(base_url('keranjang')); // Redirect kembali ke halaman keranjang
    }

    public function update_cart() {
        // Update keranjang belanja
        $cart_data = array();
        foreach ($this->cart->contents() as $items) {
            $cart_data[] = array(
                'rowid' => $items['rowid'],
                'qty'   => $_POST[$items['rowid'].'_qty'] // Ambil jumlah baru dari form
            );
        }
        $this->cart->update($cart_data);
        redirect(base_url('keranjang')); // Redirect kembali ke halaman keranjang
    }

    public function clear_cart() {
        // Kosongkan keranjang belanja
        $this->cart->destroy();
        $this->session->set_flashdata('success', 'Sukses membersihkan Keranjang.');
        redirect(base_url('keranjang')); // Redirect kembali ke halaman keranjang
    }

    public function manage($status_pesanan) {
        $this->authfilter->check_login(base_url());

        $data['page'] = array(
            'title' => 'Kelola Pesanan - Cyra Fashion Galery',
            'content' => 'admin_page/managepesanan',
            'page' => 'manage-pesanan'
        );

        $data['pesanan'] = $this->PesananModel->get_all_pesanan();
        $data['kodekonfirmasi'] = $status_pesanan;
        switch ($status_pesanan) {
            case 0:
                $data['kodepesanan'] = $this->PesananModel->get_all_kd_pesanan(null, 0);
                break;
            case 1:
                $data['kodepesanan'] = $this->PesananModel->get_all_kd_pesanan(null, 1);
                break;
            case 2:
                $data['kodepesanan'] = $this->PesananModel->get_all_kd_pesanan(null, 2);
                break;
            case 3:
                $data['kodepesanan'] = $this->PesananModel->get_all_kd_pesanan(null, 3);
                break;
            case 4:
                $data['kodepesanan'] = $this->PesananModel->get_all_kd_pesanan(null, 4);
                break;
            default:
                $data['kodepesanan'] = $this->PesananModel->get_all_kd_pesanan(null, 0);
                break;
        }
        $this->load->view('templates/dashboard', $data);
    }

    public function confirm($kdpesanan, $status_pesanan) {
        $pesanan = $this->PesananModel->get_pesanan_by_kd($kdpesanan);
        $userId = $this->session->userdata('user_id');

        if ($status_pesanan == 0) {
            $this->form_validation->set_rules('ongkir', 'Ongkos Kirim', 'required');
            $ongkir = str_replace(['.', ' '], '', $this->input->post('ongkir'));
            $total_tagihan = (int)$ongkir + (int)$this->input->post('total_tagihan');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', strip_tags(validation_errors()));
                return redirect(base_url('pesanan/manage/' . $status_pesanan));
            } else {
                $this->PesananModel->konfirmasi_pesanan($kdpesanan, $status_pesanan + 1, $ongkir, $total_tagihan);
    
                $this->session->set_flashdata('success', 'Konfirmasi pesanan berhasil dilakukan.');
                return redirect(base_url('pesanan/manage/' . $status_pesanan)); // Change 'manage' to your desired page
            }
        } else {
            $this->PesananModel->konfirmasi_pesanan($kdpesanan, $status_pesanan + 1);

            $this->session->set_flashdata('success', 'Konfirmasi pesanan berhasil dilakukan.');
            redirect(base_url('pesanan/manage/' . $status_pesanan)); // Change 'manage' to your desired page
        }
    }
}
