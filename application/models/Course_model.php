<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all_courses() {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('courses');
        return $query->result_array();
    }
    
    public function get_featured_courses($limit = 6) {
        $this->db->where('is_featured', 1);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('courses');
        return $query->result_array();
    }
    
    public function get_course_by_slug($slug) {
        $query = $this->db->get_where('courses', ['slug' => $slug]);
        return $query->row_array();
    }
    
    public function get_course($course_id) {
        $query = $this->db->get_where('courses', ['id' => $course_id]);
        return $query->row_array();
    }
    
    public function get_course_slug($course_id) {
        $this->db->select('slug');
        $this->db->where('id', $course_id);
        $query = $this->db->get('courses');
        $result = $query->row_array();
        return $result ? $result['slug'] : '';
    }
    
    public function get_categories() {
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('categories');
        return $query->result_array();
    }
    
    public function get_category_by_slug($slug) {
        $query = $this->db->get_where('categories', ['slug' => $slug]);
        return $query->row_array();
    }
    
    public function get_category($id) {
        $query = $this->db->get_where('categories', ['id' => $id]);
        return $query->row_array();
    }
    
    public function get_courses_by_category($category_id) {
        $this->db->where('category_id', $category_id);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('courses');
        return $query->result_array();
    }
    
    public function enroll_user($user_id, $course_id) {
        // Check if already enrolled
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $query = $this->db->get('enrollments');
        
        if ($query->num_rows() > 0) {
            return false; // Already enrolled
        }
        
        $data = [
            'user_id' => $user_id,
            'course_id' => $course_id,
            'enrolled_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('enrollments', $data);
    }
    
    public function get_enrolled_courses($user_id) {
        $this->db->select('courses.*');
        $this->db->from('courses');
        $this->db->join('enrollments', 'enrollments.course_id = courses.id');
        $this->db->where('enrollments.user_id', $user_id);
        $this->db->order_by('enrollments.enrolled_at', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function is_enrolled($user_id, $course_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $query = $this->db->get('enrollments');
        return $query->num_rows() > 0;
    }
    
    public function count_courses() {
        return $this->db->count_all('courses');
    }
    
    public function add_course($data) {
        return $this->db->insert('courses', $data);
    }
    
    public function update_course($course_id, $data) {
        $this->db->where('id', $course_id);
        return $this->db->update('courses', $data);
    }
    
    public function delete_course($course_id) {
        $this->db->where('id', $course_id);
        return $this->db->delete('courses');
    }
    
    public function get_course_image($course_id) {
        $this->db->select('image');
        $this->db->where('id', $course_id);
        $query = $this->db->get('courses');
        $result = $query->row_array();
        return $result ? $result['image'] : null;
    }
    
    public function add_category($data) {
        return $this->db->insert('categories', $data);
    }
    
    public function update_category($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }
    
    public function delete_category($id) {
        // Cek apakah ada kursus yang menggunakan kategori ini
        $this->db->where('category_id', $id);
        $query = $this->db->get('courses');
        
        if ($query->num_rows() > 0) {
            // Jika ada kursus yang menggunakan kategori ini, set category_id menjadi NULL
            $this->db->where('category_id', $id);
            $this->db->update('courses', ['category_id' => NULL]);
        }
        
        // Hapus kategori
        $this->db->where('id', $id);
        return $this->db->delete('categories');
    }
} 