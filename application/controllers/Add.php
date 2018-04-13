<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_CONTROLLER.php');

class Add extends MY_CONTROLLER {
    public function index() {
        //Create the data array
        $data = array();
        
        //Create the scripts array
        $scripts = array();
        
        //Add script to the scripts array
        $scripts[] = base_url('js/add.js');
        
        //Add scripts array to the data array
        $data['scripts'] = $scripts;
        
        //Get modules
        $modules = $this->_getModules();
        $data['modules'] = $modules;
        
        //Get categories
        $users = $this->_getUsers();
        $data['users'] = $users;
        
        //Load the header
        $this->load->view('page/header',$data);
        
        //Load the page view
        $this->load->view('add',$data);
        
        //Load the footer
        $this->load->view('page/footer',$data);
    }
    
    public function save(){
        //Check if  this is an ajax request
        if($this->input->is_ajax_request()){
            //Get post data and decoded
            $post = json_decode($this->input->raw_input_stream);
            
            //Validate data
            $valid = $this->_validateBike($post);
            if($valid){
                //Set up array
                $data = array(
                    'user_id' => $post->user_id,
                    'EPC' => $post->EPC,
                    'bike_type' => $post->bike_type,
                    'brand' => $post->brand
                );
                //Load database
                $this->load->database();
                $inserted = $this->db->insert('bikes',$data);
                if($inserted) {
                    $message = 'Success';
                } else {
                    $message = 'Database problem';
                }
            }else{
                $message = 'Invalid data';
            }
            
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($message));
        }else{
            exit('No direct script access allowed');
        }
    }
}