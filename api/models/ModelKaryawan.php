<?php

include './Connection.php';
    date_default_timezone_set('Asia/Jakarta');

    class Karyawan{
        private $connect;
        public $status;
        public $data= array();

        function __construct(){
            $db = new connection_database;

            $this->connect = $db->db_connection();
        }

        function login($username, $pass){
            $query = "SELECT * FROM tb_login WHERE username = '$username' AND pass = '$pass'";
            $statement = $this->connect->prepare($query);

            try{
                if($statement->execute()){
                    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                        $data[] = $row;
                    }

                    $data = array(
                        "result" => $data,
                        "status" => "ok",
                        "pesan"  => ""
                    );
                }
                return $data;
            }

            catch(PDOException $e){
                $data = array(
                    "status" => "error",
                    "pesan"  => ""
                );
                return $data;
            }

        }

        function autoincrement(){                        
            $query = "SELECT * FROM tb_datapegawai ORDER BY nip DESC LIMIT 1";
            $statement = $this->connect->prepare($query);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            function autonumber($id_terakhir, $panjang_kode, $panjang_angka){
            $angka = substr($id_terakhir, $panjang_kode, $panjang_angka);
            $angka_baru = str_repeat("0", $panjang_angka - strlen($angka+1)).($angka+1);
            $id_baru = "KRY".$angka_baru;

            return $id_baru;
            }
          //  $nip = autonumber($row['nip'], 3, 2);
        } 

        function fetch_all(){
            $query = "SELECT * FROM tb_datapegawai ORDER BY nip";
            $statement = $this->connect->prepare($query);

            try{
                if($statement->execute()){
                    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                        $data[] = $row;
                    }
                    $data = array(
                        "result" => $data,
                        "status" => "ok",
                        "pesan"  => "Berhasil",
                        "url" => "http://localhost/apk_pengajuan_lembur/api/ControllerKaryawan.php?action=fetch_all",
                        "time" => date('H:i:s d-m-y')
                    );
                    return $data;
                }
            }

            catch(PDOException $e){
                $data = array(
                    "status" => "error",
                    "pesan"  => "Kesalahan pada query, silahkan cek kembali",
                    "url" => "http://localhost/apk_pengajuan_lembur/api/ControllerKaryawan.php?action=fetch_all",
                    "time" => date('H:i:s d-m-y')
                );
                return $data;
            }

            return $this->data;
        }

        function insert($nip,$nama,$alamat,$no_telp,$divisi,$level){
            if(isset($_POST["nama"])){
                $query = "INSERT INTO tb_datapegawai(nip,nama,alamat,no_telp,divisi,level) 
                        VALUES (:nip,:nama,:alamat,:no_telp,:divisi,:level)";
                $statement = $this->connect->prepare($query);
                $statement->bindParam(":nip", $nip);
                $statement->bindParam(":nama", $nama);
                $statement->bindParam(":alamat", $alamat);
                $statement->bindParam(":no_telp", $no_telp);
                $statement->bindParam(":divisi", $divisi);
                $statement->bindParam(":level", $level);
                
                try{
                    if($statement->execute()){
                        $data[] = array(
                            "status" => "ok",
                            "pesan"  => "Berhasil",
                            "url" => "http://localhost/apk_pengajuan_lembur/api/ControllerKaryawan.php?action=insert",
                            "time" => date('H:i:s d-m-y')
                        );
                        return $data;
                    }
                    else{
                        $data[] = array(
                            "status" => "error",
                            "pesan"  => "Kesalahan pada query, silahkan cek kembali",
                            "url" => "http://localhost/apk_pengajuan_lembur/api/ControllerKaryawan.php?action=insert",
                            "time" => date('H:i:s d-m-y')
                        );
                        return $data;
                    }
                }

                catch(PDOException $e){
                    $data[] = array(
                        "status" => "error",
                        "pesan"  => "Kesalahan pada query, silahkan cek kembali",
                        "url" => "http://localhost/apk_pengajuan_lembur/api/ControllerKaryawan.php?action=insert",
                        "time" => date('H:i:s d-m-y')
                    );
                    return $data;
                }
                
            }

            else{
                $data[] = array(
                    "status" => "error",
                    "pesan"  => "Kesalahan pada query, silahkan cek kembali",
                    "url" => "http://localhost/apk_pengajuan_lembur/api/ControllerKaryawan.php?action=insert",
                    "time" => date('H:i:s d-m-y')
                );
                return $data;
            }
            return $this->data;
        }

        function fetch_single($nip){
            $query = "SELECT * FROM tb_datapegawai WHERE nip = '".$nip."'";
            $statement = $this->connect->prepare($query);
            try{
                if($statement->execute()){
                    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                        $data[] = $row;
                    }
                    $data = array(
                        "result" => $data,
                        "status" => "ok",
                        "pesan"  => "Berhasil",
                        "url" => "http://localhost/apk_pengajuan_lembur/api/ControllerKaryawan.php?action=fetch_single&nip=",
                        "time" => date('H:i:s d-m-y')
                    );
                    return $data;
                }
            }

            catch(PDOException $e){
                $data = array(
                    "status" => "error",
                    "pesan"  => "Kesalahan pada query, silahkan cek kembali",
                    "url" => "http://localhost/apk_pengajuan_lembur/api/ControllerKaryawan.php?action=fetch_single&nip=",
                    "time" => date('H:i:s d-m-y')
                );
                return $data;
            }
            return $this->data;
        }

        function update($nip,$nama,$alamat,$no_telp,$divisi,$level){
            if(isset($_POST["nip"])){
                $query = "UPDATE tb_datapegawai SET nama=:nama, alamat=:alamat, no_telp=:no_telp, divisi=:divisi, level=:level";
                $statement= $this->connect->prepare($query);
                $statement->bindParam(":nama", $nama);
                $statement->bindParam(":alamat", $alamat);
                $statement->bindParam(":no_telp", $no_telp);
                $statement->bindParam(":divisi", $divisi);
                $statement->bindParam(":level", $level);

                try{
                    if($statement->execute()){
                        $data = array(
                            "status" => "ok",
                            "pesan"  => "Berhasil",
                            "url" => "http://localhost/apk_pengajuan_lembur/api/ControllerKaryawan.php?action=update",
                            "time" => date('H:i:s d-m-y')
                        );
                        return $data;
                    }
                }
                catch(PDOException $e){
                    $data = array(
                        "status" => "error",
                        "pesan"  => "Kesalahan pada query, silahkan cek kembali",
                        "url" => "http://localhost/apk_pengajuan_lembur/api/ControllerKaryawan.php?action=update",
                        "time" => date('H:i:s d-m-y')
                    );
                    return $data;
                }
            }
            return $this->data;
        }

        function delete($id){
            $query = "DELETE * FROM tb_datapegawai WHERE id = '".$id."'";
            $statement = $this->connect->prepare($query);
          /*  try{
                if($statement->execute()){
                    $data[] = array(
                        "status" => "ok",
                        "pesan"  => "Berhasil",
                        "url" => "http://localhost/apk_pengajuan_lembur/api/ControllerKaryawan.php?action=delete&nip=",
                        "time" => date('H:i:s d-m-y')
                    );
                    return $data;
                }
            }

            catch(PDOException $e){
                $data[] = array(
                    "status" => "ok",
                    "pesan"  => "Berhasil",
                    "url" => "http://localhost/apk_pengajuan_lembur/api/ControllerKaryawan.php?action=delete&nip=",
                    "time" => date('H:i:s d-m-y')
                );
                return $data;
            } */

            if($statement->execute()){
                $data[] = array(
                    'success' => '1'
                );
            }
            else {
                $data[] = array(
                    'success' => '0'
                );
            }
            return $data;
        }


    }

?>