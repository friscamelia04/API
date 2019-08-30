<!DOCTYPE html>
<html>
<head>
<title>PENGAJUAN PEGAWAI</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<?php
    include_once ('../api/models/ModelKaryawan.php');
        $lib=new Karyawan;
        $row = $lib->auto();

        function autonumber($id_terakhir, $panjang_kode, $panjang_angka){
        $angka = substr($id_terakhir, $panjang_kode, $panjang_angka);
        $angka_baru = str_repeat("0", $panjang_angka - strlen($angka+1)).($angka+1);
        $id_baru = "TTX".$angka_baru;

        return $id_baru;
        }
        $id_pegawai = autonumber($row['nip'], 3, 3);
?>

</head>
<body>

    <div class="container">
        <br />
        <h3 align="center"><strong>PENGAJUAN PEGAWAI</strong></h3>
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
                        <th><center>ALAMAT</center></th>
                        <th><center>NO TELP</center></th>
                        <th><center>DIVISI</center></th>
                        <th><center>GAJI</center></th>
                        <th><center>ACTION</center></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div align=left style="margin-bottom:5px;">
         <a href="CetakPegawai.php"> <button type="button" class="btn btn-warning btn-xs">Cetak ke PDF</button> </a>
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
                            <label>NIP</label>
                           <input type="text" name="nip" id="nip" class="form-control" value="<?php echo $id_pegawai; ?>" readonly="" />
                        </div>
                        <div class="form-group">
                            <label>NAMA</label>
                            <input type="text" name="nama" id="nama" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>NO TELP</label>
                            <input type="text" name="no_telp" id="no_telp" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>ALAMAT</label>
                            <input type="text" name="alamat" id="alamat" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>DIVISI</label>
                            <select name="id_divisi" id="id_divisi" class="form-control">
                                    <option value="">Pilih Divisi</option>
                            </select> 
                        </div> 
                        <div class="form-group">
                            <label>GAJI</label>
                            <input type="text" name="gaji" id="gaji" class="form-control" />
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
    $(document).ready(function(){

        $.ajax({
            url:"../api/ControllerDivisi.php",
            method:"POST",
            data:"action=fetch_datadivisi",
            success:function(data){
                var objResult = JSON.parse(data);
                if(objResult.status == "ok"){
                    $.each(objResult.result, function(key,val){
                        var data = "<option value='"+val.id_divisi+"'>"+val.nama_divisi+"</option>";
                        var dataHandler = $('#id_divisi');
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
                            +"</td> <td align='center'>"+val.gaji+"</td>" 
                            +"</td> <td align='center'>" 
                            +"<button type='button' name='edit' class='btn btn-warning btn-xs edit' id='"+val.nip+"'>edit</button>" 
                            +"&nbsp;"+"<button type='button' name='delete' class='btn btn-danger btn-xs delete' id='"+val.nip+"'>delete</button></td>");
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
            $('#action').val('insert_pegawai');
            $('#button_action').val('Insert'); 
            $('.modal-title').text('Add Data');
            $('#apicrudModal').modal('show');
        })

        $('#api_crud_form').on('submit', function(event){
            event.preventDefault();
            if($('#nip').val() == ''){
                alert("Masukkan NIP");
            }
            else if($('#nama').val() == ''){
                alert("Masukkan NAMA");
            }
            else if($('#no_telp').val() == ''){
                alert("Masukkan NO TELEPON");
            }
            else if($('#alamat').val() == ''){
                alert("Masukkan ALAMAT");
            }
            else if($('#id_divisi').val() == ''){
                alert("Masukkan DIVISI");
            }
            else if($('#gaji').val() == ''){
                alert("Masukkan GAJI");
            }
            else{
                var form_data = $(this).serialize();
                $.ajax({
                    url:"../api/ControllerKaryawan.php",
                    method:"POST",
                    data:form_data,
                    success:function(data){
                        fetch_data();
                        $('#api_crud_form')[0].reset();
                        $('#apicrudModal').modal('hide');
                        if(data == 'insert_pegawai'){
                            alert("Data telah dimasukkan menggunakan PHP API");
                        }
                        if(data == 'update_pegawai'){
                            alert("Data telah terubah menggunakan PHP API");
                        }
                        console.log(data);
                    }
                });
            }
        });  

       $(document).on('click', '.edit', function(){
            var nip = $(this).attr('id');
            var action ='fetch_singlepegawai';
            $.ajax({
                url:"../api/ControllerKaryawan.php",
                method:"POST",
                data:"nip="+nip+"&action="+action,
                success:function(data){
                    $('#nip').val(nip);
                    $('#action').val('update_pegawai');
                    $('#button_action').val('Update');
                    $('.modal-title').text('Edit Data');
                    $('#apicrudModal').modal('show');
                   var objResult = JSON.parse(data);
                    if(objResult.status == "ok"){
                        $.each(objResult.result, function(key, val) {
                            $('#nama').val(val.nama);
                            $('#alamat').val(val.alamat);
                            $('#no_telp').val(val.no_telp);
                            $('#id_divisi').val(val.id_divisi);
                            $('#gaji').val(val.gaji);
                        })
                    } 
                    console.log(data);
                }
            })
        }); 

        $(document).on('click', '.delete', function(){
            var nip = $(this).attr('id');
            var action = 'delete_pegawai';
            if(confirm("Apakah Anda yakin ingin menghapusnya?")){
                $.ajax({
                    url:"../api/ControllerKaryawan.php",
                    method:"GET",
                    data:"nip="+nip+"&action="+action,
                    success:function(data){
                        fetch_data();
                        alert("Data telah terhapus"); 
                        console.log(data);
                    }
                })
            }
        }); 

    });


</script>