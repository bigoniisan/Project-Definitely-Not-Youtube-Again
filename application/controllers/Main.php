<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class main extends CI_Controller
{

//	private $_main;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('_main');
		$this->load->helper(array(
			'cookie',
			'form',
			'url'
		));
		$this->load->library(array(
			'form_validation',
			'session'
		));
	}

	public function index()
	{
		$this->homepage();
	}

	public function homepage()
	{
		$this->load_navbar();
		$video_list = $this->_main->get_videos();
		print_r($video_list);
		$this->load->view('homepage', array(
			'video_list' => $video_list
		));
	}

	public function login()
	{
		$this->load_navbar();
		$this->load->view('login');
	}

	public function signup()
	{
		$this->load_navbar();
		$this->load->view('signup');
	}

	public function my_account()
	{
		$this->load_navbar();
		$this->load->view('my_account');
	}

	public function upload()
	{
		$this->load_navbar();
		$this->load->view('upload');
	}

	public function password_reset()
	{
		$this->load_navbar();
		$this->load->view('password_reset');
	}

	public function profile_image_upload()
	{
		$data['title'] = "Upload Image using Ajax JQuery in CodeIgniter";
		$this->load_navbar();
		$this->load->view('profile_image_upload', $data);
	}

	public function verification_code_input()
	{
		$this->load_navbar();
		$this->load->view('verification_code_input');
	}

	public function load_navbar()
	{
		if ($this->session->userdata('email') != '') {
			$this->load->view('templates/navbar_logged_in');
		} else {
			$this->load->view('templates/navbar_logged_out');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('password');
		$this->session->unset_userdata('name');
		$this->session->unset_userdata('birthday');
		$this->session->unset_userdata('is_verified');
		$this->session->unset_userdata('verification_code');

		$this->homepage();
	}

	public function login_submit()
	{
		$data = array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
			'remember-me' => $this->input->post('remember-me')
		);

		$user = $this->_main->verify_user($data['email'], $data['password']);

		if (get_cookie('email') != '' && get_cookie('password') != '') {
			$session_data = array(
				'user_id' => $user[0]['user_id'],
				'email' => $user[0]['email'],
				'password' => $user[0]['password'],
				'name' => $user[0]['name'],
				'birthday' => $user[0]['birthday'],
				'is_verified' => $user[0]['is_verified']
			);
			$this->session->set_userdata($session_data);

			$this->homepage();

		} else {

			if ($user == FALSE) {
				$this->session->set_flashdata('error', 'Invalid username or password');
				$this->load_navbar();
				$this->load->view('login');
			} else {

				if ($data['remember-me']) {
					set_cookie('email', $data['email']);
					set_cookie('password', $data['password']);
				} else {
					delete_cookie('email');
					delete_cookie('password');
				}

				$session_data = array(
					'user_id' => $user[0]['user_id'],
					'email' => $user[0]['email'],
					'password' => $user[0]['password'],
					'name' => $user[0]['name'],
					'birthday' => $user[0]['birthday'],
					'is_verified' => $user[0]['is_verified']
				);
				$this->session->set_userdata($session_data);

				$this->homepage();
			}
		}
	}

	public function signup_submit()
	{
		$data = array(
			'user_id' => $this->_main->generate_user_id(),
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
			'name' => $this->input->post('name'),
			'birthday' => $this->input->post('birthday'),
			'is_verified' => FALSE
		);

		if ($this->_main->user_exists($data['email'])) {
			$this->session->set_flashdata('error', 'Email already exists');
			$this->load_navbar();
			$this->signup();
		} elseif ($data['birthday'] > date('Y-m-d')) {
			$this->session->set_flashdata('error', 'Birthday is invalid');
			$this->signup();
		} else {
			// signup success
			$this->_main->insert_user($data);
			$this->session->set_userdata($data);

			$this->send_verification_email();

			// setup security questions
//			$this->setup_security_questions();
		}
	}

	public function setup_security_questions()
	{

	}

	public function item_search()
	{
		$search_name = $this->input->post('search');
		$search_result = $this->_main->search_videos_by_name($search_name);

		if (!$search_result) {
			// no results
			echo "No results";
		} else {

		}
	}

	public function send_verification_email()
	{
		// set verification code
		$verification_code = rand(1000, 9999);
		$session_data = array(
			'is_verified' => 'no',
			'verification_code' => (string) $verification_code
		);
		$this->session->set_userdata($session_data);

		// send verification email
		$to_email = $this->session->userdata('email');
		$email_subject = 'Signup Verification Code';
		$email_message = "Please verify your email." . "<br/><br/>" . "Verification Code: " .
			$verification_code . "<br/><br/>" . "Thanks," . "<br/>" . "SupaSexy69";
		$this->send_email($to_email, $email_subject, $email_message);

		// redirect to verification code input page
		$this->verification_code_input();
	}

	public function send_email($email, $subject, $message)
	{
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'mailhub.eait.uq.edu.au',
			'smtp_port' => 25,
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		);
		$this->load->library('email', $config);

		$this->email->from('noreply@infs3202-78c24710.uqcloud.net', 'SupaSexy69');
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();
	}

	public function verify_email()
	{
		$input_code = $this->input->post('verification-code');

		if ($input_code == $this->session->userdata('verification_code')) {
			// successful verification

			// update user in db
			$data = array(
				'user_id' => $this->session->userdata('user_id'),
				'is_verified' => TRUE
			);;
			$this->_main->update_user($data['user_id'], $data);

			$session_data = array(
				'is_verified' => 'yes'
			);
			$this->session->set_userdata($session_data);

			$this->my_account();
		} else {
			// unsuccessful verification, redirect to verification code page
			$this->session->set_flashdata('email_verification', 'Incorrect verification code');
			$this->verification_code_input();
		}
	}

	public function reset_password()
	{
		$email = $this->input->post('email');
	}

	public function ajax_upload()
	{
		if(isset($_FILES["image_file"]["name"]))
		{
			$config['upload_path'] = './image_upload/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('image_file'))
			{
				echo $this->upload->display_errors();
			}
			else
			{
				$data = $this->upload->data();
				echo '<img src="'.base_url().'image_upload/'.$data["file_name"].'" width="300" height="225" class="img-thumbnail" />';
			}
		}
	}

	public function upload_video()
	{
		$config['upload_path'] = './uploads';
		$config['allowed_types'] = 'mp4';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
			$this->load_navbar();
			$this->load->view('upload');
		} else {
			$upload_data = $this->upload->data();
			$data = array(
				'video_id' => $this->_main->generate_video_id(),
				'video_name' => $upload_data['raw_name'],
				'filepath' => base_url() . 'uploads/' . $upload_data['file_name']
			);
			$this->_main->insert_video($data);

			print_r($upload_data);
			$this->load_navbar();
			$this->load->view('upload', $data);
		}
	}

	public function image_upload()
	{
		$config['upload_path'] = './images/';
		$config['allowed_types'] = 'jpg|jpeg|gif|png';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('profile-image')) {
			$this->session->set_flashdata('image_upload_error', $this->upload->display_errors());
			$this->load_navbar();
			$this->load->view('my_account');
		} else {
			$upload_data = $this->upload->data();
			$data = array(
				'user_id' => $this->session->userdata('user_id'),
				'profile_image_filepath' => base_url() . 'images/' . $upload_data['file_name']
			);
			$this->_main->set_user_profile_image($data);

			$this->load_navbar();
			$this->load->view('my_account', $data);
		}
	}

	public function change_email()
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'email' => $this->input->post('change-email')
		);

		if (!$this->_main->user_exists($data['email'])) {
			$this->session->set_userdata($data);
			$this->_main->update_user($data['user_id'], $data);
			$this->session->set_flashdata("change_email_error","Email changed successfully");
		} else {
			$this->session->set_flashdata("change_email","Error: Email already exists");
		}
		redirect(base_url() . 'main/my_account');
	}

	public function change_name()
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'name' => $this->input->post('change-name')
		);

		$user_id = $this->session->userdata('user_id');
		$this->_main->update_user($data['user_id'], $data);
		$this->session->set_userdata($data);
		$this->session->set_flashdata("change_name_error","Name changed successfully");
		redirect(base_url() . 'main/my_account');
	}

	public function change_birthday()
	{
		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'birthday' => $this->input->post('change-birthday')
		);

		if ($data['birthday'] < date('Y-m-d')) {
			$user_id = $this->session->userdata('user_id');
			$this->_main->update_user($data['user_id'], $data);
			$this->session->set_userdata($data);
			$this->session->set_flashdata("change_birthday_error","Birthday changed successfully");
		} else {
			$this->session->set_flashdata("change_birthday","Error: invalid birthday");
		}
		redirect(base_url() . 'main/my_account');
	}

}
