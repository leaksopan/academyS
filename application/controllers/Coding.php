<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coding extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['coding_model', 'lesson_model', 'course_model']);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }
    
    public function index() {
        redirect('dashboard');
    }
    
    public function exercise($id) {
        $data['exercise'] = $this->coding_model->get_exercise($id);
        
        if (empty($data['exercise'])) {
            show_404();
        }
        
        $data['title'] = $data['exercise']['title'] . ' - AcademyS';
        $data['lesson'] = $this->lesson_model->get_lesson($data['exercise']['lesson_id']);
        $data['course'] = $this->course_model->get_course($data['lesson']['course_id']);
        
        // Cek apakah user sudah pernah submit
        $user_id = $this->session->userdata('user_id');
        $data['submission'] = $this->coding_model->get_user_submissions($user_id, $id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('coding/exercise', $data);
        $this->load->view('templates/footer');
    }
    
    public function execute() {
        // Validasi AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $code = $this->input->post('code');
        $language = $this->input->post('language');
        
        if (empty($code) || empty($language)) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(['error' => 'Kode atau bahasa tidak valid']));
            return;
        }
        
        // Eksekusi kode berdasarkan bahasa
        switch ($language) {
            case 'php':
                $result = $this->coding_model->execute_php_code($code);
                break;
                
            case 'javascript':
            case 'html':
            case 'css':
                // Untuk bahasa client-side, eksekusi dilakukan di browser
                $result = ['success' => true];
                break;
                
            default:
                $result = ['error' => 'Bahasa tidak didukung'];
        }
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($result));
    }
    
    public function submit() {
        // Validasi AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $exercise_id = $this->input->post('exercise_id');
        $code = $this->input->post('code');
        
        if (empty($exercise_id) || empty($code)) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(['error' => 'Data tidak lengkap']));
            return;
        }
        
        // Cek jawaban
        $result = $this->coding_model->check_answer($exercise_id, $code);
        
        // Simpan submission
        $user_id = $this->session->userdata('user_id');
        $submission_data = [
            'user_id' => $user_id,
            'exercise_id' => $exercise_id,
            'code' => $code,
            'is_correct' => $result['is_correct'] ? 1 : 0
        ];
        
        $this->coding_model->save_submission($submission_data);
        
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode($result));
    }
    
    public function get_solution() {
        // Validasi AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $exercise_id = $this->input->post('exercise_id');
        
        if (empty($exercise_id)) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(['error' => 'ID exercise tidak valid']));
            return;
        }
        
        // Ambil solusi dari database
        $exercise = $this->coding_model->get_exercise($exercise_id);
        
        if (!$exercise) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode(['error' => 'Exercise tidak ditemukan']));
            return;
        }
        
        // Verifikasi bahwa user sudah mencoba minimal 10 kali
        $user_id = $this->session->userdata('user_id');
        $attempts = $this->coding_model->get_attempt_count($user_id, $exercise_id);
        
        if ($attempts < 10) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode([
                            'error' => 'Kamu harus mencoba minimal 10 kali sebelum melihat solusi',
                            'attempts' => $attempts
                         ]));
            return;
        }
        
        // Catat aktivitas melihat solusi
        $submission_data = [
            'user_id' => $user_id,
            'exercise_id' => $exercise_id,
            'code' => $exercise['solution_code'],
            'is_correct' => 1,
            'attempts' => $attempts
        ];
        
        $this->coding_model->save_submission($submission_data);
        
        // Gunakan JSON_HEX flags untuk escape karakter khusus
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode([
                        'solution' => $exercise['solution_code'],
                        'message' => 'Berikut adalah solusi yang benar. Pastikan kamu memahami kodenya sebelum melanjutkan.'
                     ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP));
    }
} 