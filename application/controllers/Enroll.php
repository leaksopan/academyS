<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Enroll Controller
 * 
 * @property CI_Session $session
 * @property Course_model $course_model
 * @property Enrollment_model $enrollment_model
 */
class Enroll extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('course_model');
        $this->load->model('enrollment_model');
        
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('login_required', 'Please log in to enroll in a course');
            redirect('auth/login');
        }
    }
    
    public function index($course_id = null) {
        if (!$course_id) {
            redirect('home/catalog');
        }
        
        $course = $this->course_model->get_course($course_id);
        
        if (empty($course)) {
            show_404();
        }
        
        $user_id = $this->session->userdata('user_id');
        
        // Cek apakah user sudah enroll kursus ini
        if ($this->enrollment_model->check_enrollment($user_id, $course_id)) {
            $this->session->set_flashdata('already_enrolled', 'You are already enrolled in this course');
            redirect('courses/' . $course['slug']);
        }
        
        // Proses enrollment
        if ($this->enrollment_model->enroll_user($user_id, $course_id)) {
            $this->session->set_flashdata('enrollment_success', 'You have successfully enrolled in this course');
        } else {
            $this->session->set_flashdata('enrollment_failed', 'Failed to enroll in this course. Please try again.');
        }
        
        redirect('courses/' . $course['slug']);
    }
    
    public function unenroll($course_id = null) {
        if (!$course_id) {
            redirect('dashboard');
        }
        
        $course = $this->course_model->get_course($course_id);
        
        if (empty($course)) {
            show_404();
        }
        
        $user_id = $this->session->userdata('user_id');
        
        // Cek apakah user sudah enroll kursus ini
        if (!$this->enrollment_model->check_enrollment($user_id, $course_id)) {
            $this->session->set_flashdata('not_enrolled', 'You are not enrolled in this course');
            redirect('courses/' . $course['slug']);
        }
        
        // Proses unenrollment
        if ($this->enrollment_model->delete_enrollment($user_id, $course_id)) {
            $this->session->set_flashdata('unenrollment_success', 'You have successfully unenrolled from this course');
        } else {
            $this->session->set_flashdata('unenrollment_failed', 'Failed to unenroll from this course. Please try again.');
        }
        
        redirect('courses/' . $course['slug']);
    }
}
