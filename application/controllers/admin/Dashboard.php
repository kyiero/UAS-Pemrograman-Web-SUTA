<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/Admin_Controller.php';

class Dashboard extends Admin_Controller {

    public function index()
    {
        $this->set_page_data('Dashboard', 'dashboard');
        
        // Get statistics
        $data['total_articles'] = $this->Article_model->count_all(NULL);
        $data['published_articles'] = $this->Article_model->count_all('published');
        $data['draft_articles'] = $this->Article_model->count_all('draft');
        $data['total_categories'] = $this->Category_model->count_all();
        $data['total_schedules'] = $this->Schedule_model->count_all();
        $data['upcoming_schedules'] = $this->Schedule_model->count_upcoming();
        $data['total_users'] = $this->User_model->count_all();
        
        // Get recent articles
        $data['recent_articles'] = $this->Article_model->get_all(5, 0, NULL);
        
        // Get upcoming schedules
        $data['schedules'] = $this->Schedule_model->get_upcoming(5);
        
        $this->render('admin/dashboard', $data);
    }
}
