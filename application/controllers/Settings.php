<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_CONTROLLER {
    public function index() {
        //Load database
        $this->load->database();
        
        //Get row
        $row = $this->db->get_where('settings',array('key' => 'favorite'))->row();
        
        //Get favorite
        $favorite = $row->value;
        
        //Get modules
        $modules = $this->_getModules();
        
        //Loop over them to find the favorite
        foreach($modules as $module){
            if($module['name']==$favorite){
                $url = $module['href'];
                break;
            }
        }
        redirect($url);
    }
    
    public function form() {
        //Create the data array
        $data = array();
        
        //Create the scripts array
        $scripts = array();
        
        //Add script to the scripts array
        $scripts[] = base_url('js/settings.js');
        
        //Add scripts array to the data array
        $data['scripts'] = $scripts;
        
        //Get modules
        $modules = $this->_getModules();
        $data['modules'] = $modules;
        
        //Load the header
        $this->load->view('page/header',$data);
        
        //Load the page view
        $this->load->view('settings',$data);
        
        //Load the footer
        $this->load->view('page/footer',$data);        
    }
    
    public function savesettings() {
        //Check if this is an AJAX request
        if($this->input->is_ajax_request()){
            //Get POST data and decode it
            $post = json_decode($this->input->raw_input_stream);
            //Validate settings
            $valid = $this->_validateSettings($post);
            
            //If valid save to DB
            if($valid){
                //Load database
                $this->load->database();
                //Set favorite
                $this->db->set('value',$post->favorite);
                $this->db->where('key','favorite');
                //Update the table
                $result = $this->db->update('settings');
                //If good result, set message to good
                if($result) {
                    $message = 'good';
                } else {
                    $message = 'bad';
                }
            } else {
                $message = 'bad';
            }
            //Return message as JSON
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($message));
        } else {
            exit('No direct script access allowed');
        }
    }
    
    public function getsettings() {
        //Check if this is an AJAX request
        if($this->input->is_ajax_request()){
            //Load database
            $this->load->database();
            //Fetch settings
            $results = $this->db->get('settings')->result();
            $settings = array();
            foreach($results as $result) {
                $key = $result->key;
                $value = $result->value;
                $settings[$key] = $value;
            }
            
            //Return message as JSON
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($settings));
        } else {
            exit('No direct script access allowed');
        }
    }
    
    protected function _validateSettings($post) {
        //Fetch favorite  module from the post data
        $favorite = $post->favorite;
        
        //Fetch modules to compare
        $modules = $this->_getModules();
        
        //Pull module name into an array
        $names = array();
        foreach($modules as $module) {
            $names[] = $module['name'];
        }
        
        //Return true if favorite is a module
        return in_array($favorite, $names);
    }
}