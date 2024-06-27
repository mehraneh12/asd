<?php

class model_index extends Model
{
   
   function __construct()
   {
      parent::__construct();
   }

   // یک نام و یک تلفن وارد کردیم و میخواهیم ایدی و نام مربوط به ان را در جدول مخاطبین ثبت کنیم
   function add_contact_data($post)

   {
      // در جدول یوزر تمام رکوردهایی که مقدار یوزر نامشان با شماره تلفن ورودی برابر است را برمیگرداند
      $sql = "SELECT * FROM users WHERE username=?";
      $values = array($post['contactPhone']);
      $result = $this->doSelect($sql, $values);
      if (sizeof($result) != 0) {
         // بررسی میکنداطلاعات ورودی مربوط به فرد لاگین کننده نباشد
         if ($_SESSION['id'] == $result[0]['id']) {
            echo json_encode(
               array(
                  "msg" => "اطلاعات خودتان نمیتواند به جدول مخاطبان اضافه شود",
                  "status_code" =>  "101"
               )
            );
         } else {

            // بررسی میکند اطلاعات قبلا در جدول ثبت نشده باشد
            $stmt = "SELECT * FROM contact WHERE contactid=?";
            $params = array($result[0]['id']);
            $res = $this->doSelect($stmt, $params);

            if (sizeof($res) == 0) {
               // اگر قبلا در جدول ثبت نشده ثبتش میکند
               $sql = "INSERT INTO contact(userid,contactid,name) VALUES(?,?,?) ";
               $values = array($_SESSION['id'], $result[0]['id'], $post['contactName']);
               $this->doQuery($sql, $values);
               
               echo json_encode(
                  array(
                     "msg" => "ok",
                     "status_code" =>  "200",
                     "contactName" =>  $post['contactName'],
                     "contactid"=> $values[1]
                  )
               );
            } else
               echo json_encode(
                  array(
                     "msg" => "no",
                     "status_code" =>  "303",
                     "arrayres" => "",
                     "changeid"=> ""
                  )
               );
         }
      } else {

         echo json_encode(
            array(
               "msg" => "not found",
               "status_code" =>  "404"
            )
         );
      }
   }

   // تمام مخاطبین فرد لاگین کننده را از جدول کانتکت فراخوانی میکند
   function update_contact_data()

   {
      $stmt = "SELECT * FROM contact WHERE userid=?";
      $params = array($_SESSION['id']);
      $res = $this->doSelect($stmt, $params);
      if (sizeof($res) != 0) {
         echo json_encode(
            array(
               "msg" => "ok",
               "status_code" =>  "200",
               "res" => $res
            )
         );
      } else {
         echo json_encode(
            array(
               "msg" => "no",
               "status_code" =>  "303",
               "res" => ""
            )
         );
      }
   }


   // با فرمان کاربر نام مخاطب را در جدول کانتکت تغییر میدهد
   function change_contact_data($post)
   {
     $id= $post['changenametable'];
   $sql = "UPDATE contact SET name=? where contactid=$id";
      $values = array($post['changename']);
      $this->doQuery($sql, $values); 
      
      
   }


// ثبت پیامها در جدول مسیج
   function chat($post)
   {
$message = $post['message'];
$contactid = $post['contactid'];
      $sql = "INSERT INTO message (sendId, getId, text,date) VALUES (?, ?, ?,?)";
      $values = array($_SESSION['id'], $contactid, $message,self::jalali_date("Y/m/d  h:i:s")); 
      $this->doQuery($sql, $values);


      $sql = "SELECT * FROM message WHERE (sendId=? AND getId=? AND text=?) ";
      $params = array( $_SESSION['id'], $contactid, $message);
      $Message = $this->doSelect($sql, $params);file_put_contents("meh.json",print_r( $Message,true));
    echo json_encode(array("Message" => $Message,
                            "userid"=>$_SESSION['id'],
                            "contactid"=> $contactid
                              )); 
 }

// تمام پیامهای بین مخاطب مذکور و فرد لاگین کننده را برمیگرداند و بصورت ارایه بازمیگرداند
function viewchat($post){
   $contactid = $post['contactid'];
   $userid=$_SESSION['id'];

   $sql = "SELECT * FROM message WHERE (sendId=? AND getId=?) OR ( sendId=? AND getId=? )";
$params = array($userid, $contactid,$contactid,$userid);
$arrayMessages = $this->doSelect($sql, $params);
// file_put_contents("meh.json",print_r( $arrayMessages,true));
if (sizeof($arrayMessages) > 0) {
   echo json_encode(
      array(
      "arrayMessages" => $arrayMessages, 
       "userid"=>$userid,
      "contactid"=> $contactid
     
));
}
    
}



// حذف
function del($post){
   $contactid = $post['contactid'];
   $userid=$_SESSION['id'];

$sql = "DELETE FROM users WHERE id=?";
$params = array($contactid);
$this->doQuery($sql, $params);

$sql = "DELETE FROM contact WHERE contactid=?";
$params = array($contactid);
$this->doQuery($sql, $params);

   $sql = "DELETE FROM message WHERE (sendId=? AND getId=?) OR ( sendId=? AND getId=? )";
$params = array($userid, $contactid,$contactid,$userid);
$this->doQuery($sql, $params);
   
}







function editchat($post){
   $contactid = $post['contactid'];
   $sql = "UPDATE message SET text=? where id=$contactid";
   $values = array($post['message']);
   $this->doQuery($sql, $values); 

   
   $sql = "SELECT id,text FROM message WHERE id=?";
$params = array($contactid);
$arrayMessages = $this->doSelect($sql, $params);
file_put_contents("meh.json",print_r( $arrayMessages,true));
   echo json_encode(
      array(
         "id"=>$arrayMessages[0][id],
        "text"=> $arrayMessages[0][text]
));
}



function delchat($post){
$id = $post['id'];
$sql = "DELETE FROM message WHERE id=? ";
$params = array($id);
$this->doQuery($sql, $params);
echo json_encode(
   array(
      "id"=>$id
   
)); 
}


// self::jalali_date("Y/m/d  h:i:s")
// self::jalali_date("h:i:s")  
}
