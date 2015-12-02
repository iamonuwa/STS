<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('room_model');
	}

    public function timetable_get()
    {
        $param = $this->get('id');

        $data_by = $this->room_model->get_by(array('id'=>$param));

        $data = $this->room_model->get_all();

        if ($param === NULL) {

            if ($data) {
            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }

        else{
            $this->response([
                    'status' => FALSE,
                    'message' => 'No Timetable Found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

           
        }
        $id = (int) $param;
         if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        $params = NULL;

        if (!empty($data_by))
        {
            $params = $data_by;
        }

        if (!empty($params))
        {
            $this->set_response($params, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Could Not Find The Requested Object'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
}

/* End of file Api.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/Api.php */