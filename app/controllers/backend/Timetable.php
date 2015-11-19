<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH .'libraries/libs/init.php';
class Timetable extends Backend_Controller {

	

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{		
		if ($this->input->post()) {	
			
			$data['courses'] = array();
			$data['room'] = array();
			$data['semester'] = $this->input->post('semester');
			$data['session'] = $this->input->post('session');
			$data['department'] = $this->input->post('department');
			$data['date_created'] = time();
			$data['course'] = $this->courses_model->get_all();
			$data['rooms'] = $this->room_model->get_all();
			// $data['output'] = $this->parse($data);

			dump($this->algorithm->parse($data));
		}
		else{
		$this->template->add_title_segment('Timetable Module');
		$this->template->render('backend/webapp/timetable');
		}
	}

	public function delete()
	{

		$id = $this->input->post('selector');
	  	$key = count($id);
	//multi delete using checkbox as a selector
	
		for($i=0;$i<$key;$i++){	
			$delete = $this->timetable_model->delete($id[$i]);
		}
		if($delete){
		$this->session->set_flashdata('success', 'Timetable has been deleted');
		$this->redirect_url();
			}
			else{
		$this->session->set_flashdata('msg', $this->lang->line('failure'));
		$this->redirect_url();
			}
	}

	public function parse($data)
	{
		$data['courses'] = array();
		$data['room'] = array();
		foreach ($data['course'] as $key => $value) {
				$data['courses'][] = $value->id;
		}
		foreach ($data['rooms'] as $key => $value) {
				$data['room'][] = $value->id;
		}
	}

}
// if(){
			// 	if($this->timetable_model->create($data, $skip_validation = false)){
			// 	$this->session->set_flashdata('success', $data['session'].' '.$data['semester'].' Timetable has been generated.');
			// 	$this->redirect_url();
			// 	}
			// 	else{
			// 	$this->session->set_flashdata('msg', 'Timetable could not be created at the moment. Please try again');
			// 	$this->redirect_url();
			// 	}
			// }
			// else{
			// 	$this->session->set_flashdata('msg', 'Invalid Information was supplied');
			// 	$this->redirect_url();
			// }

/* End of file Timetable.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/backend/Timetable.php */