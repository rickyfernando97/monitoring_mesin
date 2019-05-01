<?php

$config['id_modul'] = 1;
$config['app_name'] = 'MONITORING MACHINE';
$config['app_client'] = 'CV DANAGUNG';


$config['base_url'] = "http://".$_SERVER['HTTP_HOST'];
$config['base_url'] .= preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])=="\\"?"":dirname($_SERVER['SCRIPT_NAME'])).'/';

$config['base_media'] = $config['base_url'].'media/';
$config['base_bootstrap'] = $config['base_media'].'bootstrap/';
$config['base_css'] = $config['base_media'].'css/';
$config['base_js'] = $config['base_media'].'js/';

$config['path_tpl'] = FCPATH2.'client/template/';

$config['base_client'] = $config['base_url'].'client/';
$config['base_client_images'] = $config['base_client'].'images/';


// config app
$config['log_in_link'] = 'log/index';
$config['log_out_link'] = 'log/out';
$config['usergroupid_administrator'] = 1;
$config['usergroupid_supervisor'] = 4;
$config['usergroupid_perawatan'] = 2;
$config['usergroupid_operator'] = 3;
$config['access_root_administrator'] = 'admin';
$config['access_root_supervisor'] = 'supervisor';
$config['access_root_perawatan'] = 'maintenance';
$config['access_root_operator'] = 'operator';