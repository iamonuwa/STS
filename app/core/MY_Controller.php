<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('aauth','template','user_agent','lib_log'));
		$this->load->helper(array('url'));
		$this->session->set_userdata('redirect_back', $this->agent->referrer()); 
	}

	/*public function index()
	{
		echo $a;
        trigger_error("User error via trigger.", E_USER_ERROR);
        trigger_error("Warning error via trigger.", E_USER_WARNING);
        trigger_error("Notice error via trigger.", E_USER_NOTICE);
        echo $this->inverse(5) . "\n";
        echo $this->inverse(0) . "\n";
	}*/

	public function redirect_url()
	{
	if( $this->session->userdata('redirect_back') ) {
   	$redirect_url = $this->session->userdata('redirect_back'); 
   	$this->session->unset_userdata('redirect_back');
   	redirect( $redirect_url );
   		}
	}
	public function loginAuth($data)
	{
		$email = $data['email'];
		$pass = $data['pass'];

		return $this->aauth->login($email, $pass);
	}
}

/* End of file MY_Controller.php */
/* Location: .//opt/lampp/htdocs/project/app/core/MY_Controller.php */