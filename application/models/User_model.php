<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get user by username
     */
    public function get_by_username($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row();
    }

    /**
     * Get user by email
     */
    public function get_by_email($email)
    {
        return $this->db->get_where('users', ['email' => $email])->row();
    }

    /**
     * Get user by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    /**
     * Get all users
     */
    public function get_all($limit = NULL, $offset = NULL)
    {
        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('users')->result();
    }

    /**
     * Count all users
     */
    public function count_all()
    {
        return $this->db->count_all('users');
    }

    /**
     * Insert new user
     */
    public function insert($data)
    {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        
        return $this->db->insert('users', $data);
    }

    /**
     * Update user
     */
    public function update($id, $data)
    {
        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    /**
     * Delete user
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    /**
     * Verify user credentials
     */
    public function verify($username, $password)
    {
        $user = $this->get_by_username($username);
        
        if ($user && password_verify($password, $user->password)) {
            if ($user->is_active == 1) {
                return $user;
            }
        }
        
        return FALSE;
    }

    /**
     * Check if username exists
     */
    public function username_exists($username, $exclude_id = NULL)
    {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results('users') > 0;
    }

    /**
     * Check if email exists
     */
    public function email_exists($email, $exclude_id = NULL)
    {
        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results('users') > 0;
    }
}
