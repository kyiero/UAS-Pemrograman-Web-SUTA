<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/Admin_Controller.php';

class Users extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
    }

    public function index()
    {
        $this->set_page_data('Users', 'users');
        
        $data['users'] = $this->User_model->get_all();
        
        $this->render('admin/users/index', $data);
    }

    public function create()
    {
        $this->set_page_data('Create User', 'users');
        
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]|max_length[50]|callback_username_check');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]|callback_email_check');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,author,viewer]');
        
        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/users/create');
        } else {
            $user_data = [
                'username' => $this->input->post('username', TRUE),
                'email' => $this->input->post('email', TRUE),
                'password' => $this->input->post('password', TRUE),
                'full_name' => $this->input->post('full_name', TRUE),
                'role' => $this->input->post('role', TRUE),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            
            if ($this->User_model->insert($user_data)) {
                $this->session->set_flashdata('success', 'User created successfully.');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Failed to create user.');
                redirect('admin/users/create');
            }
        }
    }

    public function edit($id)
    {
        $user = $this->User_model->get_by_id($id);
        
        if (!$user) {
            show_404();
        }
        
        $this->set_page_data('Edit User', 'users');
        
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]|max_length[50]|callback_username_check[' . $id . ']');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]|callback_email_check[' . $id . ']');
        $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'matches[password]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,author,viewer]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['user'] = $user;
            $this->render('admin/users/edit', $data);
        } else {
            $user_data = [
                'username' => $this->input->post('username', TRUE),
                'email' => $this->input->post('email', TRUE),
                'full_name' => $this->input->post('full_name', TRUE),
                'role' => $this->input->post('role', TRUE),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            
            $password = $this->input->post('password');
            if (!empty($password)) {
                $user_data['password'] = $password;
            }
            
            if ($this->User_model->update($id, $user_data)) {
                $this->session->set_flashdata('success', 'User updated successfully.');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Failed to update user.');
                redirect('admin/users/edit/' . $id);
            }
        }
    }

    public function delete($id)
    {
        $user = $this->User_model->get_by_id($id);
        
        if (!$user) {
            show_404();
        }
        
        // Prevent deleting yourself
        if ($user->id == $this->data['current_user']->id) {
            $this->session->set_flashdata('error', 'You cannot delete your own account.');
            redirect('admin/users');
        }
        
        if ($this->User_model->delete($id)) {
            $this->session->set_flashdata('success', 'User deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user.');
        }
        
        redirect('admin/users');
    }

    public function username_check($username, $exclude_id = NULL)
    {
        if ($this->User_model->username_exists($username, $exclude_id)) {
            $this->form_validation->set_message('username_check', 'The {field} is already taken.');
            return FALSE;
        }
        return TRUE;
    }

    public function email_check($email, $exclude_id = NULL)
    {
        if ($this->User_model->email_exists($email, $exclude_id)) {
            $this->form_validation->set_message('email_check', 'The {field} is already registered.');
            return FALSE;
        }
        return TRUE;
    }
}
