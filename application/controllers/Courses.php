<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Courses Controller
 * 
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Output $output
 * @property Course_model $course_model
 * @property Lesson_model $lesson_model
 * @property Enrollment_model $enrollment_model
 * @property Progress_model $progress_model
 * @property Quiz_model $quiz_model
 */
class Courses extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('course_model');
        $this->load->model('lesson_model');
        $this->load->model('enrollment_model');
        $this->load->model('progress_model');
        $this->load->model('quiz_model');
    }

    public function index() {
        redirect('home/catalog');
    }
    
    public function view($slug) {
        $data['course'] = $this->course_model->get_course_by_slug($slug);
        
        if (empty($data['course'])) {
            show_404();
        }
        
        $data['title'] = $data['course']['title'] . ' - AcademyS';
        $data['lessons'] = $this->lesson_model->get_lessons_by_course_id($data['course']['id']);
        
        // Cek apakah user sudah enroll kursus ini
        if ($this->session->userdata('logged_in')) {
            $user_id = $this->session->userdata('user_id');
            $data['is_enrolled'] = $this->enrollment_model->check_enrollment($user_id, $data['course']['id']);
            $data['enrolled_count'] = $this->enrollment_model->count_enrollments($data['course']['id']);
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('courses/view', $data);
        $this->load->view('templates/footer');
    }
    
    public function category($category_slug) {
        $data['category'] = $this->course_model->get_category_by_slug($category_slug);
        
        if (empty($data['category'])) {
            show_404();
        }
        
        $data['title'] = $data['category']['name'] . ' Courses - AcademyS';
        $data['courses'] = $this->course_model->get_courses_by_category($data['category']['id']);
        
        $this->load->view('templates/header', $data);
        $this->load->view('courses/category', $data);
        $this->load->view('templates/footer');
    }
    
    public function lesson($course_slug, $lesson_id = null) {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // Jika lesson_id tidak diberikan, coba ambil dari course_slug (yang mungkin sebenarnya adalah lesson_id)
        if ($lesson_id === null) {
            // Cek apakah course_slug sebenarnya adalah lesson_id
            if (is_numeric($course_slug)) {
                $lesson_id = $course_slug;
                // Ambil course_slug dari lesson_id
                $this->load->model(['lesson_model', 'course_model']);
                $lesson = $this->lesson_model->get_lesson($lesson_id);
                if ($lesson) {
                    $course = $this->course_model->get_course($lesson['course_id']);
                    if ($course) {
                        $course_slug = $course['slug'];
                    } else {
                        show_404();
                    }
                } else {
                    show_404();
                }
            } else {
                show_404();
            }
        }

        $this->load->model(['course_model', 'lesson_model', 'quiz_model', 'progress_model']);
        $user_id = $this->session->userdata('user_id');

        $course = $this->course_model->get_course_by_slug($course_slug);
        $lesson = $this->lesson_model->get_lesson($lesson_id);
        $quiz = $this->quiz_model->get_quiz_by_lesson($lesson_id);
        
        // Ambil semua pelajaran untuk kursus ini
        $lessons = $this->lesson_model->get_lessons_by_course_id($course['id']);
        
        // Ambil data progress user
        $progress = $this->progress_model->get_user_progress($user_id);

        $data['title'] = $lesson['title'];
        $data['course'] = $course;
        $data['lesson'] = $lesson;
        $data['quiz'] = $quiz;
        $data['lessons'] = $lessons;
        $data['progress'] = $progress;

        $this->load->view('templates/header', $data);
        $this->load->view('courses/lesson', $data);
        $this->load->view('templates/footer');
    }

    public function quiz($course_slug, $lesson_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        $this->load->model(['course_model', 'lesson_model', 'quiz_model']);
        $user_id = $this->session->userdata('user_id');

        $course = $this->course_model->get_course_by_slug($course_slug);
        $lesson = $this->lesson_model->get_lesson($lesson_id);
        $quiz = $this->quiz_model->get_quiz_by_lesson($lesson_id);
        
        if (!$quiz) {
            $this->session->set_flashdata('error', 'Quiz tidak ditemukan');
            redirect('courses/' . $course_slug . '/lesson/' . $lesson_id);
        }
        
        $questions = $this->quiz_model->get_questions($quiz['id']);
        $attempts = $this->quiz_model->get_user_attempts($user_id, $quiz['id']);

        $data['title'] = 'Quiz: ' . $lesson['title'];
        $data['course'] = $course;
        $data['lesson'] = $lesson;
        $data['quiz'] = $quiz;
        $data['questions'] = $questions;
        $data['attempts'] = $attempts;
        $data['quiz_model'] = $this->quiz_model;

        $this->load->view('templates/header', $data);
        $this->load->view('courses/quiz', $data);
        $this->load->view('templates/footer');
    }

    public function submit_quiz() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        $this->load->model(['quiz_model', 'progress_model', 'course_model']);
        
        $user_id = $this->session->userdata('user_id');
        $quiz_id = $this->input->post('quiz_id');
        $answers = $this->input->post('answers');
        
        if (!$quiz_id || !$answers) {
            $this->session->set_flashdata('error', 'Data quiz tidak valid');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $quiz = $this->quiz_model->get_quiz($quiz_id);
        if (!$quiz) {
            $this->session->set_flashdata('error', 'Quiz tidak ditemukan');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }
        
        $questions = $this->quiz_model->get_questions($quiz_id);
        
        $total_points = 0;
        $earned_points = 0;
        $question_results = [];

        foreach ($questions as $question) {
            $total_points += $question['points'];
            $user_answer = isset($answers[$question['id']]) ? $answers[$question['id']] : null;
            
            if ($question['question_type'] == 'multiple_choice') {
                $is_correct = $this->check_multiple_choice_answer($question['id'], $user_answer);
                $earned_points += $is_correct ? $question['points'] : 0;
                
                $question_results[] = [
                    'question_id' => $question['id'],
                    'selected_option_id' => $user_answer,
                    'essay_answer' => null,
                    'is_correct' => $is_correct ? 1 : 0,
                    'points_earned' => $is_correct ? $question['points'] : 0
                ];
            } else {
                // Essay questions are marked as incorrect by default
                // Admin will need to review and grade them manually
                $question_results[] = [
                    'question_id' => $question['id'],
                    'selected_option_id' => null,
                    'essay_answer' => $user_answer,
                    'is_correct' => 0,
                    'points_earned' => 0
                ];
            }
        }

        $score = ($earned_points / $total_points) * 100;
        $passed = $score >= $quiz['passing_score'];

        // Save attempt
        $attempt_data = [
            'user_id' => $user_id,
            'quiz_id' => $quiz_id,
            'score' => $score,
            'passed' => $passed ? 1 : 0
        ];
        $attempt_id = $this->quiz_model->save_attempt($attempt_data);

        // Save answers
        foreach ($question_results as $result) {
            $answer_data = [
                'attempt_id' => $attempt_id,
                'question_id' => $result['question_id'],
                'selected_option_id' => $result['selected_option_id'],
                'essay_answer' => $result['essay_answer'],
                'is_correct' => $result['is_correct'],
                'points_earned' => $result['points_earned']
            ];
            $this->quiz_model->save_user_answer($answer_data);
        }

        // If passed, mark lesson as complete
        if ($passed) {
            $this->progress_model->update_lesson_progress($user_id, $quiz['lesson_id'], 1);
        }

        // Set flash message
        $this->session->set_flashdata('success', 'Quiz berhasil diselesaikan dengan skor ' . number_format($score, 1) . '%');
        
        // Redirect ke halaman kursus jika lulus, atau kembali ke quiz jika tidak
        if ($passed) {
            redirect('courses/' . $this->course_model->get_course($quiz['course_id'])['slug']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    private function check_multiple_choice_answer($question_id, $user_answer) {
        $this->load->model('quiz_model');
        $options = $this->quiz_model->get_question_options($question_id);
        
        foreach ($options as $option) {
            if ($option['is_correct'] && $option['id'] == $user_answer) {
                return true;
            }
        }
        
        return false;
    }
    
    public function enroll() {
        if (!$this->session->userdata('logged_in')) {
            echo json_encode(['success' => false, 'message' => 'Please log in to enroll in this course']);
            return;
        }
        
        $user_id = $this->session->userdata('user_id');
        $course_id = $this->input->post('course_id');
        
        // Check if already enrolled
        if ($this->enrollment_model->check_enrollment($user_id, $course_id)) {
            echo json_encode(['success' => false, 'message' => 'You are already enrolled in this course']);
            return;
        }
        
        // Process enrollment
        if ($this->enrollment_model->enroll_user($user_id, $course_id)) {
            $course = $this->course_model->get_course($course_id);
            echo json_encode(['success' => true, 'message' => 'You have successfully enrolled in this course', 'course_slug' => $course['slug']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to enroll in this course. Please try again.']);
        }
    }
} 