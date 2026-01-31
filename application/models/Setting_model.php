<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all settings as associative array
     */
    public function get_all()
    {
        $query = $this->db->get('settings');
        $settings = [];
        
        foreach ($query->result() as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        
        return $settings;
    }

    /**
     * Get setting by key
     */
    public function get($key, $default = NULL)
    {
        $row = $this->db->get_where('settings', ['setting_key' => $key])->row();
        return $row ? $row->setting_value : $default;
    }

    /**
     * Set or update setting
     */
    public function set($key, $value, $type = 'text')
    {
        $existing = $this->db->get_where('settings', ['setting_key' => $key])->row();
        
        if ($existing) {
            $this->db->where('setting_key', $key);
            return $this->db->update('settings', [
                'setting_value' => $value,
                'setting_type' => $type
            ]);
        } else {
            return $this->db->insert('settings', [
                'setting_key' => $key,
                'setting_value' => $value,
                'setting_type' => $type
            ]);
        }
    }

    /**
     * Delete setting
     */
    public function delete($key)
    {
        $this->db->where('setting_key', $key);
        return $this->db->delete('settings');
    }
}
