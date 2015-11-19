<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_Controller extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('error_model','courses_model','lecturers_model','classes_model','building_model','room_model'));
		if(!$this->aauth->is_loggedin()){
			redirect(base_url(),'refresh');
		}
	}



}

/* End of file Backend_Controller.php */
/* Location: .//opt/lampp/htdocs/project/app/libraries/Backend_Controller.php */