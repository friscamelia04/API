<!DOCTYPE html>
<html>
<head>
<title>DATA PM</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<?php
    include_once ('../api/models/ModelPM.php');
        $lib = new PM;
        $row = $lib->auto_increment();

        function autonumber($id_terakhir, $panjang_kode, $panjang_angka){
        $angka = substr($id_terakhir, $panjang_kode, $panjang_angka);
        $angka_baru = str_repeat("0", $panjang_angka - strlen($angka+1)).($angka+1);
        $id_baru = "PM".$angka_baru;

        return $id_baru;
        }
        $id_pm = autonumber($row['id_pm'], 2, 3);
?> 

</head>
<body>

    <div class="container">
        <br />
        <h3 align="center"><strong>DATA PM</strong></h3>
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
                        <th><center>ID PM</center></th>
                        <th><center>NAMA PM</center></th>
                        <th><center>ACTION</center></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div align="left" style="margin-bottom:5px;">
            <a href="CetakPM.php"> <button type="button" class="btn btn-warning btn-xs">Cetak ke PDF</button> </a>
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
                            <label>ID PM</label>
                            <input type="text" name="id_pm" id="id_pm" class="form-control" value="<?php echo $id_pm; ?>" readonly="" />
                        </div>
                        <div class="form-group">
                            <label>NAMA PM</label>
                            <input type="text" name="nama_pm" id="nama_pm" class="form-control" />
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
                url: "../api/ControllerPM.php",
                method: "POST",
                data: "action=fetch_datapm",
                success:function(data){
                    var objResult = JSON.parse(data);
                    if(objResult.status == "ok"){
                        var no = 1;
                        $.each(objResult.result, function(key, val){
                            var data = $("<tr>");
                            data.html("<td align='center'>"+no+"</td> <td align='center'>"+val.id_pm
                            +"</td> <td align='center'>"+val.nama_pm+"</td> <td align='center'>"
                            +"<button type='button' name='edit' class='btn btn-warning btn-xs edit' id='"+val.id_pm+"'>edit</button>" 
                            +"&nbsp;"+"<button type='button' name='delete' class='btn btn-danger btn-xs delete' id='"+val.id_pm+"'>delete</button></td>");
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
            $('#action').val('insert_pm');
            $('#button_action').val('Insert'); 
            $('.modal-title').text('Add Data');
            $('#apicrudModal').modal('show');
        });

        $('#api_crud_form').on('submit', function(event){
            event.preventDefault();
            if($('#nama_pm').val() == ''){
                alert("Masukkan Nama PM");
            }
            else{
                var form_data = $(this).serialize();
                $.ajax({
                    url:"../api/ControllerPM.php",
                    method:"POST",
                    data:form_data,
                    success:function(data){
                        fetch_data();
                        $('#api_crud_form')[0].reset();
                        $('#apicrudModal').modal('hide');
                        if(data == 'insert_pm'){
                            alert("Data telah dimasukkan menggunakan PHP API");
                        }
                        if(data == 'update_pm'){
                            alert("Data telah terubah menggunakan PHP API");
                        }
                        console.log(data);
                    }
                });
            }
        }); 

       $(document).on('click', '.edit', function(){
            var id_pm = $(this).attr('id');
            var action ='fetch_singlepm';
            $.ajax({
                url:"../api/ControllerPM.php",
                method:"POST",
                data:"id_pm="+id_pm+"&action="+action,
                success:function(data){
                    $('#id_pm').val(id_pm);
                    $('#action').val('update_pm');
                    $('#button_action').val('Update');
                    $('.modal-title').text('Edit Data');
                    $('#apicrudModal').modal('show');
                   var objResult = JSON.parse(data);
                    if(objResult.status == "ok"){
                        $.each(objResult.result, function(key, val) {
                            $('#nama_pm').val(val.nama_pm);
                        })
                    } 
                    console.log(data);
                }
            })
        }); 

        $(document).on('click', '.delete', function(){
            var id_pm = $(this).attr('id');
            var action = 'delete_pm';
            if(confirm("Apakah Anda yakin ingin menghapusnya?")){
                $.ajax({
                    url:"../api/ControllerPM.php",
                    method:"GET",
                    data:"id_pm="+id_pm+"&action="+action,
                    success:function(data){
                        fetch_data();
                        alert("Data telah terhapus"); 
                        //console.log(data);
                    }
                })
            }
        }); 

    });


</script>