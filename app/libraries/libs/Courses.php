<?php

class Courses{

	private $course;

	public function __construct($course)
	{
		$this->course = course;
	}

	public function getCourse()
	{
		return $this->course;
	}

	public function setCourse($course)
	{
		$this->course = $course;
	}
}