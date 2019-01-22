<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Buku_model');

      if ($this->session->userdata('status') != 'logged in')
      {
         redirect('Login/index');  
      }

    }

    public function index()
    {
       $data['title'] = '';

      if ($this->input->get('keyword'))
      {
        $keyword = $this->input->get('keyword');
        $data['buku'] = $this->Buku_model->search($keyword); 
      }
      else
      {
        $data['buku'] = $this->Buku_model->getBuku();
      }
       // var_dump($data['buku']);
       $this->load->view('templates/header', $data);
       $this->load->view('buku/index_view', $data);
       $this->load->view('templates/footer');
       }


    public function tambah()        
    {
       $data['genre'] = $this->Buku_model->getGenre();

       $data['title'] = '';

       $this->form_validation->set_rules('judul', 'Judul', 'required', array('required' => '%s harus diisi'));
       $this->form_validation->set_rules('penulis', 'Penulis', 'required', array('required' => '%s harus diisi'));
       $this->form_validation->set_rules('tahun_terbit', 'Tahun terbit', 'required|exact_length[4]', array('required' => '%s harus diisi', 'exact_length' => 'Format %s : YYYY'));
       $this->form_validation->set_rules('harga', 'Harga', 'required|min_length[5]', array('required' => '%s harus diisi', 'min_length' => '%s minimal 5 digit angka'));

      if ($this->form_validation->run() == FALSE) 
      {
          $this->load->view('templates/header', $data);
          $this->load->view('buku/tambah_view');
          $this->load->view('templates/footer');
      }
      else 
      {
      $judul = $this->input->post('judul');
      $penulis = $this->input->post('penulis');
      $tahun_terbit = $this->input->post('tahun_terbit');
      $harga = $this->input->post('harga');
      $id_genre = $this->input->post('id_genre');
     

      $data = array('judul' => $judul,
                    'penulis' => $penulis,
                    'tahun_terbit' => $tahun_terbit,
                    'harga' => $harga,
                    'id_genre' => $id_genre);

      $this->Buku_model->tambah_data($data);

      $this->session->set_flashdata('sukses', 'ditambahkan');
   
      
      redirect('Buku/index');
      }

    }
      
      public function edit($id_buku)
      {
        $data['title'] = '';

        $where = array('id_buku' => $id_buku);
        
           $this->form_validation->set_rules('judul', 'Judul', 'required', array('required' => '%s harus diisi'));
           $this->form_validation->set_rules('penulis', 'Penulis', 'required', array('required' => '%s harus diisi'));
           $this->form_validation->set_rules('tahun_terbit', 'Tahun terbit', 'required|exact_length[4]', array('required' => '%s harus diisi', 'exact_length' => 'Format %s : YYYY'));
           $this->form_validation->set_rules('harga', 'Harga', 'required|min_length[5]', array('required' => '%s harus diisi', 'min_length' => '%s minimal 5 digit angka'));
       
        if ($this->form_validation->run() == FALSE) 
        {
         
          $data['buku'] = $this->Buku_model->getBukuById($where);
          $data['genre'] = $this->Buku_model->getGenre();
          
          $this->load->view('templates/header', $data);
          $this->load->view('buku/edit_view', $data);
          $this->load->view('templates/footer');  
        } 
        else 
        {
          $id_buku = $this->input->post('id_buku');
          $judul = $this->input->post('judul');
          $penulis = $this->input->post('penulis');
          $tahun_terbit = $this->input->post('tahun_terbit');
          $harga = $this->input->post('harga');
          $id_genre = $this->input->post('id_genre');
          
     
          $data = array('judul' => $judul,
                     'penulis' => $penulis,
                     'tahun_terbit' => $tahun_terbit,
                     'harga' => $harga,
                     'id_genre' => $id_genre);
  
          
          $this->Buku_model->edit_data($where, $data); 
      
          $this->session->set_flashdata('sukses', 'Berhasil Edit Data');
      
          redirect('Buku/index');
      }
    }
  
     public function hapus($id_buku)
     {
       $where = array('id_buku' => $id_buku);

       $this->Buku_model->hapus_data($where, 'buku');
       $this->session->set_flashdata('sukses', 'Berhasil Hapus Data');
       
       redirect('Buku/index');  
      }

    public function search() //tidak perlu parameter, mengambil sendiri datanya
    {
      //$keyword = $this->input->get('keyword');
      
      //$data['buku'] = $this->Buku_model->search($keyword);
      
      //bisa memakai index_view
      $this->load->view('index_view', $data);
    }

    public function detail($id_buku)
    {
      $data['title'] = '';

      $where = array('id_buku' => $id_buku); 
      $data['buku'] = $this->Buku_model->getBukuById($where);
     
      $this->load->view('templates/header', $data);
      $this->load->view('buku/detail_view', $data);
      $this->load->view('templates/footer');       
    }
  }

   


/* End of file Buku.php */


