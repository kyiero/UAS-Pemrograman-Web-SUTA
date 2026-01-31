<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/Admin_Controller.php';

class Articles extends Admin_Controller {

    public function index()
    {
        $this->set_page_data('Articles', 'articles');
        
        // Pagination
        $config['base_url'] = base_url('admin/articles/index');
        $config['total_rows'] = $this->Article_model->count_all(NULL);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        
        $this->load->library('pagination', $config);
        
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['articles'] = $this->Article_model->get_all($config['per_page'], $page, NULL);
        $data['pagination'] = $this->pagination->create_links();
        
        $this->render('admin/articles/index', $data);
    }

    public function create()
    {
        $this->set_page_data('Create Article', 'articles');
        
        $this->form_validation->set_rules('title', 'Title', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('excerpt', 'Excerpt', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[draft,published,archived]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['categories'] = $this->Category_model->get_all(TRUE);
            $this->render('admin/articles/create', $data);
        } else {
            $title = $this->input->post('title', TRUE);
            $slug = $this->generate_slug($title, 'articles', 'slug');
            
            $article_data = [
                'category_id' => $this->input->post('category_id', TRUE),
                'user_id' => $this->data['current_user']->id,
                'title' => $title,
                'slug' => $slug,
                'content' => $this->input->post('content'),
                'excerpt' => $this->input->post('excerpt', TRUE),
                'status' => $this->input->post('status', TRUE),
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                'published_at' => ($this->input->post('status') === 'published') ? date('Y-m-d H:i:s') : NULL
            ];
            
            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $upload_path = './uploads/articles/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0755, TRUE);
                }
                
                $upload_data = $this->handle_upload('image', $upload_path, 'jpg|jpeg|png|gif');
                if ($upload_data) {
                    $article_data['image'] = 'uploads/articles/' . $upload_data['file_name'];
                }
            }
            
            if ($this->Article_model->insert($article_data)) {
                $this->session->set_flashdata('success', 'Article created successfully.');
                redirect('admin/articles');
            } else {
                $this->session->set_flashdata('error', 'Failed to create article.');
                redirect('admin/articles/create');
            }
        }
    }

    public function edit($id)
    {
        $article = $this->Article_model->get_by_id($id);
        
        if (!$article) {
            show_404();
        }
        
        // Check permission
        if ($this->data['current_user']->role !== 'admin' && $article->user_id != $this->data['current_user']->id) {
            show_error('Unauthorized access', 403);
        }
        
        $this->set_page_data('Edit Article', 'articles');
        
        $this->form_validation->set_rules('title', 'Title', 'required|trim|max_length[200]');
        $this->form_validation->set_rules('category_id', 'Category', 'required|integer');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('excerpt', 'Excerpt', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[draft,published,archived]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['article'] = $article;
            $data['categories'] = $this->Category_model->get_all(TRUE);
            $this->render('admin/articles/edit', $data);
        } else {
            $title = $this->input->post('title', TRUE);
            $slug = ($title !== $article->title) ? $this->generate_slug($title, 'articles', 'slug', $id) : $article->slug;
            
            $article_data = [
                'category_id' => $this->input->post('category_id', TRUE),
                'title' => $title,
                'slug' => $slug,
                'content' => $this->input->post('content'),
                'excerpt' => $this->input->post('excerpt', TRUE),
                'status' => $this->input->post('status', TRUE),
                'is_featured' => $this->input->post('is_featured') ? 1 : 0
            ];
            
            // Set published_at if status changed to published
            if ($this->input->post('status') === 'published' && $article->status !== 'published') {
                $article_data['published_at'] = date('Y-m-d H:i:s');
            }
            
            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $upload_path = './uploads/articles/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0755, TRUE);
                }
                
                $upload_data = $this->handle_upload('image', $upload_path, 'jpg|jpeg|png|gif');
                if ($upload_data) {
                    // Delete old image
                    if ($article->image && file_exists('./' . $article->image)) {
                        unlink('./' . $article->image);
                    }
                    $article_data['image'] = 'uploads/articles/' . $upload_data['file_name'];
                }
            }
            
            if ($this->Article_model->update($id, $article_data)) {
                $this->session->set_flashdata('success', 'Article updated successfully.');
                redirect('admin/articles');
            } else {
                $this->session->set_flashdata('error', 'Failed to update article.');
                redirect('admin/articles/edit/' . $id);
            }
        }
    }

    public function delete($id)
    {
        $article = $this->Article_model->get_by_id($id);
        
        if (!$article) {
            show_404();
        }
        
        // Check permission
        if ($this->data['current_user']->role !== 'admin' && $article->user_id != $this->data['current_user']->id) {
            show_error('Unauthorized access', 403);
        }
        
        // Delete image
        if ($article->image && file_exists('./' . $article->image)) {
            unlink('./' . $article->image);
        }
        
        if ($this->Article_model->delete($id)) {
            $this->session->set_flashdata('success', 'Article deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete article.');
        }
        
        redirect('admin/articles');
    }
}
