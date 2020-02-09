<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	//constructor for this class
	function __construct()
	{
    parent:: __construct();
    $this->load->Model('valid_user');
    $this->load->helper(array('url','string','form'));
	}
  public function index()
  {
    
  }
  public function login()
	{
		if(isset($_POST['enroll']) and isset($_POST['pass']))
		{
			$data=$this->input->post();
			if($this->valid_user->is_valid($data)) 	//login Success
			{
				$this->load->library('session');
				$this->session->set_userdata('enroll',$data['enroll']);
				$this->session->set_userdata('is_login',True);
				$this->session->set_userdata('loginas','user');
				redirect(base_url('home'),'refresh');
			}
			else
			{
				redirect(base_url('login'),'refresh');		 //login Failed
			}
		}
		else
		{
			$this->load->view('login');
		}
	}
}
