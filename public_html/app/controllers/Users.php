<?php

    class Users extends Controller {
        public function __construct() {
            $this->userModel = $this->model('User');
        }


        // REGISTER
        public function register() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => ''
                ];

                //Validate Email
                if (empty($data['email'])) {
                    $data['email_error'] = 'Please enter email';
                }
                else {
                    // Check email
                    if($this->userModel->findUserByEmail($data['email'])) {
                        $data['email_error'] = 'Email is already taken';
                    }
                }

                // Validate Name
                if (empty($data['name'])) {
                    $data['name_error'] = 'Please enter name';
                }

                // Validate Password
                if (empty($data['password'])) {
                    $data['password_error'] = 'Please enter password';
                }
                else if (strlen($data['password']) < 6) {
                    $data['password_error'] = 'Password must have at least 6 characters';
                }

                // Validate Confirm Password
                if (empty($data['confirm_password'])) {
                    $data['confirm_password_error'] = 'Please confirm password';
                }
                else {
                    if ($data['password'] != $data['confirm_password']) {
                        $data['confirm_password_error'] = 'Passwords do not match';
                    }
                }


                // IF NO ERRORS, REGISTER
                if (empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])) {
                    // Validated
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Register user
                    if($this->userModel->register($data)) {
                        redirect ('posts');
//                        die('registered');
                    }

                    else {
                        die('Failed to register');
                    }
                }
                else {
                    // Load view with errors
                    $this->view('users/register', $data);
                    }
                }

                else {
                    // SHow the form is else
                    // Init data
                    $data = [
                        'name' => '',
                        'email' => '',
                        'password' => '',
                        'confirm_password' => '',
                        'name_error' => '',
                        'email_error' => '',
                        'password_error' => '',
                        'confirm_password_error' => ''
                    ];
                    // Load view
                    $this->view('users/register', $data);

                    }
            }


        // LOGIN
        public function login() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_error' => '',
                    'password_error' => '',
                ];

                //Validate Email
                if (empty($data['email'])) {
                    $data['email_error'] = 'Please enter email';
                }

                // Validate Password
                if (empty($data['password'])) {
                    $data['password_error'] = 'Please enter password';
                }


                // Make sure errors are empty
                if (empty($data['email_error']) && empty($data['password_error'])) {
                    // Validated
                    die('success-login');
                }
                else {
                    // Load view with errors
                    $this->view('users/login', $data);
                    }
                }
                else {
                    // SHow the form is else
                    // Init data
                    $data = [
                        'name' => '',
                        'email' => '',
                        'password' => '',
                        'confirm_password' => '',
                        'name_error' => '',
                        'email_error' => '',
                        'password_error' => '',
                        'confirm_password_error' => ''
                    ];
                    // Load view
                    $this->view('users/login', $data);
                }
            }
        }
