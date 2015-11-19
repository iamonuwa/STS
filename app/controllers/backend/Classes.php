<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->input->post()){
		$data['name'] 				= e($this->input->post('level'));
		$data['class_size'] 		= e($this->input->post('capacity'));

		if (empty($data['name']) && empty($data['class_size'])) {
			$this->session->set_flashdata('msg', $this->lang->line('empty_class_both'));
			$this->redirect_url();
		}
		if (empty($data['name'])) {
			$this->session->set_flashdata('msg', $this->lang->line('empty_class'));
			$this->redirect_url();
		}
		if (empty($data['class_size'])) {
			$this->session->set_flashdata('msg', $this->lang->line('empty_size'));
			$this->redirect_url();
		}
		if(ctype_alpha($data['class_size'])){
			$this->session->set_flashdata('msg', $this->lang->line('num_class'));
			$this->redirect_url();
		}

		if ($this->classes_model->get_by('name',$data['name'])->name) {
			$this->session->set_flashdata('msg', $this->lang->line('exists_class'));
			$this->redirect_url();
		}
		$insert = $this->classes_model->create($data, $skip_validation = false);
		if ($insert) {
			$this->session->set_flashdata('success', $this->lang->line('added_class'));
		}
		else{
			$this->session->set_flashdata('msg', $this->lang->line('failure'));
		}
		$this->redirect_url();
		}
		else{
		$data['classes'] = $this->classes_model->get_all();
		$this->template->add_title_segment('Classes Module');
		$this->template->render('backend/class/index', $data);
		}
	}

	public function delete()
	{

		$id = $this->input->post('selector');
	  	$key = count($id);
	//multi delete using checkbox as a selector
	
		for($i=0;$i<$key;$i++){	
			$delete = $this->classes_model->delete($id[$i]);
		}
		if($delete){
		$this->session->set_flashdata('success', $this->lang->line('class_delete_success'));
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
		if($this->classes_model->update($param, $data)){
			$this->session->set_flashdata('success', "Updated successfully");
		redirect(base_url('backend/classes/index'),refresh);
			}
			else{
		$this->session->set_flashdata('msg', $this->lang->line('failure'));
		redirect(base_url('backend/classes/index'),refresh);
			}
		}
		else{
		$url = $this->uri->segment(5);
		$data['class'] = $this->classes_model->get_by('id', $url);
		$this->template->add_title_segment('Class Module');
		$this->template->render('backend/classes/edit', $data);
		}
	}

}

/* End of file Class.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/backend/Class.php */