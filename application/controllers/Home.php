<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	//constructor for this class
	function __construct()
	{
    parent:: __construct();
		$this->load->Model('valid_user');
		$this->load->Model('basicFunctionality');
		$this->load->library('session');
		$this->load->helper(array('url','string','form'));
	}
	//hashing function
	private function hash_password($password)
	{
	   return password_hash($password, PASSWORD_BCRYPT);
	}
	//otp generation function
	private function otp()
  {
        $otp = random_string('numeric', 6);
        return $otp;
	}
	private function getyear($enroll)
	{
		return '20'.substr($enroll,6,2);
	}
	//Function which is being called first
	public function index()
	{
		if($this->session->userdata('is_login')==1 && $this->session->userdata('loginas')=='user')
		{
			$news_id=0;
			$content['data']=$this->basicFunctionality->recentTenUploads();
			$content['news']=$this->basicFunctionality->get_news($news_id);
			$content['userdetail']=$this->basicFunctionality->get_userDetails($this->session->userdata('enroll'));
			$content['error']=' ';
			$this->load->view('elements/header');
			$this->load->view('home',$content);
			$this->load->view('elements/footer');
		}
		else
			$this->load->view('login.php');
	}
	//sign up
	public function signup()
	{
		$this->load->view('signup');
	}
	public function underconstruction()
	{
		// $this->load->view('elements/header');
		$this->load->view('under');
	}
	//login
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
				redirect(base_url('home'),'refresh');		 //login Failed
			}
		}
		else
		{
			$this->load->view('login');
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
	public function profile()
	{
		$enroll=$this->session->userdata('enroll');
		$details=$this->basicFunctionality->get_userDetails($enroll);
		$data['details']=$details;
		$this->load->view('elements/header');
		$this->load->view('profile',$data);
		$this->load->view('elements/footer');
	}
	public function news($news_id)
	{
		$content['news']=$this->basicFunctionality->get_news($news_id);
		$content['allnews']=$this->basicFunctionality->get_news(0);
		$this->load->view('elements/header');
		$this->load->view('news',$content);

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
	public function replacepassword()
	{
		// $this->valid_user->replacePassword();
	}
	public function like($upload_id)
	{
		$dataobj=$this->db->get_where('uploads',array("upload_id"=>$upload_id))->result();
		$updated_like=$dataobj[0]->likes+1;
		$q="UPDATE `uploads` SET `likes` = $updated_like WHERE `upload_id` = $upload_id;";
		if($this->db->query($q))
			return true;
		else
		 	return false;
	}
	// public function dislike($upload_id)
	// {
	// 	$dataobj=$this->db->get_where('uploads',array("upload_id"=>$upload_id))->result();
	// 	$updated_dislike=$dataobj[0]->dislikes+1;
	// 	$q="UPDATE `uploads` SET `dislikes` = $updated_dislike WHERE `upload_id` = $upload_id;";
	// 	if($this->db->query($q))
	// 		return true;
	// 	else
	// 		return false;
	// }
	public function share()
	{
		//logic for share
	}
	//logic for logout
	public function logout()
	{
	    $user_data = $this->session->all_userdata();
	        foreach ($user_data as $key => $value) {
	        $this->session->unset_userdata($key);
	        }
		     $this->session->sess_destroy();
	    redirect('home');
	}
	public function network()
	{
		$data=$this->valid_user->getuserdata($this->session->userdata('enroll'));
	}
	public function loadmoreposts()
	{
		if($this->request->post())
		{
			// $this->load->
		}
	}
}
