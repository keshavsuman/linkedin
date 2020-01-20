<?php
class Uploads extends CI_Controller
{
    public function __construct()
    {
      parent::__construct();
      $this->load->helper(array('form', 'url','date'));
      $this->load->library('session');
      $this->load->Model('file_uploads');
    }
    public function index()
    {
      echo unix_to_human(now('Asia/kolkata'));
      // $this->load->view('upload_form',array('error'=>' '));
    }
    public function uploads()
    {
        $image = $this->session->userdata('enroll').'-'.$_FILES['userfile']['name'];
        $config['file_name']            = $image;
        $config['upload_path']          = 'UPLOAD/';
        $config['allowed_types']        = 'jpeg|png';
        $config['max_size']             = 5000;
        $config['max_width']            = 2048;
        $config['max_height']           = 2048;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('home', $error);
        }
        else
        {
            // $data = array('upload_data' => $this->upload->data());
            if($this->file_uploads->image_upload($this->session->userdata('enroll'),$this->upload->data('file_name')))
            {
              $error = array('error' =>'File has been uploaded');
              $this->load->view('home', $error);
            }
        }
    }
    public function profilePicUpload()
    {

    }
  }
?>
