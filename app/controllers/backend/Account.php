<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->input->post('create_user')){
			$fullname = $this->input->post('fullname');
			$id_number = $this->input->post('id_number');
			$password = $this->input->post('password');
			$phone = $this->input->post('phone');
			$email = $this->input->post('email');
			$gender = $this->input->post('gender');
			if($this->aauth->create_user($email, $password, $id_number, $fullname, $phone, $gender)){
				$this->session->set_flashdata('success', 'Account has been created');
				$this->redirect_url();
			}
			else{
				$this->session->set_flashdata('msg', $this->aauth->print_errors());
				$this->redirect_url();
			}
		}
		else{
		$data['users'] = $this->aauth->list_users();
		$this->template->add_title_segment('Account Management');
		$this->template->render('backend/account/list', $data);	
		}	
	}

	public function ban()
	{
		$id = $this->input->post('selector');
		if($id == $this->aauth->get_user()->id){
		$this->session->set_flashdata('msg', "You cannot ban yourself");
		$this->redirect_url();
		}else{
	  	$key = count($id);
	//multi delete using checkbox as a selector
	
		for($i=0;$i<$key;$i++){	
			$delete = $this->aauth->ban_user($id[$i]);
		}
		if($delete){
		$this->session->set_flashdata('success', "Account has been banned");
		$this->redirect_url();
			}
			else{
		$this->session->set_flashdata('msg', $this->lang->line('failure'));
		$this->redirect_url();
			}
		}
	}

	public function unban()
	{
		$id = $this->input->post('selector');
	  	$key = count($id);
	//multi delete using checkbox as a selector
	
		for($i=0;$i<$key;$i++){	
			$delete = $this->aauth->unban_user($id[$i]);
		}
		if($delete){
		$this->session->set_flashdata('success', "Account has been unbanned");
		$this->redirect_url();
			}
			else{
		$this->session->set_flashdata('msg', $this->lang->line('failure'));
		$this->redirect_url();
			}
	}

	public function group()
	{
		$name = $this->input->post('name');
		$definition = $this->input->post('definition');
		if($this->aauth->create_group($name, $definition)){
		$this->session->set_flashdata('success', "Group has been Created");
		$this->redirect_url();
		}
		else{
		$this->session->set_flashdata('msg', $this->aauth->print_errors());
		$this->redirect_url();
		}
	}
	public function delete_group()
	{
		$id = $this->input->post('selector');
	  	$key = count($id);
	//multi delete using checkbox as a selector
	
		for($i=0;$i<$key;$i++){	
			$delete = $this->aauth->delete_group($id[$i]);
		}
		if($delete){
		$this->session->set_flashdata('success', "Group has been Deleted");
		$this->redirect_url();
			}
			else{
		$this->session->set_flashdata('msg', $this->lang->line('failure'));
		$this->redirect_url();
			}
	}

}

/* End of file Account.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/backend/Account.php */