<?php

class Message extends CI_Model {

    function createMessage($message){
        $message = $this->security->xss_clean($message);
        $query = "INSERT INTO Messages(user_id,message,created_at, updated_at) VALUES (?,?,NOW(),NOW())";
        $values = array($this->session->userdata('id'),$message['message']); 
        return $this->db->query($query, $values);
    }

    function fetchMessages(){
        return $this->db->query("SELECT users.first_name, users.last_name, messages.* FROM users INNER JOIN messages ON messages.user_id = users.id ORDER BY messages.created_at DESC")->result_array();
    }

    function deleteMessage($message_id){
        return $this->db->query("DELETE Messages, Comments FROM Messages INNER JOIN Comments WHERE Messages.id = Comments.message_id  AND Messages.id = ? ", $message_id); 
    }

    function createComment($comment){
        $comment = $this->security->xss_clean($comment);
        $query = "INSERT INTO Comments(message_id,user_id,comment,created_at, updated_at) VALUES (?,?,?,NOW(),NOW())";
        $values = array($comment['message_id'],$this->session->userdata('id'),$comment['comment']); 
        return $this->db->query($query, $values);
    }

    function fetchComments($message_id){
        return $this->db->query("SELECT users.first_name, users.last_name, comments.* FROM comments INNER JOIN users ON users.id = comments.user_id AND comments.message_id = ? ORDER BY comments.created_at ASC;" , $message_id)->result_array();
    }

    function deleteComment($comment_id){
        return $this->db->query("DELETE FROM Comments WHERE id = ?", $comment_id); 
    }

    function validateMessageField($post){
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        if($this->form_validation->run()) {
            return "valid";
          }else{
            return array(validation_errors());
          }
    }

    function validateCommentField($post){
        $this->form_validation->set_rules('comment', 'Comment', 'trim|required');
        if($this->form_validation->run()) {
            return "valid";
          }else{
            return array(validation_errors());
          }
    }



}
