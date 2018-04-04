<?php
class Techprocess {
  
    public function __construct()
    {
        //echo 'hi';die;
        require_once APPPATH.'third_party/techprocess/AES.php';
        require_once APPPATH.'third_party/techprocess/RequestValidate.php';
        require_once APPPATH.'third_party/techprocess/response.php';
        require_once APPPATH.'third_party/techprocess/TransactionRequestBean.php';
        require_once APPPATH.'third_party/techprocess/TransactionResponseBean.php';
        //require_once APPPATH.'third_party/techprocess/techprocess.php';
       
    }
  function show_hello_world()
  {
    return 'Hello World function from liabrary';
  }
}