<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
	/**
	 * DOCU: Functions for loading the model, validations/security.
	 * AUTHOR: Aaron Aco
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User');
		$this->load->model('Message');
	}
	private function get_csrf()
	{
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		return $csrf;
	}

	private function validatePermission($header)
	{
		$session = $this->session->userdata('id');
		if (empty($session)) {
			redirect('/' . $header);
		}
	}

	private function validateProcess($header)
	{
		if (!$this->input->post()) {
			redirect('/' . $header);
		}
	}
	/**
	 * DOCU: This function loads the view and fetches the messages, and comments
	 * AUTHOR: Aaron Aco
	 */
	public function index()
	{
		$this->validatePermission('');
		$header['title'] = 'Wall';
		$user = $this->User->fetch_profile($this->session->userdata('id'));
		$messages = $this->Message->fetchMessages();
		foreach($messages as $key => $message){
			$comments = $this->Message->fetchComments($message['id']);
			$messages[$key]['comments'] = $comments;
		}
		$data = array('header' => $header, 'user' => $user, 'csrf' => $this->get_csrf(), 'messages' => $messages);
		$this->load->view('main/wall', $data);
	}

	/**
	 * DOCU: Functions for proccessing data
	 * AUTHOR: Aaron Aco
	 */

	public function createMessageProccess(){
		$this->validateProcess('');
		$result = $this->Message->validateMessageField($this->input->post());
		if($result == 'valid'){
			$create_message = $this->Message->createMessage($this->input->post());
		}else{
			$errors = array(validation_errors());
			$this->session->set_flashdata('errors', $errors);
		}
		redirect('/main');
	}

	public function createCommentProccess(){
		$this->validateProcess('');
		$result = $this->Message->validateCommentField($this->input->post());
		if($result == 'valid'){
			$create_comment = $this->Message->createComment($this->input->post());
		}else{
			$errors = array(validation_errors());
			$this->session->set_flashdata('errors', $errors);
		}
		redirect('/main');
	}

	public function deleteMessageProccess(){
		$this->validateProcess('');
		$deleteMessage = $this->Message->deleteMessage($this->input->post());
		if($deleteMessage){
			redirect('/main');
		}
	}

	public function deleteCommentProccess(){
		$this->validateProcess('');
		$deleteComment = $this->Message->deleteComment($this->input->post());
		if($deleteComment){
			redirect('/main');
		}
	}
}
