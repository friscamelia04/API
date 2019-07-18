<!DOCTYPE HTML>
<body>
<head>
<title>FORM LOGIN</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<form action="" method="POST" id="form_login">
        <table align="center">
            <br />
            <h3><center>LOGIN</center></h3>
            <br />
            <tr>
                <td> <label>Username</label></td>
                <td><input type="text" placeholder="enter username" name="username" id="username"></td>
            </tr>
            <tr>
                <td><label>Password</label></td>
                <td><input type="password" placeholder="enter password" name="pass" id="pass"></td>
            </tr>
            <tr>
                <td><input type="hidden" name="action" id="action" value="login"></td>
                <td><input type="submit" name="btn_login" id="btn_login" value="LOGIN"></td>
            </tr>
        </table>
</form>
</body>

<script type="text/javascript">
    $(document).ready(function(){
        $('#form_login').on('submit', function(event){
            event.preventDefault();
            if($('#username').val() == ""){
                alert("Enter Username");
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
                            alert("Berhasil Login");
                            window.location.href="Index.php";
                        }
                        else if(response.status == "error"){
                            window.location.href="FormLogin.php";
                            alert("Gagal Login");
                        } 
                       // console.log(data);
                    }
                })
            }
        });
    });

</script>