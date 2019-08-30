<!DOCTYPE html>
<html>
<head>
<title>DATA LEMBUR</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container">
        <br />
        <h3 align="center"><strong>DATA LEMBUR</strong></h3>
        <br />

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><center>NO</center></th>
                        <th><center>NIP</center></th>
                        <th><center>NAMA</center></th>
                        <th><center>DIVISI</center></th>
                        <th><center>HARI</center></th>
                        <th><center>TANGGAL MULAI</center></th>
                        <th><center>JAM MULAI</center></th>
                        <th><center>TANGGAL SELESAI</center></th>
                        <th><center>JAM SELESAI</center></th>
                        <th><center>ESTIMASI JAM</center></th>
                        <th><center>GAJI</center></th>
                        <th><center>LEADER</center></th>
                        <th><center>KETERANGAN</center></th>
                        <th><center>STATUS</center></th>
                        <th><center>ACTION</center></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</body>
</html>


<div id="apicrudModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="api_crud_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                        <div class="form-group">
                            <label>ID PENGAJUAN</label>
                            <input type="text" name="id_pengajuan" id="id_pengajuan" class="form-control" readonly="" />
                        </div>
                            <label>NIP</label>
                            <input type="text" name="nip" id="nip" onkeyup="isi_otomatis()" class="form-control" readonly="" /> 
                        </div>
                        <div class="form-group">
                            <label>NAMA</label>
                            <input type="text" name="nama" id="nama" class="form-control" readonly="" />
                        </div>
                        <div class="form-group">
                            <label>DIVISI</label>
                            <input type="text" name="divisi" id="divisi" class="form-control" readonly="" />
                        </div>
                        <div class="form-group">
                            <label>HARI</label>
                            <input type="text" name="hari" id="hari" class="form-control" readonly="" />
                        </div>
                        <div class="form-group">
                            <label>TANGGAL</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" readonly="" />
                        </div>
                        <div class="form-group">
                            <label>JAM MULAI</label><br />
                            <input type="time" name="jam_mulai" id="jam_mulai" class="timepicker" readonly="" />
                        </div>
                        <div class="form-group">
                            <label>TANGGAL SELESAI</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" readonly="" />
                        </div>
                        <div class="form-group">
                            <label>JAM SELESAI</label><br />
                            <input type="time" name="jam_selesai" id="jam_selesai" class="timepicker" readonly="" />
                        </div>
                        <div class="form-group">
                            <label>LEADER</label>
                            <select name="leader" id="leader" class="form-control" readonly="">
                                    <option value="">Pilih Leader</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>KETERANGAN</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Berikan Alasan" readonly=""></textarea>
                        </div>
                        <div class="form-group">
                            <label>GAJI</label><br />
                            <input type="text" name="gaji" id="gaji" class="form-control" readonly="" />
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="btn_accept" id="btn_accept" class="btn btn-success"  >Accept</button>
                    <button type="button" name="btn_reject" id="btn_reject" class="btn btn-danger"  >Reject</button>
                </div>
            </form>
        </div>
    </div>
</diV>

<script type="text/javascript">

    function isi_otomatis(){
        var nip = $('#nip').val();
        var action = 'fetch_otomatis'
        $.ajax({
            url:"../api/ControllerPengajuan.php",
            method:"POST",
            data:"nip="+nip+"&action="+action,
            success:function(data){
                var objResult = JSON.parse(data);
                if(objResult.status == "ok"){
                        $.each(objResult.result, function(key, val) {
                            $('#nama').val(val.nama);
                            $('#divisi').val(val.nama_divisi);
                            $('#gaji').val(val.gaji);
                        })
                    } 
                console.log(data);
            }
        })
    }

    $(document).ready(function(){
        $.ajax({
            url:"../api/ControllerPM.php",
            method:"POST",
            data:"action=fetch_datapm",
            success:function(data){
                var objResult = JSON.parse(data);
                if(objResult.status == "ok"){
                    $.each(objResult.result, function(key, val){
                        var data = "<option value='"+val.id_pm+"'>"+val.nama_pm+"</option>";
                        var dataHandler = $('#leader');
                        dataHandler.append(data);
                    })
                }
            }
        })

        fetch_data();

        function fetch_data(){
            var dataHandler = $('tbody');
            dataHandler.html("");
            $.ajax({
                url: "../api/ControllerPengajuan.php",
                method: "POST",
                data: "action=fetch_datapengajuan",
                success:function(data){
                    var objResult = JSON.parse(data);
                    if(objResult.status == "ok"){
                        var no = 1;
                        $.each(objResult.result, function(key, val){
                            var data = $("<tr>");
                            data.html("<td align='center'>"+no+"</td> <td align='center'>"+val.nip
                            +"</td> <td align='center'>"+val.nama+"</td> <td align='center'>"+val.nama_divisi
                            +"</td> <td align='center'>"+val.hari+"</td>" 
                            +"</td> <td align='center'>"+val.tanggal+"</td>" 
                            +"</td> <td align='center'>"+val.jam_mulai+"</td>" 
                            +"</td> <td align='center'>"+val.tanggal_selesai+"</td>" 
                            +"</td> <td align='center'>"+val.jam_selesai+"</td>" 
                            +"</td> <td align='center'>"+val.estimasi_jam+"</td>" 
                            +"</td> <td align='center'>"+val.gaji+"</td>" 
                            +"</td> <td align='center'>"+val.nama_pm+"</td>" 
                            +"</td> <td align='center'>"+val.keterangan+"</td>" 
                            +"</td> <td align='center'><button type='button' name='status' class='btn btn-success btn-xs edit' id='"+val.status+"'>"+val.status+"</button></td>" 
                            +"</td> <td align='center'>" 
                            +"<button type='button' name='edit' class='btn btn-primary btn-xs edit' id='"+val.id_pengajuan+"'>Konfirmasi</button></td>");
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

        $('#api_crud_form').on('submit', function(event){
            event.preventDefault();
            if($('#nip').val() == ''){
                alert("Masukkan NIP");
            }
            else if($('#nama').val() == ''){
                alert("Masukkan NAMA");
            }
            else if($('#divisi').val() == ''){
                alert("Masukkan DIVISI");
            }
            else if($('#hari').val() == ''){
                alert("Masukkan HARI");
            }
            else if($('#tanggal').val() == ''){
                alert("Masukkan TANGGAL");
            }
            else if($('#jam_mulai').val() == ''){
                alert("Masukkan JAM MULAI");
            }
            else if($('#tanggal_selesai').val() == ''){
                alert("Masukkan TANGGAL SELESAI");
            }
            else if($('#jam_selesai').val() == ''){
                alert("Masukkan JAM SELESAI");
            }
            else if($('#leader').val() == ''){
                alert("Masukkan LEADER");
            }
            else if($('#keterangan').val() == ''){
                alert("Masukkan KETERANGAN");
            }
            else{
                var form_data = $(this).serialize();
                $.ajax({
                    url:"../api/ControllerPengajuan.php",
                    method:"POST",
                    data:form_data,
                    success:function(data){
                        fetch_data();
                        $('#api_crud_form')[0].reset();
                        $('#apicrudModal').modal('hide');
                        console.log(data);
                        if(data == 'update_pengajuan'){
                            alert("Data telah terubah menggunakan PHP API");
                        } 
                        if(data == 'tolak_pengajuan'){
                            alert("Data telah terubah menggunakan PHP API");
                        } 
                    }
                });
            }
        });  

       $(document).on('click', '.edit', function(){
            var id_pengajuan = $(this).attr('id');
            var action ='fetch_singlepengajuan';
            $.ajax({
                url:"../api/ControllerPengajuan.php",
                method:"POST",
                data:"id_pengajuan="+id_pengajuan+"&action="+action,
                success:function(data){
                    $('#id_pengajuan').val(id_pengajuan);
                    $('.modal-title').text('Edit Data');
                    $('#apicrudModal').modal('show');
                   var objResult = JSON.parse(data);
                    if(objResult.status == "ok"){
                        $.each(objResult.result, function(key, val) {
                            $('#nip').val(val.nip);
                            $('#nama').val(val.nama);
                            $('#divisi').val(val.nama_divisi);
                            $('#hari').val(val.hari);
                            $('#tanggal').val(val.tanggal);
                            $('#jam_mulai').val(val.jam_mulai);
                            $('#tanggal_selesai').val(val.tanggal_selesai);
                            $('#jam_selesai').val(val.jam_selesai);
                            $('#leader').val(val.leader);
                            $('#keterangan').val(val.keterangan);
                            $('#gaji').val(val.gaji);
                        })
                    } 
                    console.log(data);
                }
            })
        });

        $(document).on('click', '.status', function(){
            var status = $(this).attr('id');
            var action ='fetch_singlepengajuan';
            $.ajax({
                url:"../api/ControllerPengajuan.php",
                method:"POST",
                data:"status="+status+"&action="+action,
                success:function(data){
                    $('#id_pengajuan').val(id_pengajuan);
                    $('.modal-title').text('Cetak Data');
                    $('#apicrudModal').modal('show');
                   var objResult = JSON.parse(data);
                    if(objResult.status == "ok"){
                        $.each(objResult.result, function(key, val) {
                            $('#nip').val(val.nip);
                            $('#nama').val(val.nama);
                            $('#divisi').val(val.nama_divisi);
                            $('#hari').val(val.hari);
                            $('#tanggal').val(val.tanggal);
                            $('#jam_mulai').val(val.jam_mulai);
                            $('#tanggal_selesai').val(val.tanggal_selesai);
                            $('#jam_selesai').val(val.jam_selesai);
                            $('#leader').val(val.leader);
                            $('#keterangan').val(val.keterangan);
                            $('#gaji').val(val.gaji);
                        })
                    } 
                    console.log(data);
                }
            })
        });

        $('#apicrudModal').on('click', '#btn_accept', function(){
            var id_pengajuan = $('#id_pengajuan').val();

            if (confirm("Apakah anda yakin menyetujuinya?")){
                $.ajax({
                    url:"../api/ControllerPengajuan.php",
                    method:"POST",
                    data:"id_pengajuan="+id_pengajuan+"&action=terima_pengajuan&status=Disetujui",
                    success:function(data){
                        var objResult = JSON.parse(data);
                        if(objResult.status == "ok"){
                            $('#apicrudModal').modal('hide');
                            fetch_data();
                        console.log(data);
                        }
                    }
                })
            }
        }) 

        $('#apicrudModal').on('click', '#btn_reject', function(){
            var id_pengajuan = $('#id_pengajuan').val();

            if(confirm("Apakah anda yakin menolaknya?")){
                $.ajax({
                    url:"../api/ControllerPengajuan.php",
                    method:"POST",
                    data:"id_pengajuan="+id_pengajuan+"&action=tolak_pengajuan"+"&status=Ditolak",
                    success:function(data){
                        var objResult = JSON.parse(data);
                        if(objResult.status == "ok"){
                            $('#apicrudModal').modal('hide');
                            fetch_data();
                        console.log(data);
                        }
                    }
                })
            }
        })

    });


</script>