<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModify extends CI_Controller {
    public function index() {
        //Create the data array
        $data = array();
        
        $clients = $this->_getClients();
        $data['clients'] = $clients;
                
        //Load the page view
        $this->load->view('userModify',$data);
    }
    
    public function fetch(){
        //Check if  this is an ajax request
        if($this->input->is_ajax_request()){
            
            $data = array();
            
            $user = $this->_getUser($this->session->userdata('user_id'));
            $data['user'] = $user;
            
            $vinculations = $this->_getVinculations($this->session->userdata('client_id'));
            $data['vinculations'] = $vinculations;
                
            $client = $this->_getClient($this->session->userdata('client_id'));
            $data['lat'] =$client->lat;
            $data['lng'] =$client->lng;
            if($client->type==1){
                $data['message'] = "university";
                $faculties = $this->_getFaculties($this->session->userdata('user_id'));
                $data['faculties'] = $faculties;
            }else{
                $data['message'] = "company";
            }
            
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }else{
            exit('No direct script access allowed');
        }
    }
    
    public function save(){
        //Check if  this is an ajax request
        if($this->input->is_ajax_request()){
            //Get post data and decoded
            $post = json_decode($this->input->raw_input_stream);
            
            //Validate data
            $valid = $this->_validateUser($post);
            if($valid=="true"){
                //Initialize encryption class
                $this->load->library('encrypt');
                //Set up array
                $data = array(
                    'client_id' => $post->inputClientID,
                    'full_name' => $post->inputName,
                    'identification' => $post->inputIdentification,
                    'birthdate' => $post->inputBirthdate,
                    'gender' => $post->inputGender,
                    'email' => $post->inputEmail,
                    'pswd' => $this->encrypt->encode($post->inputPassword),
                    'mant_frecuency' => $post->inputMantFrec,
                    'd_home' => $post->inputDistance,
                    'drbici' => $post->inputDrBici,
                    'address' => $post->inputAddress,
                    'cellphone' => $post->inputCellphone,
                    'vinculation' => $post->inputVinculation,
                    'faculty' => $post->inputFacultad,
                    'ipTerms' => $post->ipTerms
                );
                //Load database
                $this->load->database();
                $inserted = $this->db->insert('users',$data);
                if($inserted) {
                    $message = 'Success';
                } else {
                    $message = 'Database problem';
                }
            }else{
                $message = $valid;
            }
            
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($message));
        }else{
            exit('No direct script access allowed');
        }
    }
    
    protected function _validateClient($clientID){
        $valid = true;
        
        $clients = $this->_getClients();
        $clientsIDs = array();
        foreach($clients as $client){
            $clientsIDs[] = $client->id;
        }
        if(!in_array($clientID,$clientsIDs)){
            $valid = false;
        }
        return $valid;
    }
    
    protected function _validateUser($post){
        $valid = "true";
        
        $this->load->database();
        
        $domain = 'FIND_IN_SET('.$this->db->escape(substr($post->inputEmail,strpos($post->inputEmail,"@")+1)).',domains) and id='.$post->inputClientID;
        $client = $this->db
                ->select('*')
                ->from('clients')
                ->where($domain)
                ->get()
                ->row();
        if(empty($client)){
            $valid="Ingresa un email valido";
        }
        
        $user = $this->db->get_where('users',array('email' => $post->inputEmail))->row();
        if(!empty($user)){
            $valid = "El email ingresado ya existe.";
        }
        
        $user = $this->db->get_where('users',array('identification' => $post->inputIdentification))->row();
        if(!empty($user)){
            $valid = "La identificación ingresada ya existe.";
        }        
        
        if($post->inputDistance<=0){
            $valid = "Debes arrastar el marcador (punto rojo en el mapa) a tu lugar de residencia.";
        }
        return $valid;
    }
    
    protected function _getClient($clientID){
        $this->load->database();
        $client = $this->db->get_where('clients',array('id' => $clientID))->row();
        return $client;
    }
    
    protected function _getUser($userID){
        $this->load->database();
        $client = $this->db->get_where('users',array('id' => $userID))->row();
        return $client;
    }

    protected function _getClients(){
        //Load database
        $this->load->database();
        
        //Fetch categories
        $clients= $this->db->get('clients')->result();
        
        //Return array of object
        return $clients;
    }
    
    protected function _getVinculations($client_id){
        //Load database
        $this->load->database();
        
        //Fetch vinculations of client
        $this->db->where('client_id =',$client_id);
        $this->db->where('active =',0);
        $vinculations= $this->db->get('vinculations')->result();
        
        //Return array of object
        return $vinculations;
    }
    
    protected function _getFaculties($client_id){
        //Load database
        $this->load->database();
        
        //Fetch categories
        $this->db->where('client_id =',$client_id);
        $this->db->where('active =',0);
        $faculties= $this->db->get('faculties')->result();
        
        //Return array of object
        return $faculties;
    }
}