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
//		$data['users'] = $this->_main->get_all_emails();

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
				'birthday' => $user[0]['birthday']
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
					'birthday' => $user[0]['birthday']
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
			'birthday' => $this->input->post('birthday')
		);

		if ($this->_main->user_exists($data['email'])) {
			$this->session->set_flashdata('error', 'Email already exists');
			$this->load_navbar();
			$this->signup();
		} elseif ($data['birthday'] > date('Y-m-d')) {
			$this->session->set_flashdata('error', 'Birthday is invalid');
			$this->signup();
		} else {
			$this->_main->insert_user($data);
			$this->session->set_userdata($data);
			$this->homepage();
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
		$data = array(
			'video' => $this->input->post('userfile')
		);

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

	public function send_email()
	{
		$to_email = $this->input->post('send-email');

		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => '94546302pp@gmail.com',
			'smtp_pass' => 'asd123qwe!',
			'mailtype' => 'html',
			'starttls' => true
		);
		$this->load->library('email', $config);

		$this->email->from('94546302pp@gmail.com', 'SupaSexy 69');
//		$this->email->to('misterimouto@gmail.com');
		$this->email->to('94546302pp@gmail.com');
//		$this->email->to($to_email);
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');

//		$this->email->send();

		if($this->email->send()) {
			$this->session->set_flashdata("email_sent","Congratulation Email Send Successfully.");
			$this->my_account();
		} else {
			$this->session->set_flashdata("email_sent","You have encountered an error");
			$this->my_account();
		}
	}

	public function change_email()
	{
		$data = array(
			'email' => $this->input->post('change-email')
		);

		$user_id = $this->session->userdata('user_id');
		$this->_main->update_user($user_id, $data);

		$this->session->set_userdata($data);
		redirect(base_url() . 'main/my_account');
	}

	public function change_name()
	{
		$data = array(
			'name' => $this->input->post('change-name')
		);

		$user_id = $this->session->userdata('user_id');
		$this->_main->update_user($user_id, $data);

		$this->session->set_userdata($data);
		redirect(base_url() . 'main/my_account');
	}

	public function change_birthday()
	{
		$data = array(
			'birthday' => $this->input->post('change-birthday')
		);

		$user_id = $this->session->userdata('user_id');
		$this->_main->update_user($user_id, $data);

		$this->session->set_userdata($data);
		redirect(base_url() . 'main/my_account');
	}

}
