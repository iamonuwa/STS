<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH .'libraries/libs/init.php';
class Timetable extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public $fixed = array();
			
	public function index()
	{
	$settings['day_start'] = 8;
	$settings['day_end'] = 16;
	$settings['break_time_start'] = 12;
	$settings['break_time_stop'] = 14;
	$settings['lecture_period'] = 2; //number of hours per lecture
	$settings['lecture_days'] = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');

//classes in the department
$classes = array(
    1 => 'OND1',
    2 => 'OND2',
    3 => 'HND1',
    4 => 'HND2'
);

//lectures for the respective classes
$lectures = array(
    $classes[1] => array('COS-101','COS-102','COS-103','COS-104','COS-105','COS-106','COS-107','COS-108'),
    $classes[2] => array('COS-201','COS-202','COS-203','COS-204','COS-205','COS-206','COS-207','COS-208'),
    $classes[3] => array('COS-301','COS-302','COS-303','COS-304','COS-305','COS-306','COS-307','COS-308'),
    $classes[4] => array('COS-401','COS-402','COS-403','COS-404','COS-405','COS-406','COS-407','COS-408')
);		
		if ($this->input->post()) {	
			$data['courses'] = array();
			$data['room'] = array();
			$class = $this->input->post('level');
			$classes = $this->classes_model->get_by('id', $class);
			$lectures = $this->courses_model->get_many_by('level_id', $class);
			$data['semester'] = $this->input->post('semester');
			$data['session'] = $this->input->post('session');
			$data['department'] = $this->input->post('department');
			$data['rooms'] = $this->room_model->get_all();
			$data['date_created'] = time();

			echo $this->random_course(array_keys($classes, $class)[0]);
			// echo $lectures;
			// dump($classes->name);
			// var_dump($this->random_course(array_keys($classes->name, $lectures)[0]));

		}
		else{
		$data['classes'] = $this->classes_model->get_all();
		$this->template->add_title_segment('Timetable Module');
		$this->template->render('backend/webapp/timetable',$data);
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

	
// var_dump($classes[1]);
//this array is strictly used at run-time
// $fixed = array();
   // echo random_course(array_keys($classes, $class)[0]);
/* ALGORITHMS */
function random_course($current_class=1)
{
    global $lectures, $classes, $fixed;
    $random_index = rand(0, (sizeof($lectures[$classes[$current_class]])-1) );
    $random_course = $lectures[$classes[$current_class]][$random_index];

    if(isset($fixed[$random_course]))
    {
        if($fixed[$random_course] < 2)
        {
            $fixed[$random_course]++;
        }
        else //if this course has already appeared twice
        {
            return random_course($current_class); //recursively generate random course till we get what we want
        }
    }
    else //if this course has not appeared in the time-table for the first time
    {
        $fixed[$random_course] = 1;
    }
    return $random_course;
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