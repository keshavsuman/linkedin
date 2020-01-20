<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class profile extends CI_Controller
{
	//constructor for this class
	function __construct()
	{
    parent:: __construct();
    $this->load->helper('url');
  }
  public function index()
  {
    $this->load->view('elements/header.php');
    $this->load->view('profile.php');
    $this->load->view('elements/footer.php');
  }
}
