<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Controller
 * 
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Upload $upload
 * @property User_model $user_model
 * @property Course_model $course_model
 * @property Lesson_model $lesson_model
 * @property Quiz_model $quiz_model
 * @property Coding_model $coding_model
 */
class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library(['session', 'form_validation']);
        $this->load->model(['user_model', 'course_model', 'lesson_model', 'quiz_model', 'coding_model']);
        
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        // Cek apakah user adalah admin
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('access_denied', 'Anda tidak memiliki akses ke halaman admin');
            redirect('dashboard');
        }
    }

    public function dashboard() {
        $data['title'] = 'Admin Dashboard - AcademyS';
        $data['total_users'] = $this->user_model->count_users();
        $data['total_courses'] = $this->course_model->count_courses();
        $data['total_lessons'] = $this->lesson_model->count_lessons();
        $data['recent_users'] = $this->user_model->get_recent_users(5);
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer');
    }
    
    public function users() {
        $data['title'] = 'Manage Users - AcademyS';
        $data['users'] = $this->user_model->get_all_users();
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('templates/footer');
    }
    
    public function courses() {
        $data['title'] = 'Manage Courses - AcademyS';
        $data['courses'] = $this->course_model->get_all_courses();
        $data['categories'] = $this->course_model->get_categories();
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/courses', $data);
        $this->load->view('templates/footer');
    }
    
    public function add_course() {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('slug', 'Slug', 'required|is_unique[courses.slug]');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Add Course - AcademyS';
            $data['categories'] = $this->course_model->get_categories();
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/add_course', $data);
            $this->load->view('templates/footer');
        } else {
            // Proses upload gambar jika ada
            $config['upload_path'] = './assets/images/courses/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;
            
            $this->load->library('upload', $config);
            
            if (!empty($_FILES['image']['name'])) {
                if ($this->upload->do_upload('image')) {
                    $upload_data = $this->upload->data();
                    $image = $upload_data['file_name'];
                } else {
                    $image = NULL;
                    $this->session->set_flashdata('upload_error', $this->upload->display_errors());
                }
            } else {
                $image = NULL;
            }
            
            $course_data = [
                'title' => $this->input->post('title'),
                'slug' => $this->input->post('slug'),
                'description' => $this->input->post('description'),
                'category_id' => $this->input->post('category_id'),
                'level' => $this->input->post('level'),
                'image' => $image,
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->course_model->add_course($course_data)) {
                $this->session->set_flashdata('course_added', 'Kursus berhasil ditambahkan');
                redirect('admin/courses');
            } else {
                $this->session->set_flashdata('course_add_failed', 'Gagal menambahkan kursus');
                redirect('admin/add_course');
            }
        }
    }
    
    public function edit_course($id) {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Course - AcademyS';
            $data['course'] = $this->course_model->get_course($id);
            $data['categories'] = $this->course_model->get_categories();
            
            if (empty($data['course'])) {
                show_404();
            }
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/edit_course', $data);
            $this->load->view('templates/footer');
        } else {
            // Proses upload gambar jika ada
            $config['upload_path'] = './assets/images/courses/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;
            
            $this->load->library('upload', $config);
            
            if (!empty($_FILES['image']['name'])) {
                if ($this->upload->do_upload('image')) {
                    $upload_data = $this->upload->data();
                    $image = $upload_data['file_name'];
                    
                    // Hapus gambar lama jika ada
                    $old_image = $this->course_model->get_course_image($id);
                    if ($old_image && file_exists('./assets/images/courses/' . $old_image)) {
                        unlink('./assets/images/courses/' . $old_image);
                    }
                } else {
                    $image = $this->course_model->get_course_image($id);
                    $this->session->set_flashdata('upload_error', $this->upload->display_errors());
                }
            } else {
                $image = $this->course_model->get_course_image($id);
            }
            
            $course_data = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'category_id' => $this->input->post('category_id'),
                'level' => $this->input->post('level'),
                'image' => $image,
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->course_model->update_course($id, $course_data)) {
                $this->session->set_flashdata('course_updated', 'Kursus berhasil diperbarui');
                redirect('admin/courses');
            } else {
                $this->session->set_flashdata('course_update_failed', 'Gagal memperbarui kursus');
                redirect('admin/edit_course/' . $id);
            }
        }
    }
    
    public function delete_course($id) {
        // Hapus gambar kursus jika ada
        $image = $this->course_model->get_course_image($id);
        if ($image && file_exists('./assets/images/courses/' . $image)) {
            unlink('./assets/images/courses/' . $image);
        }
        
        if ($this->course_model->delete_course($id)) {
            $this->session->set_flashdata('course_deleted', 'Kursus berhasil dihapus');
        } else {
            $this->session->set_flashdata('course_delete_failed', 'Gagal menghapus kursus');
        }
        
        redirect('admin/courses');
    }
    
    // Mengelola pelajaran (lessons)
    public function lessons() {
        $course_id = $this->input->get('course_id');
        
        if (!$course_id) {
            redirect('admin/courses');
        }
        
        $this->load->model(['course_model', 'lesson_model']);
        
        $data['title'] = 'Manage Lessons - AcademyS';
        $data['course'] = $this->course_model->get_course($course_id);
        
        // Pastikan slug tersedia
        if (!isset($data['course']['slug'])) {
            $data['course']['slug'] = $this->course_model->get_course_slug($course_id);
        }
        
        $data['lessons'] = $this->lesson_model->get_lessons_by_course_id($course_id);
        $data['course_id'] = $course_id;
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/lessons', $data);
        $this->load->view('templates/footer');
    }
    
    public function add_lesson() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        $this->load->model('course_model');
        $this->load->library('form_validation');

        $data['courses'] = $this->course_model->get_all_courses();
        
        // Ambil course_id dari URL jika ada
        $course_id = $this->input->get('course_id');
        $data['course_id'] = $course_id;
        
        // Jika ada course_id, ambil data course
        if ($course_id) {
            $data['course'] = $this->course_model->get_course($course_id);
        } else {
            // Jika tidak ada course_id, set default kosong
            $data['course'] = null;
        }

        $this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('course_id', 'Kursus', 'required');
        $this->form_validation->set_rules('content', 'Konten', 'required');
        $this->form_validation->set_rules('order_number', 'Urutan', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header');
            $this->load->view('admin/add_lesson', $data);
            $this->load->view('templates/footer');
        } else {
            $lesson_data = [
                'title' => $this->input->post('title'),
                'course_id' => $this->input->post('course_id'),
                'content' => $this->input->post('content'),
                'order_number' => $this->input->post('order_number'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $lesson_id = $this->lesson_model->add_lesson($lesson_data);

            $this->session->set_flashdata('success', 'Pelajaran berhasil ditambahkan');
            redirect('admin/lessons?course_id=' . $this->input->post('course_id'));
        }
    }
    
    public function edit_lesson($id) {
        $lesson = $this->lesson_model->get_lesson($id);
        
        if (empty($lesson)) {
            show_404();
        }
        
        $course_id = $lesson['course_id'];
        
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');
        $this->form_validation->set_rules('order_number', 'Order', 'required|numeric');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Lesson - AcademyS';
            $data['lesson'] = $lesson;
            $data['course'] = $this->course_model->get_course($course_id);
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/edit_lesson', $data);
            $this->load->view('templates/footer');
        } else {
            $lesson_data = [
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'order_number' => $this->input->post('order_number')
            ];
            
            if ($this->lesson_model->update_lesson($id, $lesson_data)) {
                $this->session->set_flashdata('lesson_updated', 'Pelajaran berhasil diperbarui');
                redirect('admin/lessons?course_id=' . $course_id);
            } else {
                $this->session->set_flashdata('lesson_update_failed', 'Gagal memperbarui pelajaran');
                redirect('admin/edit_lesson/' . $id);
            }
        }
    }
    
    public function delete_lesson($id) {
        $lesson = $this->lesson_model->get_lesson($id);
        
        if (empty($lesson)) {
            show_404();
        }
        
        $course_id = $lesson['course_id'];
        
        if ($this->lesson_model->delete_lesson($id)) {
            $this->session->set_flashdata('lesson_deleted', 'Pelajaran berhasil dihapus');
        } else {
            $this->session->set_flashdata('lesson_delete_failed', 'Gagal menghapus pelajaran');
        }
        
        redirect('admin/lessons?course_id=' . $course_id);
    }

    // Mengelola kategori
    public function categories() {
        $data['title'] = 'Manage Categories - AcademyS';
        $data['categories'] = $this->course_model->get_categories();
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/categories', $data);
        $this->load->view('templates/footer');
    }
    
    public function add_category() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('slug', 'Slug', 'required|is_unique[categories.slug]');
        $this->form_validation->set_rules('description', 'Description', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Add Category - AcademyS';
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/add_category', $data);
            $this->load->view('templates/footer');
        } else {
            $category_data = [
                'name' => $this->input->post('name'),
                'slug' => $this->input->post('slug'),
                'description' => $this->input->post('description'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->course_model->add_category($category_data)) {
                $this->session->set_flashdata('category_added', 'Kategori berhasil ditambahkan');
                redirect('admin/categories');
            } else {
                $this->session->set_flashdata('category_add_failed', 'Gagal menambahkan kategori');
                redirect('admin/add_category');
            }
        }
    }
    
    public function edit_category($id) {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Category - AcademyS';
            $data['category'] = $this->course_model->get_category($id);
            
            if (empty($data['category'])) {
                show_404();
            }
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/edit_category', $data);
            $this->load->view('templates/footer');
        } else {
            $category_data = [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Jika slug diubah dan tidak kosong
            if ($this->input->post('slug') && $this->input->post('slug') !== $this->input->post('old_slug')) {
                $this->form_validation->set_rules('slug', 'Slug', 'required|is_unique[categories.slug]');
                
                if ($this->form_validation->run() === FALSE) {
                    $this->session->set_flashdata('slug_error', 'Slug sudah digunakan, silakan gunakan slug lain');
                    redirect('admin/edit_category/' . $id);
                }
                
                $category_data['slug'] = $this->input->post('slug');
            }
            
            if ($this->course_model->update_category($id, $category_data)) {
                $this->session->set_flashdata('category_updated', 'Kategori berhasil diperbarui');
                redirect('admin/categories');
            } else {
                $this->session->set_flashdata('category_update_failed', 'Gagal memperbarui kategori');
                redirect('admin/edit_category/' . $id);
            }
        }
    }
    
    public function delete_category($id) {
        if ($this->course_model->delete_category($id)) {
            $this->session->set_flashdata('category_deleted', 'Kategori berhasil dihapus');
        } else {
            $this->session->set_flashdata('category_delete_failed', 'Gagal menghapus kategori');
        }
        
        redirect('admin/categories');
    }
    
    // Mengelola quiz
    public function quizzes() {
        $lesson_id = $this->input->get('lesson_id');
        
        if ($lesson_id) {
            // Jika ada lesson_id, tampilkan quiz untuk lesson tersebut
            $this->load->model(['lesson_model', 'quiz_model', 'course_model']);
            
            $data['title'] = 'Manage Quizzes - AcademyS';
            $data['lesson'] = $this->lesson_model->get_lesson($lesson_id);
            $data['course'] = $this->course_model->get_course($data['lesson']['course_id']);
            $data['quiz'] = $this->quiz_model->get_quiz_by_lesson($lesson_id);
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/quizzes', $data);
            $this->load->view('templates/footer');
        } else {
            // Jika tidak ada lesson_id, tampilkan daftar semua quiz
            $this->load->model(['quiz_model', 'lesson_model', 'course_model']);
            
            $data['title'] = 'Manage All Quizzes - AcademyS';
            $data['quizzes'] = $this->quiz_model->get_all_quizzes();
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/all_quizzes', $data);
            $this->load->view('templates/footer');
        }
    }
    
    public function add_quiz() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        $lesson_id = $this->input->get('lesson_id');
        
        $this->load->model(['lesson_model', 'quiz_model', 'course_model']);
        $this->load->library('form_validation');
        
        if ($lesson_id) {
            // Jika ada lesson_id, tambahkan quiz untuk lesson tersebut
            $data['lesson'] = $this->lesson_model->get_lesson($lesson_id);
            $data['course'] = $this->course_model->get_course($data['lesson']['course_id']);
            
            // Cek apakah lesson sudah memiliki quiz
            $existing_quiz = $this->quiz_model->get_quiz_by_lesson($lesson_id);
            if ($existing_quiz) {
                $this->session->set_flashdata('error', 'Pelajaran ini sudah memiliki quiz');
                redirect('admin/quizzes?lesson_id=' . $lesson_id);
            }

            $this->form_validation->set_rules('title', 'Judul', 'required');
            $this->form_validation->set_rules('description', 'Deskripsi', 'required');
            $this->form_validation->set_rules('passing_score', 'Nilai Kelulusan', 'required|numeric');

            if ($this->form_validation->run() == FALSE) {
                $data['title'] = 'Add Quiz - AcademyS';
                $this->load->view('templates/header', $data);
                $this->load->view('admin/add_quiz', $data);
                $this->load->view('templates/footer');
            } else {
                $quiz_data = [
                    'lesson_id' => $lesson_id,
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'passing_score' => $this->input->post('passing_score'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $quiz_id = $this->quiz_model->add_quiz($quiz_data);

                // Tambahkan pertanyaan jika ada
                if ($this->input->post('questions')) {
                    $questions = $this->input->post('questions');
                    foreach ($questions as $index => $question) {
                        $question_data = [
                            'quiz_id' => $quiz_id,
                            'question_text' => $question['text'],
                            'question_type' => $question['type'],
                            'points' => $question['points'],
                            'order_number' => $index + 1,
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        $question_id = $this->quiz_model->add_question($question_data);

                        // Tambahkan opsi jika pertanyaan pilihan ganda
                        if ($question['type'] == 'multiple_choice') {
                            $correct_option = $this->input->post('questions')[$index]['correct_option'] ?? 0;
                            
                            foreach ($question['options'] as $opt_index => $option) {
                                $option_data = [
                                    'question_id' => $question_id,
                                    'option_text' => $option['text'],
                                    'is_correct' => ($opt_index == $correct_option) ? 1 : 0,
                                    'order_number' => $opt_index + 1,
                                    'created_at' => date('Y-m-d H:i:s')
                                ];
                                $this->quiz_model->add_option($option_data);
                            }
                        }
                    }
                }

                $this->session->set_flashdata('success', 'Quiz berhasil ditambahkan');
                redirect('admin/quizzes?lesson_id=' . $lesson_id);
            }
        } else {
            // Jika tidak ada lesson_id, tampilkan form untuk memilih lesson
            $data['title'] = 'Add Quiz - AcademyS';
            $data['lessons'] = $this->lesson_model->get_all_lessons_with_course();
            
            $this->form_validation->set_rules('lesson_id', 'Pelajaran', 'required');
            $this->form_validation->set_rules('title', 'Judul', 'required');
            $this->form_validation->set_rules('description', 'Deskripsi', 'required');
            $this->form_validation->set_rules('passing_score', 'Nilai Kelulusan', 'required|numeric');
            
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('templates/header', $data);
                $this->load->view('admin/add_quiz_select_lesson', $data);
                $this->load->view('templates/footer');
            } else {
                $lesson_id = $this->input->post('lesson_id');
                
                // Cek apakah lesson sudah memiliki quiz
                $existing_quiz = $this->quiz_model->get_quiz_by_lesson($lesson_id);
                if ($existing_quiz) {
                    $this->session->set_flashdata('error', 'Pelajaran ini sudah memiliki quiz');
                    redirect('admin/quizzes');
                }
                
                $quiz_data = [
                    'lesson_id' => $lesson_id,
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'passing_score' => $this->input->post('passing_score'),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $quiz_id = $this->quiz_model->add_quiz($quiz_data);
                
                $this->session->set_flashdata('success', 'Quiz berhasil ditambahkan. Silakan tambahkan pertanyaan.');
                redirect('admin/edit_quiz/' . $quiz_id);
            }
        }
    }
    
    public function edit_quiz($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model(['quiz_model', 'lesson_model', 'course_model']);
        $this->load->library('form_validation');
        
        $quiz = $this->quiz_model->get_quiz($id);
        
        if (empty($quiz)) {
            show_404();
        }
        
        $lesson_id = $quiz['lesson_id'];
        $data['lesson'] = $this->lesson_model->get_lesson($lesson_id);
        $data['course'] = $this->course_model->get_course($data['lesson']['course_id']);
        $data['quiz'] = $quiz;
        $data['questions'] = $this->quiz_model->get_questions($id);
        
        $this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required');
        $this->form_validation->set_rules('passing_score', 'Nilai Kelulusan', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Quiz - AcademyS';
            $this->load->view('templates/header', $data);
            $this->load->view('admin/edit_quiz', $data);
            $this->load->view('templates/footer');
        } else {
            $quiz_data = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'passing_score' => $this->input->post('passing_score'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->quiz_model->update_quiz($id, $quiz_data);
            
            $this->session->set_flashdata('success', 'Quiz berhasil diperbarui');
            redirect('admin/quizzes?lesson_id=' . $lesson_id);
        }
    }
    
    public function delete_quiz($id) {
        $this->load->model('quiz_model');
        
        $quiz = $this->quiz_model->get_quiz($id);
        
        if (empty($quiz)) {
            show_404();
        }
        
        $lesson_id = $quiz['lesson_id'];
        
        if ($this->quiz_model->delete_quiz($id)) {
            $this->session->set_flashdata('success', 'Quiz berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus quiz');
        }
        
        redirect('admin/quizzes?lesson_id=' . $lesson_id);
    }
    
    public function add_question($quiz_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model(['quiz_model', 'lesson_model', 'course_model']);
        $this->load->library('form_validation');
        
        $quiz = $this->quiz_model->get_quiz($quiz_id);
        
        if (empty($quiz)) {
            show_404();
        }
        
        $lesson_id = $quiz['lesson_id'];
        $data['lesson'] = $this->lesson_model->get_lesson($lesson_id);
        $data['course'] = $this->course_model->get_course($data['lesson']['course_id']);
        $data['quiz'] = $quiz;
        
        $this->form_validation->set_rules('question_text', 'Pertanyaan', 'required');
        $this->form_validation->set_rules('question_type', 'Tipe Pertanyaan', 'required');
        $this->form_validation->set_rules('points', 'Poin', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Add Question - AcademyS';
            $this->load->view('templates/header', $data);
            $this->load->view('admin/add_question', $data);
            $this->load->view('templates/footer');
        } else {
            $question_data = [
                'quiz_id' => $quiz_id,
                'question_text' => $this->input->post('question_text'),
                'question_type' => $this->input->post('question_type'),
                'points' => $this->input->post('points'),
                'order_number' => $this->input->post('order_number'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $question_id = $this->quiz_model->add_question($question_data);
            
            // Tambahkan opsi jika pertanyaan pilihan ganda
            if ($this->input->post('question_type') == 'multiple_choice') {
                $options = $this->input->post('options');
                $correct_option = $this->input->post('correct_option');
                
                foreach ($options as $index => $option_text) {
                    if (!empty($option_text)) {
                        $option_data = [
                            'question_id' => $question_id,
                            'option_text' => $option_text,
                            'is_correct' => ($index == $correct_option) ? 1 : 0,
                            'order_number' => $index + 1,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        $this->quiz_model->add_option($option_data);
                    }
                }
            }
            
            $this->session->set_flashdata('success', 'Pertanyaan berhasil ditambahkan');
            redirect('admin/edit_quiz/' . $quiz_id);
        }
    }
    
    public function edit_question($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model(['quiz_model', 'lesson_model', 'course_model']);
        $this->load->library('form_validation');
        
        $question = $this->quiz_model->get_question($id);
        
        if (empty($question)) {
            show_404();
        }
        
        $quiz_id = $question['quiz_id'];
        $quiz = $this->quiz_model->get_quiz($quiz_id);
        $lesson_id = $quiz['lesson_id'];
        
        $data['lesson'] = $this->lesson_model->get_lesson($lesson_id);
        $data['course'] = $this->course_model->get_course($data['lesson']['course_id']);
        $data['quiz'] = $quiz;
        $data['question'] = $question;
        $data['options'] = $this->quiz_model->get_question_options($id);
        
        $this->form_validation->set_rules('question_text', 'Pertanyaan', 'required');
        $this->form_validation->set_rules('points', 'Poin', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Edit Question - AcademyS';
            $this->load->view('templates/header', $data);
            $this->load->view('admin/edit_question', $data);
            $this->load->view('templates/footer');
        } else {
            $question_data = [
                'question_text' => $this->input->post('question_text'),
                'points' => $this->input->post('points'),
                'order_number' => $this->input->post('order_number')
            ];
            
            $this->quiz_model->update_question($id, $question_data);
            
            // Update opsi jika pertanyaan pilihan ganda
            if ($question['question_type'] == 'multiple_choice') {
                $options = $this->input->post('options');
                $option_ids = $this->input->post('option_ids');
                $correct_option = $this->input->post('correct_option');
                
                // Update opsi yang sudah ada
                foreach ($option_ids as $index => $option_id) {
                    if (isset($options[$index]) && !empty($options[$index])) {
                        $option_data = [
                            'option_text' => $options[$index],
                            'is_correct' => ($index == $correct_option) ? 1 : 0
                        ];
                        $this->quiz_model->update_option($option_id, $option_data);
                    }
                }
                
                // Tambahkan opsi baru jika ada
                if (isset($options['new'])) {
                    foreach ($options['new'] as $index => $option_text) {
                        if (!empty($option_text)) {
                            $option_data = [
                                'question_id' => $id,
                                'option_text' => $option_text,
                                'is_correct' => ($correct_option == 'new_'.$index) ? 1 : 0,
                                'order_number' => count($option_ids) + $index + 1,
                                'created_at' => date('Y-m-d H:i:s')
                            ];
                            $this->quiz_model->add_option($option_data);
                        }
                    }
                }
            }
            
            $this->session->set_flashdata('success', 'Pertanyaan berhasil diperbarui');
            redirect('admin/edit_quiz/' . $quiz_id);
        }
    }
    
    public function delete_question($id) {
        $this->load->model('quiz_model');
        
        $question = $this->quiz_model->get_question($id);
        
        if (empty($question)) {
            show_404();
        }
        
        $quiz_id = $question['quiz_id'];
        
        if ($this->quiz_model->delete_question($id)) {
            $this->session->set_flashdata('success', 'Pertanyaan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus pertanyaan');
        }
        
        redirect('admin/edit_quiz/' . $quiz_id);
    }

    // Mengelola pengguna
    public function add_user() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
        $this->form_validation->set_rules('role', 'Role', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Tambah Pengguna - AcademyS';
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/add_user', $data);
            $this->load->view('templates/footer');
        } else {
            $user_data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role' => $this->input->post('role'),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            
            // Proses upload gambar profil jika ada
            if (!empty($_FILES['profile_image']['name'])) {
                $config['upload_path'] = './assets/images/profiles/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('profile_image')) {
                    $upload_data = $this->upload->data();
                    $user_data['profile_image'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('upload_error', $this->upload->display_errors());
                }
            }
            
            if ($this->user_model->add_user($user_data)) {
                $this->session->set_flashdata('user_added', 'Pengguna berhasil ditambahkan');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('user_add_failed', 'Gagal menambahkan pengguna');
                redirect('admin/add_user');
            }
        }
    }

    public function edit_user($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->library('form_validation');
        
        $data['user'] = $this->user_model->get_user($id);
        
        if (empty($data['user'])) {
            show_404();
        }
        
        // Set rules untuk username dan email, kecuali jika tidak berubah
        if ($this->input->post('username') && $this->input->post('username') !== $data['user']['username']) {
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        } else {
            $this->form_validation->set_rules('username', 'Username', 'required');
        }
        
        if ($this->input->post('email') && $this->input->post('email') !== $data['user']['email']) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        }
        
        // Jika password diisi, validasi
        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'matches[password]');
        }
        
        $this->form_validation->set_rules('role', 'Role', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Pengguna - AcademyS';
            
            // Tambahkan default value untuk field yang mungkin tidak ada
            if (!isset($data['user']['profile_image'])) {
                $data['user']['profile_image'] = '';
            }
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/edit_user', $data);
            $this->load->view('templates/footer');
        } else {
            $user_data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'role' => $this->input->post('role'),
                'is_active' => $this->input->post('is_active') ? 1 : 0
            ];
            
            // Update password jika diisi
            if ($this->input->post('password')) {
                $user_data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }
            
            // Proses upload gambar profil jika ada
            if (!empty($_FILES['profile_image']['name'])) {
                $config['upload_path'] = './assets/images/profiles/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('profile_image')) {
                    $upload_data = $this->upload->data();
                    $user_data['profile_image'] = $upload_data['file_name'];
                    
                    // Hapus gambar lama jika ada
                    $old_image = $data['user']['profile_image'];
                    if ($old_image && file_exists('./assets/images/profiles/' . $old_image)) {
                        unlink('./assets/images/profiles/' . $old_image);
                    }
                } else {
                    $this->session->set_flashdata('upload_error', $this->upload->display_errors());
                }
            }
            
            if ($this->user_model->update_user($id, $user_data)) {
                $this->session->set_flashdata('user_updated', 'Pengguna berhasil diperbarui');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('user_update_failed', 'Gagal memperbarui pengguna');
                redirect('admin/edit_user/' . $id);
            }
        }
    }

    public function delete_user($user_id) {
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // Cek apakah user yang login adalah admin
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus pengguna');
            redirect('admin/users');
        }

        // Cek apakah user mencoba menghapus dirinya sendiri
        if ($user_id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri');
            redirect('admin/users');
        }

        // Ambil data user
        $user = $this->user_model->get_user($user_id);
        
        if (!$user) {
            $this->session->set_flashdata('error', 'Pengguna tidak ditemukan');
            redirect('admin/users');
        }

        // Hapus gambar profil jika ada
        if ($user['profile_image'] && $user['profile_image'] != 'default.jpg') {
            $file_path = './assets/images/profiles/' . $user['profile_image'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        // Hapus user dari database
        if ($this->user_model->delete_user($user_id)) {
            $this->session->set_flashdata('user_deleted', 'Pengguna berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus pengguna');
        }

        redirect('admin/users');
    }
    
    // Mengelola Coding Exercises
    public function coding_exercises() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model('coding_model');
        
        $data['title'] = 'Kelola Coding Exercises - AcademyS';
        $data['exercises'] = $this->coding_model->get_all_exercises();
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/coding_exercises', $data);
        $this->load->view('templates/footer');
    }
    
    public function add_coding_exercise() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model(['coding_model', 'lesson_model']);
        $this->load->library('form_validation');
        
        $data['lessons'] = $this->lesson_model->get_all_lessons_with_course();
        
        $this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('lesson_id', 'Pelajaran', 'required');
        $this->form_validation->set_rules('language', 'Bahasa', 'required');
        $this->form_validation->set_rules('instructions', 'Instruksi', 'required');
        $this->form_validation->set_rules('starter_code', 'Kode Awal', 'required');
        $this->form_validation->set_rules('solution_code', 'Kode Solusi', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Tambah Coding Exercise - AcademyS';
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/add_coding_exercise', $data);
            $this->load->view('templates/footer');
        } else {
            $exercise_data = [
                'lesson_id' => $this->input->post('lesson_id'),
                'title' => $this->input->post('title'),
                'language' => $this->input->post('language'),
                'instructions' => $this->input->post('instructions'),
                'starter_code' => $this->input->post('starter_code'),
                'solution_code' => $this->input->post('solution_code'),
                'test_cases' => $this->input->post('test_cases')
            ];
            
            if ($this->coding_model->add_exercise($exercise_data)) {
                $this->session->set_flashdata('success', 'Coding exercise berhasil ditambahkan');
                redirect('admin/coding_exercises');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan coding exercise');
                redirect('admin/add_coding_exercise');
            }
        }
    }
    
    public function edit_coding_exercise($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model(['coding_model', 'lesson_model']);
        $this->load->library('form_validation');
        
        $data['exercise'] = $this->coding_model->get_exercise($id);
        
        if (empty($data['exercise'])) {
            show_404();
        }
        
        $data['lessons'] = $this->lesson_model->get_all_lessons_with_course();
        
        $this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('lesson_id', 'Pelajaran', 'required');
        $this->form_validation->set_rules('language', 'Bahasa', 'required');
        $this->form_validation->set_rules('instructions', 'Instruksi', 'required');
        $this->form_validation->set_rules('starter_code', 'Kode Awal', 'required');
        $this->form_validation->set_rules('solution_code', 'Kode Solusi', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Coding Exercise - AcademyS';
            
            $this->load->view('templates/header', $data);
            $this->load->view('admin/edit_coding_exercise', $data);
            $this->load->view('templates/footer');
        } else {
            $exercise_data = [
                'lesson_id' => $this->input->post('lesson_id'),
                'title' => $this->input->post('title'),
                'language' => $this->input->post('language'),
                'instructions' => $this->input->post('instructions'),
                'starter_code' => $this->input->post('starter_code'),
                'solution_code' => $this->input->post('solution_code'),
                'test_cases' => $this->input->post('test_cases')
            ];
            
            if ($this->coding_model->update_exercise($id, $exercise_data)) {
                $this->session->set_flashdata('success', 'Coding exercise berhasil diperbarui');
                redirect('admin/coding_exercises');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui coding exercise');
                redirect('admin/edit_coding_exercise/' . $id);
            }
        }
    }
    
    public function delete_coding_exercise($id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model('coding_model');
        
        $exercise = $this->coding_model->get_exercise($id);
        
        if (empty($exercise)) {
            show_404();
        }
        
        if ($this->coding_model->delete_exercise($id)) {
            $this->session->set_flashdata('success', 'Coding exercise berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus coding exercise');
        }
        
        redirect('admin/coding_exercises');
    }
} 