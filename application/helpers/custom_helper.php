<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_user_details')){
   function get_user_details($id){
       //get main CodeIgniter object
       $ci =& get_instance();
       
       //load databse library
       $ci->load->database();
       
       //get data from database
       $query = $ci->db->get_where('tbl_subject_master',array('subject_master_id'=>$id));
       
       if($query->num_rows() > 0){
           $result = $query->result();
           return $result;
       }else{
           return false;
       }
   }
   
   function get_question_type() {
        //get main CodeIgniter object
        $ci = & get_instance();
        //load databse library
        $ci->load->database();
        //get data from database
        $ci->db->select("*");
        $ci->db->from('tbl_question_type_master');
        $query = $ci->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }
    
    function get_question() {
        //get main CodeIgniter object
        $ci = & get_instance();
        //load databse library
        $ci->load->database();
        //get data from database
        $ci->db->select("*");
        $ci->db->from('tbl_question_master');
        $query = $ci->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }
    
    
    function get_taggingData() {
        $ci = & get_instance();
        $ci->load->database();
        $ci->db->select("*");
        $ci->db->from('tagging_exam_subject_chapter_topic');
        $query = $ci->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }
    
    function getQuestionLevelData() {
        $ci = & get_instance();
        $ci->load->database();
        $ci->db->select("*");
        $ci->db->from('question_level');
        $query = $ci->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }
    
    
    
    function get_tagging($id){
       $ci =& get_instance();
       $ci->load->database();
       $query = $ci->db->get_where('tagging_exam_subject_chapter_topic',array('tagging_master_id'=>$id));       
       if($query->num_rows() > 0){
           $result = $query->row();
           return $result;
       }else{
           return false;
       }
   }
    
   function test(){
       echo 'custom helper test';
   }
    
    
   
}
