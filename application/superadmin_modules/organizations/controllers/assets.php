<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
Author: Mitesh Patel
Date: 24/6/2014
Version: 1.0
*/

class assets extends MY_Controller {

    function __construct() {
        parent::__construct();
        $path=getcwd();

        //---get working directory and map it to your module
        $file = $path . '/application/front-modules/' . implode('/', $this->uri->segments);

        //----get path parts form extension
        $path_parts = pathinfo( $file);
        //---set the type for the headers
        $file_type=  strtolower($path_parts['extension']);
        if (is_file($file)) {
            //----write propper headers
            switch ($file_type) {
                case 'css':
                    header('Content-type: text/css');
                    break;

                case 'js':
                    header('Content-type: text/javascript');
                    break;
                
                case 'json':
                    header('Content-type: application/json');
                    break;
                
                case 'xml':
                   header('Content-type: text/xml');
                    break;
                
                case 'pdf':
                  header('Content-type: application/pdf');
                    break;
                
                case 'jpg' || 'jpeg' || 'png' || 'gif':
                    header('Content-type: image/'.$file_type);
                    readfile($file);
                    exit;
                    break; 
            }
 
            include $file;
        } else {
            show_404();
        }
        exit;
    }

} 