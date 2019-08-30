<!DOCTYPE html>
<html>
<head>
<title>DATA PEGAWAI</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container">
        <br />
        <h3 align="center"><strong>DATA PEGAWAI</strong></h3>
        <br />
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><center>NO</center></th>
                        <th><center>NIP</center></th>
                        <th><center>NAMA</center></th>
                        <th><center>ALAMAT</center></th>
                        <th><center>NO TELP</center></th>
                        <th><center>DIVISI</center></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</body>
</html>

<script type="text/javascript">
        fetch_data();

        function fetch_data(){
            var dataHandler = $('tbody');
            dataHandler.html("");
            $.ajax({
                url: "../api/ControllerKaryawan.php",
                method: "POST",
                data: "action=fetch_datapegawai",
                success:function(data){
                    var objResult = JSON.parse(data);
                    if(objResult.status == "ok"){
                        var no = 1;
                        $.each(objResult.result, function(key, val){
                            var data = $("<tr>");
                            data.html("<td align='center'>"+no+"</td> <td align='center'>"+val.nip
                            +"</td> <td align='center'>"+val.nama+"</td> <td align='center'>"+val.alamat
                            +"</td> <td align='center'>"+"0"+val.no_telp+"</td>" 
                            +"</td> <td align='center'>"+val.nama_divisi+"</td>" 
                            +"</td> ");
                            dataHandler.append(data);
                            no++;
                        })   
                    }
                    else {
                        alert("Data Tidak Ditemukan");
                    } 
                    console.log(data);
                }
            })
        }

</script>
