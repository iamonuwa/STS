<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Lecturers_model extends MY_Model {

	/**
     * This model's default database table. Automatically
     * guessed by pluralising the model name.
     */
    protected $_table = 'project_lecturer';

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

/* End of file Lecturers_model.php */
/* Location: .//opt/lampp/htdocs/project/app/models/Lecturers_model.php */