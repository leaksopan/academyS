<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_lessons_by_course_id($course_id) {
        $this->db->where('course_id', $course_id);
        $this->db->order_by('order_number', 'ASC');
        $query = $this->db->get('lessons');
        return $query->result_array();
    }
    
    public function get_all_lessons_with_course() {
        $this->db->select('lessons.*, courses.title as course_title, courses.slug as course_slug');
        $this->db->from('lessons');
        $this->db->join('courses', 'courses.id = lessons.course_id', 'left');
        $this->db->order_by('courses.title', 'ASC');
        $this->db->order_by('lessons.order_number', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_lesson($lesson_id) {
        $query = $this->db->get_where('lessons', ['id' => $lesson_id]);
        return $query->row_array();
    }
    
    public function get_next_lesson($course_id, $current_order) {
        $this->db->where('course_id', $course_id);
        $this->db->where('order_number >', $current_order);
        $this->db->order_by('order_number', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get('lessons');
        return $query->row_array();
    }
    
    public function get_prev_lesson($course_id, $current_order) {
        $this->db->where('course_id', $course_id);
        $this->db->where('order_number <', $current_order);
        $this->db->order_by('order_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('lessons');
        return $query->row_array();
    }
    
    public function count_lessons($course_id = null) {
        if ($course_id) {
            $this->db->where('course_id', $course_id);
        }
        return $this->db->count_all_results('lessons');
    }
    
    public function add_lesson($data) {
        return $this->db->insert('lessons', $data);
    }
    
    public function update_lesson($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('lessons', $data);
    }
    
    public function delete_lesson($id) {
        $this->db->where('id', $id);
        return $this->db->delete('lessons');
    }
} 