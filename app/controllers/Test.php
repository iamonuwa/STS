<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Test extends Backend_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
        public $loop;

        public function index()
	{
//        $natural_born_killers = array("lions", "tigers", "bears", "kittens");
        $buildings = $this->room_model->get_all();
            for($i = 0; $i <= 3; $i++) {
                shuffle($buildings);
            }
            foreach ($buildings as $building) {
                $room_allocation =  $this->room_model->get_by('id', $building->id)->name;
                echo $room_allocation.'</br>';
            }
        }

//$store = array();
//$room = $this->building_model->get_all();
//
////        dump($room);
//for($i = 0; $i <= 3; $i++){
//$rooms = array_rand($room);
//$data = $this->building_model->get_by('id',$rooms);
//dump($data);
//}
//
////            }
//
//
//
////        dump(array_values($courses));
	
}

/* End of file Test.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/Test.php */