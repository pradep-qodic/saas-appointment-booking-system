<?php
//$this->output->set_header('Access-Control-Allow-Origin: '.$this->config->item('requestOrigin'));
$this->output->set_header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
$this->output->set_header('Access-Control-Allow-Headers: Authorization,X-Requested-With');
$this->output->set_header('Content-Type: application/json; charset=utf-8');
echo $json;
?>