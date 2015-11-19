<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Courses_model extends MY_Model {

	/**
     * This model's default database table. Automatically
     * guessed by pluralising the model name.
     */
    protected $_table = 'project_course';

    /**
     * This model's default primary key or unique identifier.
     * Used by the get(), update() and delete() functions.
     */
    protected $primary_key = 'id';

    public function __construct()
    {
    	parent::__construct();
    }

}

/* End of file Courses_model.php */
/* Location: .//opt/lampp/htdocs/project/app/models/Courses_model.php */