<?php
include('models/ModelKaryawan.php');

$api_object = new Karyawan;

$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];

switch($action){
    case 'login':
        $data = $api_object->login($_POST["username"], $_POST["pass"]);
    break;

    case 'fetch_all':
        $data = $api_object->fetch_all();
    break;

    case 'insert':
        $data = $api_object->insert($_POST["nip"], $_POST["nama"], 
                $_POST["alamat"], $_POST["no_telp"], $_POST["divisi"], $_POST["level"]);
    break;

    case 'fetch_single':
        $data = $api_object->fetch_single($_GET["nip"]);
    break;

    case 'update':
        $data = $api_object->update($_POST["nip"], $_POST["nama"], $_POST["alamat"],
        $_POST["no_telp"], $_POST["divisi"], $_POST["level"]);
    break;

    case 'delete':
        $data = $api_object->delete($_GET["id"]);
    break;
}

echo json_encode($data);

?>