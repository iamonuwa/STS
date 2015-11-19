<?php defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH.'libraries/libs/class_lib.php';
class Test extends Backend_Controller {

	private $subjects = array();
    private $professors = array();
    private $timetables = array();
    private $classes = array();
    private $combinations = array();

	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// var_dump($this->courses_model->get_by('lecturer_id', 1)->id);
		var_dump($this->readInput());
	}

	public function readInput() {
        $classroom = array();
        $room1 = new ClassRoom("D101", 20, false, "Common");
        $classroom[] = $room1;
        $room2 = new ClassRoom("E101", 20, false, "ComputerScience");
        $classroom[] = $room2;
        $room3 = new ClassRoom("LAB1", 20, true, "ComputerScience");
        $classroom[] = $room3;
        $this->professors[] = (new Professor(1, "DR. A. N. Ezeano"));
        $this->professors[] = (new Professor(2, "Mr. C. J.C Ayatalumo ")); 
        $this->createLectures($this->professors);
        $timetb1 = new TimeTable($classroom, $this->classes); 
        $courseid = 1;
        $courseName = "MSc.I.T. Part I";
        echo("reading input.......<br/>");
        $this->subjects[] = (new Subject(1, "IR", 4, false, "ComputerScience"));
        $this->subjects[] = (new Subject(2, "P&S", 4, false, "ComputerScience"));
        $this->subjects[] = (new Subject(3, "DS", 4, false, "ComputerScience"));
        $this->subjects[] = (new Subject(4, "WR", 1, false, "Common"));
        $this->subjects[] = (new Subject(5, "TOC", 4, false, "ComputerScience"));
        $this->subjects[] = (new Subject(6, "IRlab", 3, true, "ComputerScience"));
        $this->subjects[] = (new Subject(7, "JAVA", 3, true, "ComputerScience"));
        echo("new course creation.......<br/>");
        $course1 = new Course($courseid, $courseName, $this->subjects);
        $course1->createCombination("IR/P&S/DS/WR/TOC/IRlab/JAVA/", 20);
        $course1->createStudentGroups();
        $studentGroups = $course1->getStudentGroups();
        $timetb1->addStudentGroups($studentGroups);
        $this->subjects = array();
        $this->subjects[] = (new Subject(8, "DM", 4, false, "ComputerScience"));
        $this->subjects[] = (new Subject(9, "DAA", 4, false, "ComputerScience"));
        $this->subjects[] = (new Subject(10, "SS", 1, false, "ComputerScience"));
        $this->subjects[] = (new Subject(11, "ML", 4, false, "Common"));
        $this->subjects[] = (new Subject(12, "UML", 4, false, "ComputerScience"));
        $this->subjects[] = (new Subject(13, "MLlab", 3, true, "ComputerScience"));
        $this->subjects[] = (new Subject(14, "R", 3, true, "ComputerScience"));
        $course2 = new Course(2, "MSc.I.T. Part II", $this->subjects);
        $course2->createCombination("DM/DAA/SS/ML/UML/MLlab/R/", 20);
        $course2->createStudentGroups();
        $studentGroups = $course2->getStudentGroups();
        $timetb1->addStudentGroups($studentGroups);
        echo("Setting tt.......<br/>");
        echo("adding tt.......<br/>");
        $timetb1->initializeTimeTable();
        $this->timetables[] = ($timetb1);
        echo("populating.......<br/>");
        $this->populateTimeTable($timetb1);
        $this->algorithm->populationAccepter($this->timetables);
    }

       public function populateTimeTable(TimeTable $timetb1) {
        $i = 0;
        echo("populating started.......<br/>");
        while ($i < 3) {
            $tempTimetable = $timetb1;
            $allrooms = $tempTimetable->getRoom();
            foreach ($allrooms as $room) {
                $weekdays = $room->getWeek()->getWeekDays();

                shuffle($weekdays);

                if (!$room->isLaboratory()) {
                    foreach ($weekdays as $day) {
                        $slot = $day->getTimeSlot();
                        shuffle($slot);
                    }
                }
            }

            $this->timetables[] = ($tempTimetable);
            $i++;
        }
        echo("populating done.......<br/>");
        echo("display called.......<br/>");
        $this->display();
    }

    private function createLectures(array $professors) {
// TODO Auto-generated method stub
        foreach ($professors as $professor) {
        	$this->classes[] = (new Lecture($professor));
            // $subjectsTaught = $professor->getSubjectTaught();
            // foreach ($subjectsTaught as $subject) {
            //     $this->classes[] = (new Lecture($professor, $subject));
            // }
        }
    }

        private function display() {
// TODO Auto-generated method stub
        $i = 1;
        echo("displaying all tt's.......<br/>");
        foreach ($this->timetables as $currentTimetable) {
            echo("+++++++++++++++++++++++++++++++++++++++++<br/>Time Table no. " . $i . "<br/>");
            echo("Score : " . $currentTimetable->getFittness() . "<br/>");
            $allrooms = $currentTimetable->getRoom();
            foreach ($allrooms as $room) {
                echo("Room: " . $room->getRoomNo() . "<br/>");
                $weekdays = $room->getWeek()->getWeekDays();
                foreach ($weekdays as $day) {
                    $timeslots = $day->getTimeSlot();
                    foreach ($timeslots as $lecture) {
                        if ($lecture->getLecture() !== null) {
//System.out.print(" (Subject: "+lecture.getLecture().getSubject()+" --> Professor: "+lecture.getLecture().getProfessor().getProfessorName()+" GrpName: "+lecture.getLecture().getStudentGroup().getName()+")");
                            echo("(");
                            echo $lecture->getLecture()->getSubject();
                            echo "#";
                            echo $lecture->getLecture()->getProfessor()->getProfessorName();
                            echo "#";
                            echo explode('/', $lecture->getLecture()->getStudentGroup()->getName())[0];
                            echo ")";
                        } else {
                            echo("   free   ");
                        }
                    }
                    echo("<br/>");
                }
                echo("<br/><br/>");
            }
            $i++;
        }
    }

	
}

/* End of file Test.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/Test.php */