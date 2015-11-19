<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->aauth->is_loggedin()){
			redirect(base_url('backend/'.$this->aauth->get_user()->name.'/dashboard'),'refresh');
		}
		if($this->input->post()){
			$data['email'] 			= e($this->input->post('email'));
			$data['pass'] 			= e($this->input->post('password'));

			if(empty($data['email']) || empty($data['pass'])){
				$this->session->set_flashdata('msg', "Login Credentials are required");
				$this->redirect_url();
			}

			if($this->loginAuth($data)){
				redirect(base_url('backend/'.$this->aauth->get_user()->name.'/dashboard'), 'refresh');
			}
			else{
				$this->session->set_flashdata('msg', "Invalid Login Credentials");
				$this->redirect_url();
			}
		}
		else{
		$this->template->add_title_segment('STEMS CPanel');
		$this->template->render('frontend/login');
		}
	}
}
/*

Angular JS Code
$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		$data['email'] = $request->email;
		$data['password'] = $request->password;
		$check = $this->loginAuth($data);
		$return = array();
		if($check){
			$return['status'] = 'success';
			$return['message']= 'Login Was Successful';
		}
		else{
			$return['status'] = 'error';
			$return['message']= $this->aauth->print_errors();
		}
		print_r(json_encode($return));
		*/