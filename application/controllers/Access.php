<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends MY_Controller {
    public function index(){
        //Create the data array
        $data = array();
        
        //Create the scripts array
        $scripts = array();
        //Add script to the scripts array
        $scripts[] = 'https://cdn.datatables.net/v/dt/dt-1.10.16/b-1.5.0/b-html5-1.5.0/b-print-1.5.0/r-2.2.1/datatables.min.js';
        $scripts[] = base_url('js/access.js');        
        //Add scripts array to the data array
        $data['scripts'] = $scripts;
        
        //Add style to data array
        $styles = array();
        $styles[] = 'https://cdn.datatables.net/v/bs/dt-1.10.16/af-2.2.2/b-1.4.2/r-2.2.0/datatables.min.css';
        $data['styles'] = $styles;
        
        //Get modules
        $modules = $this->_getModules();
        $data['modules'] = $modules;
        
        //Get categories
        $users = $this->_getUsers();
        $data['users'] = $users;
                
        //Load the header
        $this->load->view('page/header',$data);
        
        //Load the page view
        $this->load->view('access',$data);
        
        //Load the footer
        $this->load->view('page/footer',$data);
    }
    
    public function fetch(){
        //Checj if this is an ajax request
        if($this->input->is_ajax_request()){
            //Load database
            $this->load->database();
            $this->db->select('access.id,users.full_name,bikes.brand,access.access_time,parkings.address');
            $this->db->from('access');
            $this->db->join('parkings','access.parking_id=parkings.id');
            $this->db->join('clients','parkings.client_id=clients.id');
            $this->db->join('bikes','access.EPC=CONCAT(clients.EPC,bikes.EPC)');
            $this->db->join('users','bikes.user_id=users.id');
            $this->db->where('clients.id',$this->session->userdata('client_id'));
            $access = $this->db->get()->result();
            
            //JSON encode the purchases
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($access));
        }else{
            exit('No direct script access allowed');
        }
    }
    
    public function test(){
        echo 'already ran'; die;
        //Load database
        $this->load->database();
        
        //Load the faker library
        require_once FCPATH . 'application/third_party/Faker-master/src/autoload.php';
        //Initiate Faker, so we can use it
        $faker = faker\Factory::create();
        
        //Create 3000 fake purchases
        for($i=0; $i<3000; $i++){
            $date= $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d');
            $price= $faker->randomFloat(2,1,150);
            $description= ucfirst($faker->words(2, true));
            $category_id= $faker->numberBetween(1,6);
            //Create data array
            $data= array(
                'date' => $date,
                'price' => $price,
                'description' => $description,
                'category_id' => $category_id
            );
            //Insert fake purchase into database
            $this->db->insert('purchases',$data);
        }
        echo 'Done';
    }
}
