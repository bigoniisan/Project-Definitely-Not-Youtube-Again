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

	public function generate_user_id()
	{
		return $this->users_count() + 1;
	}

	public function users_count()
	{
		$query = $this->db->get('users');
		return $query->num_rows();
	}
}
