
<?php

class Login extends Controller
{
    public $checkLogin = '';

    function __construct()
    {
        parent::__construct();
        //متغیر چک لاگین در خط 36 صفحه چک لاگین مقدار دهی میشود.وقتی که سشن ست میشود
        $this->checkLogin = Model::session_get("username");
        // اگر فرد قبلا لاگین کرده به صفحه اصلی سایت وارد شو
         if ($this->checkLogin != FALSE) {
            header("Location:".URL);
        }

    }
// و اگر هنوز لاگین نکرده به صفحه حاوی فرم لاگین برو
    function index()
    {
        $this->view('login/index');
      
    }
   
    function check_data()
    { 
        // این تابع عملیات مربوط به لاگین را بر عهده دارد
        $this->model->check_data($_POST);
    }
}

?>