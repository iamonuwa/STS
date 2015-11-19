<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Lecturer extends Backend_Controller {


	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->input->post()){
		$data['name'] 			= e($this->input->post('lecturer_name'));
		$data['department'] 	= e($this->input->post('department'));
		if (empty($data['name'])) {
			$this->session->set_flashdata('msg', $this->lang->line('empty_lecturer'));
			$this->redirect_url();
		}
		if (empty($data['department'])) {
			$this->session->set_flashdata('msg', $this->lang->line('empty_department'));
			$this->redirect_url();
		}
		if ($this->lecturers_model->get_by('name',$data['name'])->name) {
			$this->session->set_flashdata('msg', $this->lang->line('exists_lecturer'));
			$this->redirect_url();
		}


		$insert = $this->lecturers_model->create($data, $skip_validation = false);
		if ($insert) {
			$this->session->set_flashdata('success', $this->lang->line('added_lecturer'));
		}
		else{
			$this->session->set_flashdata('msg', $this->lang->line('failure'));
		}
		$this->redirect_url();
		}
		else{
		$data['lecturer'] = $this->lecturers_model->get_all();
		$this->template->add_title_segment('Lecturers Module');
		$this->template->render('backend/lecturer/index', $data);
		}
	}

	public function delete()
	{

		$id = $this->input->post('selector');
	  	$key = count($id);
	//multi delete using checkbox as a selector
	
		for($i=0;$i<$key;$i++){	
			$delete = $this->lecturers_model->delete($id[$i]);
		}
		if($delete){
		$this->session->set_flashdata('success', $this->lang->line('lecturer_delete_success'));
		$this->redirect_url();
			}
			else{
		$this->session->set_flashdata('msg', $this->lang->line('failure'));
		$this->redirect_url();
			}
	}
	public function edit($param)
	{
		if($this->input->post()){
		$data['name'] = e($this->input->post('name'));
		if($this->lecturers_model->update($param, $data)){
			$this->session->set_flashdata('success', "Updated successfully");
		redirect(base_url('backend/lecturer/index'),refresh);
			}
			else{
		$this->session->set_flashdata('msg', $this->lang->line('failure'));
		redirect(base_url('backend/lecturer/index'),refresh);
			}
		}
		else{
		$url = $this->uri->segment(5);
		$data['lecturer'] = $this->lecturers_model->get_by('id', $url);
		$this->template->add_title_segment('Lecturers Module');
		$this->template->render('backend/lecturer/edit', $data);
		}
	}

}

/* End of file Lecturer.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/backend/Lecturer.php */