<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UserInd extends MY_CONTROLLER {
    public function index() {
        //Create data array
        $data = array();
        
        //Add styles
        $styles = array(
            '//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css'
        );
        $data['styles'] = $styles;
        //Add scripts
        $scripts = array(
            '//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
            '//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js',
            base_url('js/userInd.js')
        );
        $data['scripts']=$scripts;
        
        //Load view files
        $this->load->view('page/header_user',$data);
        $this->load->view('userInd',$data);
        $this->load->view('page/footer',$data);
    }
    
    public function fetch(){
        //Checj if this is an ajax request
        if($this->input->is_ajax_request()){
            $results = array();
            //Load database
            $this->load->database();
            $this->db->query("SET lc_time_names = 'es_CO'");
            
            $results['user_id'] = $this->session->userdata('user_id');
            $results['chart'] = $this->db
                    ->select('MONTHNAME(a.access_time) AS Fecha, COUNT(a.id) AS Ingresos')
                    ->from('access a, bikes b, users u, clients c')                 
                    ->where('b.user_id=u.id')
                    ->where('u.client_id=c.id')
                    ->where('a.EPC=CONCAT(c.EPC,b.EPC)')
                    ->where('u.id',$this->session->userdata('user_id'))
                    ->group_by('MONTHNAME(a.access_time)')
                    ->order_by('YEAR(a.access_time)')
                    ->order_by('MONTH(a.access_time)')
                    ->get()
                    ->result();
            //Check if there are results
            if($results['chart'] == false){
                $results['chart'] = 'problem';
            }
            
            $results['total'] = $this->db
                    ->select('COUNT(a.id) AS Ingresos')
                    ->from('access a, bikes b, users u, clients c')                 
                    ->where('b.user_id=u.id')
                    ->where('u.client_id=c.id')
                    ->where('a.EPC=CONCAT(c.EPC,b.EPC)')
                    ->where('u.id',$this->session->userdata('user_id'))
                    ->get()
                    ->row();
            //Check if there are results
            if($results['total'] == false){
                $results['total'] = 0;
            }else{
                $results['total'] = $results['total']->Ingresos;
            }
            
            $results['distance'] = $this->db
                    ->select('SUM(u.d_home) AS Distancia')
                    ->from('access a, bikes b, users u, clients c')                 
                    ->where('b.user_id=u.id')
                    ->where('u.client_id=c.id')
                    ->where('a.EPC=CONCAT(c.EPC,b.EPC)')
                    ->where('u.id',$this->session->userdata('user_id'))
                    ->get()
                    ->row();
            //Check if there are results
            if($results['distance'] == false){
                $results['distance'] = 0;
            }else{
                $results['distance'] = $results['distance']->Distancia;
            }
            
            $results['users'] = $this->db
                    ->select('u.full_name AS Usuario, COUNT(a.id) AS Ingresos')
                    ->from('access a, bikes b, users u, clients c')
                    ->where('b.user_id=u.id')
                    ->where('u.client_id=c.id')
                    ->where('a.EPC=CONCAT(c.EPC,b.EPC)')
                    ->where('c.id',$this->session->userdata('client_id'))
                    ->where("a.access_time>DATE_FORMAT(NOW() ,'%Y-%m-01')")
                    ->order_by('Ingresos','DESC')
                    ->group_by('u.id')
                    ->get()
                    ->row();
            //Check if there are results
            if($results['users'] == false){
                $results['user'] = '';
            }else{
                $results['user'] = $results['users']->Usuario;
                $results['userAccess'] = $results['users']->Ingresos;
            }
            
            //JSON encode the purchases
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($results));
        }else{
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
