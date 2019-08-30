<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
<form action="" method="POST" id="form_login">
    <div class="login-box">
        <h1>Login</h1>
        <div class="textbox">
            <i class="fa fa-user" aria-hidden="true"></i>
            <input type="text" placeholder="Username or NIP" id="username" name="username">
        </div>
        <div class="textbox">
            <i class="fa fa-lock" aria-hidden="true"></i>
            <input type="password" placeholder="Password" id="pass" name="pass">
        </div>
        <td><input type="hidden" name="action" id="action" value="login"></td>
        <td><input class="btn" type="submit" name="btn_login" id="btn_login" value="LOGIN"></td>
    </div>
</form>

</body>

</html>

<script type="text/javascript">
    $(document).ready(function(){
        $('#form_login').on('submit', function(event){
            event.preventDefault();
            if($('#username').val() == ""){
                alert("Enter Username or Nip");
            }
            else if($('#pass').val() == ""){
                alert("Enter Password");
            }
            else{
                var form_data = $(this).serialize();
                $.ajax({
                    url:"../api/ControllerKaryawan.php",
                    method:"POST",
                    data:form_data,
                    success:function(data){
                        var response = JSON.parse(data);
                        if(response.status == "ok"){
                            $.each(response.result , function(key, val){
                                var level = val.level_pegawai;
                                alert("Berhasil Login");
                                if(level == "HRD"){
                                    window.location.href="LevelHRD.php";
                                }
                                else if(level == "ATASAN"){
                                    window.location.href="LevelPegawai.php";
                                }
                                else{
                                    window.location.href="LevelPegawai.php";
                                }
                            }) 
                        }
                        else if(response.status == "error"){
                            window.location.href="FormLogin.php";
                            alert("Gagal Login");
                        }  
                        console.log(data);
                    }
                })
            }
        });
    });

</script>