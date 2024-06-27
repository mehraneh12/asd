<?php

class model_login extends Model
{
    public $checkLogin = '';
    public $checkid='';

    function __construct()
    {
        parent::__construct();
        
    }
// این تابع عملیات مربوط به لاگین را بر عهده دارد
    function check_data($post)
    {
        // چک میکند که کاربر قبلا ثبت نام کرده یا نه
        $sql = "SELECT * FROM users WHERE username=? AND password=?";
        $params = array($post['username'], md5($post['password']));
        $result = $this->doSelect($sql, $params);
        //  اگر ثبت نام نکرده خطا میدهد که فرد باید اول ثبت نام کند
        if (sizeof($result) == 0) {
           
                 echo json_encode(array(
                    "msg" => "not found",
                    "status_code"=>  "404"
                )
            );
            
        //  اگر ثبت نام کرده برایش یک سشن ست میکند تا لاگین شود  
        // نام سشن را برابر شماره تلفن قرار میدهد
    //    ایدی سشن را هم ایدی فرد در جدول یوزر قرار میدهد
    } else {
            
            $this->session_set("username", $result[0]['username']);
            $this->session_set("id", $result[0]['id']);
            $this->checkLogin = $result[0]['username'];
            $this->checkid=$result[0]['id'];
            echo json_encode(array(
                    "msg" => "ok",
                    "status_code"=>  "200"
                )
            );
        }
    }
}
?>