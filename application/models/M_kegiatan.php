<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_kegiatan extends CI_Model{
	public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function get($params=array()){

        if(isset($params['id_mesin'])){
            if($params['id_mesin']!=0 && $params['id_mesin']!='') {
                $this->db->where('produksi.id_mesin',$params['id_mesin']);
            }
        }

        if(isset($params['kode_batch'])){
            $this->db->where('kode_batch',$params['kode_batch']);
        }

        if(isset($params['tgl_mulai']) && !empty($params['tgl_mulai']))
            $this->db->where("date(waktu_mulai) >= '{$params['tgl_mulai']}'", NULL, FALSE);

        if(isset($params['tgl_selesai']) && !empty($params['tgl_selesai']))
            $this->db->where("date(waktu_mulai) <= '{$params['tgl_selesai']}'", NULL, FALSE);

        if(isset($params['duration_life_is_null']))
        {
            $this->db->where("(duration_life = 0 OR prosentase = 0)",NULL,FALSE);
            $this->db->where('produksi.active', 0);
        }

        if(isset($params['isActive']))
        {
            $this->db->where('produksi.active', 1);
        }

        $this->db->join('master_produk','produksi.id_produk=master_produk.id_produk','join');
        $this->db->join('master_mesin','produksi.id_mesin=master_mesin.id_mesin','join');
        $this->db->order_by('waktu_mulai','desc');
        $res = $this->db->get('produksi');

        // echo $this->db->last_query();
        // exit;

        return $res;
    }

    function get_byid($params=array()){
        if(isset($params['id_produksi'])){
            $this->db->where('id_produksi',$params['id_produksi']);
            $this->db->join('(
                    SELECT SUM(b.downtime_duration) AS total_downtime
                    FROM produksi a
                    LEFT JOIN downtime b ON a.id_produksi = b.id_produksi AND STATUS = 3 AND b.waktu_mulai > a.waktu_mulai
                    AND a.id_produksi = '.$params['id_produksi'].'
                ) c','1=1','left');
        }
        $this->db->join('master_produk','produksi.id_produk=master_produk.id_produk','join');
        $res = $this->db->get('produksi')->first_row();
        return $res;
    }

    function add($params=array()){
        $res = $this->db->insert('produksi',$params);
        return $res;
    }

    function upd($params=array()){
        if(isset($params['id_produksi'])){
            $this->db->where('id_produksi',$params['id_produksi']);
        }
        unset($params['id_produksi']);
        
        $res = $this->db->update('produksi',$params);
        return $res;
    }
}