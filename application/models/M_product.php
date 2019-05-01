<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_product extends CI_Model{

	public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function get($params=array()){
        if(isset($params['active'])){
            $this->db->where('active',$params['active']);
        }

		$res = $this->db->get('master_produk');
		return $res;
    }

    function add($params=array()){
        if(isset($params['id_produk'])){
            unset($params['id_produk']);
        }
        $res = $this->db->insert('master_produk',$params);
        return $res;
    }

    function upd($params=array()){
        if(isset($params['id_produk'])){
            $this->db->where('id_produk',$params['id_produk']);
        }
        unset($params['id_produk']);

        $res = $this->db->update('master_produk',$params);
        return $res;
    }

    function del($params=array()){
        if(isset($params['id_produk'])){
            $this->db->where('id_produk',$params['id_produk']);
        }
        unset($params['id_produk']);

        $res = $this->db->delete('master_produk',$params);
        return $res;
    }
}