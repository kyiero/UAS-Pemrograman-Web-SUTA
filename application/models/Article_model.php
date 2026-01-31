<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all articles with category and author info
     */
    public function get_all($limit = NULL, $offset = NULL, $status = 'published')
    {
        $this->db->select('articles.*, categories.name as category_name, categories.slug as category_slug, users.full_name as author_name');
        $this->db->from('articles');
        $this->db->join('categories', 'categories.id = articles.category_id');
        $this->db->join('users', 'users.id = articles.user_id');
        
        if ($status) {
            $this->db->where('articles.status', $status);
        }
        
        $this->db->order_by('articles.created_at', 'DESC');
        
        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }

    /**
     * Get article by ID
     */
    public function get_by_id($id)
    {
        $this->db->select('articles.*, categories.name as category_name, categories.slug as category_slug, users.full_name as author_name');
        $this->db->from('articles');
        $this->db->join('categories', 'categories.id = articles.category_id');
        $this->db->join('users', 'users.id = articles.user_id');
        $this->db->where('articles.id', $id);
        
        return $this->db->get()->row();
    }

    /**
     * Get article by slug
     */
    public function get_by_slug($slug)
    {
        $this->db->select('articles.*, categories.name as category_name, categories.slug as category_slug, users.full_name as author_name');
        $this->db->from('articles');
        $this->db->join('categories', 'categories.id = articles.category_id');
        $this->db->join('users', 'users.id = articles.user_id');
        $this->db->where('articles.slug', $slug);
        $this->db->where('articles.status', 'published');
        
        return $this->db->get()->row();
    }

    /**
     * Get articles by category
     */
    public function get_by_category($category_id, $limit = NULL, $offset = NULL)
    {
        $this->db->select('articles.*, categories.name as category_name, categories.slug as category_slug, users.full_name as author_name');
        $this->db->from('articles');
        $this->db->join('categories', 'categories.id = articles.category_id');
        $this->db->join('users', 'users.id = articles.user_id');
        $this->db->where('articles.category_id', $category_id);
        $this->db->where('articles.status', 'published');
        $this->db->order_by('articles.created_at', 'DESC');
        
        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }

    /**
     * Get featured articles
     */
    public function get_featured($limit = 5)
    {
        $this->db->select('articles.*, categories.name as category_name, categories.slug as category_slug, users.full_name as author_name');
        $this->db->from('articles');
        $this->db->join('categories', 'categories.id = articles.category_id');
        $this->db->join('users', 'users.id = articles.user_id');
        $this->db->where('articles.is_featured', 1);
        $this->db->where('articles.status', 'published');
        $this->db->order_by('articles.created_at', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    /**
     * Count articles
     */
    public function count_all($status = 'published')
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results('articles');
    }

    /**
     * Count by category
     */
    public function count_by_category($category_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->where('status', 'published');
        return $this->db->count_all_results('articles');
    }

    /**
     * Insert article
     */
    public function insert($data)
    {
        return $this->db->insert('articles', $data);
    }

    /**
     * Update article
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('articles', $data);
    }

    /**
     * Delete article
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('articles');
    }

    /**
     * Increment views
     */
    public function increment_views($id)
    {
        $this->db->set('views', 'views+1', FALSE);
        $this->db->where('id', $id);
        return $this->db->update('articles');
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
        return $this->db->count_all_results('articles') > 0;
    }

    /**
     * Search articles
     */
    public function search($keyword, $limit = NULL, $offset = NULL)
    {
        $this->db->select('articles.*, categories.name as category_name, categories.slug as category_slug, users.full_name as author_name');
        $this->db->from('articles');
        $this->db->join('categories', 'categories.id = articles.category_id');
        $this->db->join('users', 'users.id = articles.user_id');
        $this->db->where('articles.status', 'published');
        $this->db->group_start();
        $this->db->like('articles.title', $keyword);
        $this->db->or_like('articles.content', $keyword);
        $this->db->or_like('articles.excerpt', $keyword);
        $this->db->group_end();
        $this->db->order_by('articles.created_at', 'DESC');
        
        if ($limit !== NULL) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }
}
