<?php

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		session_start();
		$this->load->library('form_validation');
	}

	function index() {
		$this->load->view('login_view');
	}

	public function login() {
		
		$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');

		if ($this->form_validation->run() !== FALSE) {
			// Then query the DB because the form was filled out correctly
			$this->load->model('admin_model');
			$res = $this
					->admin_model 
					->verify_user(
						$this->input->post('email_address'), 
						$this->input->post('password'));
			if ($res !== FALSE) {
				// Person has account
				$_SESSION['username'] = $this->input->post('email_address');
				$_SESSION['user_id'] = $res->id;
				redirect('welcome');
			}
		}
		$this -> load -> view('login_view');
	}

	public function logout() {
		session_destroy();
		$this -> load -> view('login_view');
	}
	
	public function register() {
		// Set form validation rules
		$this->form_validation->set_rules('first_name','First Name','required|max_length[40]');
		$this->form_validation->set_rules('last_name','Last Name','required|max_length[40]');
		$this->form_validation->set_rules('email_address','Email Address','required|valid_email');
		$this->form_validation->set_rules('password','Password','required|min_length[4]');
		
		// Run rules and do something if they check out
		if($this->form_validation->run() !== FALSE){
			// Register the new user into the database, and currently set their account to inactive
			$this->load->model('admin_model');
			// Randomly generate a number to use as their activation key.  Send it to the model with the
			// post values.
			$random = rand(1122, 9999);
			$res = $this
					->admin_model
					->register_user(
						$this->input->post('first_name'),
						$this->input->post('last_name'),
						$this->input->post('email_address'),
						$this->input->post('password'),
						$random
					);
			if($res!==FALSE){
				// Send the user an email with the randomly generated number, and a link to where
				// they can input it.  Once they input and submit the key (random value) their account
				// will be set as active.
				$this->load->library('email');
				$this->email->from('validation_imp@chrischross.com', 'Validation Imp');
				$this->email->to($this->input->post('email_address'));
				//$this->email->to('chrisciampoli@gmail.com');
				$this->email->subject('Thank you for registering with ChrisChross');
				$this->email->message('Thank you for registering with ChrisChross, you will need to ' . 'click here: http://localhost/chrischross/index.php/admin/validate/' . $random . ' to activate.');	
				$this->email->send();

				// will be set as active.  The other idea I have for this is to instead send an email
				// with a premade link with the email and key already input.  Once they click the link
				// it will run the validate function
				redirect('admin');
			}
		}
		$errors['email'] = '<p style="color:red;">Email address already exists</p>';
		$this->load->view('register',$errors);
	}

	public function validate($key) {
		if($key == ''){
			$this->load->library('sorry');
		}
		$this->load->model('admin_model');
		$res = $this
				->admin_model
				->validate_user(
					$key
				);
		if($res!==FALSE){
			$this->load->view('thankyou');
		} else {
			$this->load->view('sorry');
		}
	}
}
?>
