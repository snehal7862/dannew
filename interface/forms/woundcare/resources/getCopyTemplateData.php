<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";
require_once('../../../globals.php');

/**
 * This will fetch all the Medical Information template data from the given template_id
 */


if($_POST['template_type'] == "Medical Information") {
    $qry = sqlStatement("SELECT * FROM form_wound_care ORDER BY date DESC LIMIT 5");

    $all = [];
    for ($iter = 0; $row = sqlFetchArray($qry); $iter++) {
        $all[$iter] = $row;
    }

    echo json_encode($all);
    exit();
}

if($_POST['template_type'] == "Physical Exam") {
    $qry = sqlStatement("SELECT * FROM form_wound_care ORDER BY date DESC LIMIT 5");

    $all = [];
    for ($iter = 0; $row = sqlFetchArray($qry); $iter++) {
        $all[$iter] = $row;
    }

    echo json_encode($all);
    exit();
}

if($_POST['template_type'] == "Wound Care") {
    $qry = sqlStatement("SELECT * FROM form_wound_location ORDER BY date DESC LIMIT 5");

    $all = [];
    for ($iter = 0; $row = sqlFetchArray($qry); $iter++) {
        $all[$iter] = $row;
    }

    echo json_encode($all);
    exit();
}

if($_POST['template_type'] == "Dermitology") {
    $qry = sqlStatement("SELECT * FROM form_wound_problem ORDER BY date DESC LIMIT 5");

    $all = [];
    for ($iter = 0; $row = sqlFetchArray($qry); $iter++) {
        $all[$iter] = $row;
    }

    echo json_encode($all);
    exit();
}

if($_POST['template_type'] == "Wound Care Treatment") {
    $qry = sqlStatement("SELECT * FROM form_wound_treatment ORDER BY date DESC LIMIT 5");

    $all = [];
    for ($iter = 0; $row = sqlFetchArray($qry); $iter++) {
        $all[$iter] = $row;
    }

    echo json_encode($all);
    exit();
}

if($_POST['template_type'] == "Dermitology Treatment") {
    $qry = sqlStatement("SELECT * FROM form_dermitology_treatment ORDER BY date DESC LIMIT 5");

    $all = [];
    for ($iter = 0; $row = sqlFetchArray($qry); $iter++) {
        $all[$iter] = $row;
    }

    echo json_encode($all);
    exit();
}

