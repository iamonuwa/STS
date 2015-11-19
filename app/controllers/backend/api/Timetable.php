<?php defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is a timetable API
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Onuwa Nnachi Isaac
 * @license         MIT
 * @link            https://github.com/ionuwa4u
 */

class Timetable extends REST_Controller {

	function __construct()
    {
        parent::__construct();
    }

    public function timetable_get()
    {
        $this->response('My First API Response');
    }
}