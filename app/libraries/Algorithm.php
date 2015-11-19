 <?php


 class Algorithm{

 	private static $weekDayNames = array();
    private static $lectureTimings = array();
	
		public function parse($data)
		{
		$courses = array();
		$rooms = array();
		foreach ($data['course'] as $key => $value) {
				$courses[] = $value->id;
		}

		foreach ($data['rooms'] as $key => $value) {
				$rooms[] = $value->id;
			}
		return $this->mutation($courses, $rooms);
		}
		

		public function mutation($courses, $rooms)
		{
			$periods = array();
			$course_choices = $courses;
			$room_choice = $rooms;
 			shuffle($course_choices);
 			shuffle($room_choice);
			$periods = array();
			$count_rooms = count($rooms);
			$room_id = $rooms;
			$days = $this->createWeek();
			$slots = $this->createLectureTime();
			$periods['course_code'] = $course_choices;
			$periods['room_number'] = $room_id;
			return $periods;			
		}

		private static function createWeek() {
        $weekDaysName = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'); //Represent values returned by Java DateFormatSymbols#getWeekdays()
        for ($i = 1; $i < count($weekDaysName); $i++) {
            // echo($weekDaysName[$i] . "<br/>");
            if (strcasecmp($weekDaysName[$i], "Sunday") !== 0) {
                Algorithm::$weekDayNames[] = ($weekDaysName[$i]);
            	}
        	}
    	}
    	private static function createLectureTime() {
        for ($i = 9; $i < 16; $i++) {
            Algorithm::$lectureTimings[] = ($i . ":00" . " TO " . ($i + 1) . ":00");
        }
    }
	    
 }