<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Initialization extends Backend_Controller {

	private $subjects = array();
    private $professors = array();
    private $timetables = array();
    private $classes = array();
    private $combinations = array();

	public function __construct()
	{
		parent::__construct();
	}

	public function readInput() {
        $classroom = array();
        $room1 = new ClassRoom("D101", 20, false, "Common");
        $classroom[] = $room1;
        $room2 = new ClassRoom("E101", 20, false, "ComputerScience");
        $classroom[] = $room2;
        $room3 = new ClassRoom("LAB1", 20, true, "ComputerScience");
        $classroom[] = $room3;
//		ClassRoom room4 = new ClassRoom("LAB2", 20, true);
//		classroom.add(room4);
//		ClassRoom room5 = new ClassRoom("G101", 20, false);
//		classroom.add(room5);
//		ClassRoom room6 = new ClassRoom("H101", 20, false);
//		classroom.add(room6);
//		ClassRoom room6 = new ClassRoom("I101", 60, false);
//		classroom.add(room6);


        $this->professors[] = (new Professor(1, "Shruti", "IR/IRlab/DM"));
        $this->professors[] = (new Professor(2, "Snehal", "P&S"));
        $this->professors[] = (new Professor(3, "Ramrao", "DS"));
        $this->professors[] = (new Professor(4, "Ranjit", "WR"));
        $this->professors[] = (new Professor(5, "Shekhar", "TOC"));
        $this->professors[] = (new Professor(6, "Monica", "SS"));
        $this->professors[] = (new Professor(7, "Ravi", "R"));
        $this->professors[] = (new Professor(8, "Amit", "ML/MLlab"));
        $this->professors[] = (new Professor(9, "Rama", "DAA/UML"));

        $this->createLectures($this->professors);

        $timetb1 = new TimeTable($classroom, $this->classes); //, professors);
//timetb1.initialization(classroom, classes);
//TimeTable timetb2=new TimeTable(classroom, classes);
//TimeTable timetb3=new TimeTable(classroom, classes);

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
//combinations.addAll(course1.getCombinations());
//timetb2.addStudentGroups(studentGroups);
///timetb3.addStudentGroups(studentGroups);

        $this->subjects = array(); //Clear array

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
//combinations.addAll(course2.getCombinations());
//timetb2.addStudentGroups(studentGroups);
//timetb3.addStudentGroups(studentGroups);

        echo("Setting tt.......<br/>");

        echo("adding tt.......<br/>");
        $timetb1->initializeTimeTable();
//timetb2.initializeTimeTable();
//timetb3.initializeTimeTable();
        $this->timetables[] = ($timetb1);
//timetable.add(timetb2);
//timetable.add(timetb3);

        echo("populating.......<br/>");



//display();

        $this->populateTimeTable($timetb1);
        $ge = new GeneticAlgorithm();

//ge.fitness(timetb1);
//		timetb1.createTimeTableGroups(combinations);
        $ge->populationAccepter($this->timetables);
//		//ge.fitness(timetb2);
//ge.fitness(timetb3);
//populateTimeTable();
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
            $subjectsTaught = $professor->getSubjectTaught();
            foreach ($subjectsTaught as $subject) {
                $this->classes[] = (new Lecture($professor, $subject));
            }
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

/* End of file initialization.php */
/* Location: .//opt/lampp/htdocs/project/app/controllers/backend/genetic_algorithm/initialization.php */