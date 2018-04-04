<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

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
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __Construct() {
        parent::__Construct();
        $this->load->database(); // load database
        $this->load->model('Item'); // load model 
        $this->load->helper('Custom_helper');  // load Custom Helper 
        $this->load->library('Liabrary');  // load Custom Liabrary 
         $this->load->library('Techprocess');  // load Custom Liabrary 
        $this->load->library('session');
        $result = $this->session->all_userdata();
        if (!isset($result['user_data']['logged_in'])) {
            redirect('backoffice/login');
        }
    }

    public function index1() {
        $this->data['items'] = $this->Item->getItems(); // calling Post model method getPosts()
        $this->load->view('Items/listing', $this->data); // load the view file , we are passing $data array to view file
    }

    public function dashboard() {
        //echo '<pre>'; print_r($_SESSION['cart']);  
//        echo $this->liabrary->show_hello_world();die;  //////////Call Custom Liabrary function 
//         echo  test();die;                             ///////// Call Custom Helper function
        $this->load->library('pagination');
        $config = [
            'base_url' => base_url('items/dashboard'),
            'per_page' => 5,
            'total_rows' => $this->Item->num_rows(),
            'full_tag_open' => "<ul class='pagination'>",
            'full_tag_close' => "</ul>",
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'prev_tag_open' => '<li>',
            'prev_tag_close' => '</li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>',
            'cur_tag_open' => "<li class='active'><a>",
            'cur_tag_close' => '</a></li>',
        ];

        $this->pagination->initialize($config);
        $articles = $this->Item->articles_list($config['per_page'], $this->uri->segment(3));
        $this->load->view('Items/listing', ['articles' => $articles]);
    }

    public function view() {
        $id = $this->uri->segment(3);
        $this->data['item'] = $this->Item->getItemsById($id);
        $this->load->view('Items/view', $this->data); // load the view file , we are passing $data array to view file
    }

    public function create() {
        $this->load->view('Items/add');
    }

    public function addtocart() {
       // session_destroy();die;
        //session_start();
        if (isset($_GET) & !empty($_GET)) {
            $id = $_GET['id'];
            if (isset($_GET['quant']) & !empty($_GET['quant'])) {
                $quant = $_GET['quant'];
            } else {
                $quant = 1;
            }
            $_SESSION['cart'][$id] = array("quantity" => $quant);
            redirect('items/cart');
        } else {
            redirect('items/cart');
        }
        //echo "<pre>";
        //print_r($_SESSION['cart']);
        //echo "</pre>";
    }

    public function cart() {
        $this->load->view('Items/cart');
    }

    public function add() {
        //print_r($_FILES);die;
        $name = $this->input->post('name');
        $price = $this->input->post('price');
        $count = $this->Item->checkDuplicacy($name);

        $this->load->library('upload');
        $config = array(
            'upload_path' => CAT_IMAGE_PATH,
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => FALSE,
            'max_size' => "2048000", // Can be set to particular file size
            // 'max_height' => "900",
            // 'max_width' => "900",
            'file_name' => time() . $_FILES['item_image']['name'],
            'remove_spaces' => TRUE
        );
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('item_image')) {
            $this->session->set_flashdata('msg-error', 'Please select Image');
            redirect('items/create');
            $response = array("status" => 0, "errorMsg" => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data());
            $fileName = $data['upload_data']['file_name'];

            if ($name != '') {
                if ($count < 1) {
                    $data = array(
                        'name' => $this->input->post('name'),
                        'price' => $this->input->post('price'),
                        'item_image' => $fileName
                    );
                    $this->Item->add($data);
                    $this->session->set_flashdata('message', 'Item added succesfully');
                    redirect('items/dashboard');
                } else {
                    $this->session->set_flashdata('msg-error', 'Item already exist');
                    redirect('items/dashboard');
                }
            } else {
                $this->session->set_flashdata('msg-error', 'Please enter Item name');
                redirect('items/dashboard');
            }
        }
    }

    public function edit() {
        $id = $this->uri->segment(3);
        $this->data['item'] = $this->Item->getItemsById($id);
        $this->load->view('Items/edit', $this->data); // load the view file , we are passing $data array to view file
    }

    public function update($id) {
        $name = $this->input->post('name');
        $price = $this->input->post('price');
        $item_image = $this->input->post('item_image');
        $hiddenImage = $this->input->post('hiddenImage');
        $count = $this->Item->checkDuplicacyUpdate($name, $id);
        //echo $count;die;
        if ($count < 1) {
            /////////////////////////////////////////////////////////  
            if (isset($_FILES['item_image'])) {
                if ($_FILES['item_image']['size'] > 0) {
                    $new_image = time() . $_FILES['item_image']['name'];
                    $config = array(
                        'upload_path' => CAT_IMAGE_PATH,
                        'allowed_types' => "gif|jpg|png|jpeg|pdf",
                        'overwrite' => FALSE,
                        'max_size' => "2048000", // Can be set to particular file size
                        //'max_height' => "900",
                        //'max_width' => "900",
                        'file_name' => $new_image,
                        'remove_spaces' => TRUE
                    );

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('item_image')) {
                        $fileStatus = 1;
                    } else {
                        $response = array("status" => 0, "errorMsg" => $this->upload->display_errors());
                    }
                } else {
                    $fileStatus = 0;
                    $new_image = $hiddenImage;
                }
            } else {
                $fileStatus = 0;
                $new_image = $hiddenImage;
            }

            if ($fileStatus == '1') {
                $image_url = CAT_IMAGE_PATH . $hiddenImage;
                chmod($image_url, 0777);
                unlink($image_url);
            }
            //////////////////


            $data = array(
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'item_image' => $new_image
            );
            $query = $this->Item->update($id, $data);
            $this->session->set_flashdata('message', 'Item updated sucessfully');
            redirect('items/dashboard');
        } else {
            $this->session->set_flashdata('msg-error', 'Item already Exist');
            redirect('items/edit/' . $id . '');
        }
    }

    public function delete($id) {
        $result = $this->Item->getItemsById($id);
        $image_name = $result->item_image;
        $image_url = CAT_IMAGE_PATH . $image_name;
        chmod($image_url, 0777);
        unlink($image_url);
        $this->Item->delete($id);
        $this->session->set_flashdata('message', 'Item deleted Succesfully');
        redirect('items/dashboard');
    }

    public function deleteSelected() {
        $var = $_POST['chkValue'];
        $implode = implode(',', $var);
        $delete = $this->Item->deleteSelected($implode);
        if ($delete) {
            echo 'Deleted All';
        } else {
            echo 'Not Deleted';
        }
    }

    public function deletecart() {
        if (isset($_GET['id']) & !empty($_GET['id'])) {
            $id = $_GET['id'];
            unset($_SESSION['cart'][$id]);
            redirect('items/cart');
        }
    }

    public function payment() {
        $this->load->view('Items/techprocess');
    }

}
