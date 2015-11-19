<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->input->post()){
		$data['name'] 				= e($this->input->post('name'));
		$data['building_id'] 		= e($this->input->post('building_name'));
		$data['capacity'] 			= e($this->input->post('capacity'));
		if (empty($data['name'])) {
			$this->session->set_flashdata('msg', $this->lang->line('empty_room'));
			$this->redirect_url();
		}
		if (empty($data['capacity'])) {
			$this->session->set_flashdata('msg', $this->lang->line('empty_room_capacity'));
			$this->redirect_url();
		}
		if(ctype_alpha($data['capacity'])){
			$this->session->set_flashdata('msg', $this->lang->line('num_room'));
			$this->redirect_url();
		}
		if ($this->classes_model->get_by('name',$data['name'])->name) {
			$this->session->set_flashdata('msg', $this->lang->line('exists_room'));
			$this->redirect_url();
		}

		$insert = $this->room_model->create($data, $skip_validation = false);
		if ($insert) {
			$this->session->set_flashdata('success', $this->lang->line('added_room'));
		}
		else{
			$this->session->set_flashdata('msg', $this->lang->line('failure'));
		}
		$this->redirect_url();
		}
		else{
		$data['room'] = $this->room_model->get_all();
		$data['building'] = $this->building_model->get_all();
		$this->template->add_title_segment('Rooms Module');
		$this->template->render('backend/room/index',$data);
		}
	}

	public function delete()
	{

		$id = $this->input->post('selector');
	  	$key = count($id);
	//multi delete using checkbox as a selector
	
		for($i=0;$i<$key;$i++){	
			$delete = $this->room_model->delete($id[$i]);
		}
		if($delete){
		$this->session->set_flashdata('success', $this->lang->line('room_delete_success'));
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
		if($this->room_model->update($param, $data)){
			$this->session->set_flashdata('success', "Updated successfully");
		redirect(base_url('backend/room/index'),refresh);
			}
			else{
		$this->session->set_flashdata('msg', $this->lang->line('failure'));
		redirect(base_url('backend/room/index'),refresh);
			}
		}
		else{
		$url = $this->uri->segment(5);
		$data['room'] = $this->building_model->get_by('id', $url);
		$this->template->add_title_segment('Rooms Module');
		$this->template->render('backend/room/edit', $data);
		}
	}

}

/* End of file Room.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/backend/Room.php */