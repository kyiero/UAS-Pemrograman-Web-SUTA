<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all categories
     */
    public function get_all($active_only = FALSE)
    {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        $this->db->order_by('name', 'ASC');
        return $this->db->get('categories')->result();
    }

    /**
     * Get category by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where('categories', ['id' => $id])->row();
    }

    /**
     * Get category by slug
     */
    public function get_by_slug($slug)
    {
        return $this->db->get_where('categories', ['slug' => $slug, 'is_active' => 1])->row();
    }

    /**
     * Count categories
     */
    public function count_all()
    {
        return $this->db->count_all('categories');
    }

    /**
     * Insert category
     */
    public function insert($data)
    {
        return $this->db->insert('categories', $data);
    }

    /**
     * Update category
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    /**
     * Delete category
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('categories');
    }

    /**
     * Check if slug exists
     */
    public function slug_exists($slug, $exclude_id = NULL)
    {
        $this->db->where('slug', $slug);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results('categories') > 0;
    }

    /**
     * Get categories with article count
     */
    public function get_with_count()
    {
        $this->db->select('categories.*, COUNT(articles.id) as article_count');
        $this->db->from('categories');
        $this->db->join('articles', 'articles.category_id = categories.id AND articles.status = "published"', 'left');
        $this->db->where('categories.is_active', 1);
        $this->db->group_by('categories.id');
        $this->db->order_by('categories.name', 'ASC');
        return $this->db->get()->result();
    }
}
