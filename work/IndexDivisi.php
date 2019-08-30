<!DOCTYPE html>
<html>
<head>
<title>DATA DIVISI</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<?php
    include_once ('../api/models/ModelDivisi.php');
        $lib=new Divisi;
        $data = $lib->auto_increment();

        function autonumber($id_terakhir, $panjang_kode, $panjang_angka){
        $angka = substr($id_terakhir, $panjang_kode, $panjang_angka);
        $angka_baru = str_repeat("0", $panjang_angka - strlen($angka+1)).($angka+1);
        $id_baru = "DIV".$angka_baru;

        return $id_baru;
        }
        $id_divisi = autonumber($data['id_divisi'], 3, 3);
?> 

</head>
<body>

    <div class="container">
        <br />
        <h3 align="center"><strong>DATA DIVISI</strong></h3>
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
                        <th><center>ID DIVISI</center></th>
                        <th><center>NAMA DIVISI</center></th>
                        <th><center>ACTION</center></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div align="left" style="margin-bottom:5px;">
            <a href="CetakDivisi.php"> <button type="button" class="btn btn-warning btn-xs">Cetak ke PDF</button> </a>
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
                            <label>ID DIVISI</label>
                            <input type="text" name="id_divisi" id="id_divisi" class="form-control" value="<?php echo $id_divisi; ?>" readonly="" />
                        </div>
                        <div class="form-group">
                            <label>NAMA DIVISI</label>
                            <input type="text" name="nama_divisi" id="nama_divisi" class="form-control" />
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

        fetch_data();

        function fetch_data(){
            var dataHandler = $('tbody');
            dataHandler.html("");
            $.ajax({
                url: "../api/ControllerDivisi.php",
                method: "POST",
                data: "action=fetch_datadivisi",
                success:function(data){
                    var objResult = JSON.parse(data);
                    if(objResult.status == "ok"){
                        var no = 1;
                        $.each(objResult.result, function(key, val){
                            var data = $("<tr>");
                            data.html("<td align='center'>"+no+"</td> <td align='center'>"+val.id_divisi
                            +"</td> <td align='center'>"+val.nama_divisi+"</td> <td align='center'>"
                            +"<button type='button' name='edit' class='btn btn-warning btn-xs edit' id='"+val.id_divisi+"'>edit</button>" 
                            +"&nbsp;"+"<button type='button' name='delete' class='btn btn-danger btn-xs delete' id='"+val.id_divisi+"'>delete</button></td>");
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
            $('#action').val('insert_divisi');
            $('#button_action').val('Insert'); 
            $('.modal-title').text('Add Data');
            $('#apicrudModal').modal('show');
        });

        $('#api_crud_form').on('submit', function(event){
            event.preventDefault();
            if($('#nama_divisi').val() == ''){
                alert("Masukkan Nama Divisi");
            }
            else{
                var form_data = $(this).serialize();
                $.ajax({
                    url:"../api/ControllerDivisi.php",
                    method:"POST",
                    data:form_data,
                    success:function(data){
                        fetch_data();
                        $('#api_crud_form')[0].reset();
                        $('#apicrudModal').modal('hide');
                        if(data == 'insert_divisi'){
                            alert("Data telah dimasukkan menggunakan PHP API");
                        }
                        if(data == 'update_divisi'){
                            alert("Data telah terubah menggunakan PHP API");
                        }
                        console.log(data);
                    }
                });
            }
        }); 

       $(document).on('click', '.edit', function(){
            var id_divisi = $(this).attr('id');
            var action ='fetch_singledivisi';
            $.ajax({
                url:"../api/ControllerDivisi.php",
                method:"POST",
                data:"id_divisi="+id_divisi+"&action="+action,
                success:function(data){
                    $('#id_divisi').val(id_divisi);
                    $('#action').val('update_divisi');
                    $('#button_action').val('Update');
                    $('.modal-title').text('Edit Data');
                    $('#apicrudModal').modal('show');
                   var objResult = JSON.parse(data);
                    if(objResult.status == "ok"){
                        $.each(objResult.result, function(key, val) {
                            $('#nama_divisi').val(val.nama_divisi);
                        })
                    } 
                    console.log(data);
                }
            })
        }); 

        $(document).on('click', '.delete', function(){
            var id_divisi = $(this).attr('id');
            var action = 'delete_divisi';
            if(confirm("Apakah Anda yakin ingin menghapusnya?")){
                $.ajax({
                    url:"../api/ControllerDivisi.php",
                    method:"GET",
                    data:"id_divisi="+id_divisi+"&action="+action,
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