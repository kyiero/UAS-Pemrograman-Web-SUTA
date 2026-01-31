<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/Admin_Controller.php';

class Schedules extends Admin_Controller {

    public function index()
    {
        $this->set_page_data('Schedules', 'schedules');
        
        $data['schedules'] = $this->Schedule_model->get_all();
        
        $this->render('admin/schedules/index', $data);
    }

    public function create()
    {
        $this->set_page_data('Create Schedule', 'schedules');
        
        $this->form_validation->set_rules('title', 'Title', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('ustadz', 'Ustadz', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('location', 'Location', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('event_date', 'Event Date', 'required');
        $this->form_validation->set_rules('event_time', 'Event Time', 'required');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('duration', 'Duration', 'trim|max_length[50]');
        
        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/schedules/create');
        } else {
            $schedule_data = [
                'title' => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE),
                'ustadz' => $this->input->post('ustadz', TRUE),
                'location' => $this->input->post('location', TRUE),
                'event_date' => $this->input->post('event_date', TRUE),
                'event_time' => $this->input->post('event_time', TRUE),
                'duration' => $this->input->post('duration', TRUE),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            
            if ($this->Schedule_model->insert($schedule_data)) {
                $this->session->set_flashdata('success', 'Schedule created successfully.');
                redirect('admin/schedules');
            } else {
                $this->session->set_flashdata('error', 'Failed to create schedule.');
                redirect('admin/schedules/create');
            }
        }
    }

    public function edit($id)
    {
        $schedule = $this->Schedule_model->get_by_id($id);
        
        if (!$schedule) {
            show_404();
        }
        
        $this->set_page_data('Edit Schedule', 'schedules');
        
        $this->form_validation->set_rules('title', 'Title', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('ustadz', 'Ustadz', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('location', 'Location', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('event_date', 'Event Date', 'required');
        $this->form_validation->set_rules('event_time', 'Event Time', 'required');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('duration', 'Duration', 'trim|max_length[50]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['schedule'] = $schedule;
            $this->render('admin/schedules/edit', $data);
        } else {
            $schedule_data = [
                'title' => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE),
                'ustadz' => $this->input->post('ustadz', TRUE),
                'location' => $this->input->post('location', TRUE),
                'event_date' => $this->input->post('event_date', TRUE),
                'event_time' => $this->input->post('event_time', TRUE),
                'duration' => $this->input->post('duration', TRUE),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            
            if ($this->Schedule_model->update($id, $schedule_data)) {
                $this->session->set_flashdata('success', 'Schedule updated successfully.');
                redirect('admin/schedules');
            } else {
                $this->session->set_flashdata('error', 'Failed to update schedule.');
                redirect('admin/schedules/edit/' . $id);
            }
        }
    }

    public function delete($id)
    {
        $schedule = $this->Schedule_model->get_by_id($id);
        
        if (!$schedule) {
            show_404();
        }
        
        if ($this->Schedule_model->delete($id)) {
            $this->session->set_flashdata('success', 'Schedule deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete schedule.');
        }
        
        redirect('admin/schedules');
    }
}
