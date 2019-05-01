<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_mesin extends CI_Model{
	public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function get($params=array()){
        $this->db->select('
                    master_mesin.*,
                    master_user.id_user,
                    master_user.username,
                    master_user.nama,
                    produksi.id_produksi, 
                    produksi.id_user, 
                    produksi.active, 
                    produksi.kode_batch, 
                    produksi.waktu_mulai, 
                    produksi.waktu_selesai, 
                    produksi.keterangan_produksi');

        if(isset($params['status_mesin'])){
            $this->db->where('status_mesin',$params['status_mesin']);
        }

        $this->db->join('produksi','master_mesin.id_mesin=produksi.id_mesin and produksi.active = 1','left');
        $this->db->join('master_user','produksi.id_user=master_user.id_user','left');
        $this->db->order_by("master_mesin.id_mesin", "asc");
        $res = $this->db->get('master_mesin');
        return $res;
    }

    function get_machine_only(){
        $res = $this->db->get('master_mesin');
        return $res;
    }

    function get_byid($params=array()){
        if(isset($params['id_mesin'])){
            $this->db->where('id_mesin',$params['id_mesin']);
        }
        $res = $this->db->get('master_mesin')->first_row();
        return $res;
    }

    function add($params=array()){
        if(isset($params['id_mesin'])){
            unset($params['id_mesin']);
        }
        $res = $this->db->insert('master_mesin',$params);
        return $res;
    }

    function upd($params=array()){
        if(isset($params['id_mesin'])){
            $this->db->where('id_mesin',$params['id_mesin']);
        }
        unset($params['id_mesin']);

        $res = $this->db->update('master_mesin',$params);
        return $res;
    }

    function del($params=array()){
        if(isset($params['id_mesin'])){
            $this->db->where('id_mesin',$params['id_mesin']);
        }
        unset($params['id_mesin']);

        $res = $this->db->delete('master_mesin',$params);
        return $res;
    }
}