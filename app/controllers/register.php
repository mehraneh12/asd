<?php
class register extends controller
{ 
    public $checkLogin ='';

    function __construct()
    {
        parent::__construct();
         $this->checkLogin= model::session_get("username");
        if ($this->checkLogin != FALSE) {
            header("Location:".URL);
        }
    }
    function index()
    {
        $this->view("register/index");
    }
    function insert_data(){
     
        $this->model->insert_data($_POST);
    }
}
