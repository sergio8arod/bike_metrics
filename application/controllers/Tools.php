<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends CI_Controller {
    public function install($module)
    {
        if(is_cli()){
            switch($module) {
                case 'clients':
                    $result = $this->_installClients();
                    $this->_feedback($result,'Clients');
                    break;
                case 'users':
                    $result = $this->_installUsers();
                    $this->_feedback($result,'Users');
                    break;
                case 'access':
                    $result = $this->_installAccess();
                    $this->_feedback($result,'Access');
                    break;
                default:
                    echo 'No such module'.PHP_EOL;
            }
        } else {
            exit('No direct script access allowed cli');
        }
    }
    
    protected function _feedback($result, $module){
        if($result){
            echo $module.' module installed'.PHP_EOL;
        } else{
            echo 'Problem installing '.$module.' module '.PHP_EOL;
        }
    }
        
    protected function _installClients(){
        //Load database
        $this->load->database();
        //Create clients table
        $sql = 'CREATE TABLE IF NOT EXISTS clients'
                . '('
                . 'id INT(9) NOT NULL AUTO_INCREMENT,'
                . 'name VARCHAR(255) NOT NULL,'
                . 'active VARCHAR(2) NOT NULL,'
                . 'type VARCHAR(2) NOT NULL,'
                . 'domains VARCHAR(4000),'
                . 'terms VARCHAR(500) NOT NULL,'
                . 'lat DECIMAL NOT NULL,'
                . 'lng DECIMAL NOT NULL,'
                . 'EPC VARCHAR (24) NOT NULL,'
                . 'PRIMARY KEY(id)'
                . ');';
        $success = $this->db->query($sql);
        if($success){
            //Create vinculations
            $sql = 'CREATE TABLE IF NOT EXISTS vinculations'
                    . '('
                    . 'id INT(9) NOT NULL AUTO_INCREMENT,'
                    . 'name VARCHAR(150) NOT NULL,'
                    . 'client_id INT(9) NOT NULL,'
                    . 'active VARCHAR(2) NOT NULL DEFAULT 0,'
                    . 'PRIMARY KEY(id)'
                    . 'FOREIGN KEY(client_id) REFERENCES clients(id)'
                    . ');';
            $success = $this->db->query($sql);
            
            $sql = 'CREATE TABLE IF NOT EXISTS faculties'
                    . '('
                    . 'id INT(9) NOT NULL AUTO_INCREMENT,'
                    . 'name VARCHAR(150) NOT NULL,'
                    . 'client_id INT(9) NOT NULL,'
                    . 'active VARCHAR(2) NOT NULL DEFAULT 0,'
                    . 'PRIMARY KEY(id)'
                    . 'FOREIGN KEY(client_id) REFERENCES clients(id)'
                    . ');';
            $success = $this->db->query($sql);
            
            //Create parkings table
            $sql = 'CREATE TABLE IF NOT EXISTS parkings'
                    . '('
                    . 'id INT(9) NOT NULL AUTO_INCREMENT,'
                    . 'client_id INT(9) NOT NULL,'
                    . 'address VARCHAR(255) NOT NULL,'
                    . 'PRIMARY KEY(id),'
                    . 'FOREIGN KEY(client_id) REFERENCES clients(id)'
                    . ');';
            return $this->db->query($sql);
        } else{
            //Problems
            return false;
        }
    }
    
    protected function _installUsers(){
        //Load database
        $this->load->database();
        //Create users table
        $sql = 'CREATE TABLE IF NOT EXISTS users'
                . '('
                . 'id INT(9) NOT NULL AUTO_INCREMENT,'
                . 'client_id INT(9) NOT NULL,'
                . 'full_name VARCHAR(255) NOT NULL,'
                . 'identification VARCHAR(20) NOT NULL,'
                . 'birthdate DATE NOT NULL,'
                . 'gender VARCHAR(6),'
                . 'address VARCHAR(200),'
                . 'cellphone VARCHAR(10),'
                . 'address VARCHAR(200),'
                . 'vinculation_id INT(9) NOT NULL,'
                . 'faculty_id INT(9) NOT NULL,'
                . 'email VARCHAR(500) NOT NULL,'
                . 'pswd VARCHAR(250) NOT NULL,'
                . 'mant_frecuency VARCHAR(20) NOT NULL,'
                . 'drbici VARCHAR(2) NOT NULL,'
                . 'registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,'
                . 'd_home INT(3) NOT NULL DEFAULT 6,'
                . 'role INT(4) NOT NULL DEFAULT 0,'
                . 'ipTerms VARCHAR(20),'
                . 'PRIMARY KEY(id),'
                . 'FOREIGN KEY(client_id) REFERENCES clients(id),'
                . 'FOREIGN KEY(vinculation_id) REFERENCES vinculations(id),'
                . 'FOREIGN KEY(faculty_id) REFERENCES faculties(id)'
                . ');';
        $success = $this->db->query($sql);
        if($success){
            //Create bikes table
            $sql = 'CREATE TABLE IF NOT EXISTS bikes'
                    . '('
                    . 'id INT(9) NOT NULL AUTO_INCREMENT,'
                    . 'user_id INT(9) NOT NULL,'
                    . 'EPC VARCHAR(50) NOT NULL,'
                    . 'bike_type VARCHAR(255) NOT NULL,'
                    . 'brand VARCHAR(255) NOT NULL,'
                    . 'PRIMARY KEY(id),'
                    . 'FOREIGN KEY(user_id) REFERENCES users(id)'
                    . ');';
            return $this->db->query($sql);
        } else{
            //Problems
            return false;
        }
    }
    
    protected function _installAccess(){
        //Load database
        $this->load->database();
        //Create access table
        $sql = 'CREATE TABLE IF NOT EXISTS access'
                . '('
                . 'id INT(9) NOT NULL AUTO_INCREMENT,'
                . 'id_local INT(20) NOT NULL,'
                . 'EPC VARCHAR(50) NOT NULL,'
                . 'access_time DATETIME NOT NULL,'
                . 'parking_id INT(9) NOT NULL,'
                . 'PRIMARY KEY(id),'
                . 'FOREIGN KEY(parking_id) REFERENCES parkings(id)'
                . ');';
        return $this->db->query($sql);
    }
}
