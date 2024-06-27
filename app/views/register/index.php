<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <base href="<?= URL; ?>">

    <link rel="stylesheet" href="public/css/style2.css">

</head>

<body>
    <form class="login" onsubmit="return false;">
        <h1>register</h1>
        <div id="div">
          
            <input type="text" id="username" placeholder="091533....." maxlength="11" required>
        </div>
      
        <input type="password" id="password" placeholder="   password" required>

        <input type="password" id="configPassword" placeholder="config-password" required>
        <div>
            <a href="login">login</a>
            <button type="submit" id="btn">register</button>

        </div>

        <span id="showerror" style="visibility: hidden;"></span>


    </form>

    <script src="public/js/jquery-3.4.1.min.js"></script>
    <script>
        //اگر فیلدهای ضروری پر نشوند در زیر انها پیامی ظاهر خواهد شد
        document.addEventListener("DOMContentLoaded", function() {
            var elements = document.getElementsByTagName("input");
            for (var i = 0; i < elements.length; i++) {
                elements[i].oninvalid = function(e) {
                    e.target.setCustomValidity("");
                    if (!e.target.validity.valid) {
                        e.target.setCustomValidity("پر کردن این فیلد الزامیست");
                    }
                };
                elements[i].oninput = function(e) {
                    e.target.setCustomValidity("");
                };
            }
        })


        // اعتبار سنجی پسور وارد شده
        function CheckPassword(inputtxt) {
            var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
            if (inputtxt.match(passw)) {

                return true;
            } else {

                return false;
            }
        }

        ///اعتبار سنجی شماره تلفن همراه در ایران
        function Checkphone(phone) {
            var regex = new RegExp("^(\\+98|0)?9\\d{9}$");
            var result = regex.test(phone);
            return result;
        }

        ///اگر کلید اینتر را بزنیم مانند دکمه سابمیت عمل میکند 
        $("#btn").on('keypress', function(e) {
            if (e.which == 13) {
                $('form#btn').submit();
                return false;
            }
        });


        ///شروع
        // با زدن کلید رجیستر تابع زیر اجرا میشود و اطلاعات در جدول یوزر ثبت میشود
        $("#btn").on('click', function() {
            var username = document.getElementById("username").value;

            var password = document.getElementById("password").value;

            var configPassword = document.getElementById("configPassword").value;
// شروع اعتبار سنجی فیلدها
            if (Checkphone(username) == false) {
                document.getElementById("showerror").style.visibility = "visible";
                $("#showerror").text(" فرمت موبایل رعایت نشده است")
                
            } else if (password !== configPassword) {
                document.getElementById("showerror").style.visibility = "visible";
                $("#showerror").text("تکرار پسورد اشتباه است");
                document.getElementById("configPassword").value = "";
            } else if (CheckPassword(password) == false) {
                document.getElementById("showerror").style.visibility = "visible";
                $("#showerror").text(" پسورد باید بین 6 تا 20 کاراکتر و شامل حروف کوچک و بزرگ انگلیسی , اعداد باشد");
                document.getElementById("password").value = "";
                document.getElementById("configPassword").value = "";
// پایان اعتبار سنجی فیلدها 
// و شروع عملیات ار سال و اضافه کردن اطلاعات به جدول
            } else {
                $.ajax({
                    url: "<?= URL; ?>register/insert_data",
                    type: "POST",
                    data: {
                        "username": username,
                        "password": password,
                        "configPassword": configPassword
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status_code == "404") {
                            // خطای 404 یعنی کاربر قبلا ثبت نام کرده
                            window.location = "<?= URL; ?>login";
                        } else {
                            checkregister = "ok";
                            // عملیات ثبت نام کاربر با موفقیت انجام شد
                            window.location = "<?= URL; ?>login";
                        }
                    },
                    error: function(response) {
                        alert("خطای 500");
                        // خطای 500 یعنی نقص فنی در ارسال ایجکس وجود دارد
                    }
                });
            }
        });
    </script>
</body>

</html>