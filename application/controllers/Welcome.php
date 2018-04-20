<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_CONTROLLER.php');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
            //Check if the usser is logged in
            $logged_in = $this->session->userdata('logged_in');
        
            //If not logged in, redirect to login form
            if($logged_in == TRUE) {
                redirect('add/index');
            } else {
                $this->load->view('welcome_message');
            }
            
	}
        public function login()
        {
            //Check if this is an AJAX request
            if($this->input->is_ajax_request()){
                $data = array();
                //Get POST data and decode it
                $post = json_decode($this->input->raw_input_stream);
                $user = $this->_getUser($post->inputEmail);
                
                //Initialize encryption class
                $this->load->library('encrypt');
                
                if($post->inputPassword == $this->encrypt->decode($user->pswd)) {
                    if($user->client_id>0){
                        //Add user login info to session
                        $this->session->set_userdata('logged_in',TRUE);
                        $this->session->set_userdata('client_id',$user->client_id);
                        $this->session->set_userdata('user_id',$user->id);
                        $data['role'] = $user->role;
                        $data['message'] = "good";                        
                    } else {
                        $data['message'] = "bad";
                    }
                }else{
                    $data['message'] = "Invalid user";
                    $data['user'] = $user;
                }
                //Check email and password
                
                //Return message as JSON
                $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
            } else {
                exit('No direct script access allowed');
            }
        }
        public function register()
        {
            $this->load->view('register');
        }
        public function logout()
        {
            //Logout the user 
            $this->session->unset_userdata('logged_in');
            $this->session->unset_userdata('client_id');
            //Redirect back to login
            redirect('welcome/index');
        }
        protected function _getUser($email){
            //Load database
            $this->load->database();
            $db_user= $this->db->get_where('users',array('email' => $email))->row();
            /*$client_id = 0;
            if($user->inputPassword == $db_user->pswd) {
                $client_id = $db_user->client_id;
            }*/
            return $db_user;
        }
}
