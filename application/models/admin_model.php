<?php

class Admin_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function verify_user($email,$password)
	{
		$q = $this
				->db
				->where('email_address',$email)
				->where('password',sha1($password))
				->where('status','active')
				->limit(1)
				->get('users');
		if($q->num_rows() > 0){
			return $q->row();
		}
		return false;
	}
	
	public function register_user($first_name,$last_name,$email_address,$password,$key)
	{
		// Check if the email exists first in the DB
		$emailCheck = $this
						->db
						->where('email_address',$email_address)
						->limit(1)
						->get('users');
		if($emailCheck->num_rows() >= 1){
			return FALSE;
		} else {
			$q = $this
				->db
				->set('first_name',$first_name)
				->set('last_name',$last_name)
				->set('email_address',$email_address)
				->set('password',sha1($password))
				->set('key',$key)
				->set('status','inactive')
				->insert('users');
		}
		
	}
	
	public function validate_user($key){
		// Check if the key supplied even exists in the DB	
		$checkKey = $this
						->db
						->where('key',$key)
						->limit(1)
						->get('users');
		if($checkKey->num_rows != 1) {
			return FALSE;
		} else {
			$q = $this
					->db
					->set('status','active')
					->where('key',$key)
					->update('users');
		}
	}	
}

?>