<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class adminfunction extends CI_Model
{
  public function collectdata()
  {
    $data = array();
    $data['totaluploads']=$this->db->get('uploads')->num_rows();
    $data['totalusers']=$this->db->get('users')->num_rows();
    $data['pendingrequests']=$this->db->get('waiting')->num_rows();
    return $data;
  }
  public function verifylogin($data)
  {
    $success=$this->db->get_where('admin',array('admin_id'=>$data['admin_id']))->result();
    if(count($success)==1)
     return	password_verify($data['password'],$success[0]->password);
    else
      return false;
  }
  public function addnews($news)
  {
    $data = array('news_title' =>$news['newstitle'] ,
      'startdate' => $news['dateopened'],
      'enddate' => $news['dateend'],
      'news_content' => $news['newscontent'],
      'news_id'=>$this->db->get('news')->num_rows()+1,
      'news_image'=>$news['newsimage'],
   );
    if($this->db->insert('news',$data))
      return true;
    else
      return false;
  }
  public function removenews($news)
  {
    if($this->db->delete('news',array('news'=>$news)))
      return true;
    else
      return false;
  }
  public function removepost($id)
  {
    $uploads=$this->db->delete('uploads',array('upload_id'=>$id));
    if($uploads)
      return true;
    else
      return false;
  }
  public function addadmin($admin)
  {
    if($this->db->insert('admin',$admin))
      return true;
    else
      return false;
  }
  public function get_requests()
  {
    $sql="SELECT * FROM users join waiting on (users.Enrollment=waiting.Enrollment);";
    $result=$this->db->query($sql)->result_array();
    return $result;
  }
  public function get_accepted()
  {
    $sql="SELECT * FROM users join uploads on (users.Enrollment=uploads.Enrollment) order by upload_id desc; ;";
    $result=$this->db->query($sql)->result_array();
    return $result;
  }
  public function searchuser($data)
  {
    $enroll=$data['enroll'];
    $username=$data['name'];
    if(strlen($enroll) or strlen($username))
    $sql="SELECT * FROM `users` Where `Enrollment` like '%$enroll%' or `Name` like '%$username%';";

    if(strlen($enroll)==0 or strlen($username))
    $sql="SELECT * FROM `users` Where `Name` like '%$username%';";

    if(strlen($enroll) or strlen($username)==0)
    $sql="SELECT * FROM `users` Where `Enrollment` like '%$enroll%';";

    $result=$this->db->query($sql)->result_array();
    return $result;
  }
  public function getAllNews()
  {
    $result=$this->db->get('news')->result();
    return $result;
  }
}
?>
