<?php

class User extends CI_Model {

    function fetch_user($user){
        $user = $this->security->xss_clean($user);
        return $this->db->query("SELECT * FROM Users WHERE email = ?  AND password = ?", array($user['email'], sha1($user['password'])))->row_array();
    }

    function create_user($user){ 
        $user = $this->security->xss_clean($user);
        $query = "INSERT INTO Users(first_name,last_name,email, password,created_at, updated_at) VALUES (?,?,?,?,NOW(),NOW())";
        $values = array($user['firstname'],$user['lastname'],$user['email'],sha1($user['password'])); 
        return $this->db->query($query, $values);
    }

    function fetch_profile($user_id){
        return $this->db->query("SELECT * FROM Users WHERE id=?", $user_id)->row_array();
    }


    function validate($post){
        $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|matches[password_confirmation]');
        $this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'trim|required');
        if($this->form_validation->run()) {
            return "valid";
          }else{
            return array(validation_errors());
          }
    }
}
