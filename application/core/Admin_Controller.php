<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends CI_Controller {

    protected $data = [];

    public function __construct()
    {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            redirect('admin/auth/login');
        }
        
        // Load user data
        $this->load->model('User_model');
        $user = $this->User_model->get_by_id($this->session->userdata('user_id'));
        
        if (!$user || $user->is_active != 1) {
            $this->session->sess_destroy();
            redirect('admin/auth/login');
        }
        
        // Check if user has admin or author role
        if (!in_array($user->role, ['admin', 'author'])) {
            show_error('Unauthorized access', 403);
        }
        
        $this->data['current_user'] = $user;
        
        // Load models
        $this->load->model('Article_model');
        $this->load->model('Category_model');
        $this->load->model('Schedule_model');
        $this->load->model('Setting_model');
    }

    /**
     * Check if user is admin
     */
    protected function is_admin()
    {
        return $this->data['current_user']->role === 'admin';
    }

    /**
     * Require admin role
     */
    protected function require_admin()
    {
        if (!$this->is_admin()) {
            show_error('Admin access required', 403);
        }
    }

    /**
     * Set page data
     */
    protected function set_page_data($title, $active_menu = '')
    {
        $this->data['page_title'] = $title;
        $this->data['active_menu'] = $active_menu;
    }

    /**
     * Render view
     */
    protected function render($view, $data = [])
    {
        $this->data = array_merge($this->data, $data);
        $this->load->view('admin/templates/header', $this->data);
        $this->load->view('admin/templates/sidebar', $this->data);
        $this->load->view($view, $this->data);
        $this->load->view('admin/templates/footer', $this->data);
    }

    /**
     * Generate unique slug
     */
    protected function generate_slug($text, $table, $field = 'slug', $exclude_id = NULL)
    {
        $this->load->helper('text');
        $slug = url_title(convert_accented_characters($text), '-', TRUE);
        
        $original_slug = $slug;
        $counter = 1;
        
        while ($this->slug_exists($table, $field, $slug, $exclude_id)) {
            $slug = $original_slug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Check if slug exists
     */
    private function slug_exists($table, $field, $slug, $exclude_id = NULL)
    {
        $this->db->where($field, $slug);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($table) > 0;
    }

    /**
     * Handle file upload
     */
    protected function handle_upload($field_name, $upload_path, $allowed_types = 'jpg|jpeg|png|gif')
    {
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = $allowed_types;
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload($field_name)) {
            return $this->upload->data();
        }
        
        return FALSE;
    }
}
