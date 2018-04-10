<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_CONTROLLER extends CI_Controller {
    
    public function __construct() {
        //Run the parent's constructor
        parent::__construct();
        
        //Check if the usser is logged in
        $logged_in = $this->session->userdata('logged_in');
        
        //If not logged in, redirect to login form
        if($logged_in == FALSE) {
            redirect('welcome/index');
        }
    }

    protected function _getModules() {
        //Make modules array
        $modules = array();
        
        //Add module to array
        $modules[] = array(
            'name' => 'Agregar Bici',
            'href' => 'add/index'
        );
        //Bikes module to array
        $modules[] = array(
            'name' => 'Bicis',
            'href' => 'bikes/index'
        );
        //Users module to array
        $modules[] = array(
            'name' => 'Usuarios',
            'href' => 'users/index'
        );
        //Access module to array
        $modules[] = array(
            'name' => 'Ingresos',
            'href' => 'access/index'
        );
        //Reports module to array
        /*$modules[] = array(
            'name' => 'Indicadores',
            'href' => 'reports/index'
        );
        //Add settings
        $modules[] = array(
            'name' => 'Configuraciones',
            'href' => 'settings/form'
        );*/
        
        //Return modules
        return $modules;
    }
    
    protected function _getUsers(){
        //Load database
        $this->load->database();
        
        //Fetch users
        $users= $this->db->get_where('users',array('client_id' => $this->session->userdata('client_id')))->result();
        
        //Return array of object
        return $users;
    }
    
    protected function _getClients(){
        //Load database
        $this->load->database();
        
        //Fetch categories
        $users= $this->db->get('clients')->result();
        
        //Return array of object
        return $users;
    }
    
    protected function _getVinculations($client_id){
        //Load database
        $this->load->database();
        
        //Fetch vinculations of client
        $vinculations= $this->db->get_where('vinculations',array('clien_id' => $client_id))->result();
        
        //Return array of object
        return $vinculations;
    }
    
    protected function _getFaculties($client_id){
        //Load database
        $this->load->database();
        
        //Fetch categories
        $faculties= $this->db->get_where('faculties',array('clien_id' => $client_id))->result();
        
        //Return array of object
        return $faculties;
    }
    
    protected function _validateBike($post){
        $valid = $this->_validateUser($post->user_id);
        if(empty($post->bike_type)){
            $valid = false;
        }
        if(empty($post->EPC)){
            $valid = false;
        }
        if(empty($post->brand)){
            $valid = false;
        }
        return $valid;
    }
    
    protected function _validateUser($user_id){
        $valid = true;
        $users = $this->_getUsers();
        $usersIDs = array();
        foreach($users as $user){
            $usersIDs[] = $user->id;
        }
        if(!in_array($user_id,$usersIDs)){
            $valid = false;
        }
        return $valid;
    }
    
    protected function _validateDate($date){
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}