<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
	/**
	 * DOCU: Functions for security and loading models
	 * AUTHOR: Aaron Aco
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User');
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
		if (!empty($session)) {
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
	 * DOCU: Functions for loading views
	 * AUTHOR: Aaron Aco
	 */
	public function index()
	{
		$this->validatePermission('main');
		$header['title'] = 'Sign in';
		$data = array('header' => $header, 'csrf' => $this->get_csrf());
		$this->load->view('user/signin', $data);
	}

	public function signup()
	{
		$this->validatePermission('main');
		$header['title'] = "Sign up";
		$data = array('header' => $header, 'csrf' => $this->get_csrf());
		$this->load->view('user/signup', $data);
	}
	/**
	 * DOCU: Functions for proccessing data
	 * AUTHOR: Aaron Aco
	 */
	public function signinProcess()
	{
		$this->validateProcess('');
		$signin_user = $this->User->fetch_user($this->input->post());
		if ($signin_user) {
			$message = "Success! Welcome back, {$signin_user['first_name']} {$signin_user['last_name']}";
			$this->session->set_flashdata('success', $message);
			$this->session->set_userdata('id', $signin_user['id']);
			redirect('/main');
		} else {
			$message = "<p>Login failed! Please check your credentials.</p>";
			$this->session->set_flashdata('errors', array($message));
			redirect('/');
		}
	}
	public function signupProcess()
	{
		$this->validateProcess('');
		$result = $this->User->validate($this->input->post());
		if ($result == "valid") {
			$create_user = $this->User->create_user($this->input->post());
			if ($create_user) {
				$message = "Success! You may now sign in!";
				$this->session->set_flashdata('success', $message);
				redirect('/');
			}
		} else {
			$errors = array(validation_errors());
			$this->session->set_flashdata('errors', $errors);
			redirect('/signup');
		}
	}
	public function signoutProcess()
	{
		$message = "Success! Goodbye!";
		$this->session->set_flashdata('success', $message);
		$this->session->unset_userdata('id');
		redirect('/');
	}
}
