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
//		$this->load->view('homepage');
		$this->display_videos();
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
		$this->load_navbar();
		$this->load->view('homepage');
	}

	public function login_submit()
	{
		$data = array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password')
		);

		$user = $this->_main->verify_user($data['email'], $data['password']);

		if ($user == FALSE) {
			$this->session->set_flashdata('error', 'Invalid username or password');
			$this->load_navbar();
			$this->load->view('login');
		} else {
			print_r($user);
			$session_data = array(
				'user_id' => $user[0]['user_id'],
				'email' => $user[0]['email'],
				'password' => $user[0]['password'],
				'name' => $user[0]['name'],
				'birthday' => $user[0]['birthday']
			);
			$this->session->set_userdata($session_data);
			$this->load_navbar();
			$this->load->view('homepage');
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
			$this->load->view('signup');
		} else {
			$this->_main->insert_user($data);
			$this->session->set_userdata($data);
			$this->load_navbar();
			$this->load->view('homepage');
		}

	}

	public function reset_password()
	{
		$email = $this->input->post('email');
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

	public function display_videos()
	{
		$video_list = $this->_main->get_videos();
		print_r($video_list);
		$this->load->view('homepage', array(
			'video_list' => $video_list
		));
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
