<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function cek_login($where) 
    {
      $query = $this->db->get_where('admin', $where)->num_rows();

      return $query;
    }

}

/* End of file Login_model.php */


//select memakai get_where()
//num_rows mengecek berapa baris yang berhasil
?>
