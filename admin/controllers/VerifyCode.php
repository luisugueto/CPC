<?php
    require_once("../models/Doctors.php");

    $doctor = new Doctors();
    $id = $_GET['doctorId'];
    $code = $_GET['code'];
    $doctor->setDoctorId($id);
    $content = $doctor->GetDoctorContent();
    
    if($content['Code'] == $code){
        echo json_encode("exito");
    }
    else{
        echo json_encode("fallo");
    }

?>