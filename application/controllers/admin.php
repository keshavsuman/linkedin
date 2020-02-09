<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class admin extends CI_Controller
{
    function __construct()
  	{
  	    parent:: __construct();
        $this->load->helper('url');
        $this->load->Model(array('file_uploads','adminfunction'));
        $this->load->library('session');
    }
    public function accept($id)
    {
      if($this->file_uploads->accept_image($id))
      {
        redirect(base_url('admin/showrequests'),'refresh');
      }
    }
    public function reject($id)
    {
        if($this->file_uploads->remove_image($id))
        {
          redirect(base_url('admin/showrequests'),'refresh');
        }
    }
    public function showrequests()
    {
        $result=$this->adminfunction->get_requests();
        $data = array('result' => $result );
        if(count($result)==0)
        $data['descrip']="Sorry, There is no requests to accept";
        else
        $data['descrip']="You can accept Requests here";
        $this->load->view('admin/adminheader');
        $this->load->view('admin/adminsidebar');
        $this->load->view('admin/showrequests',$data);
        $this->load->view('admin/adminfooter');
    }
    private function hash_password($password)
  	{
  	   return password_hash($password, PASSWORD_BCRYPT);
  	}
    public function index()
    {
      if($this->session->userdata('is_login')==1 && $this->session->userdata('loginas')=='admin')
      {
        $data=$this->adminfunction->collectdata();
        $this->load->view('admin/adminheader');
        $this->load->view('admin/adminsidebar');
        $this->load->view('admin/dashboard',$data);
        $this->load->view('admin/adminfooter');
      }
      else
      $this->load->view('admin/adminlogin');
    }
    public function login()
    {
      $d=$this->input->post();
      $data=array(
        'username'=>$d['username'],
        'password'=>$d['pass']
      );
      if($this->adminfunction->verifylogin($data))
      {
        $this->session->set_userdata('admin_id',$data['username']);
        $this->session->set_userdata('is_login',True);
        $this->session->set_userdata('loginas','admin');
        redirect(base_url('admin'),'refresh');
      }
      else
      {
      redirect(base_url('admin'),'refresh');
      }
    }
    public function searchuser()
    {
      $content=array("data"=>array());
      $this->load->view('admin/adminheader');
      $this->load->view('admin/adminsidebar');
      $this->load->view('admin/Search',$content);
      $this->load->view('admin/adminfooter');
    }
    public function search()
    {
      $content['data']=$this->adminfunction->searchuser($this->input->post());
      $this->load->view('admin/adminheader');
      $this->load->view('admin/adminsidebar');
      $this->load->view('admin/Search',$content);
      $this->load->view('admin/adminfooter');
    }
    public function imagecrousel()
    {
      $this->load->view('admin/adminheader');
      $this->load->view('admin/adminsidebar');
      $this->load->view('admin/imagecrousel');
      $this->load->view('admin/adminfooter');
    }
    public function news()
    {
      if($this->session->userdata('is_login')==1 && $this->session->userdata('loginas')=='admin')
      {
      $news=$this->adminfunction->getAllNews();
      $content['news']=$news;
      $this->load->view('admin/adminheader');
      $this->load->view('admin/adminsidebar');
      $this->load->view('admin/adminnews',$content);
      $this->load->view('admin/adminfooter');
    }
    else {
      redirect('admin/','refresh');
    }
    }
    public function addadmin()
    {
      if($this->session->userdata('is_login')==1 && $this->session->userdata('loginas')=='admin')
      {
      $this->load->view('admin/adminheader');
      $this->load->view('admin/adminsidebar');
      $this->load->view('admin/addadmin');
      $this->load->view('admin/adminfooter');
      }
      else {
        redirect('admin/','refresh');
      }
    }
    public function insertadmin()
    {
      $data=$this->input->post();
      $admin = array(
        'username' => $data['username'],
        'password' =>$this->hash_password($data['pass'])
      );
      if($this->adminfunction->addadmin($admin))
        $this->index();
      else
        $this->addadmin();
    }
    public function removepost($id)
    {
      if($this->adminfunction->removepost($id))
        return true;
      else
        return false;
    }
    public function addnews()
    {
      $news=$this->input->post();
      if($this->adminfunction->addnews($news))
        $this->news();
      else
        return false;
    }
    public function removenews()
    {
      if($this->adminfunction->removenews())
        return true;
      else
        return false;
    }
    public function removeaccepted()
    {
      if($this->session->userdata('is_login')==1 && $this->session->userdata('loginas')=='admin')
      {
      $result=$this->adminfunction->get_accepted();
      $data = array('result' => $result );
      $this->load->view('admin/adminheader');
      $this->load->view('admin/adminsidebar');
      $this->load->view('admin/removepost',$data);
      $this->load->view('admin/adminfooter');
    }
    else {
      redirect('admin/','refresh');
    }
    }
    public function getallnews()
    {
      $this->adminfunction->getAllNews();
    }
    public function logout()
  	{
  	    $user_data = $this->session->all_userdata();
  	        foreach ($user_data as $key => $value) {
  	        $this->session->unset_userdata($key);
  	        }
  		     $this->session->sess_destroy();
  	    redirect('admin');
  	}
}
