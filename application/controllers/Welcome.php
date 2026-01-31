<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Article_model');
		$this->load->model('Category_model');
		$this->load->model('Schedule_model');
		$this->load->model('Setting_model');
	}

	/**
	 * Homepage
	 */
	public function index()
	{
		$data['page_title'] = 'Home';
		$data['settings'] = $this->Setting_model->get_all();
		$data['featured_articles'] = $this->Article_model->get_featured(3);
		$data['recent_articles'] = $this->Article_model->get_all(6, 0, 'published');
		$data['categories'] = $this->Category_model->get_with_count();
		$data['upcoming_schedules'] = $this->Schedule_model->get_upcoming(4);
		
		$this->load->view('frontend/templates/header', $data);
		$this->load->view('frontend/home', $data);
		$this->load->view('frontend/templates/footer', $data);
	}

	/**
	 * Articles listing
	 */
	public function articles($page = 0)
	{
		$config['base_url'] = base_url('articles');
		$config['total_rows'] = $this->Article_model->count_all('published');
		$config['per_page'] = 9;
		$config['uri_segment'] = 2;
		
		$this->load->library('pagination', $config);
		
		$data['page_title'] = 'All Articles';
		$data['settings'] = $this->Setting_model->get_all();
		$data['articles'] = $this->Article_model->get_all($config['per_page'], $page, 'published');
		$data['categories'] = $this->Category_model->get_with_count();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('frontend/templates/header', $data);
		$this->load->view('frontend/articles', $data);
		$this->load->view('frontend/templates/footer', $data);
	}

	/**
	 * View single article
	 */
	public function article($slug)
	{
		$article = $this->Article_model->get_by_slug($slug);
		
		if (!$article) {
			show_404();
		}
		
		// Increment views
		$this->Article_model->increment_views($article->id);
		
		$data['page_title'] = $article->title;
		$data['settings'] = $this->Setting_model->get_all();
		$data['article'] = $article;
		$data['related_articles'] = $this->Article_model->get_by_category($article->category_id, 3);
		$data['categories'] = $this->Category_model->get_with_count();
		
		$this->load->view('frontend/templates/header', $data);
		$this->load->view('frontend/article_detail', $data);
		$this->load->view('frontend/templates/footer', $data);
	}

	/**
	 * Category articles
	 */
	public function category($slug, $page = 0)
	{
		$category = $this->Category_model->get_by_slug($slug);
		
		if (!$category) {
			show_404();
		}
		
		$config['base_url'] = base_url('category/' . $slug);
		$config['total_rows'] = $this->Article_model->count_by_category($category->id);
		$config['per_page'] = 9;
		$config['uri_segment'] = 3;
		
		$this->load->library('pagination', $config);
		
		$data['page_title'] = $category->name;
		$data['settings'] = $this->Setting_model->get_all();
		$data['category'] = $category;
		$data['articles'] = $this->Article_model->get_by_category($category->id, $config['per_page'], $page);
		$data['categories'] = $this->Category_model->get_with_count();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('frontend/templates/header', $data);
		$this->load->view('frontend/category', $data);
		$this->load->view('frontend/templates/footer', $data);
	}

	/**
	 * Schedules listing
	 */
	public function schedules()
	{
		$data['page_title'] = 'Jadwal Kajian';
		$data['settings'] = $this->Setting_model->get_all();
		$data['schedules'] = $this->Schedule_model->get_upcoming(50);
		$data['categories'] = $this->Category_model->get_with_count();
		
		$this->load->view('frontend/templates/header', $data);
		$this->load->view('frontend/schedules', $data);
		$this->load->view('frontend/templates/footer', $data);
	}
}

