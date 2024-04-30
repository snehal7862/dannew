<?php

/**
 * Created by PhpStorm.
 * User: Hussain
 * Date: 10/13/2022
 * Time: 12:49 PM
 */

require ('vendor/autoload.php');

// print_r($_GET); die; 
$formid = isset($_GET['id']) ?? $_GET['id'];
$formname = $_GET['formname'];
$locationData = [];
$problemData = [];
$userid = $_SESSION['authUserID'];
if(!empty($formid)){

    $fetch_data = sqlStatement("SELECT * FROM  form_wound_care WHERE `id` = $formid");
    $woundcar_form = sqlFetchArray($fetch_data);

    if($woundcar_form['is_edit'] == 0 && $woundcar_form['edited_by'] == null){
        $query = "UPDATE form_wound_care SET is_edit = 1, edited_by = ? WHERE id = ?";

        sqlStatement($query, [$userid, $formid]);
    }
    
    $data = sqlStatement("SELECT * FROM  form_wound_care WHERE `id` = $formid");
    $woundcar_form_data = sqlFetchArray($data);
    $woundId = $woundcar_form_data['id'];
    $locations = sqlStatement("SELECT * FROM form_wound_location WHERE wound_id = $woundId");
    $problems = sqlStatement("SELECT * FROM form_wound_problem WHERE wound_id = $woundId");

    foreach ($locations as $location) {
        $locationId = $location['id'];
        $locationTreatment = sqlStatement("SELECT * FROM form_wound_treatment WHERE location_id = $locationId");

        $locationData[] = [
            'location' => $location,
            'locationTreatment' => $locationTreatment,
        ];
    }

    foreach ($problems as $problem) {
        $problemtreatmentId = $problem['id'];
        $problemTreatment = sqlStatement("SELECT * FROM form_dermitology_treatment WHERE problem_id = $problemtreatmentId");

        $problemData[] = [
            'problem' => $problem,
            'problemTreatment' => $problemTreatment,
        ];
    }

}
else{
    $woundcar_form_data = [];
    $locationData = [];
    $problemData = [];
}


use WoundCare\Bootstrap;
use WoundCare\DiagnosisCodes;
use WoundCare\Lists;
use OpenEMR\Common\Csrf\CsrfUtils;

$twig = new Bootstrap();
$list = new Lists();
$dianosis = new DiagnosisCodes();

            $content = $twig->content();
              $sides = $list->sides();
$anatomicalDirection = $list->anatomicalDirection();
          $locations = $list->locations();
         $woundTypes = $list->woundTypes();
     $drainageAmount = $list->drainageAmount();
         $surgically = $list->surgically();
     $woundThickness = $list->woundThickness();
$drainageDescription = $list->drainageDescription();
     $treatmentTypes = $list->treatmentTypes();
         $treatments = $list->treatments();
         $quantities = $list->quantities();
$strengthFormulation = $list->strengthFormulation();
              $forms = $list->forms();
            //  $icd10s = $dianosis->diagnoses();
               $csrf = CsrfUtils::collectCsrfToken();
          $encounter = $_SESSION['encounter'];

 $qry = sqlStatement("SELECT template_name, id FROM form_woundcare_templates");
 $physicalqry = sqlStatement("SELECT physical_exam_name, id FROM form_woundcare_physical_exam");
$procedureNotes = sqlStatement("SELECT template, id FROM form_treatment_note");
 $wound_template = sqlStatement("SELECT wound_template_name, id FROM form_wound_template");
 $dermatology = sqlStatement("SELECT template_name, id FROM form_dermatology");
 $assessments = sqlStatement("SELECT assessment_name, id FROM assessment_template");
 $cptCodes = sqlStatement("SELECT cpt_code, id FROM cpt_codes");
 $icd10s = sqlStatement("SELECT icd_code, icd_name, id FROM icd_codes");

echo $twig->twigEnv()->render(
    'progress_template.twig',
    [
        'content' => $content,
        'sides' => $sides,
        'anatomicalDirection' => $anatomicalDirection,
        'locations' => $locations,
        'woundTypes' => $woundTypes,
        'drainageAmount' => $drainageAmount,
        'surgically' => $surgically,
        'woundThickness' => $woundThickness,
        'drainageDescription' => $drainageDescription,
        'treatmentTypes' => $treatmentTypes,
        'treatments' => $treatments,
        'quantities' => $quantities,
        'strengthFormulation' => $strengthFormulation,
        'forms' => $forms,
        'icd10s' => $icd10s,
        'csrfUtils' => $csrf,
        'template' => $qry,
        'physicalqry' => $physicalqry,
        'procedureNotes' => $procedureNotes,
        'wound_template' => $wound_template,
        'dermatology' => $dermatology,
        'assessments' => $assessments,
        'cptCodes' => $cptCodes,
        'encounter' => $encounter,
        'woundcare_data' => $woundcar_form_data,
        'location_data' => $locationData,
        'problem_data' => $problemData,
        'userid' => $userid
    ]
);
