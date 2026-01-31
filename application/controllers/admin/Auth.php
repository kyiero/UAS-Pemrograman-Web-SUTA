<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    /**
     * Login page
     */
    public function login()
    {
        // Redirect if already logged in
        if ($this->session->userdata('user_id')) {
            redirect('admin/dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/auth/login');
        } else {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->User_model->verify($username, $password);

            if ($user) {
                // Check if user has admin or author role
                if (in_array($user->role, ['admin', 'author'])) {
                    // Set session data
                    $session_data = [
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'full_name' => $user->full_name,
                        'role' => $user->role,
                        'logged_in' => TRUE
                    ];
                    $this->session->set_userdata($session_data);

                    // Redirect to dashboard
                    $this->session->set_flashdata('success', 'Welcome back, ' . $user->full_name . '!');
                    redirect('admin/dashboard');
                } else {
                    $this->session->set_flashdata('error', 'You do not have permission to access the admin panel.');
                    redirect('admin/auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid username or password.');
                redirect('admin/auth/login');
            }
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'You have been logged out successfully.');
        redirect('admin/auth/login');
    }
}
