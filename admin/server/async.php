<?php
    require_once("../models/Doctors.php");
    include("../includes/functions.php");
    require_once('slim.php');

// Get posted data, if something is wrong, exit
try {
    $images = Slim::getImages();
}
catch (Exception $e) {
    // echo error
    Slim::outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'Error'
    ));
    return;
}

// No image found under given input name
if ($images === false) {
    Slim::outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'No image found under given input name'
    ));
    return;
}

// Should always be one dataset (when posting async)
$image = array_shift($images);

// If no images found
if (!isset($image)) {
    Slim::outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'If no images found'
    ));
    return;
}

// If image found but no output image data present
if (!isset($image['output']['data'])) {
    Slim::outputJSON(array(
        'status' => SlimStatus::FAILURE,
        'message' => 'If image found but no output image data present'
    ));
    return;
}

$namePhoto = slugify($image['input']['name']);

// Save the file
$file = Slim::saveFile($image['output']['data'], $namePhoto, "../img/doctors");

// Return results as JSON
Slim::outputJSON(array(
    'status' => SlimStatus::SUCCESS,
    'file' => $file['name'],
    'path' => $file['path']
));

$doctors = new Doctors();
$doctors->setDoctorId($_GET["id"]);
$doctors->setLogo($file['name']);
$doctors->UpdateDoctorLogo();

?>
