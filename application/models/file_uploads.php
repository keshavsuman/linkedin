<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class file_uploads extends CI_Model
{
  public function image_upload($enrollment,$filename)
  {
    $entry1 = $this->db->query('SELECT * FROM waiting')->num_rows();
    $entry2 = $this->db->query('SELECT * FROM uploads')->num_rows();
      $d=array(
      'Enrollment'=>$enrollment,
      'fileaddress'=>$filename,
      'upload_id'=>$entry1+$entry2+1,
      'date'=>unix_to_human(now('Asia/kolkata')),
    );
    if($this->db->insert('waiting',$d))
    return true;
    else
    return false;
  }
  public function accept_image($id)
  {
    $data=$this->db->get_where('waiting',array('upload_id'=>$id))->result_array();
    if($this->db->delete('waiting',array('upload_id'=>$id)) && $this->db->insert('uploads',$data[0]))
    return true;
    else
    return false;
  }
  public function remove_image($id)
  {
    if($this->db->delete('waiting',array('upload_id'=>$id)))
    return true;
    else
    return false;
  }
  public function crousel_upload($filename)
  {
    $d = array('fileaddress' => $filename);
    if($this->db->insert('imagecrousel',$d))
    return true;
    else
    return false;
  }
}
?>
