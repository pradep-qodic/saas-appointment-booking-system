<?php
/*
Author: Daniel Gutierrez
Date: 9/18/12
Version: 1.0
*/

class Menu_model extends CI_Model{
	
	function create(){
		
	}
	
	function read(){
		//Just a prototype
		$menu = array();
		$submenu=array();
		$menu[0] = new stdClass();
		$menu[0]->url = "events";
		$menu[0]->name = "Events";
		
		$menu[1] = new stdClass();
		$menu[1]->url = "";
		$menu[1]->name = "Settings";
		
			/*$submenu[0] = new stdClass();
			$submenu[0]->url = "";
			$submenu[0]->name = "Change Password";*/
            
            $submenu[0] = new stdClass();
			$submenu[0]->url = "users/account";
			$submenu[0]->name = "Edit Account";
			
			$submenu[1] = new stdClass();
			$submenu[1]->url = "users/logout";
			$submenu[1]->name = "Logout";
			
		$menu[1]->submenu=$submenu;
		return $menu;
	}
	
	function menu_admin(){
		//Just a prototype

		$menu = new stdClass();
		$menu->url = "";
		$menu->name = "Admin";

		return $menu;
	}
	
	function update(){
		
	}
	
	function delete(){
		
	}
	
	
		
}

?>