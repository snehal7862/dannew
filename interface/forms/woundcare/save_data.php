<?php

/*
 *   package OpenEMR
 *   link    https://www.open-emr.org
 *   author  Sherwin Gaddis <sherwingaddis@gmail.com>
 *   Copyright (c) 2022.
 */

 require_once dirname(__DIR__, 2) . '/globals.php';


$sets =
"get_date = ?, " .
"copy_date = ?, " .
"wc_complaint = ?, " .
"wc_hpi = ?, " .
"wc_current_medication = ?, " .
"medical_history = ?, " .
"wc_allergies = ?, " .
"wc_surgical_history = ?, " .
"wc_social = ?, " .
"wc_family = ?, " .
"wc_ros = ?, " .
"wc_vitals = ?, " .
"wc_t = ?, " .
"wc_p = ?, " .
"wc_hr = ?, " .
"wc_systolic = ?, " .
"wc_diastolic = ?, " .
"wc_bp = ?, " .
"wc_ht = ?, " .
"wc_wt = ?, " .
"wc_bmi = ?, " .
"wc_general = ?, " .
"wc_head = ?, " .
"wc_eyes = ?, " .
"wc_nose = ?, " .
"wc_throat = ?, " .
"wc_ears = ?, " .
"wc_oral = ?, " .
"wc_neck = ?, " .
"wc_skin = ?, " .
"wc_lungs = ?, " .
"wc_breast = ?, " .
"wc_heart = ?, " .
"wc_back = ?, " .
"wc_pelvic = ?, " .
"wc_genitourinary = ?, " .
"wc_neurologic = ?, " .
"wc_musculoskeletal = ?, " .
"wc_abdomen = ?, " .
"wc_extremities = ? " ;

$location =
"wound_id = ?, " .
"wc_side = ?, " .
"wc_anatomical = ?, " .
"wc_location = ?, " .
"wc_wound_type = ?, " .
"wc_thickness = ?, " .
"wc_drainage_amount = ?, " .
"wc_drainage_description = ?, " .
"wc_surgically = ?, " .
"wc_undermining = ?, " .
"wc_tunneling = ?, " .
"wc_ordo = ?, " .
"wc_signs1 = ?, " .
"wc_signs2 = ?, " .
"wc_surfacearea = ?, " .
"wc_volume = ?, " .
"wc_assessment_diagnosis1 = ?, " .
"wc_plan = ?, " .
"wc_medication = ? " ;

$treatment =
"location_id = ?," .
"wc_cpt_code = ?," .
"wc_procdure_notes = ?," .
"wc_additional_notes = ? ";

$problem =
    "wound_id = ?," .
    "dr_description = ?," .
    "dr_location = ?," .
    "icd = ?," .
    "dr_plan = ?," .
    "dr_medication = ? ";

$problem_treatment =
    "problem_id = ?," .
    "dr_procdure_notes = ?," .
    "dr_additional_notes = ?," .
    "wc_cpt_code = ? " ;



sqlStatement(
    "INSERT INTO form_wound_care SET " . $sets,
    [
        $_POST['date'],
        $_POST['copy_date'],
        $_POST['wc_complaint'],
        $_POST['wc_hpi'],
        $_POST['wc_current_medication'],
        $_POST['medical_history'],
        $_POST['wc_allergies'],
        $_POST['wc_surgical_history'],
        $_POST['wc_social'],
        $_POST['wc_family'],
        $_POST['wc_ros'],
        $_POST['wc_vitals'],
        $_POST['wc_t'],
        $_POST['wc_p'],
        $_POST['wc_hr'],
        $_POST['wc_systolic'],
        $_POST['wc_diastolic'],
        $_POST['wc_bp'],
        $_POST['wc_ht'],
        $_POST['wc_wt'],
        $_POST['wc_bmi'],
        $_POST['wc_general'],
        $_POST['wc_head'],
        $_POST['wc_eyes'],
        $_POST['wc_nose'],
        $_POST['wc_throat'],
        $_POST['wc_ears'],
        $_POST['wc_oral'],
        $_POST['wc_neck'],
        $_POST['wc_skin'],
        $_POST['wc_lungs'],
        $_POST['wc_breast'],
        $_POST['wc_heart'],
        $_POST['wc_back'],
        $_POST['wc_pelvic'],
        $_POST['wc_genitourinary'],
        $_POST['wc_neurologic'],
        $_POST['wc_musculoskeletal'],
        $_POST['wc_abdomen'],
        $_POST['wc_extremities']
    ]
);


$getData = "SELECT * FROM form_wound_care ORDER BY id DESC LIMIT 1";
$data = sqlQuery($getData);



foreach($_POST['location'] as $loc){
sqlStatement(
    "INSERT INTO form_wound_location SET " . $location,
    [
        $data['id'],
        $loc['wc_side'],
        $loc['wc_anatomical'],
        $loc['wc_location'],
        $loc['wc_wound_type'],
        $loc['wc_thickness'],
        $loc['wc_drainage_amount'],
        $loc['wc_drainage_description'],
        $loc['wc_surgically'],
        $loc['wc_undermining'],
        $loc['wc_tunneling'],
        $loc['wc_ordo'],
        $loc['wc_signs1'],
        $loc['wc_signs2'],
        $loc['wc_surfacearea'],
        $loc['wc_volume'],
        $loc['icd-10'],
        $loc['wc_plan'],
        $loc['wc_medication'],
    ]
);
$locationData = "SELECT * FROM form_wound_location ORDER BY id DESC LIMIT 1";
$locdata = sqlQuery($locationData);


foreach($loc['treatment'] as $treat){

sqlStatement(
    "INSERT INTO form_wound_treatment SET " . $treatment,
    [
        $locdata['id'],
        $treat['wc_cpt_code'],
        $treat['wc_procdure_notes'],
        $treat['wc_additional_notes'],
    ]
);
}
}

foreach($_POST['problem'] as $pro){
    sqlStatement(
        "INSERT INTO form_wound_problem SET " . $problem,
        [
            $data['id'],
            $pro['dr_description'],
            $pro['dr_location'],
            $pro['icd-10'],
            $pro['dr_plan'],
            $pro['dr_medication'],
        ]
    );

    $problemData = "SELECT * FROM form_wound_problem ORDER BY id DESC LIMIT 1";
    $prodData = sqlQuery($problemData);

    foreach($pro['treatment'] as $treat){
        sqlStatement(
            "INSERT INTO form_dermitology_treatment SET " . $problem_treatment,
            [
                $prodData['id'],
                $treat['dr_procdure_notes'],
                $treat['dr_additional_notes'],
                $treat['dr_cpt_code'],
            ]
        );
    }

}

 echo "success";

?>
