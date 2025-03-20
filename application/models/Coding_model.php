<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coding_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // CRUD untuk Coding Exercises
    
    public function get_all_exercises() {
        $this->db->select('coding_exercises.*, lessons.title as lesson_title');
        $this->db->from('coding_exercises');
        $this->db->join('lessons', 'lessons.id = coding_exercises.lesson_id', 'left');
        $this->db->order_by('coding_exercises.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_exercise($id) {
        $this->db->select('coding_exercises.*, lessons.title as lesson_title');
        $this->db->from('coding_exercises');
        $this->db->join('lessons', 'lessons.id = coding_exercises.lesson_id', 'left');
        $this->db->where('coding_exercises.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function get_exercises_by_lesson($lesson_id) {
        $this->db->where('lesson_id', $lesson_id);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('coding_exercises');
        return $query->result_array();
    }
    
    public function add_exercise($data) {
        $this->db->insert('coding_exercises', $data);
        return $this->db->insert_id();
    }
    
    public function update_exercise($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('coding_exercises', $data);
    }
    
    public function delete_exercise($id) {
        $this->db->where('id', $id);
        return $this->db->delete('coding_exercises');
    }
    
    // User Submissions
    
    public function save_submission($data) {
        // Cek apakah user sudah pernah submit
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('exercise_id', $data['exercise_id']);
        $query = $this->db->get('user_coding_submissions');
        
        if ($query->num_rows() > 0) {
            // Update submission yang sudah ada
            $existing = $query->row_array();
            $this->db->where('id', $existing['id']);
            $data['attempts'] = $existing['attempts'] + 1;
            return $this->db->update('user_coding_submissions', $data);
        } else {
            // Buat submission baru
            $data['attempts'] = 1; // Set initial attempt count
            return $this->db->insert('user_coding_submissions', $data);
        }
    }
    
    public function get_user_submissions($user_id, $exercise_id = null) {
        $this->db->where('user_id', $user_id);
        if ($exercise_id) {
            $this->db->where('exercise_id', $exercise_id);
        }
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('user_coding_submissions');
        
        if ($exercise_id) {
            return $query->row_array();
        }
        
        return $query->result_array();
    }
    
    public function get_attempt_count($user_id, $exercise_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('exercise_id', $exercise_id);
        $query = $this->db->get('user_coding_submissions');
        
        if ($query->num_rows() > 0) {
            $submission = $query->row_array();
            return $submission['attempts'];
        }
        
        return 0;
    }
    
    public function check_answer($exercise_id, $user_code) {
        // Ambil data exercise
        $exercise = $this->get_exercise($exercise_id);
        
        if (!$exercise) {
            return ['is_correct' => false, 'message' => 'Exercise tidak ditemukan'];
        }
        
        // Untuk HTML, CSS, dan JavaScript, kita bisa menggunakan pendekatan sederhana
        // dengan membandingkan output atau struktur kode
        
        // Untuk PHP, kita perlu menjalankan kode dan membandingkan output
        
        // Pendekatan sederhana: bandingkan dengan solution_code
        // Dalam implementasi nyata, sebaiknya gunakan test cases
        
        $solution = trim($exercise['solution_code']);
        $user_code = trim($user_code);
        
        // Hapus whitespace dan komentar untuk perbandingan yang lebih akurat
        $solution = preg_replace('/\s+/', ' ', $solution);
        $user_code = preg_replace('/\s+/', ' ', $user_code);
        
        // Untuk perbandingan sederhana
        $is_correct = ($solution == $user_code);
        
        // Jika ada test cases, gunakan itu untuk validasi
        if (!empty($exercise['test_cases'])) {
            $test_cases = json_decode($exercise['test_cases'], true);
            // Implementasi validasi test cases
            // ...
        }
        
        return [
            'is_correct' => $is_correct,
            'message' => $is_correct ? 'Jawaban benar!' : 'Jawaban belum tepat, coba lagi.'
        ];
    }
    
    // Fungsi untuk menjalankan kode PHP dengan aman
    public function execute_php_code($code) {
        // Hapus tag PHP untuk mencegah include file
        $code = preg_replace('/<\?php|\?>/', '', $code);
        
        // Daftar fungsi berbahaya yang dilarang
        $blacklist = [
            'exec', 'shell_exec', 'system', 'passthru', 'proc_open',
            'popen', 'curl_exec', 'curl_multi_exec', 'parse_ini_file',
            'show_source', 'file_get_contents', 'file_put_contents',
            'fopen', 'fwrite', 'file', 'unlink', 'rmdir', 'mkdir',
            'rename', 'copy', 'move_uploaded_file', 'include', 'include_once',
            'require', 'require_once', 'phpinfo', 'posix_mkfifo', 'posix_kill',
            'posix_getpwuid', 'apache_child_terminate', 'posix_setpgid',
            'posix_setsid', 'posix_setuid', 'ini_set', 'set_time_limit'
        ];
        
        // Cek apakah ada fungsi berbahaya
        foreach ($blacklist as $func) {
            if (preg_match('/\b' . preg_quote($func) . '\s*\(/i', $code)) {
                return ['error' => "Fungsi berbahaya terdeteksi: $func"];
            }
        }
        
        // Cek penggunaan variabel superglobal
        $superglobals = ['$_SERVER', '$_GET', '$_POST', '$_FILES', '$_COOKIE', 
                         '$_SESSION', '$_REQUEST', '$_ENV', '$GLOBALS'];
        
        foreach ($superglobals as $global) {
            if (strpos($code, $global) !== false) {
                return ['error' => "Akses ke superglobal tidak diizinkan: $global"];
            }
        }
        
        // Batasi waktu eksekusi
        $code = "set_time_limit(3);\n" . $code;
        
        // Jalankan kode dalam output buffering
        ob_start();
        try {
            $result = eval($code);
            $output = ob_get_clean();
            return ['output' => $output, 'result' => $result];
        } catch (Throwable $e) {
            ob_end_clean();
            return ['error' => $e->getMessage()];
        }
    }
    
    // Check if is_solution_view column exists in user_coding_submissions table
    public function add_solution_view_column_if_not_exists() {
        // Check if column exists
        $query = $this->db->query("SHOW COLUMNS FROM `user_coding_submissions` LIKE 'is_solution_view'");
        if ($query->num_rows() == 0) {
            // Column doesn't exist, add it
            $this->db->query("ALTER TABLE `user_coding_submissions` ADD `is_solution_view` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_correct`");
            return true;
        }
        return false;
    }
} 