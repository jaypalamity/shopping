<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Item extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function num_rows() {
        $query = $this->db
                ->select('*')
                ->from('items')
                ->get();
        return $query->num_rows();
    }

///////////// for paging we have to use limot and offset ////////////////
    public function articles_list($limit, $offset) {
        $query = $this->db
                ->select('*')
                ->from('items')
                ->limit($limit, $offset)
                ->get();
        return $query->result();
    }

///////////// for get all data have to use this function ////////////////
    function getItems() {
        $this->db->select("*");
        $this->db->from('items');
        $query = $this->db->get();
        return $query->result();
    }

///////////// for single row of data have to use  ////////////////
    public function getItemsById($id) {
        $q = $this->db->select('*')
                ->where('id', $id)
                ->get('items');
        return $q->row();
    }

///////////// function fo add  ////////////////
    public function add($data) {
        return $this->db->insert('items', $data);
    }

///////////// function for update  ////////////////
    public function update($id, $data) {
        return $this->db->where('id', $id)->update('items', $data);
        //echo $this->db->last_query();
    }

///////////// function for delete  ////////////////
    public function delete($id) {
        return $this->db->delete('items', ['id' => $id]);
        //echo $this->db->last_query();die;
    }

///////////// function for count noumber of rows during add  ////////////////
    public function checkDuplicacy($name) {
        $query = $this->db
                ->select(['name'])
                ->from('items')
                ->where('name', $name)
                ->get();
        return $query->num_rows();
    }

///////////// function for count noumber of rows during update  ////////////////
    public function checkDuplicacyUpdate($name, $id) {
        $query = $this->db
                ->select(['name'])
                ->from('items')
                ->where('name', $name)
                ->where('id !=', $id)
                ->get();
        return $query->num_rows();
    }

    public function deleteSelected() {
        $checkedValue = $this->input->post('chkValue');
        $ids = implode(',', $checkedValue);
        $query = $this->db->query("SELECT item_image FROM items WHERE id IN($ids)");
        $result = $query->result();
        foreach ($result as $imageName) {
            $image_url = CAT_IMAGE_PATH . $imageName->item_image;
            chmod($image_url, 0777);
            unlink($image_url);
        }
        $delete = $this->db->query("DELETE  FROM items WHERE id IN($ids)");
        if ($delete) {
            $this->session->set_flashdata('message', 'Item deleted Succesfully');
            redirect('items/dashboard');
        } else {
            $this->session->set_flashdata('mes-error', 'Item Not deleted Succesfully');
            redirect('items/dashboard');
        }
    }

//    function deleteUser($data) {
//        if (!empty($data)) {
//            $this->db->where_in('id', $data);
//            $this->db->delete('users');
//        }
//    }

}

?>