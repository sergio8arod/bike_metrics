<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_CONTROLLER.php');

class Users extends MY_Controller {
    public function index(){
        //Create the data array
        $data = array();
        
        //Create the scripts array
        $scripts = array();
        //Add script to the scripts array
        $scripts[] = 'https://cdn.datatables.net/v/dt/dt-1.10.16/b-1.5.0/b-html5-1.5.0/b-print-1.5.0/r-2.2.1/datatables.min.js';
        $scripts[] = base_url('js/users.js');        
        //Add scripts array to the data array
        $data['scripts'] = $scripts;
        
        //Add style to data array
        $styles = array();
        $styles[] = 'https://cdn.datatables.net/v/bs/dt-1.10.16/af-2.2.2/b-1.4.2/r-2.2.0/datatables.min.css';
        $data['styles'] = $styles;
        
        //Get modules
        $modules = $this->_getModules();
        $data['modules'] = $modules;
        
        //Get clients
        $clients = $this->_getClients();
        $data['clients'] = $clients;
        
        //Load the header
        $this->load->view('page/header',$data);
        
        //Load the page view
        $this->load->view('users',$data);
        
        //Load the footer
        $this->load->view('page/footer',$data);
    }
    
    public function fetch(){
        //Checj if this is an ajax request
        if($this->input->is_ajax_request()){
            //Load database
            $this->load->database();
            //$this->db->select('bikes.id,bikes.user_id,bikes.EPC,bikes.bike_type,bikes.brand');
            //$this->db->from('purchases');
            //$this->db->join('categories','purchases.category_id=categories.id');
            $users = $this->db->get_where('users',array('client_id' => $this->session->userdata('client_id')))->result();
            
            //Add DT_RowId to array
            foreach($users as $user){
                $user->DT_RowId = 'id_'.$user->id;
            }
            //JSON encode the purchases
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($users));
        }else{
            exit('No direct script access allowed');
        }
    }
    
    public function load(){
        //Check if this is an ajax request
        if($this->input->is_ajax_request()){
            //Get post data and decode it
            $post = json_decode($this->input->raw_input_stream);
            $id = $post->id;
            //Validate post data
            if(is_numeric($id)){
                //Load database
                $this->load->database();
                $user= $this->db->get_where('users',array('id' => $id))->row();
                if($user == false){
                    $user= 'error';
                }
            }else{
                $user= 'error';
            }
            //encode output
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($user));
        }else{
            exit('No direct script access allowed');
        }
    }
    
    protected function _validate($post){
        $valid = true;
        if(!$this->_validateDate($post->date)){
            $valid = false;
        }
        if(!is_numeric($post->price)){
            $valid = false;
        }
        if(empty($post->description)){
            $valid = false;
        }
        $categories = $this->_getCategories();
        $categoryIDs = array();
        foreach($categories as $category){
            $categoryIDs[] = $category->id;
        }
        if(!in_array($post->category_id,$categoryIDs)){
            $valid = false;
        }
        return $valid;
    }
    
    public function save(){
        //Check if this is an ajax request
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
                $updated = $this->db->update('bikes',$data,array('id'=>$post->id));
                if($updated) {
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
