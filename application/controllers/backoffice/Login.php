<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
    }

    public function index() {
        $this->load->view('Admin/login');
    }

    public function loginCheck() {        
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $query = $this->db->query("SELECT status FROM users WHERE username = '".$username."'");
       $status =  $query->row();
      //echo  $statusValue = $status->status;die;
        if ($username == '' && $password == '') {
             $this->session->set_flashdata('message', 'Please Enter Username and Password');
            redirect('backoffice/login');
          
        } else {
             $value = $this->Login_model->login($username, $password);
        }
        //echo 'hi';die;
        if ($value) {
            /////////// Set Remember Me Cookies /////////////////           
            if ($this->input->post("remember_me") == 1) {
                $hour = time() + 3600 * 24 * 30;
                setcookie('username', $username, $hour);
            }
            if ($this->input->post("remember_me") == 1) {
                $hour = time() + 3600 * 24 * 30;
                setcookie('password', $password, $hour);
            }
            /////////// Set Remember Me Cookies /////////////////            
                redirect('items/dashboard');
            }
         else {
            $this->session->set_flashdata('message', 'Invalid Username or Password');
            redirect('backoffice/login');
            return false;
        }
        
        
        /////////// USer inactive code //////////////////////////////////////////////////////////
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('backoffice/login');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */