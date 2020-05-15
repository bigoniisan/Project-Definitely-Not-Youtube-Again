<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _main extends CI_Model
{

	public function verify_user($email, $password)
	{
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function user_exists($email)
	{
		$this->db->where('email', $email);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function update_user($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
	}

	public function insert_user($data)
	{
		$this->db->insert('users', $data);
	}

	public function get_all_emails()
	{
		$this->db->select('email');
		$query = $this->db->get('users');
		return $query->result_array();
	}

	public function get_user_details($data=array())
	{
		$this->db->where('email', $data['email']);
		$query = $this->db->get('users');
		return $query->result_array();
	}

	public function users_count()
	{
		$query = $this->db->get('users');
		return $query->num_rows();
	}

	public function generate_user_id()
	{
		return $this->users_count() + 1;
	}

	public function insert_video($data)
	{
		$this->db->insert('videos', $data);
	}

	public function videos_count()
	{
		$query = $this->db->get('videos');
		return $query->num_rows();
	}

	public function generate_video_id()
	{
		return $this->videos_count() + 1;
	}

	public function get_videos()
	{
		$query = $this->db->get('videos');
		return $query->result_array();
	}

	public function set_user_profile_image($data)
	{
		$this->db->where('user_id', $data['user_id']);
		$this->db->update('users', $data);
	}

	public function search_videos_by_name($search_name)
	{
		$this->db->where('video_name', $search_name);
		$query = $this->db->get('videos');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_video_by_id($video_id)
	{
		$this->db->where('video_id', $video_id);
		$query = $this->db->get('videos');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function search_videos_by_name_contains($search_name)
	{
		// split search terms into array
		$search_terms = explode(' ', $search_name);
		foreach($search_terms as $search_term) {
			$this->db->or_like('video_name', $search_term);
		}
		$query = $this->db->get('videos');
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function insert_security_questions($data)
	{
		$this->db->insert('security_questions', $data);
	}
}
