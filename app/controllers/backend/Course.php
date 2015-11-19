<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->input->post()){
		$data['title'] 				= e($this->input->post('course_title'));
		$data['code'] 				= e($this->input->post('course_code'));
		$data['lecturer_id'] 		= e($this->input->post('course_lecturer'));
		$data['level_id'] 			= e($this->input->post('level_id'));
		$data['course_description'] = e($this->input->post('course_description'));

		if (empty($data['title']) && empty($data['code']) && empty($data['lecturer_id']) && empty($data['level_id']) && empty($data['course_description'])) {
			$this->session->set_flashdata('msg', $this->lang->line('empty_course_all'));
			$this->redirect_url();
		}
		if (empty($data['title'])) {
			$this->session->set_flashdata('msg', $this->lang->line('empty_course_title'));
			$this->redirect_url();
		}
		if (empty($data['code'])) {
			$this->session->set_flashdata('msg', $this->lang->line('empty_course_code'));
			$this->redirect_url();
		}
		if (empty($data['course_description'])) {
			$this->session->set_flashdata('msg', $this->lang->line('empty_course_desc'));
			$this->redirect_url();
		}

		if ($this->courses_model->get_by('title',$data['title'])->title) {
			$this->session->set_flashdata('msg', $this->lang->line('exists_course_title'));
			$this->redirect_url();
		}
		if ($this->courses_model->get_by('code',$data['code'])->code) {
			$this->session->set_flashdata('msg', $this->lang->line('exists_course_code'));
			$this->redirect_url();
		}

		$insert = $this->courses_model->create($data, $skip_validation = false);
		if ($insert) {
			$this->session->set_flashdata('success', $this->lang->line('added_course'));
		}
		else{
			$this->session->set_flashdata('msg', $this->lang->line('failure'));
		}
		$this->redirect_url();
		}
		
		else{
		$data['course'] = $this->courses_model->get_all();
		$data['lecturers'] = $this->lecturers_model->get_all();
		$data['classes'] = $this->classes_model->get_all();
		$data['courses_by'] = $this->courses_model->get_by('id', 1);
		$this->template->add_title_segment('Courses Module');
		$this->template->render('backend/course/index', $data);
		}
	}
	public function delete()
	{

		$id = $this->input->post('selector');
	  	$key = count($id);
	//multi delete using checkbox as a selector
	
		for($i=0;$i<$key;$i++){	
			$delete = $this->courses_model->delete($id[$i]);
		}
		if($delete){
		$this->session->set_flashdata('success', $this->lang->line('course_delete_success'));
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
		if($this->courses_model->update($param, $data)){
			$this->session->set_flashdata('success', "Updated successfully");
		redirect(base_url('backend/course/index'),refresh);
			}
			else{
		$this->session->set_flashdata('msg', $this->lang->line('failure'));
		redirect(base_url('backend/course/index'),refresh);
			}
		}
		else{
		$url = $this->uri->segment(5);
		$data['course'] = $this->courses_model->get_by('id', $url);
		$this->template->add_title_segment('Course Module');
		$this->template->render('backend/course/edit', $data);
		}
	}
}

/* End of file Course.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/backend/Course.php */