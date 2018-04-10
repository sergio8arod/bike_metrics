<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Reports_dates extends MY_CONTROLLER {
    public function index() {
        //Create data array
        $data = array();
        //get our modules for the navbar
        $modules = $this->_getModules();
        $data['modules'] = $modules;
        
        //Add styles
        $styles = array(
            '//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css'
        );
        $data['styles'] = $styles;
        //Add scripts
        $scripts = array(
            '//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
            '//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js',
            base_url('js/reports.js')
        );
        $data['scripts']=$scripts;
        
        //Load view files
        $this->load->view('page/header',$data);
        $this->load->view('reports',$data);
        $this->load->view('page/footer',$data);
    }
    
    public function fetch(){
        //Checj if this is an ajax request
        if($this->input->is_ajax_request()){
            $results = array();
            //Load database
            $this->load->database();
            $results['chart'] = $this->db
                    ->select('DATE(a.access_time) AS Fecha, COUNT(a.id) AS Ingresos')
                    ->from('access a, parkings p')
                    ->where('a.parking_id=p.id')
                    ->where('p.client_id',$this->session->userdata('client_id'))
                    ->where("a.access_time>DATE_FORMAT(NOW() ,'%Y-%m-01')")
                    ->group_by('DATE(a.access_time)')
                    ->get()
                    ->result();
            //Check if there are results
            if($results['chart'] == false){
                $results['chart'] = 'problem';
            }
            
            $results['total'] = $this->db
                    ->select('COUNT(a.id) AS Ingresos')
                    ->from('access a, parkings p')
                    ->where('a.parking_id=p.id')
                    ->where('p.client_id',$this->session->userdata('client_id'))
                    ->get()
                    ->row();
            //Check if there are results
            if($results['total'] == false){
                $results['total'] = 0;
            }else{
                $results['total'] = $results['total']->Ingresos;
            }
            
            //JSON encode the purchases
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($results));
        }else{
            exit('No direct script access allowed');
        }
    }
    
    public function fetchd()
    {
        // Check if this is an ajax request
        if ($this->input->is_ajax_request()) {
            // Get post data and decode it
            $post = json_decode($this->input->raw_input_stream);
            
            // Validate from and to
            $from = $post->from;
            $to = $post->to;
            
            if ($this->_validateDate($from) && $this->_validateDate($to)) {
                // Load up the database
                $this->load->database();
                // Query the database
                $results = $this->db
                        ->select('DATE(a.access_time) AS Fecha, COUNT(a.id) AS Ingresos')
                        ->from('access a, parkings p')
                        ->where('a.parking_id=p.id')
                        ->where('p.client_id',$this->session->userdata('client_id'))
                        ->where('a.access_time >=', $from)
                        ->where('a.access_time <=', $to)
                        ->group_by('DATE(a.access_time)')
                        ->get()
                        ->result();
                        
                if ($results == false) {
                    $results = 'problem';
                }                        
            } else {
                $results = 'problem';
            }
            
            // Return as json
            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($results));
        } else {
            exit('No direct script access allowed');
        }
    }
    
    public function totalAccess(){
        //Checj if this is an ajax request
        if($this->input->is_ajax_request()){
            //Load database
            $this->load->database();
            $results = $this->db
                    ->select('DCOUNT(a.id) AS Ingresos')
                    ->from('access a, parkings p')
                    ->where('a.parking_id=p.id')
                    ->where('p.client_id',$this->session->userdata('client_id'))
                    ->get()
                    ->result();
            //Check if there are results
            if($results == false){
                $results = 'problem';
            }
            //JSON encode the purchases
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($results));
        }else{
            exit('No direct script access allowed');
        }
    }
}
