<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Building extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->input->post()){
		$data['name'] 			= e($this->input->post('name'));

		if (empty($data['name'])) {
			$this->session->set_flashdata('msg', $this->lang->line('empty_building'));
			$this->redirect_url();
		}
		if(ctype_alnum($data['name'])){
			$this->session->set_flashdata('msg', $this->lang->line('alpha_building'));
			$this->redirect_url();
		}
		if ($this->building_model->get_by('name',$data['name'])->name) {
			$this->session->set_flashdata('msg', $this->lang->line('exists_building'));
			$this->redirect_url();
		}

		$insert = $this->building_model->create($data, $skip_validation = false);
		if ($insert) {
			$this->session->set_flashdata('success', $this->lang->line('added_building'));
		}
		else{
			$this->session->set_flashdata('msg', $this->lang->line('failure'));
		}
		$this->redirect_url();
		}
		else{
		$data['building'] = $this->building_model->get_all();
		$this->template->add_title_segment('Buildings Module');
		$this->template->render('backend/building/index', $data);
		}
	}

	public function delete()
	{

		$id = $this->input->post('selector');
	  	$key = count($id);
	//multi delete using checkbox as a selector
	
		for($i=0;$i<$key;$i++){	
			$delete = $this->building_model->delete($id[$i]);
		}
		if($delete){
		$this->session->set_flashdata('success', $this->lang->line('building_delete_success'));
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
		if($this->building_model->update($param, $data)){
			$this->session->set_flashdata('success', "Updated successfully");
		redirect(base_url('backend/building/index'),refresh);
			}
			else{
		$this->session->set_flashdata('msg', $this->lang->line('failure'));
		redirect(base_url('backend/building/index'),refresh);
			}
		}
		else{
		$url = $this->uri->segment(5);
		$data['building'] = $this->building_model->get_by('id', $url);
		$this->template->add_title_segment('Buildings Module');
		$this->template->render('backend/building/edit', $data);
		}
	}

}

/* End of file Building.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/backend/Building.php */