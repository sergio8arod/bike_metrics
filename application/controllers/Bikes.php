<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bikes extends MY_Controller {
    public function index(){
        //Create the data array
        $data = array();
        
        //Create the scripts array
        $scripts = array();
        //Add script to the scripts array
        $scripts[] = 'https://cdn.datatables.net/v/dt/dt-1.10.16/b-1.5.0/b-html5-1.5.0/b-print-1.5.0/r-2.2.1/datatables.min.js';
        $scripts[] = base_url('js/bikes.js');        
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
        $this->load->view('bikes',$data);
        
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
            $bikes = $this->db
                    ->select('*')
                    ->from('bikes b, users u')
                    ->where('b.user_id=u.id')
                    ->where('u.client_id',$this->session->userdata('client_id'))
                    ->get()
                    ->result();
            
            //Add DT_RowId to array
            foreach($bikes as $bike){
                $bike->DT_RowId = 'id_'.$bike->id;
            }
            //JSON encode the purchases
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($bikes));
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
                $bike= $this->db->get_where('bikes',array('id' => $id))->row();
                if($bike == false){
                    $bike= 'error';
                }
            }else{
                $bike= 'error';
            }
            //encode output
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($bike));
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
