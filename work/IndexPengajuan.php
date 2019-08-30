<!DOCTYPE html>
<html>
<head>
<title>PENGAJUAN LEMBUR</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<?php
    include_once ('../api/models/ModelPengajuan.php');
        $lib=new Pengajuan;
        $data = $lib->auto_idpengajuan();

        function autonumber($id_terakhir, $panjang_kode, $panjang_angka){
        $angka = substr($id_terakhir, $panjang_kode, $panjang_angka);
        $angka_baru = str_repeat("0", $panjang_angka - strlen($angka+1)).($angka+1);
        $id_baru = "PNG".$angka_baru;

        return $id_baru;
        }
        $id_pengajuan = autonumber($data['id_pengajuan'], 3, 3);
?>

</head>
<body>

    <div class="container">
        <br />
        <h3 align="center"><strong>PENGAJUAN LEMBUR</strong></h3>
        <br />
        <div align="right" style="margin-bottom:5px;">
            <button type="button" name="add_button" id="add_button"
            class="btn btn-success btn-xs">ADD</button>
        </div>

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
                            <input type="text" name="id_pengajuan" id="id_pengajuan" class="form-control" value="<?php echo $id_pengajuan; ?>" readonly="" />
                        </div>
                            <label>NIP</label>
                            <input type="text" name="nip" id="nip" onkeyup="isi_otomatis()" class="form-control" /> 
                         <!--   <select name="nip" id="nip" onkeyup="isi_otomatis()" class="form-control">
                                    <option value="">Pilih NIP</option>
                            </select> -->
                        </div>
                        <div class="form-group">
                            <label>NAMA</label>
                            <input type="text" name="nama" id="nama" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>DIVISI</label>
                            <input type="text" name="divisi" id="divisi" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>HARI</label>
                            <input type="text" name="hari" id="hari" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>TANGGAL</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>JAM MULAI</label><br />
                            <input type="time" name="jam_mulai" id="jam_mulai" class="timepicker" />
                        </div>
                        <div class="form-group">
                            <label>TANGGAL SELESAI</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>JAM SELESAI</label><br />
                            <input type="time" name="jam_selesai" id="jam_selesai" class="timepicker" />
                        </div>
                        <div class="form-group">
                            <label>LEADER</label>
                            <select name="leader" id="leader" class="form-control">
                                    <option value="">Pilih Leader</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>KETERANGAN</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Berikan Alasan"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="insert" />
                    <input type="submit" name="button_action" id="button_action" class="btn btn-info" value="Insert" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                            $('#divisi').val(val.id_divisi);
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
                            +"</td> <td align='center'><button type='button' name='status' class='btn btn-success btn-xs' id='"+val.status+"' disabled >"+val.status+"</button></td>" 
                            +"</td>");
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

        $('#add_button').click(function(){
            $('#action').val('insert_pengajuan');
            $('#button_action').val('Insert'); 
            $('.modal-title').text('Add Data');
            $('#apicrudModal').modal('show');
        });

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
            else if($('#gaji').val() == ''){
                alert("Masukkan GAJI");
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
                        if(data == 'insert_pengajuan'){
                            alert("Data telah dimasukkan menggunakan PHP API");
                        }
                    }
                });
            }
        });   

    });


</script>