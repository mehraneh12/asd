<?php

class Index extends Controller
{
    public $checkLogin = '';
    public $checkid='';

    function __construct()
    {
        parent::__construct();
        
    //   unset( $_SESSION['username']);
            $this->checkLogin = Model::session_get("username");
      
            if ($this->checkLogin == FALSE) {
                header("Location:".URL."login");
            }
        }
    

    function index()
    {
        
        $this->view('index/index');
    }
    function add_contact_data(){
    
        $this->model->add_contact_data($_POST);
    }
    function update_contact_data(){
    
        $this->model->update_contact_data();
    }
    function change_contact_data(){
    
        $this->model->change_contact_data($_POST);
    }

    function saveChat(){
    
        $this->model->saveChat($_POST);
    }
    function chat(){
    
        $this->model->chat($_POST);
    }
    function viewchat(){
    
        $this->model->viewchat($_POST);
    }
    function del(){
    
        $this->model->del($_POST);
    }
    
    function editchat(){
    
        $this->model->editchat($_POST);
    }
   
    function  delchat(){
    
        $this->model->delchat($_POST);
    }
}