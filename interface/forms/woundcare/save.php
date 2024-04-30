<?php
global $userauthorized;

/**
 *
 *   package OpenEMR
 *   link    https://www.open-emr.org
 *   author  Sherwin Gaddis <sherwingaddis@gmail.com>
 *   Copyright (c) 2022.
 *
 */

require_once(__DIR__ . "/../../globals.php");
require ('vendor/autoload.php');
require_once("$srcdir/api.inc");
require_once("$srcdir/forms.inc");

use Google\Service\Script;
use OpenEMR\Common\Csrf\CsrfUtils;

if (!CsrfUtils::verifyCsrfToken($_POST["csrf_token"])) {
    CsrfUtils::csrfNotVerified();
}
$remove_token = array_shift($_POST);
function formMetaData($userauthorized): void
{

    if ($_GET["mode"] == "update") {
        $id = $_GET["id"];
        $query = "UPDATE form_wound_care SET is_edit = 0, edited_by = null WHERE id = $id";

        sqlStatement($query);

        $woundCareUpdateData = $_POST;
        unset($woundCareUpdateData["location"]);
        unset($woundCareUpdateData["problem"]);
        $success = formUpdate('form_wound_care', $woundCareUpdateData, $_GET["id"], $userauthorized);

        foreach ($_POST["location"] as $locationData) {

            $locationDatawithOutTreatment = $locationData;
            unset($locationDatawithOutTreatment["treatment"]);
            unset($locationDatawithOutTreatment["location_id"]);
            $locationDatawithOutTreatment["wound_id"] = $_GET["id"];

            if (isset($locationData["location_id"]) && $locationData["location_id"]) {
                // Update existing entry
                formUpdate("form_wound_location", $locationDatawithOutTreatment, $locationData["location_id"], $userauthorized);
            } else {
                // Insert new entry
                $locaionId = formSubmit("form_wound_location", $locationDatawithOutTreatment, $_GET["id"], $userauthorized);
            }


            foreach ($locationData["treatment"] as $locationTreatmentData) {
                $locationDatawithOutTreatmentId = $locationTreatmentData;
                unset($locationDatawithOutTreatmentId["treatment_id"]);
                $locationDatawithOutTreatmentId["location_id"] = $locationData["location_id"] ?? $locaionId;

                // Check if treatment_id is present or not
                if (isset($locationTreatmentData["treatment_id"]) && $locationTreatmentData["treatment_id"]) {
                    // Update existing entry
                    formUpdate("form_wound_treatment", $locationDatawithOutTreatmentId, $locationTreatmentData["treatment_id"], $userauthorized);
                } else {
                    // Insert new entry
                    $newid = formSubmit("form_wound_treatment", $locationDatawithOutTreatmentId, $_GET["id"], $userauthorized);
                }
            }
        }

        foreach ($_POST["problem"] as $problemData) {

            $problemDatawithOutTreatment = $problemData;
            unset($problemDatawithOutTreatment["treatment"]);
            unset($problemDatawithOutTreatment["problem_id"]);
            $problemDatawithOutTreatment["wound_id"] = $_GET["id"];

            if (isset($problemData["problem_id"]) && $problemData["problem_id"]) {
                // Update existing entry
                formUpdate("form_wound_problem", $problemDatawithOutTreatment, $problemData["problem_id"], $userauthorized);
            } else {
                // Insert new entry
                $problemId = formSubmit("form_wound_problem", $problemDatawithOutTreatment, $_GET["id"], $userauthorized);
            }


            foreach ($problemData["treatment"] as $problemTreatmentData) {

                $problemDatawithOutTreatmentId = $problemTreatmentData;
                unset($problemDatawithOutTreatmentId["treatment_id"]);
                $problemDatawithOutTreatmentId["problem_id"] = $problemData["problem_id"] ?? $problemId;

                // Check if treatment_id is present or not
                if (isset($problemTreatmentData["treatment_id"]) && $problemTreatmentData["treatment_id"]) {
                    // Update existing entry
                    formUpdate("form_dermitology_treatment", $problemDatawithOutTreatmentId, $problemTreatmentData["treatment_id"], $userauthorized);
                } else {
                    // Insert new entry
                    $newid = formSubmit("form_dermitology_treatment", $problemDatawithOutTreatmentId, $_GET["id"], $userauthorized);
                }


            }
        }

    } else {

        $vitalForm = [];
        $woundcareData = $_POST;
        $vitalForm['bps'] = $woundcareData['wc_systolic'];
        $vitalForm['bpd'] = $woundcareData['wc_diastolic'];
        $vitalForm['weight'] = $woundcareData['wc_wt'];
        $vitalForm['height'] = $woundcareData['wc_ht'];
        $vitalForm['temperature'] = $woundcareData['wc_t'];
        $vitalForm['respiration'] = $woundcareData['wc_hr'];
        $vitalForm['BMI'] = $woundcareData['wc_bmi'];
        $vitalForm['pulse'] = $woundcareData['wc_p'];

        unset($woundcareData["location"]);
        unset($woundcareData["problem"]);
        $newid = formSubmit("form_wound_care", $woundcareData, isset($_GET["id"]) ?? $_GET["id"], $userauthorized);
        $vitalFormId = formSubmit("form_vitals", $vitalForm, isset($_GET["id"]) ?? $_GET["id"], $userauthorized);

        addForm($_SESSION['encounter'], "Vitals", $vitalFormId, "vitals", $_SESSION["pid"], $userauthorized);

        if(isset($_POST['wc_allergies']) && !empty($_POST['wc_allergies'])){
            sqlQuery(
                'INSERT INTO lists
                (
                    date, type, erx_source, begdate,
                    title, external_allergyid, pid, user, outcome
                )
            VALUES
                (
                    NOW(), \'allergy\', \'1\', NOW(),
                    ?, ?, ?, ?, ?
                );',
                array(
                    $_POST['wc_allergies'],
                    $_POST['wc_allergies'],
                    $_SESSION["pid"],
                    $userauthorized,
                    0
                )
            );
        }

        if(isset($_POST['medical_history']) && !empty($_POST['medical_history'])){
            sqlQuery(
                'INSERT INTO lists
                (
                    date, type, erx_source, begdate,
                    title, external_allergyid, pid, user, outcome
                )
            VALUES
                (
                    NOW(), \'medical_problem\', \'1\', NOW(),
                    ?, ?, ?, ?, ?
                );',
                array(
                    $_POST['medical_history'],
                    $_POST['medical_history'],
                    $_SESSION["pid"],
                    $userauthorized,
                    0
                )
            );
        }

        if(isset($_POST['wc_current_medication']) && !empty($_POST['wc_current_medication'])){
            sqlQuery(
                'INSERT INTO lists
                (
                    date, type, erx_source, begdate,
                    title, external_allergyid, pid, user, outcome
                )
            VALUES
                (
                    NOW(), \'medication\', \'1\', NOW(),
                    ?, ?, ?, ?, ?
                );',
                array(
                    $_POST['wc_current_medication'],
                    $_POST['wc_current_medication'],
                    $_SESSION["pid"],
                    $userauthorized,
                    0
                )
            );
        }

        foreach ($_POST["location"] as $locationData) {

            $locationDatawithOutTreatment = $locationData;
            unset($locationDatawithOutTreatment["treatment"]);
            $locationDatawithOutTreatment["wound_id"] = $newid;
            $locationId = formSubmit("form_wound_location", $locationDatawithOutTreatment, isset($_GET["id"]) ?? $_GET["id"], $userauthorized);


            foreach ($locationData["treatment"] as $locationTreatmentData) {

                $locationTreatmentData["location_id"] = $locationId;
                formSubmit("form_wound_treatment", $locationTreatmentData, isset($_GET["id"]) ?? $_GET["id"], $userauthorized);

            }
        }

        foreach ($_POST["problem"] as $problemData) {

            $probleDatawithOutTreatment = $problemData;
            unset($probleDatawithOutTreatment["treatment"]);
            $probleDatawithOutTreatment["wound_id"] = $newid;
            $problemId = formSubmit("form_wound_problem", $probleDatawithOutTreatment, isset($_GET["id"]) ?? $_GET["id"], $userauthorized);


            foreach ($problemData["treatment"] as $problemTreatmentData) {

                $problemTreatmentData["problem_id"] = $problemId;
                formSubmit("form_dermitology_treatment", $problemTreatmentData, isset($_GET["id"]) ?? $_GET["id"], $userauthorized);

            }
        }

        addForm($_SESSION['encounter'], "Wound Care", $newid, "woundcare", $_SESSION["pid"], $userauthorized);

    }

    //TODO: build new function to save form data into the form encounter table

}

// $newid = $data->getFormId();
formMetaData($userauthorized);



formHeader("Redirecting....");
formJump();
formFooter();

