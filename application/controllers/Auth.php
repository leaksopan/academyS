<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Controller
 * 
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property User_model $user_model
 */
class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
        $this->load->model('user_model');
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Login - AcademyS';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            
            $user = $this->user_model->login($email, $password);
            
            if ($user) {
                $user_data = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'logged_in' => TRUE
                ];
                
                $this->session->set_userdata($user_data);
                
                // Redirect berdasarkan role
                if ($user['role'] === 'admin') {
                    redirect('admin/dashboard');
                } else {
                    redirect('dashboard');
                }
            } else {
                $this->session->set_flashdata('login_failed', 'Invalid email or password');
                redirect('auth/login');
            }
        }
    }
    
    public function register() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Register - AcademyS';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/register');
            $this->load->view('templates/footer');
        } else {
            $password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            
            $data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $password_hash,
                'full_name' => $this->input->post('full_name') ?? $this->input->post('username'),
                'role' => 'user',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->user_model->register($data)) {
                $this->session->set_flashdata('user_registered', 'You are now registered. Please log in.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('registration_failed', 'Registration failed. Please try again.');
                redirect('auth/register');
            }
        }
    }
    
    public function logout() {
        $this->session->unset_userdata(['user_id', 'username', 'email', 'role', 'logged_in']);
        $this->session->set_flashdata('user_logged_out', 'You have been logged out');
        redirect('auth/login');
    }
    
    public function reset_password() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Reset Password - AcademyS';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/reset_password');
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email');
            
            if ($this->user_model->check_email_exists($email)) {
                // Dalam aplikasi nyata, kirim email reset password
                // Untuk demo, kita hanya tampilkan pesan sukses
                $this->session->set_flashdata('password_reset', 'Password reset instructions have been sent to your email.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('reset_failed', 'Email not found in our records.');
                redirect('auth/reset_password');
            }
        }
    }
} 