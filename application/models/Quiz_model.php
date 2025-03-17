<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_quiz_by_lesson($lesson_id) {
        $this->db->where('lesson_id', $lesson_id);
        $query = $this->db->get('quizzes');
        return $query->num_rows() > 0 ? $query->row_array() : null;
    }
    
    public function get_all_quizzes() {
        $this->db->select('quizzes.*, lessons.title as lesson_title, courses.title as course_title, courses.slug as course_slug');
        $this->db->from('quizzes');
        $this->db->join('lessons', 'lessons.id = quizzes.lesson_id', 'left');
        $this->db->join('courses', 'courses.id = lessons.course_id', 'left');
        $this->db->order_by('quizzes.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function add_quiz($data) {
        $this->db->insert('quizzes', $data);
        return $this->db->insert_id();
    }
    
    public function update_quiz($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('quizzes', $data);
    }
    
    public function delete_quiz($id) {
        // Hapus semua pertanyaan dan opsi terkait terlebih dahulu
        $questions = $this->get_questions($id);
        foreach ($questions as $question) {
            $this->delete_question($question['id']);
        }
        
        // Hapus quiz
        $this->db->where('id', $id);
        return $this->db->delete('quizzes');
    }
    
    public function get_questions($quiz_id) {
        $this->db->where('quiz_id', $quiz_id);
        $this->db->order_by('order_number', 'ASC');
        $query = $this->db->get('questions');
        return $query->result_array();
    }
    
    public function get_question($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('questions');
        return $query->num_rows() > 0 ? $query->row_array() : null;
    }
    
    public function add_question($data) {
        $this->db->insert('questions', $data);
        return $this->db->insert_id();
    }
    
    public function update_question($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('questions', $data);
    }
    
    public function delete_question($id) {
        // Hapus semua opsi terkait terlebih dahulu
        $this->db->where('question_id', $id);
        $this->db->delete('question_options');
        
        // Hapus pertanyaan
        $this->db->where('id', $id);
        return $this->db->delete('questions');
    }
    
    public function add_option($data) {
        $this->db->insert('question_options', $data);
        return $this->db->insert_id();
    }
    
    public function update_option($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('question_options', $data);
    }
    
    public function save_attempt($data) {
        $this->db->insert('quiz_attempts', $data);
        return $this->db->insert_id();
    }
    
    public function save_user_answer($data) {
        $this->db->insert('user_answers', $data);
        return $this->db->insert_id();
    }
    
    public function get_user_attempts($user_id, $quiz_id = null) {
        $this->db->where('user_id', $user_id);
        if ($quiz_id) {
            $this->db->where('quiz_id', $quiz_id);
        }
        $this->db->order_by('completed_at', 'DESC');
        $query = $this->db->get('quiz_attempts');
        return $query->result_array();
    }
    
    public function get_user_answers($attempt_id) {
        $this->db->where('attempt_id', $attempt_id);
        $query = $this->db->get('user_answers');
        return $query->result_array();
    }
    
    public function get_user_average_score($user_id) {
        $this->db->select_avg('score');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('quiz_attempts');
        $result = $query->row_array();
        return $result['score'] ?? 0;
    }
    
    public function count_passed_quizzes($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('passed', 1);
        return $this->db->count_all_results('quiz_attempts');
    }
    
    public function get_quiz($quiz_id) {
        $this->db->where('id', $quiz_id);
        $query = $this->db->get('quizzes');
        return $query->num_rows() > 0 ? $query->row_array() : null;
    }
    
    public function get_question_options($question_id) {
        $this->db->where('question_id', $question_id);
        $this->db->order_by('order_number', 'ASC');
        $query = $this->db->get('question_options');
        return $query->result_array();
    }
} 