
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?= URL; ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link rel="stylesheet" href="public/css/font-awesome.min.css">
   
    <!-- <link rel="stylesheet" href="public/css/style3.css">  -->
    <link rel="stylesheet" href="public/css/style4.css">
</head>

<body>
    <div class="container">
        <div class="col-md-4 side">
            <div class="header" >
                <span >فراوین</span>
                <div>
                <i class="fa fa-plus" id="plus"></i>
                <i class="fa fa-refresh" id="refresh"></i>
                <i class="fa fa-trash del" onclick="del()"></i>
                </div>
            </div>
            <ul id="contact">
                
             </ul>
        </div>
        <div class="col-md-8 chat">
            <div class="header">
                <span id="changeNam1"></span>
               
            </div>
            <div class="body" id="msg-card_body">
               
            </div>
            <div class="footer">
                
                <textarea name="" class="form-control type_msg  text" placeholder="... Type your message" id="message"></textarea>
            <a id="sendMessage"><i class="fa fa-send" ></i></a> 
        </div>
        </div>
    </div>
 <!-- modalAdd add ********************************************************************-->
    <div id="modalAdd">
        <div class="content">
            <form onsubmit="return false">
                <i id="close" class="close fas fa-times " style=""></i><br>
                <input type="text" placeholder="name" id="name2" class="contact"><br>
                <input type="text" placeholder=".......0915" id="phone2" class="contact" maxlength="11"><br>
                <button type="submit" id="add" class="contact">add contact</button><br>
                <span id="warning1" style="color: white;display:none;">bbbbbbbbbbb</span>
                <input type="hidden" id="hiddenInput">
            </form>
        </div>
    </div>
<!-- modal change *************************************************************************** -->
    <div id="modalChange">
        <div class="content">
            <form onsubmit="return false">
            <i id="close1" class="close fas fa-times " style=""></i><br>
                <input type="text" placeholder="new name" id="newName" class="contact"><br>

                <button type="submit" id="changeName" class="contact">change name</button><br>
                <span id="warning2" style="display:none;color:white;"></span>
            </form>
        </div>
    </div>
    <!-- ---------------------------------------000000000000000000000000000 -->
   
<!-- ---------------------------------------------000000000000000000000000000000000000000 -->

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="public/js/demo.js"></script>
    <script type="text/javascript" src="public/js/helper.js"></script>
    <script type="text/javascript" src="public/js/bootstrap.min.js"></script>
    <script>
      //update_contact_data // به روزرسانی مخاطبین با اماده شدن سند برنامه
      jQuery(document).ready(function() {
      
    $.ajax({
    url: "<?= URL; ?>index/update_contact_data",
    type: "POST",
    data: {},
    success: function(response) {
        response = JSON.parse(response);

        addContact(response.res);
    },
    error: function(response) {
        alert("خطای 500");
    }
});


// جلوگیری از تداخل جی کویری با کتابخانه های دیگری که از علامت مشابه $ استفاده میکنند با دو خط پایین
    // $.noConflict();
    // jQuery(document).ready(function($){
        var modalAdd = document.getElementById('modalAdd');
        var plus = document.getElementById('plus');
        var add = document.getElementById('add');
        var close = document.getElementById('close');
        var refresh = document.getElementById('refresh');
       
// اعتبار سنجی شماره تلفن
        function Checkphone(phone) {
            var regex = new RegExp("^(\\+98|0)?9\\d{9}$");
            var result = regex.test(phone);
            return result;
        }

          //وقتی مودال باز یا بسته میشود کل فیلدهای ان پاکسازی میشود
          plus.onclick = function() {
            document.getElementById("name2").value = "";
            document.getElementById("phone2").value = "";
            document.getElementById("warning1").style.display = "none";
            modalAdd.style.display = 'block';
        };
//خالی کردن اینپوت ها در هنگام فوکوس
        document.getElementById("name2").onfocus = function() {
            document.getElementById("name2").value = "";
            $("#warning1").text("");
        };
        // خالی کردن اینپوت ها در هنگام فوکوس
        document.getElementById("phone2").onfocus = function() {
            document.getElementById("phone2").value = "";
            $("#warning1").text("");
        };
       

        //add_contact_data// مخاطبین را از مودال میگیرد و توسط تابع اد اچ تی ام ال به ساید بار اضافه میکند 
        add.onclick = function() {
            var contactName = document.getElementById("name2").value;
            var contactPhone = document.getElementById("phone2").value;
            var warning1 = document.getElementById("warning1");

            if (contactName == "" || contactPhone == "") {
                warning1.style.display = "block";
                $("#warning1").text("پر کردن تمامی فیلدها الزامیست");
            } else if (Checkphone(contactPhone) == false) {
                warning1.style.display = "block";
                $("#warning1").text(" فرمت موبایل رعایت نشده است");

            } else {

                $.ajax({
                    url: "<?= URL; ?>index/add_contact_data",
                    type: "POST",
                    data: {
                        "contactName": contactName,
                        "contactPhone": contactPhone

                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status_code == "606") {
                            warning1.style.display = "block";
                            $("#warning1").text("این مخاطب قبلا با نام دیگری به جدول مخاطبان اضافه شده");
                        } else if (response.status_code == "101") {
                            warning1.style.display = "block";
                            $("#warning1").text("اطلاعات خودتان نمیتواند به جدول مخاطبان اضافه شود");
                        } else if (response.status_code == "404") {

                            warning1.style.display = "block";
                            $("#warning1").text("مخاطب را به فراوین دعوت کنید");

                        } else if (response.status_code == "303") {

                            warning1.style.display = "block";
                            $("#warning1").text("این مخاطب قبلا در جدول مخاطبین اضافه شده");

                        } else {

                            warning1.style.display = "block";
                            
                            addHtmlElement(response.contactName ,response.contactid);
                        }
                    },
                    error: function(response) {
                        alert("خطای 500");
                    }
                });
            }
        };


       

        //addHtmlElement------------------------------------------------------------------------------
        // مخاطبین را تک به تک به تابع اد اچ تی ام ال میفرستد تا در نوار ساید بار به نمایش در بیایند
        function addContact(res) {
            $("#contact").empty();
            for (let i = 0; i < res.length; i++) {
                    addHtmlElement(res[i]['name'],res[i]['contactid']);
              }
        }


 var isHiddenInputCreated = false;
function addHtmlElement($name, $contactid) {
    //یک اینپوت از نوی مخفی میسازد و کانتکت ایدی مخاطب کلیک شده را در ان نگهداری میکند
    // اینپوت فقط یکبار ساخته میشود ولی مقدار موجود در ان با کلیک مخاطبین تغییر میکند  
    if (!isHiddenInputCreated) {
          $("<input>").attr("type", "hidden").attr("id", "hiddeninput").appendTo("body");
          $("<input>").attr("type", "hidden").attr("id", "hiddeninput2").appendTo("body");
          $("<input>").attr("type", "hidden").attr("id", "hiddeninput3").appendTo("body");
          isHiddenInputCreated = true;
        }
       
// در ساید بار یک ال ای میسازد و اطلاعات مخاطب را در ان قرار میدهد 
    var li = $("<li>").attr("data-id", $contactid).attr("class", "liclass");
    var buttonHTML = '<p>' + $name + '</p><i class="fa fa-edit " id="edit" onclick="edit()"></i>';
    li.html(buttonHTML);
    $("#contact").append(li);
    $("#modalAdd").css("display", "none");
}
 



// با کلیک بر روی هر مخاطب در ساید بار رنگ ان و نام هدر کانتینر تغییر میکند
// مقدار موجود در اینپوت مخفی هم تغییر میکند
// و تمام پیامهای موجود در کانتینر پاک شده و پیامهای این مخاطب با کمک تابع ویو چت  نمایش داده میشود

$("#contact").on("click", "li", function() {
    load($(this)); // فراخوانی load با المان li کلیک شده
});

// setInterval------------->>>>>>>>>>>>>>>>>
function load($liElement) {
    console.log("صفحه به‌روز شد!");
    $liElement.addClass("active").siblings().removeClass("active");
    var Nam = $liElement.children("p").text();
    $("#changeNam1").text(Nam);
    var contactid = $liElement.data("id");
    // var contactid = $liElement.attr("data-id");
    $("#hiddeninput").val(contactid);
    
//   setInterval(function() {
    $("#msg-card_body").empty();
    $.ajax({
        url: "<?=URL;?>index/viewchat",
        type: "POST",
        data: {
            "contactid": contactid
        },
        success: function(response) {
            response = JSON.parse(response);
            viewChatfunc(response.arrayMessages, response.userid, response.contactid);
        },
        error: function(response) {
            alert("خطای 500");
        }
    });
//   }, 3000);
   
}
// <<<<<<<<<<<<<<<<<-----------------setInterval



// refresh-----------------------------------------------------------------------------------------------
// با کلیک بر روی ان مخاطبین به روز رسانی می شوند
$("#refresh").click(function(){ 

    $.ajax({
    url: "<?= URL; ?>index/update_contact_data",
    type: "POST",
    data: {},
    success: function(response) {
        response = JSON.parse(response);

        addContact(response.res);
    },
    error: function(response) {
        alert("خطای 500");
    }
});
});


//change_contact_data-----------------------------------------------------------------------------------------------------------------
// نام جدید مخاطب را گرفته و در لیست مخاطبین و هدر کانتینر و در جدول کانتکت انرا تغییر می دهد
$("#changeName").click(function() {
            if ($("#newName").val() == "") {
                warning2.style.display = "block";
                $("#warning2").text("پر کردن تمامی فیلدها الزامیست");
            } else {
                var changename=$("#newName").val();

                $("li.active").children("p").text(changename);
                $("#changeNam1").text(changename);
                var changenametable=$("#hiddeninput").val();
            
                $.ajax({
                url: "<?= URL; ?>index/change_contact_data",
                type: "POST",
                data: {
                    "changename":changename,
                    "changenametable":changenametable
                },
                success: function(response) {
                                     
                },
                error: function(response) {
                    alert("خطای 500");
                }
            });
                document.getElementById("modalChange").style.display = 'none';
            }
        });
       




// با کلیک بر روی یک مخاطب پیامهای بین مخاطب و فرد لاگین کننده را در کانتینر به نمایش میگذارد

// function viewChatfunc(arrayMessages, userid, contactid) {

//   try{  
//     $.each(arrayMessages, function(index, message) {
//         var id=message.id;
//         var sendId = message.sendId;
//         var text = message.text;
//         var date = message.date;
//         var div = $("<div>").attr("id", id).addClass("main-div");
//         // var div = $("<div>").attr("id", id).addClass("main-div").on("contextmenu", rightclick);
//         var item = '<div class="f"><span > <pre class="f">'+text+'</pre></span><span class="time">' + date + '</span></div>';
//         $(div).html(item); 
//         $("#msg-card_body").append($(div));
  
//         if (sendId == userid) { 
//         $(div).addClass("left");
//         } else if (sendId == contactid) {
//         console.log(id+"  "+sendId + "  " + text+"  "+"contactid :  "+contactid);
//         $(div).addClass("right");
//         } 
      

//     });
//   } catch (exception) {
//       console.error("606");
//   }   
// }          
                // 
// function viewChatfunc(arrayMessages, userid, contactid) {
//     try {
//         $.each(arrayMessages, function(index, message) {
//             var id = message.id;
//             var sendId = message.sendId;
//             var text = message.text;
//             var date = message.date;
//             var div = $("<div>").attr("data-id", id).addClass("chatdiv");
//             var item = '<pre class="m1">' + text + '</pre><span class="time">' + date + '</span>';
//             $(div).html(item);
//             $("#msg-card_body").append($(div));

//             if (sendId == userid) {
//                 $(div).addClass("right");
//             } else if (sendId == contactid) {
//                 console.log(id + "  " + sendId + "  " + text + "  " + "contactid :  " + contactid);
//                 $(div).addClass("left");
//             }

// // ------------------->>>>>>>>>>>
//  // ایجاد یک منو context
// $(document).on("contextmenu", ".chatdiv", function(e) {
//     e.preventDefault();
//     var w=$(this).data("id");
//     $("#hiddeninput2").val(w); 
//     // مخفی کردن منو context اگر قبلا باز شده باشد
//     $(".custom-context-menu").hide();
    
//     // مخصوص سازی منو context
//     var customContextMenu = $("<div class='custom-context-menu'>\
//                                 <ul>\
//                                     <li class='edit' >ویرایش پیام</li>\
//                                     <li class='delete'>حذف پیام</li>\
//                                 </ul>\
//                               </div>");


   
//     // نمایش منو context در مکان کلیک شده
//     customContextMenu.css({
//         top: e.pageY,
//         left: e.pageX
//     }).appendTo("#msg-card_body").show();

//     // عملکرد گزینه ویرایش
//     $(".edit").on("click", function() {
//       var q = $("#hiddeninput2").val();alert("q = "+q);
//        var y=$("#q .m1").text();alert("y = "+y)
//        $(".text").text(y);
//     });

//     // عملکرد گزینه حذف
//     $(".delete").on("click", function() {
//         // کد حذف پیام
//     });

//     // بستن منو context با کلیک روی صفحه
//     $(document).on("click", function() {
//         $(".custom-context-menu").hide();
//     });
// });

// // جلوگیری از نمایش منو context پیش‌فرض مرورگر
// $(document).on("contextmenu", function() {
//     return false;
// });
// // جلوگیری از نمایش منو context پیش‌فرض مرورگر
// $(document).on("contextmenu", function() {
//     return false;
// });
// // <<<<<<<<<<<<<<<----------------

//         });
//     } catch (exception) {
//         console.error("606");
//     }
// }
           


function viewChatfunc(arrayMessages, userid, contactid) {
    try {
        $.each(arrayMessages, function(index, message) {
            var id = message.id;
            var sendId = message.sendId;
            var text = message.text;
            var date = message.date;
            var div = $("<div>").attr("data-id", id).addClass("chatdiv").attr("id",id);
            var item = '<pre class="m1">' + text + '</pre><span class="time">' + date + '</span>';
            $(div).html(item);
            $("#msg-card_body").append($(div));

            if (sendId == userid) {
                $(div).addClass("right");
            } else if (sendId == contactid) {
                console.log(id + "  " + sendId + "  " + text + "  " + "contactid :  " + contactid);
                $(div).addClass("left");
            }

// ------------------->>>>>>>>>>>
 // ایجاد یک منو context
 $(document).on("contextmenu", "#msg-card_body", function(e) {
    e.preventDefault();
    var targetDiv = $(e.target).closest(".chatdiv");
    var w=targetDiv .data("id");
    $("#hiddeninput2").val(w); 
    $("#hiddeninput3").val(w); 
    // مخفی کردن منو context اگر قبلا باز شده باشد
    $(".custom-context-menu").hide();
    
    // مخصوص سازی منو context
    var customContextMenu = $("<div class='custom-context-menu'>\
                                <ul>\
                                    <li class='edit' >ویرایش پیام</li>\
                                    <li class='del'>حذف پیام</li>\
                                </ul>\
                              </div>");


   
                            //   / نمایش منو context در مکان کلیک شده
        customContextMenu.css({
            top: e.pageY,
            left: e.pageX
        }).appendTo("#msg-card_body").show();

        // عملکرد گزینه ویرایش
        $(".edit").on("click", function() {
            var q = $("#hiddeninput2").val();alert("q = "+q);
            var y = targetDiv.find(".m1").text();alert("y = "+y);
            $(".text").text(y);

        });
    // عملکرد گزینه حذف
    $(".del").on("click", function() {
         var id = $("#hiddeninput3").val();alert("id = "+id);
        
         $.ajax({
                      url: "<?=URL;?>index/delchat",
                      type: "POST",
                      data: {
                              "id":id
                          
                            },
                       success: function(response) {
                                                        response = JSON.parse(response);
                                                        var del= response.id;
                                                        alert(del);
                                                        $("div #del").remove();
                                                   },
                      error: function(response) {
                                                        alert("خطای 500");
                                                 }
                     });

    });

    // بستن منو context با کلیک روی صفحه
    $(document).on("click", function() {
        $(".custom-context-menu").hide();
    });
});


// جلوگیری از نمایش منو context پیش‌فرض مرورگر
$(document).on("contextmenu", function() {
    return false;
});
// <<<<<<<<<<<<<<<----------------

        });
    } catch (exception) {
        console.error("606");
    }
}
      

 //     فرستادن اطلاعات کانتکت و متن پیام ارسالی برای ثبت در جدول مسیج
 $("#sendMessage").click( function() {
    var message = $("#message").val();alert("message = "+message);
    var hi2=   $("#hiddeninput2").val()
        if(hi2=="") {  
              var contactid=   $("#hiddeninput").val(); 
            $.ajax({
                      url: "<?=URL;?>index/chat",
                      type: "POST",
                      data: {
                              "contactid":contactid,
                               "message":message
                            },
                       success: function(response) {
                                                        response = JSON.parse(response);
                                                       
                                                        viewChatfunc( response.Message,response.userid,response.contactid);
                                                          $("#message").val("");

                                                   },
                      error: function(response) {
                                                        alert("خطای 500");
                                                 }
                     });

          }
        else{   
            var contactid=hi2;alert("contactidmmmmmmmmmm = "+contactid);
            // $("#contactid .m1").text(message);
            $.ajax({
                      url: "<?=URL;?>index/editchat",
                      type: "POST",
                      data: {
                              "contactid":contactid,
                               "message":message
                            },
                       success: function(response) {
                                                        response = JSON.parse(response);
                                                         alert(response.id);
                                                        // alert("jjjjjjjjjj");
                                                        //   $("#message").val("");
                                                        var id=response.id;
                                                        var text=response.text;
                                                     

                                                        // alert("y1:"+y1);
                                                   
                                                       
                                                    $("#id .m1").text(text);
                                                    // targetDiv.find(".m1").text( response.message);
                                                        // editmessagefunc( response.message,response.contactid);
                                                       

                                                   },
                      error: function(response) {
                                                        alert("خطای 500");
                                                 }
                     });
        }     
         
      
        

                     $("#hiddeninput2").val("");
                     alert($("#hiddeninput2").val());
    });
           
 // با کلیک بر روی ضربدر مودال اضافه کردن مخاطب را میبندد
        close.onclick = function closeModal() {
            modalAdd.style.display = 'none';
        };

// با کلیک بر روی ضربدر مودال تغییر نام مخاطب را میبندد
        document.getElementById('close1').onclick = function closemodalChange() {
            document.getElementById('modalChange').style.display = 'none';
        };


    });  
    // با کلیک بر روی دکمه ادیت مخاطب مودال مربوط به تغیر نام را نمایش میدهد
    function edit() {
        console.log("f");
    document.getElementById("newName").value = "";
            document.getElementById("warning2").style.display = "block";
            document.getElementById("modalChange").style.display = 'block'; 
        
       }   
       
       
    //   با کلیک بر روی دکمه حذف اطلاعات مخاطب را ازهمه جا پاک میکند
 function del() {
     var contactid = $("li.active").data("id");
     var contactid = $("input#hiddeninput").val();

    $.ajax({
        url: "<?= URL; ?>index/del",
        type: "POST",
        data: {"contactid": contactid},
        success: function(response) {
           
            $("li.active").remove();
           $("#changeNam1").text("");
           $("#msg-card_body").children().remove();
        },
        error: function(response) {
            alert("خطای 500");
        }
    });
}


  </script>
</body>

</html>
