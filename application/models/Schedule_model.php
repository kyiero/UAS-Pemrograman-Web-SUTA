<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all schedules
     */
    public function get_all($limit = NULL, $offset = NULL, $active_only = FALSE)
    {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        $this->db->order_by('event_date', 'ASC');
        $this->db->order_by('event_time', 'ASC');
        
        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get('schedules')->result();
    }

    /**
     * Get upcoming schedules
     */
    public function get_upcoming($limit = 10)
    {
        $this->db->where('event_date >=', date('Y-m-d'));
        $this->db->where('is_active', 1);
        $this->db->order_by('event_date', 'ASC');
        $this->db->order_by('event_time', 'ASC');
        $this->db->limit($limit);
        
        return $this->db->get('schedules')->result();
    }

    /**
     * Get schedule by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where('schedules', ['id' => $id])->row();
    }

    /**
     * Count schedules
     */
    public function count_all()
    {
        return $this->db->count_all('schedules');
    }

    /**
     * Count upcoming schedules
     */
    public function count_upcoming()
    {
        $this->db->where('event_date >=', date('Y-m-d'));
        $this->db->where('is_active', 1);
        return $this->db->count_all_results('schedules');
    }

    /**
     * Insert schedule
     */
    public function insert($data)
    {
        return $this->db->insert('schedules', $data);
    }

    /**
     * Update schedule
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('schedules', $data);
    }

    /**
     * Delete schedule
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('schedules');
    }
}
