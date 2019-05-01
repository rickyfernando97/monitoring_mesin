<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_detailkegiatan extends CI_Model{
	public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function get($params=array()){
        $this->db->select('downtime.*, produksi.kode_batch, master_mesin.nama_mesin, master_mesin.kode_mesin, master_problem.*');

        if(isset($params['id_produksi'])){
            $this->db->where('downtime.id_produksi',$params['id_produksi']);
        }

        if(isset($params['status'])){
            $this->db->where('downtime.status',$params['status']);
        }

        if(isset($params['id_mesin'])){
            if($params['id_mesin']!=0 && $params['id_mesin']!='') {
                $this->db->where('produksi.id_mesin',$params['id_mesin']);
            }
        }

        if(isset($params['tgl_mulai'])){
            if($params['tgl_mulai']!=0 && $params['tgl_mulai']!='') {
                $this->db->where("DATE_FORMAT(downtime.waktu_mulai,'%d/%m/%Y')", $params['tgl_mulai']);
            }
        }

        if(isset($params['downtime_duration'])){
            if($params['downtime_duration']=='IS_NULL'){
                $this->db->where('downtime.downtime_duration IS NULL');
            } else if($params['downtime_duration']=='IS_NOT_NULL'){
                $this->db->where('downtime.downtime_duration IS NOT NULL');
            }
        }

        $this->db->from('downtime');
        $this->db->join('produksi','downtime.id_produksi=produksi.id_produksi','left');
        $this->db->join('master_mesin','produksi.id_mesin=master_mesin.id_mesin','left');
        $this->db->join('master_problem','downtime.id_problem=master_problem.id_problem and master_problem.status = 1','left');
        $this->db->order_by('produksi.id_produksi','asc');
        $this->db->order_by('produksi.waktu_mulai','asc');
        $res = $this->db->get();
        return $res;
    }

    function get_byid($params=array()){
        if(isset($params['id_downtime'])){
            $this->db->where('id_downtime',$params['id_downtime']);
        }
        if(isset($params['id_produksi'])){
            $this->db->where('id_produksi',$params['id_produksi']);
        }
        if(isset($params['status'])){
            $this->db->where('downtime.status',$params['status']);
            if($params['status']){
                $this->db->order_by("downtime.waktu_mulai", "desc");
            }
        }
        $this->db->join('master_problem','downtime.id_problem=master_problem.id_problem and master_problem.status=1','left');
        $res = $this->db->get('downtime')->first_row();
        return $res;
    }

    function add($params=array()){
        $res = $this->db->insert('downtime',$params);
        return $res;
    }

    function upd($params=array()){
        if(isset($params['id_downtime'])){
            $this->db->where('id_downtime',$params['id_downtime']);
        }
        unset($params['id_downtime']);
        
        $res = $this->db->update('downtime',$params);
        return $res;
    }
}