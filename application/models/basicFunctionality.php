<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class basicFunctionality extends CI_Model
{
  public function recentTenUploads()
  {
    return $this->db->query('SELECT * FROM uploads join users on (users.user_id=uploads.user_id) order by upload_id desc LIMIT 10')->result();
  }
  public function get_news($news_id)
  {
    if($news_id==0)
    {
      return $this->db->get('news')->result();
    }
    else {
      return $this->db->get_where('news',array("news_id"=>$news_id))->result()[0];
    }
  }
  public function get_userDetails($enrollment)
  {
    return $this->db->get_where('users',array("Enrollment"=>$enrollment))->result()[0];
  }
}
?>
