<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";
require_once('../../../globals.php');


/**
 * This will fetch all the Medical Information template data from the given template_id
 */


if($_POST['template_type'] == "Medical Information Delete") {

    $id = $_POST['template_id'];

    $query = "DELETE FROM form_woundcare_templates WHERE id = ?";
    sqlStatement($query, $id);
    
    echo json_encode(['message'  => 'Data deleted!']);
    exit();
}

if($_POST['template_type'] == "Physical Exam Delete") {

    $id = $_POST['template_id'];

    $query = "DELETE FROM form_woundcare_physical_exam WHERE id = ?";
    sqlStatement($query, $id);
    
    echo json_encode(['message'  => 'Data deleted!']);
    exit();
}

if($_POST['template_type'] == "Wound  Care Delete") {

    $id = $_POST['template_id'];

    $query = "DELETE FROM form_wound_template WHERE id = ?";
    sqlStatement($query, $id);
    
    echo json_encode(['message'  => 'Data deleted!']);
    exit();
}

if($_POST['template_type'] == "Dermitology Delete") {

    $id = $_POST['template_id'];

    $query = "DELETE FROM  form_dermatology WHERE id = ?";
    sqlStatement($query, $id);
    
    echo json_encode(['message'  => 'Data deleted!']);
    exit();
}


