<!DOCTYPE html>
<html>
<head>
<title>REST API</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<?php
    require_once('../api/Connection.php');
        $db=new connection_database;
        $connect = $db->db_connection();
                                
        $sql = "SELECT * FROM tb_datapegawai ORDER BY nip DESC LIMIT 1";
        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        function autonumber($id_terakhir, $panjang_kode, $panjang_angka){
        $angka = substr($id_terakhir, $panjang_kode, $panjang_angka);
        $angka_baru = str_repeat("0", $panjang_angka - strlen($angka+1)).($angka+1);
        $id_baru = "KRY".$angka_baru;

        return $id_baru;
        }
        $nip = autonumber($row['nip'], 3, 2);
?> 

</head>
<body>

    <div class="container">
        <br />
        <h3 align="center"><strong>DATA PEGAWAI</strong></h3>
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
                        <th><center>LEVEL</center></th>
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
                            <label>NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control" value="<?php echo $nip; ?>" readonly="" />
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
                            <input type="text" name="divisi" id="divisi" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>LEVEL</label>
                            <input type="text" name="level" id="level" class="form-control" />
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
                url: "../api/ControllerKaryawan.php",
                method: "POST",
                data: "action=fetch_all",
                success:function(data){
                    var objResult = JSON.parse(data);
                    if(objResult.status == "ok"){
                        var no = 1;
                        $.each(objResult.result, function(key, val){
                            var data = $("<tr>");
                            data.html("<td align='center'>"+no+"</td> <td align='center'>"+val.nip
                            +"</td> <td align='center'>"+val.nama+"</td> <td align='center'>"+val.alamat
                            +"</td> <td align='center'>"+"0"+val.no_telp+"</td>" 
                            +"</td> <td align='center'>"+val.divisi+"</td>" 
                            +"</td> <td align='center'>"+val.level+"</td> <td align='center'>" 
                            +"<button type='button' name='edit' class='btn btn-warning btn-xs edit' id='"+val.id+"'>edit</button>" 
                            +"&nbsp;"+"<button type='button' name='delete' class='btn btn-danger btn-xs delete' id='"+val.id+"'>delete</button></td>");
                            dataHandler.append(data);
                            no++;
                        })   
                    }
                    else {
                        alert("Data Tidak Ditemukan");
                    } 
                }
            })
        }

        $('#add_button').click(function(){
            $('#action').val('insert');
            $('#button_action').val('Insert'); 
            $('.modal-title').text('Add Data');
            $('#apicrudModal').modal('show');
        });

        $('#api_crud_form').on('submit', function(event){
            event.preventDefault();
            if($('#nip').val() == ''){
                alert("Enter NIP");
            }
            else if($('#nama').val() == ''){
                alert("Enter Your Name");
            }
            else if($('#no_telp').val() == ''){
                alert("Enter Your No Telp");
            }
            else if($('#alamat').val() == ''){
                alert("Enter Your Address");
            }
            else if($('#divisi').val() == ''){
                alert("Enter Your Divisi");
            }
            else if($('#level').val() == ''){
                alert("Enter Your Level");
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
                        if(data == 'insert'){
                            alert("Data telah dimasukkan menggunakan PHP API");
                        }
                        if(data == 'update'){
                            alert("Data telah terubah menggunakan PHP API");
                        }
                    }
                });
            }
        }); 

      /*  $(document).on('click', '.edit', function(){
            var nip = $(this).attr('id');
            var action = 'fetch_single';
            $.ajax({
                url:"../api/ControllerKaryawan.php",
                method:"POST",
                data:"nip="+nip+"&action="+action,
                success:function(data){
                   // $('#hidden_id').val(id);
                   // $('#nip').val(data.nip);
                   // $('#nama').val(data.nama);
                   // $('#no_telp').val(data.no_telp);
                   // $('#alamat').val(data.alamat); 
                    $('#action').val('update');
                    $('#button_action').val('Update');
                    $('.modal-title').text('Edit Data');
                    $('#apicrudModal').modal('show');
                  //  $('#hidden_id').val(id);
                    

                    var objResult = JSON.parse(data);
                    if(objResul.status == "ok"){
                        $.each(objResult.result, function(key, val)){
                            $('#nip').val(val.nip);
                            $('#nama').val(val.nama);
                            $('#alamat').val(val.alamat);
                            $('#no_telp').val(val.no_telp);
                            $('#divisi').val(val.divisi);
                            $('#level').val(val.level);
                        }
                    }
                }
            })
        }); */

        $(document).on('click', '.delete', function(){
            var id = $(this).attr('id');
            var action ='delete';
            if(confirm("Apakah Anda yakin ingin menghapusnya?")){
                $.ajax({
                    url:"../api/ControllerKaryawan.php",
                    method:"GET",
                    data:"id="+id+"&action="+action,
                    success:function(data){
                        fetch_data();
                        alert("Data telah terhapus");
                       // console.log(data);
                    }
                })
            }
        }); 

    });


</script>