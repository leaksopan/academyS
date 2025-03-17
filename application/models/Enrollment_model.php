<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enrollment_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function enroll_user($user_id, $course_id) {
        $data = [
            'user_id' => $user_id,
            'course_id' => $course_id,
            'enrolled_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('enrollments', $data);
    }
    
    public function check_enrollment($user_id, $course_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $query = $this->db->get('enrollments');
        
        return ($query->num_rows() > 0);
    }
    
    public function get_user_enrollments($user_id) {
        $this->db->select('e.*, c.title, c.slug, c.level, c.image');
        $this->db->from('enrollments e');
        $this->db->join('courses c', 'e.course_id = c.id');
        $this->db->where('e.user_id', $user_id);
        $this->db->order_by('e.enrolled_at', 'DESC');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    public function count_enrollments($course_id = null) {
        if ($course_id) {
            $this->db->where('course_id', $course_id);
        }
        return $this->db->count_all_results('enrollments');
    }
    
    public function delete_enrollment($user_id, $course_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        return $this->db->delete('enrollments');
    }
} 