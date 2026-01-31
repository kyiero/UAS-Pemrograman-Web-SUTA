<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/Admin_Controller.php';

class Categories extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
    }

    public function index()
    {
        $this->set_page_data('Categories', 'categories');
        
        $data['categories'] = $this->Category_model->get_all();
        
        $this->render('admin/categories/index', $data);
    }

    public function create()
    {
        $this->set_page_data('Create Category', 'categories');
        
        $this->form_validation->set_rules('name', 'Category Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('icon', 'Icon', 'trim|max_length[50]');
        
        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/categories/create');
        } else {
            $name = $this->input->post('name', TRUE);
            $slug = $this->generate_slug($name, 'categories', 'slug');
            
            $category_data = [
                'name' => $name,
                'slug' => $slug,
                'description' => $this->input->post('description', TRUE),
                'icon' => $this->input->post('icon', TRUE),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            
            if ($this->Category_model->insert($category_data)) {
                $this->session->set_flashdata('success', 'Category created successfully.');
                redirect('admin/categories');
            } else {
                $this->session->set_flashdata('error', 'Failed to create category.');
                redirect('admin/categories/create');
            }
        }
    }

    public function edit($id)
    {
        $category = $this->Category_model->get_by_id($id);
        
        if (!$category) {
            show_404();
        }
        
        $this->set_page_data('Edit Category', 'categories');
        
        $this->form_validation->set_rules('name', 'Category Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('icon', 'Icon', 'trim|max_length[50]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['category'] = $category;
            $this->render('admin/categories/edit', $data);
        } else {
            $name = $this->input->post('name', TRUE);
            $slug = ($name !== $category->name) ? $this->generate_slug($name, 'categories', 'slug', $id) : $category->slug;
            
            $category_data = [
                'name' => $name,
                'slug' => $slug,
                'description' => $this->input->post('description', TRUE),
                'icon' => $this->input->post('icon', TRUE),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            
            if ($this->Category_model->update($id, $category_data)) {
                $this->session->set_flashdata('success', 'Category updated successfully.');
                redirect('admin/categories');
            } else {
                $this->session->set_flashdata('error', 'Failed to update category.');
                redirect('admin/categories/edit/' . $id);
            }
        }
    }

    public function delete($id)
    {
        $category = $this->Category_model->get_by_id($id);
        
        if (!$category) {
            show_404();
        }
        
        // Check if category has articles
        $article_count = $this->Article_model->count_by_category($id);
        if ($article_count > 0) {
            $this->session->set_flashdata('error', 'Cannot delete category with articles. Please reassign or delete articles first.');
            redirect('admin/categories');
        }
        
        if ($this->Category_model->delete($id)) {
            $this->session->set_flashdata('success', 'Category deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete category.');
        }
        
        redirect('admin/categories');
    }
}
