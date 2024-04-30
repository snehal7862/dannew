<?php

/*
 *   package OpenEMR
 *   link    https://www.open-emr.org
 *   author  Sherwin Gaddis <sherwingaddis@gmail.com>
 *   Copyright (c) 2022.
 */


require_once dirname(__DIR__, 3) . '/globals.php';

if($_POST['template_type'] == "Medical Information") {
    $getData = "SELECT template_name FROM form_woundcare_templates WHERE template_name = ?";
    $data = sqlQuery($getData, $_POST['template_name']);

    $sets = "template_name = ?, " .
        "template_chief_complaint = ?, " .
        "template_hip = ?, " .
        "template_current_medication = ?, " .
        "template_medical_history = ?, " .
        "template_allergies = ?, " .
        "template_surgical_history = ?, " .
        "template_social_history = ?, " .
        "template_family_history = ?, " .
        "template_ros = ?";

    if (empty($data['template_name'])) {
        sqlStatement(
            "INSERT INTO form_woundcare_templates SET " . $sets,
            [
                $_POST['template_name'],
                $_POST['template_chief_complaint'],
                $_POST['template_hip'],
                $_POST['template_current_medication'],
                $_POST['template_medical_history'],
                $_POST['template_allergies'],
                $_POST['template_surgical_history'],
                $_POST['template_social_history'],
                $_POST['template_family_history'],
                $_POST['template_ros']
            ]
        );
        echo "success first save";
    } else {
        $sql = "UPDATE form_woundcare_templates SET " . $sets ." WHERE template_name = ?";
        $update = sqlStatement(
            $sql,
            array(
                $_POST['template_name'],
                $_POST['template_chief_complaint'],
                $_POST['template_hip'],
                $_POST['template_current_medication'],
                $_POST['template_medical_history'],
                $_POST['template_allergies'],
                $_POST['template_surgical_history'],
                $_POST['template_social_history'],
                $_POST['template_family_history'],
                $_POST['template_ros'],
                $_POST['template_name']
            )
        );
        echo "update success";
    }
}


if($_POST['template_type'] == "Physical Exam") {
    $getData = "SELECT physical_exam_name FROM form_woundcare_physical_exam WHERE physical_exam_name = ?";
    $data = sqlQuery($getData, $_POST['physical_exam_name']);
    $sets = "physical_exam_name = ?," .
        "physical_exam_general = ?," .
        "physical_exam_head = ?," .
        "physical_exam_eyes = ?," .
        "physical_exam_nose = ?," .
        // "physical_exam_throat = ?," .
        "physical_exam_ears = ?," .
        "physical_exam_oral_cavity = ?," .
        "physical_exam_neck = ?," .
        "physical_exam_skin = ?," .
        "physical_exam_lungs = ?," .
        "physical_exam_abdomen = ?," .
        "physical_exam_extemities = ?," .
        "physical_exam_heart = ?," .
        "physical_exam_back = ?," .
        "physical_exam_pelvic = ?," .
        "physical_exam_breast = ?," .
        "physical_exam_genitourinary = ?," .
        "physical_exam_neurologic = ?," .
        "physical_exam_musculoskeletal = ?";

    if (empty($data['physical_exam_name'])) {

    sqlStatement(
        "INSERT INTO form_woundcare_physical_exam SET " . $sets,
        [
            $_POST['physical_exam_name'],
            $_POST['template_general'],
            $_POST['template_head'],
            $_POST['template_eyes'],
            $_POST['template_nose'],
            // $_POST['template_throat'],
            $_POST['template_ears'],
            $_POST['template_oral_cavity'],
            $_POST['template_neck'],
            $_POST['template_skin'],
            $_POST['template_lungs'],
            $_POST['template_abdomen'],
            $_POST['template_extemities'],
            $_POST['template_heart'],
            $_POST['template_back'],
            $_POST['template_pelvic'],
            $_POST['template_breast'],
            $_POST['template_genitourinary'],
            $_POST['template_neurologic'],
            $_POST['template_musculoskeletal']
        ]
    );
    echo "success first save";
    } else {
        $sql = "UPDATE form_woundcare_physical_exam SET " . $sets ." WHERE physical_exam_name = ?";
        $update = sqlStatement(
            $sql,
            array(
                $_POST['physical_exam_name'],
                $_POST['template_general'],
                $_POST['template_head'],
                $_POST['template_eyes'],
                $_POST['template_nose'],
                // $_POST['template_throat'],
                $_POST['template_ears'],
                $_POST['template_oral_cavity'],
                $_POST['template_neck'],
                $_POST['template_skin_history'],
                $_POST['template_lungs'],
                $_POST['template_abdomen'],
                $_POST['template_extemities'],
                $_POST['template_heart'],
                $_POST['template_back'],
                $_POST['template_pelvic'],
                $_POST['template_breast'],
                $_POST['template_genitourinary'],
                $_POST['template_neurologic'],
                $_POST['template_musculoskeletal'],
                $_POST['physical_exam_name']
            )
        );
        echo "update success";
    }
}


if($_POST['template_type'] == "Wound Template") {
    $getData = "SELECT wound_template_name FROM form_wound_template WHERE wound_template_name = ?";
    $data = sqlQuery($getData, $_POST['template_name']);

    $sets = "wound_template_name = ?," .
            "template_side = ?," .
            "template_anatomical_action = ?," .
            "template_location = ?," .
            "template_wound_type = ?," .
            "template_wound_thickness = ?," .
            "template_drainage_amount = ?," .
            "template_drainage_description = ?," .
            "template_debrided_surgically_created = ?," .
            "template_undermining = ?," .
            "template_tunneling = ?," .
            "template_ordo = ?" ;


            if (empty($data['wound_template_name'])) {
                sqlStatement(
                    "INSERT INTO form_wound_template SET " . $sets,
                    [
                        $_POST['template_name'],
                        $_POST['template_side'],
                        $_POST['template_anatomical_action'],
                        $_POST['template_location'],
                        $_POST['template_wound_type'],
                        $_POST['template_wound_thickness'],
                        $_POST['template_drainage_amount'],
                        $_POST['template_drainage_description'],
                        $_POST['template_debrided_surgically_created'],
                        $_POST['template_undermining'],
                        $_POST['template_tunneling'],
                        $_POST['template_ordo']
                    ]
                    );
                    echo "success first save";
            }else{
                $sql = "UPDATE form_wound_template SET " . $sets ." WHERE wound_template_name = ?";
                $update = sqlStatement(
                    $sql,
                    array(
                        $_POST['template_name'],
                        $_POST['template_side'],
                        $_POST['template_anatomical_action'],
                        $_POST['template_location'],
                        $_POST['template_wound_type'],
                        $_POST['template_wound_thickness'],
                        $_POST['template_drainage_amount'],
                        $_POST['template_drainage_description'],
                        $_POST['template_debrided_surgically_created'],
                        $_POST['template_undermining'],
                        $_POST['template_tunneling'],
                        $_POST['template_ordo'],
                        $_POST['template_name'],
                    )
                );
                echo "update success";
            }

}

/**
 * This will fetch all the Dermatology data and check if the template name is already exists then will update the data
 * Otherwise will insert the new record.
 */
if($_POST['template_type'] == "Dermatology") {
    $getData = "SELECT template_name FROM form_dermatology WHERE template_name = ?";
    $data = sqlQuery($getData, $_POST['template_name']);

    $sets = "template_name = ?," .
            "description = ?," .
            "location = ?" ;


            if (empty($data['template_name'])) {
                sqlStatement(
                    "INSERT INTO form_dermatology SET " . $sets,
                    [
                        $_POST['template_name'],
                        $_POST['description'],
                        $_POST['location'],
                    ]
                    );
                    echo "success first save";
            }else{
                $sql = "UPDATE form_dermatology SET " . $sets ." WHERE template_name = ?";
                $update = sqlStatement(
                    $sql,
                    array(
                        $_POST['template_name'],
                        $_POST['description'],
                        $_POST['location'],
                        $_POST['template_name'],
                    )
                );
                echo "update success";
            }

}

/**
 * This will save the Assessment data.
 */

if($_POST['template_type'] == 'Assessment'){
    $getData = "SELECT assessment_name FROM assessment_template WHERE assessment_name = ?";
    $data = sqlQuery($getData, $_POST['template_name']);

    $sets = "assessment_name = ?," .
            "ICD_10 = ?," .
            "medication = ?," .
            "assessment_type = ?," .
            "plan = ?" ;

            if (empty($data['assessment_name'])) {
                sqlStatement(
                    "INSERT INTO assessment_template SET " . $sets,
                    [
                        $_POST['template_name'],
                        json_encode($_POST['ICD_10']),
                        $_POST['medication'],
                        $_POST['assessment_type'],
                        $_POST['plan'],
                    ]
                    );
                    echo "success first save";
            }else{
                $sql = "UPDATE assessment_template SET " . $sets ." WHERE assessment_name = ?";
                $update = sqlStatement(
                    $sql,
                    array(
                        $_POST['template_name'],
                        json_encode($_POST['ICD_10']),
                        $_POST['medication'],
                        $_POST['assessment_type'],
                        $_POST['plan'],
                        $_POST['template_name'],
                    )
                );
                echo "update success";
            }

}

//treatment procedure note save

if($_POST['template_type'] == "Procure Note") {
    $getData = "SELECT template FROM form_treatment_note WHERE template = ?";
    $data = sqlQuery($getData, $_POST['template']);

    $sets = "template = ?," .
        "treatment_procedure_note = ?," .
        "treatment_additional_note = ?," .
        "treatment_cpt_code = ?";

    if (empty($data['template'])) {

        sqlStatement(
            "INSERT INTO form_treatment_note SET " . $sets,
            [
                $_POST['template'],
                $_POST['treatment_procedure_note'],
                $_POST['treatment_additional_note'],
                $_POST['treatment_cpt_code'],
            ]
        );
        echo "success first save";
    } else {
        $sql = "UPDATE form_treatment_note SET " . $sets ." WHERE template = ?";
        $update = sqlStatement(
            $sql,
            array(
                $_POST['template'],
                $_POST['treatment_procedure_note'],
                $_POST['treatment_additional_note'],
                $_POST['treatment_cpt_code'],
                $_POST['template'],
            )
        );
        echo "update success";
    }
}

if($_POST['template_type'] == "Add CPT code") {


    $getData = "SELECT cpt_code FROM cpt_codes WHERE cpt_code = ?";
    $data = sqlQuery($getData, $_POST['cpt_code']);

    $sets = "cpt_code = ?";

    if(!empty($data)){
        echo "Cpt code already exist";
    }else{

        $code = $_POST['cpt_code'];
        $code = trim( $code );

        sqlStatement(
            "INSERT INTO cpt_codes SET " . $sets,
            [
               $code,
            ]
        );
        echo "Cpt code saved";
    }

    
 

}


if($_POST['template_type'] == "Add ICD code") {


    $getData = "SELECT icd_name FROM icd_codes WHERE icd_name = ?";
    $data = sqlQuery($getData, $_POST['icd_name']);

    $sets = "icd_name = ?," . 
    "icd_code = ?";

    $code = $_POST['icd_code'];
    $code = trim( $code );

    if (empty($data['icd_name'])) {
         sqlStatement(
            "INSERT INTO icd_codes SET " . $sets,
            [
               $_POST['icd_name'], 
               $code
            ]
        );
            echo "success first save";
    }else{
        $sql = "UPDATE icd_codes SET " . $sets ." WHERE icd_name = ?";
        $update = sqlStatement(
            $sql,
            [
                $_POST['icd_name'],
                $code,
                $_POST['icd_name']
             ]
        );
        echo "update success";
    }
 

}

