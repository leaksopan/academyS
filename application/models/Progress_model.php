<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progress_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_user_progress($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('progress');
        
        $progress = [];
        foreach ($query->result_array() as $row) {
            $progress[$row['lesson_id']] = $row;
        }
        
        return $progress;
    }
    
    public function get_course_progress($user_id, $course_id) {
        $this->db->select('progress.*, lessons.course_id');
        $this->db->from('progress');
        $this->db->join('lessons', 'lessons.id = progress.lesson_id');
        $this->db->where('progress.user_id', $user_id);
        $this->db->where('lessons.course_id', $course_id);
        $query = $this->db->get();
        
        $completed = 0;
        $total = $this->db->where('course_id', $course_id)->count_all_results('lessons');
        
        foreach ($query->result_array() as $row) {
            if ($row['completed']) {
                $completed++;
            }
        }
        
        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $total > 0 ? round(($completed / $total) * 100) : 0
        ];
    }
    
    public function update_lesson_progress($user_id, $lesson_id, $completed) {
        // Check if progress record exists
        $this->db->where('user_id', $user_id);
        $this->db->where('lesson_id', $lesson_id);
        $query = $this->db->get('progress');
        
        if ($query->num_rows() > 0) {
            // Update existing record
            $this->db->where('user_id', $user_id);
            $this->db->where('lesson_id', $lesson_id);
            return $this->db->update('progress', [
                'completed' => $completed,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Create new record
            return $this->db->insert('progress', [
                'user_id' => $user_id,
                'lesson_id' => $lesson_id,
                'completed' => $completed,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
    
    public function is_lesson_completed($user_id, $lesson_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('lesson_id', $lesson_id);
        $this->db->where('completed', 1);
        $query = $this->db->get('progress');
        return $query->num_rows() > 0;
    }
} 