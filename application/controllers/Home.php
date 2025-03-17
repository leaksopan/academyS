<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home Controller
 * 
 * @property Course_model $course_model
 * @property User_model $user_model
 */
class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('course_model');
        $this->load->model('user_model');
    }

    public function index() {
        $data['title'] = 'AcademyS - Learn to Code';
        $data['featured_courses'] = $this->course_model->get_featured_courses();
        $data['categories'] = $this->course_model->get_categories();
        
        $this->load->view('templates/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function catalog() {
        $data['title'] = 'Course Catalog - AcademyS';
        $data['courses'] = $this->course_model->get_all_courses();
        $data['categories'] = $this->course_model->get_categories();
        
        $this->load->view('templates/header', $data);
        $this->load->view('home/catalog', $data);
        $this->load->view('templates/footer');
    }
} 