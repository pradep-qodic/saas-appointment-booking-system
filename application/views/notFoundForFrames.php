
<?php 
	//$this->output->set_header('Access-Control-Allow-Origin: '.$this->config->item('requestOrigin'));
	$this->output->set_header('Content-Type: application/json; charset=utf-8');
	$json=json_encode(array("status"=>"error","message"=>"Unauthorised Access","data"=>""));
	echo $json;
?>

