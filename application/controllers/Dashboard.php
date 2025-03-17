<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Controller
 * 
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property User_model $user_model
 * @property Course_model $course_model
 * @property Progress_model $progress_model
 * @property Quiz_model $quiz_model
 * @property Lesson_model $lesson_model
 */
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model(['user_model', 'course_model', 'progress_model', 'quiz_model', 'lesson_model']);
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->user_model->get_user($user_id);
        $data['enrolled_courses'] = $this->course_model->get_enrolled_courses($user_id);
        $data['progress'] = $this->progress_model->get_user_progress($user_id);
        $data['quiz_model'] = $this->quiz_model;
        
        // Tambahkan informasi progress untuk setiap kursus
        foreach ($data['enrolled_courses'] as $key => $course) {
            $data['enrolled_courses'][$key]['progress'] = $this->progress_model->get_course_progress($user_id, $course['id']);
        }
        
        $data['title'] = 'Dashboard - AcademyS';
        
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function profile() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->user_model->get_user($user_id);
        
        $data['title'] = 'Profile - AcademyS';
        
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/profile', $data);
        $this->load->view('templates/footer');
    }
    
    public function update_profile() {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        
        if ($this->form_validation->run() === FALSE) {
            $this->profile();
        } else {
            $user_id = $this->session->userdata('user_id');
            
            $data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email')
            ];
            
            if ($this->user_model->update_user($user_id, $data)) {
                $this->session->set_flashdata('profile_updated', 'Your profile has been updated');
                redirect('dashboard/profile');
            } else {
                $this->session->set_flashdata('profile_update_failed', 'Profile update failed');
                redirect('dashboard/profile');
            }
        }
    }
    
    public function enroll($course_id) {
        $user_id = $this->session->userdata('user_id');
        
        if ($this->course_model->enroll_user($user_id, $course_id)) {
            $this->session->set_flashdata('enrollment_success', 'You have successfully enrolled in this course');
        } else {
            $this->session->set_flashdata('enrollment_failed', 'Enrollment failed. You may already be enrolled in this course');
        }
        
        redirect('courses/view/' . $this->course_model->get_course_slug($course_id));
    }
    
    public function update_progress() {
        $user_id = $this->session->userdata('user_id');
        $lesson_id = $this->input->post('lesson_id');
        $course_id = $this->input->post('course_id');
        $completed = $this->input->post('completed') ? 1 : 0;
        
        if ($this->progress_model->update_lesson_progress($user_id, $lesson_id, $completed)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    
    public function get_next_lesson() {
        $user_id = $this->session->userdata('user_id');
        $course_id = $this->input->post('course_id');
        
        // Get course slug
        $course = $this->course_model->get_course($course_id);
        $course_slug = $course['slug'];
        
        // Get user progress for this course
        $progress = $this->progress_model->get_course_progress($user_id, $course_id);
        
        // Get all lessons for this course
        $lessons = $this->lesson_model->get_lessons_by_course_id($course_id);
        
        // Find the next incomplete lesson
        $next_lesson_id = null;
        foreach ($lessons as $lesson) {
            $lesson_id = $lesson['id'];
            if (!isset($progress['lessons'][$lesson_id]) || !$progress['lessons'][$lesson_id]['completed']) {
                $next_lesson_id = $lesson_id;
                break;
            }
        }
        
        echo json_encode([
            'success' => true,
            'lesson_id' => $next_lesson_id,
            'course_slug' => $course_slug
        ]);
    }
} 