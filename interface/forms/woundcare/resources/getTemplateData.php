<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";
require_once('../../../globals.php');

/**
 * This will fetch all the Medical Information template data from the given template_id
 */
if($_POST['template_type'] == "Medical Information") {
    $qry = sqlStatement("select * from form_woundcare_templates where id = '".$_POST['template_id']."'");
    echo json_encode($qry);
    exit();
}

/**
 * This will fetch the template name and id of last added record
 */
if($_POST['template_type'] == "Medical Information Update") {
    $qry = sqlStatement("select template_name,id from form_woundcare_templates ORDER BY id DESC LIMIT 1");
    echo json_encode($qry);
    exit();
}

/**
 * This will fetch the physical exam name and id of last added record
 */
if($_POST['template_type'] == "Physical Exam Update") {
    $qry = sqlStatement("select physical_exam_name,id from form_woundcare_physical_exam ORDER BY id DESC LIMIT 1");
    echo json_encode($qry);
    exit();
}

/**
 * This will fetch all the Physical Exam template data from the given template_id
 */
if($_POST['template_type'] == "Physical Exam") {
    $qry = sqlStatement("select * from form_woundcare_physical_exam where id = '".$_POST['template_id']."'");
    echo json_encode($qry);
    exit();
}

/**
 * This will fetch all the wound template data from the given template_id
 */
if($_POST['template_type'] == "Wound Template") {
    $qry = sqlStatement("select * from form_wound_template where id = '".$_POST['template_id']."'");
    echo json_encode($qry);
    exit();
}


/**
 * This will fetch the template name and id of last added record
 */
if($_POST['template_type'] == "Wound Template Update") {
    $qry = sqlStatement("select wound_template_name, id from form_wound_template ORDER BY id DESC LIMIT 1");
    echo json_encode($qry);
    exit();
}

/**
 * This will fetch all the dermatology template data from the given template_id
 */
if($_POST['template_type'] == "Dermatology") {
    $qry = sqlStatement("select * from form_dermatology where id = '".$_POST['template_id']."'");
    echo json_encode($qry);
    exit();
}


/**
 * This will fetch the template name and id of last added record
 */
if($_POST['template_type'] == "Dermatology Update") {
    $qry = sqlStatement("select template_name, id from form_dermatology ORDER BY id DESC LIMIT 1");
    echo json_encode($qry);
    exit();
}


/**
 * This will fetch all the assessment data from the given assessment_id
 */
if($_POST['template_type'] == "Assessment") {
    $qry = sqlStatement("select * from assessment_template where id = '".$_POST['template_id']."'");
    echo json_encode($qry);
    exit();
}


/**
 * This will fetch the assessment name and id of last added record
 */
if($_POST['template_type'] == "Assessment Update") {
    $qry = sqlStatement("select assessment_name, id from assessment_template ORDER BY id DESC LIMIT 1");
    echo json_encode($qry);
    exit();
}


/**
 * This will fetch all the Procedure Notes data from the given template_id
 */
if($_POST['template_type'] == "Procedure Note") {
    $qry = sqlStatement("select * from form_treatment_note where id = '".$_POST['template_id']."'");
    echo json_encode($qry);
    exit();
}


/**
 * This will fetch all the Cpt code data from the given template_id
 */
if($_POST['template_type'] == "Cpt code data") {
    $qry = sqlStatement("select cpt_code, id from cpt_codes ORDER BY id DESC LIMIT 1");
    echo json_encode($qry);
    exit();
}

/**
 * This will fetch all the Icd code data from the given template_id
 */
if($_POST['template_type'] == "Icd code Get data") {
    $qry = sqlStatement("select icd_code, icd_name, id from icd_codes ORDER BY id DESC LIMIT 1");
    echo json_encode($qry);
    exit();
}

/**
 * This will fetch all the Icd code data from the given template_id
 */
if($_POST['template_type'] == "Icd code data") {
    $qry = sqlStatement("select icd_code, icd_name, id from icd_codes where id = '".$_POST['template_id']."'");
    echo json_encode($qry);
    exit();
}


/**
 * This will fetch the procedure note and id of last added record
 */
if($_POST['template_type'] == "Procure Note") {
    $qry = sqlStatement("select template, id from form_treatment_note ORDER BY id DESC LIMIT 1");
    echo json_encode($qry);
    exit();
}


if($_POST['template_type'] == "Cpt codes data"){
    $input = $_POST['input'];
    $qry = sqlStatement("select code_text from codes where code_type = 100 AND code_text LIKE '%$input%'");
    if(sqlFetchArray($qry) > 0){
        for ($iter = 0; $row = sqlFetchArray($qry); $iter++) {
            $suggestion = $row['code_text'];
            $options .= "<li>$suggestion</li>";
        }
    }else{
        $output .= '<li>Code Not Found</li>';  
    }
    
    echo $options;
    exit();
}

