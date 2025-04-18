<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function register($data) {
        return $this->db->insert('users', $data);
    }
    
    public function login($email, $password) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        $user = $query->row_array();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function get_user($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row_array();
    }
    
    public function update_user($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }
    
    public function check_email_exists($email) {
        $query = $this->db->get_where('users', ['email' => $email]);
        return $query->num_rows() > 0;
    }
    
    public function check_username_exists($username) {
        $query = $this->db->get_where('users', ['username' => $username]);
        return $query->num_rows() > 0;
    }
    
    public function get_user_role($user_id) {
        $this->db->select('role');
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        $result = $query->row_array();
        
        return $result ? $result['role'] : null;
    }
    
    public function is_admin($user_id) {
        $role = $this->get_user_role($user_id);
        return $role === 'admin';
    }
    
    public function get_all_users() {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('users');
        return $query->result_array();
    }
    
    public function count_users() {
        return $this->db->count_all('users');
    }
    
    public function get_recent_users($limit = 5) {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('users');
        return $query->result_array();
    }
    
    public function add_user($data) {
        return $this->db->insert('users', $data);
    }

    public function delete_user($user_id) {
        $this->db->where('id', $user_id);
        return $this->db->delete('users');
    }
    
    /**
     * Mendapatkan daftar pengguna dengan filter pencarian, role, dan status
     *
     * @param string|null $search Kata kunci pencarian
     * @param string|null $role Filter berdasarkan role
     * @param string|null $status Filter berdasarkan status (aktif/nonaktif)
     * @return array Daftar pengguna yang terfilter
     */
    public function get_filtered_users($search = null, $role = null, $status = null) {
        // Jika ada kata kunci pencarian
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('username', $search);
            $this->db->or_like('email', $search);
            $this->db->group_end();
        }
        
        // Filter berdasarkan role
        if (!empty($role)) {
            $this->db->where('role', $role);
        }
        
        // Filter berdasarkan status
        if ($status !== null && $status !== '') {
            $this->db->where('is_active', $status);
        }
        
        // Urutkan berdasarkan tanggal pembuatan terbaru
        $this->db->order_by('created_at', 'DESC');
        
        $query = $this->db->get('users');
        return $query->result_array();
    }
} 