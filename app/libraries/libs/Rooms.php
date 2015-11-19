<?php 

class Rooms 
{
	private $room;

	public function __construct($room)
	{
		$this->room = $room;
	}

	public function getRoom()
	{
		return $this->room;
	}

	public function setRoom($room)
	{
		$this->room = $room;
	}
}