<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller
{
	//constructor for this class
	function __construct()
	{
    parent:: __construct();
    $this->load->library('session');
    $this->load->Helper(array('url','string'));
	}
  public function index()
  {
    $this->load->view('signup');
  }
  //Get year from Enrollment number
  private function getyear($enroll)
	{
		return '20'.substr($enroll,6,2);
	}
  //hashing function
  private function hash_password($password)
  {
     return password_hash($password, PASSWORD_BCRYPT);
  }
  //otp generation function
  private function otp()
  {
        $otp = random_string('numeric', 6); // codeigniter library function -> random_string
        return $otp;
  }
  //logic to send mail for otp
  public function sendMail($to)
  {
          $otp=$this->otp();
          $this->session->set_userdata('otp',$otp);
          $message = 'Your OTP is '.$otp;
          $this->load->library('email');
          $this->email->set_newline("\r\n");
          $this->email->from('acropolisgroups@gmail.com'); // change it to yours
          $this->email->to($to);// change it to yours
          $this->email->subject('Confirmation Email');
          $this->email->message($message);
          if($this->email->send())
         {
           return True;
         }
         else
        {
         show_error($this->email->print_debugger());
       }
    }
    //logic to check whether otp sent is correct or not
  	public function otpConfirmation()
  	{
  		$d = $this->input->post();
  		if($d['otp']==$this->session->userdata('otp'))
  		{
  			if($this->valid_user->confirm_signup($this->session->email))
  			{
  				redirect(base_url());
  			}
  		}
  		else
  		{
  			echo "otp not matched";
  		}
  	}
    //logic for forget password
    public function forget_password()
    {
      $this->load->view('forgetpassword',array('error'=>' '));
    }
    //Logic for password reset
    public function resetpassword()
    {
      $data=$this->input->post();
      if($this->valid_user->isexits($data))
      {
        $this->sendMail($data['email']);
        $this->load->view('otpp.php');
      }
      else{
        $this->load->view('forgetpassword',array('error'=>'There is no user with this credentials'));
      }
    }
    public function passOtpConfirmation()
    {
      $d = $this->input->post();
      if($d['otp']==$this->session->userdata('otp'))
      {
        $this->load->view('newpassword.php');
      }
      else
      {
        echo "otp not matched";
      }
    }
    //Logic for registering new user
    public function registerUser()
    {
      $d = $this->input->post();
      $data= array(
          'Enrollment' => $d['enroll'],
          'Password'=> $this->hash_password($d['password']),
          'email'=>$d['email'],
          'Class'=>$d['class'],
          'Branch'=>$d['branch'],
          'Year'=>$this->getyear($d['enroll']),
          'Name'=>$d['name'],
          'institute'=>$d['institute']
        );
        $this->session->set_userdata('email',$d['email']);
      if($this->db->insert('unconfirmed_signup', $data))
      {
        if($this->sendmail($data['email']))
        {
        $this->load->view('otp');
        }
      }
      else
      {
        echo "failed";
      }
    }
}
