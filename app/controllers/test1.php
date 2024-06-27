<?php
class test1 extends controller
{ 
    public $checkLogin ='';

    function __construct()
    {
        parent::__construct();
        
    }
    function index()
    {
        $this->view("test1/index");
    }
    function test1_data(){
     
        $this->model->test1_data($_POST);
    }
}
