<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	//constructor for this class
	function __construct()
	{
    parent:: __construct();
		$this->load->Model(array('basicFunctionality'));
		$this->load->library('session');
		$this->load->helper(array('url','string','form'));
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
	public function underconstruction()
	{
		$this->load->view('elements/header');
		$this->load->view('under');
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
	public function not_found()
	{
		$this->load->view('elements/header');
		$this->load->view('elements/notfound');
	}
	public function logout()
	{
	    $user_data = $this->session->all_userdata();
	        foreach ($user_data as $key => $value) {
	        $this->session->unset_userdata($key);
	        }
		     $this->session->sess_destroy();
	    redirect('home');
	}
}
