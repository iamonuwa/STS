<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['error_log'] = $this->error_model->get_all();
		$this->template->add_title_segment('Dashboard');
		$this->template->render('backend/dashboard', $data);
	}

	public function profile()
	{
		$this->template->add_title_segment('My Profile');
		$this->template->render('backend/account/profile');
	}

	public function list_all()
	{
		$this->template->add_title_segment('User Management');
		$this->template->render('backend/account/list');
	}

	public function groups()
	{
		$data['group'] = $this->aauth->list_groups();
		$this->template->add_title_segment('Groups Management');
		$this->template->render('backend/account/group',$data);
	}

	public function ban()
	{
		$this->template->add_title_segment('Banned Accounts');
		$this->template->render('backend/account/ban');
	}

	public function logout()
	{
		if($this->aauth->logout()){
			redirect(base_url(),'refresh');
       	}
	}

	public function webapp()
	{
		$this->template->add_title_segment('Web Application Backups');
		$this->template->render('backend/webapp/backup');
	}

	public function error()
	{
		$id = $this->input->post('selector');
	  	$key = count($id);
	//multi delete using checkbox as a selector
	
		for($i=0;$i<$key;$i++){	
			$delete = $this->error_model->delete($id[$i]);
		}
		if($delete){
		$this->session->set_flashdata('success', "Error(s) has been deleted");
		$this->redirect_url();
			}
			else{
		$this->session->set_flashdata('msg', $this->lang->line('failure'));
		$this->redirect_url();
			}
	}

}

/* End of file Home.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/backend/Home.php */