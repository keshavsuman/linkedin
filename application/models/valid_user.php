<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Valid_user extends CI_Model
{
  //hashing function
	private function hash_password($password){
	   return password_hash($password, PASSWORD_BCRYPT);
	}

  public function is_valid()
  {
			$data=$this->input->post();
      $success=$this->db->get_where('users',array('Enrollment'=>$data['enroll']))->result();
			if(count($success)==1)
			 return	password_verify($data['pass'],$success[0]->Password);
      else
        return false;
  }

  public function confirm_signup($email)
  {
		$result=$this->db->get_where('unconfirmed_signup',array('email'=>$email))->result_array();
		if(count($result)>0)
		{
			$enroll= $result[0]['Enrollment'];
			$qry="DELETE FROM unconfirmed_signup WHERE Enrollment='$enroll';";
			$data= array(
					'Enrollment' => $result[0]['Enrollment'],
					'Password'=> $result[0]['Password'],
					'email'=>$result[0]['email'],
					'Class'=>$result[0]['Class'],
					'Branch'=>$result[0]['Branch'],
					'Year'=>$result[0]['Year'],
					'Name'=>$result[0]['Name'],
					'institute'=>$result[0]['institute']
				);
			if($this->db->insert('users',$data) && $this->db->query($qry))
			{
				return true;
			}
		}
  }
	public function isexits($data)
	{
		$r=$this->db->get_where('users',$data)->result();
		if(count($r)==1)
		return true;
		else
		return false;
	}
}
?>
