

<!DOCTYPE html >
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <base href="<?= URL; ?>">

    <link rel="stylesheet" href="public/css/style.css">
</head>

<body >
    <!-- فرم لاگین ***************************************************************************-->
    <form class="login" onsubmit="return false;">
        <h1>login</h1>
        <input type="text" id="username" placeholder="0915......." maxlength="11" required >
        <input type="password" id="password" placeholder="password" required >
        <div>
            <button type="submit" id="btn" class="btn">login</button>
            <a href="register" class="btn">register</a>
        </div>
        <span id="showerror" style="visibility: hidden;"></span>

    </form>


<!-- اضافه کردن جی کویری -->
    <script src="public/js/jquery-3.4.1.min.js"></script>
<!-- شروع اسکریپت نویسی -->
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


        // اعتبار سنجی پسورد وارد شده
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




    $("#btn").on('click',function (){
          var username = document.getElementById("username").value;
          var password = document.getElementById("password").value;

        
              $.ajax({
                  url: "<?= URL; ?>login/check_data",
                  type: "POST",
                  data: {
                      "username": username,
                      "password": password
                  },
                  success: function (response){
                      response = JSON.parse(response);
                    
                       if(response.status_code == "404"){
                        document.getElementById("showerror").style.visibility = "visible";
                          $("#showerror").text(".شما هنوز ثبت نام نکرده اید");
                         
                      }else{
                        // اگر فرد قبلا ثبت نام کرده و لاگین هم به درستی انجام شود به صفحه اصلی فرستاده میشود
                          window.location = "<?=URL;?>";
                      }
                  },
                  error: function (response) {
                      alert("خطای ajax");
                  }
              });
          }
        
    );
</script>

</body>

</html>




























<!-- hi login page
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <base href="<?= URL; ?>">

    <link rel="stylesheet" href="public/css/style.css">

</head>

<body>
    <form class="login" onsubmit="return false;">
        <h1>ورود</h1>
        <div>
       <div> <lable for="username">شماره موبایل</lable></div>
       <div> <input type="text" id="username" name="username" placeholder="09........." pattern="09(0[1-2]|1[0-9]|3[0-9]|2[0-1])-?[0-9]{3}-?[0-9]{4}"></div></div>
        <lable for="password">رمز عبور</lable>
        رمز عبور  :<input type="password" id="password" name="password"  placeholder=" رمز عبور">
        
        
        <span id="showerror"></span>
        <button type="submit" id="btn">ورود</button>

    </form>


<script src="public/js/jquery-3.4.1.min.js"></script>

<script>
    function CheckPassword(inputtxt)
    {
        var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
        if(inputtxt.value.match(passw))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    $("#btn").on('click',function (){
          var username = document.getElementById("username").value;
          var password = document.getElementById("password").value;

          if(username == ""){
              $("#showError").text("Username is empty");
          } else if (password == ""){
              $("#showError").text("Password is empty");
          } else if (!CheckPassword(password)){
              $("#showError").text("Password is not secure");
          } else {
              $.ajax({
                  url: "<?= URL; ?>login/check_data",
                  type: "POST",
                  data: {
                      "username": username,
                      "password": password
                  },
                  success: function (response){
                      response = JSON.parse(response);
                      if(response.status_code == "404"){
                          $("#showError").text("Username or Password is wrong");
                      } else {
                          window.location = "<?= URL; ?>";
                      }
                  },
                  error: function (response) {
                      alert("dsgdgfdgdfgd");
                  }
              });
          }
        }
    );
</script>

</body>
</html> -->