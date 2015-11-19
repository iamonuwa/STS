<?php


class Algorithm
{
	/**
	 * The CodeIgniter object variable
	 * @access public
	 * @var object
	 */
	public $CI;

	/**
	 * Variable for loading the config array into
	 * @access public
	 * @var array
	 */
	public $config_vars;

	/**
	 * Array to store error messages
	 * @access public
	 * @var array
	 */
	public $errors = array();

	/**
	 * Array to store info messages
	 * @access public
	 * @var array
	 */
	public $infos = array();
	
	/**
	 * Local temporary storage for current flash errors
	 *
	 * Used to update current flash data list since flash data is only available on the next page refresh
	 * @access public
	 * var array
	 */
	public $flash_errors = array();

	/**
	 * Local temporary storage for current flash infos
	 *
	 * Used to update current flash data list since flash data is only available on the next page refresh
	 * @access public
	 * var array
	 */
	public $flash_infos = array();

	/**
     * The CodeIgniter object variable
	 * @access public
     * @var object
     */
    public $site_db;

    /**
    * Defines Password Cost Per Server
    * @access public
    * @var object
    */
    public $cost = '10';

    private static $GlobalBestTimetable;
    private static $min = 1000;
    private static $weekDayNames = array();
    private static $lectureTimings = array();

	########################
	# Base Functions
	########################

	/**
	 * Constructor
	 */
	public function __construct() {

		// get main CI object
		$this->CI = & get_instance();

		// Dependancies
		if(CI_VERSION >= 2.2){
			$this->CI->load->library('driver');
		}
		$this->CI->load->library('session');
		$this->CI->load->library('email');
		$this->CI->load->helper('url');
		$this->CI->load->helper('string');
		$this->CI->load->helper('email');
		$this->CI->load->helper('language');
		$this->CI->lang->load('site');

 		// config/site.php
		$this->CI->config->load('site');
		$this->config_vars = $this->CI->config->item('site');

		$this->site_db = $this->CI->load->database($this->config_vars['app_db'], TRUE); 
		
		// load error and info messages from flashdata (but don't store back in flashdata)
		$this->errors = $this->CI->session->flashdata('errors');
		$this->infos = $this->CI->session->flashdata('infos');
	}

	// randomly got population from any class requiring it
	public static function populationAccepter(array $timeTableCollection) {


        foreach ($timeTableCollection as $tt) {
            Algorithm::fitness($tt);
        }
        Algorithm::createWeek();
        Algorithm::createLectureTime();
        Algorithm::selection($timeTableCollection);
    }

    private static function createWeek() {
        $weekDaysName = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'); //Represent values returned by Java DateFormatSymbols#getWeekdays()
        for ($i = 1; $i < count($weekDaysName); $i++) {
            echo("weekday = " . $weekDaysName[$i] . "<br/>");
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

    public static function selection(array $timetables) {
        $iterations = 50;
        $i = 1;
        $mutants = array();
        foreach ($timetables as $t) {
            Algorithm::fitness($t);
        }

        while ($iterations !== 0) {

            foreach ($timetables as $tt) {
                $score = $tt->getFittness();
                if ($score < Algorithm::$min) {
                    Algorithm::$min = $score;
                    Algorithm::$GlobalBestTimetable = $tt;
                    Algorithm::display();
                }
            }
            if (Algorithm::$min === 0) {
                Algorithm::display();
                exit();
            } else {
                echo("Iteration :" . $i . "<br/>");
                $i++;
                $iterations--;
                foreach ($timetables as $timetable1) {	
                    $childTimetable = Algorithm::crossOver($timetable1);
                    $mutant = Algorithm::Mutation($childTimetable);
                    $mutants[] = ($mutant);
                }

                $timetables = array();
                for ($j = 0; $j < count($mutants); $j++) {
                    Algorithm::fitness($mutants[$j]);
                    $timetables[] = ($mutants[$j]);
                }
                $mutants = array();
            }
        }
        Algorithm::display();
    }

    public static function fitness(TimeTable $timetable) {
        $rooms = $timetable->getRoom();
        foreach ($rooms as $room1) {
            $score = 0;
            foreach ($rooms as $room2) {
                if ($room2 != $room1) {
                    $weekdays1 = $room1->getWeek()->getWeekDays();
                    $weekdays2 = $room2->getWeek()->getWeekDays();
                    for ($i = 0; $i < count($weekdays1) && $i < count($weekdays2); $i++) {
                        $day1 = $weekdays1[$i];
                        $day2 = $weekdays2[$i];

                        $timeslots1 = $day1->getTimeSlot();
                        $timeslots2 = $day2->getTimeSlot();
                        for ($i = 0; $i < count($timeslots1) && $i < count($timeslots2); $i++) {
                            $lecture1 = $timeslots1[$i];
                            $lecture2 = $timeslots2[$i];
                            if ($lecture1->getLecture() !== null && $lecture2->getLecture() !== null) {
                                $professorName1 = $lecture1->getLecture()->getProfessor()->getProfessorName();
                                $professorName2 = $lecture2->getLecture()->getProfessor()->getProfessorName();
                                $stgrp1 = $lecture1->getLecture()->getStudentGroup()->getName();
                                $stgrp2 = $lecture2->getLecture()->getStudentGroup()->getName();
                                if ($stgrp1 == $stgrp2 || $professorName1 == $professorName2) {
                                    $score += 1;
                                }

                                $stcomb1 = $lecture1->getLecture()->getStudentGroup()->getCombination();
                                $arr = $lecture2->getLecture()->getStudentGroup()->getCombination();
                                foreach ($stcomb1 as $st) {
                                    foreach ($arr as $value) {
                                        if ($st == $value) {
                                            $score += 1;
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $timetable->setFittness($score);
        }

        echo("Score..................................." . $timetable->getFittness() . "<br/>");
    }

    private static function Mutation(TimeTable $parentTimetable) {
        $mutantTimeTable = $parentTimetable;
        $rnd1 = 0;
        $rnd2 = 0;
        $presentClassroom = $mutantTimeTable->getRoom();
        foreach ($presentClassroom as $classRoom) {
            $rnd1 = rand(0, 5);
            $rnd2 = -1;
            while ($rnd1 !== $rnd2) {
                $rnd2 = rand(0, 5);
            }
            $weekDays = $classRoom->getWeek()->getWeekDays();
            $day1 = $weekDays[$rnd1];
            $day2 = $weekDays[$rnd2];

            $timeSlotsOfday1 = $day1->getTimeSlot();
            $timeSlotsOfday2 = $day2->getTimeSlot();

            $day1->setTimeSlot($timeSlotsOfday2);
            $day2->setTimeSlot($timeSlotsOfday1);
            break;
        }
        return $mutantTimeTable;
    }

    private static function crossOver(TimeTable $fatherTimeTable) {
        $arr = $fatherTimeTable->getRoom();
        foreach ($arr as $room) {
            if (!$room->isLaboratory()) {
                $days = $room->getWeek()->getWeekDays();
                $i = 0;
                while ($i < 3) {
                    $rnd = rand(0, 5);
                    $day = $days[$rnd];
                    $slot = $day->getTimeSlot();
                    shuffle($slot);
                    $i++;
                }
            }
        }
        return $fatherTimeTable;
    }

    private static function display() {
// TODO Auto-generated method stub
        $i = 0;
        $j = 0;
        echo("Minimum : " . Algorithm::$min . "<br/>");
        echo("<br/>Score : " . Algorithm::$GlobalBestTimetable->getFittness() . "<br/>");
        $allrooms = Algorithm::$GlobalBestTimetable->getRoom();
        foreach ($allrooms as $room) {
            echo("<br/>Room: " . $room->getRoomNo() . "<br/>");
            $weekdays = $room->getWeek()->getWeekDays();
            echo("<br/>Timings:    ");
            foreach (Algorithm::$lectureTimings as $lt) {
                echo(" " . $lt . " ");
            }
            $i = 0;
            echo("<br/>");
            foreach ($weekdays as $day) {
                echo("Day: " . Algorithm::$weekDayNames[$i]);
                $timeslots = $day->getTimeSlot();
                $i++;
                for ($k = 0; $k < count($timeslots); $k++) {
                    if ($k === 3) {
                        echo("       BREAK       ");
                    }
                    $lecture = $timeslots[$k];
                    if (null !== $lecture->getLecture()) {
                        echo("  (");
                        echo $lecture->getLecture()->getSubject();
                        echo "#";
                        echo $lecture->getLecture()->getProfessor()->getProfessorName();
                        echo "#";
                        echo explode("/", $lecture->getLecture()->getStudentGroup()->getName())[0];
                        echo ")";
                    } else {
                        echo(" FREE LECTURE ");
                    }
                }
                echo("<br/>");
            }
            echo("<br/>");
        }
    }
	
	########################
	# Error / Info Functions
	########################

	/**
	 * Error
	 * Add message to error array and set flash data
	 * @param string $message Message to add to array
	 * @param boolean $flashdata if TRUE add $message to CI flashdata (deflault: FALSE)
	 */
	public function error($message = '', $flashdata = FALSE){
		$this->errors[] = $message;
		if($flashdata)
		{
			$this->flash_errors[] = $message;
			$this->CI->session->set_flashdata('errors', $this->flash_errors);
		}
	}

	/**
	 * Keep Errors
	 *
	 * Keeps the flashdata errors for one more page refresh.  Optionally adds the default errors into the
	 * flashdata list.  This should be called last in your controller, and with care as it could continue
	 * to revive all errors and not let them expire as intended.
	 * Benefitial when using Ajax Requests
	 * @see http://ellislab.com/codeigniter/user-guide/libraries/sessions.html
	 * @param boolean $include_non_flash TRUE if it should stow basic errors as flashdata (default = FALSE)
	 */
	public function keep_errors($include_non_flash = FALSE)
	{
		// NOTE: keep_flashdata() overwrites anything new that has been added to flashdata so we are manually reviving flash data
		// $this->CI->session->keep_flashdata('errors');

		if($include_non_flash)
		{
			$this->flash_errors = array_merge($this->flash_errors, $this->errors);
		}
		$this->flash_errors = array_merge($this->flash_errors, (array)$this->CI->session->flashdata('errors'));
		$this->CI->session->set_flashdata('errors', $this->flash_errors);
	}

	//tested
	/**
	 * Get Errors Array
	 * Return array of errors
	 * @return array Array of messages, empty array if no errors
	 */
	public function get_errors_array()
	{

		if (!count($this->errors)==0)
		{
			return $this->errors;
		}
		else
		{
			return array();
		}
	}

	/**
	 * Print Errors
	 * 
	 * Prints string of errors separated by delimiter
	 * @param string $divider Separator for errors
	 */
	public function print_errors($divider = '<br />')
	{
		$msg = '';
		$msg_num = count($this->errors);
		$i = 1;
		foreach ($this->errors as $e)
		{
			$msg .= $e;

			if ($i != $msg_num)
			{
				$msg .= $divider;
			}
			$i++;
		}
		echo $msg;
	}
	
	/**
	 * Clear Errors
	 * 
	 * Removes errors from error list and clears all associated flashdata
	 */
	public function clear_errors()
	{
		$this->errors = [];
		$this->CI->session->set_flashdata('errors', $this->errors);
	}

	/**
	 * Info
	 *
	 * Add message to info array and set flash data
	 * 
	 * @param string $message Message to add to infos array
	 * @param boolean $flashdata if TRUE add $message to CI flashdata (deflault: FALSE)
	 */
	public function info($message = '', $flashdata = FALSE)
	{
		$this->infos[] = $message;
		if($flashdata)
		{
			$this->flash_infos[] = $message;
			$this->CI->session->set_flashdata('infos', $this->flash_infos);
		}
	}

	/**
	 * Keep Infos
	 *
	 * Keeps the flashdata infos for one more page refresh.  Optionally adds the default infos into the
	 * flashdata list.  This should be called last in your controller, and with care as it could continue
	 * to revive all infos and not let them expire as intended.
	 * Benefitial by using Ajax Requests
	 * @see http://ellislab.com/codeigniter/user-guide/libraries/sessions.html
	 * @param boolean $include_non_flash TRUE if it should stow basic infos as flashdata (default = FALSE)
	 */
	public function keep_infos($include_non_flash = FALSE)
	{
		// NOTE: keep_flashdata() overwrites anything new that has been added to flashdata so we are manually reviving flash data
		// $this->CI->session->keep_flashdata('infos');

		if($include_non_flash)
		{
			$this->flash_infos = array_merge($this->flash_infos, $this->infos);
		}
		$this->flash_infos = array_merge($this->flash_infos, (array)$this->CI->session->flashdata('infos'));
		$this->CI->session->set_flashdata('infos', $this->flash_infos);
	}

	/**
	 * Get Info Array
	 *
	 * Return array of infos
	 * @return array Array of messages, empty array if no errors
	 */
	public function get_infos_array()
	{
		if (!count($this->infos)==0)
		{
			return $this->infos;
		}
		else
		{
			return array();
		}
	}


	/**
	 * Print Info
	 *
	 * Print string of info separated by delimiter
	 * @param string $divider Separator for info
	 *
	 */
	public function print_infos($divider = '<br />')
	{

		$msg = '';
		$msg_num = count($this->infos);
		$i = 1;
		foreach ($this->infos as $e)
		{
			$msg .= $e;

			if ($i != $msg_num)
			{
				$msg .= $divider;
			}
			$i++;
		}
		echo $msg;
	}
	
	/**
	 * Clear Info List
	 * 
	 * Removes info messages from info list and clears all associated flashdata
	 */
	public function clear_infos()
	{
		$this->infos = [];
		$this->CI->session->set_flashdata('infos', $this->infos);
	}
}