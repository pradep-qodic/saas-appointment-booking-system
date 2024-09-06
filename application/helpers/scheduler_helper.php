<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
Author: Mitesh Patel
Date: 16/12/2014
Version: 1.0
*/
if ( ! function_exists('admin_base_url'))
{
	function admin_base_url($uri = '')
	{
        $CI =& get_instance();
        $u=$CI->config->base_url();
        $res=substr($u, 0, -11);
        return $res.$uri;
	}
}
if ( ! function_exists('base_url1'))
{
    function base_url1($uri = '')
    {
        return base_url($uri);
    }
}
