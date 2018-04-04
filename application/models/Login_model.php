<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'users';
    }

    function login($email, $password) {
        //echo 'ji';die;
        $this->db->where("username", $email);
        $this->db->where("password", $password);
        $query = $this->db->get($this->table_name);
        //print_r($this->db->last_query());
        //die;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                //add all data to session
                $newdata = array(
                    'user_id' => $rows->id,
                    'username' => $rows->username,
                    'logged_in' => TRUE,
                    'status' => $rows->status,
//                    'first_name' => $rows->first_name,
//                    'last_name' => $rows->last_name,
                );
            }
            $this->session->set_userdata('user_data', $newdata);        
            return true;
        }
    }

    function changepassword($npassword, $username) {
        $data = array('password' => $npassword);
        $where = "username = '" . $username . "'";
        $str = $this->db->update_string($this->table_name, $data, $where);
        return $this->db->query($str);
    }

    function subscribe($email) {
        $this->db->where("subscribe_email", $email);

        $query = $this->db->get('gyp_newsletter');
        //print_r($this->db->last_query());
        //die;
        if ($query->num_rows() > 0) {
            return json_encode(array('error' => 'email already exist.'));
        } else {
            $data = array('subscribe_email' => $email);
            $str = $this->db->insert_string('gyp_newsletter', $data);
            $this->db->query($str);
            return json_encode(array('success' => 'Thanks for subscription.'));
        }
    }

}

?>