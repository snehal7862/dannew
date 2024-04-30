<?php

/**
 *
 *   package OpenEMR
 *   link    https://www.open-emr.org
 *   author  Sherwin Gaddis <sherwingaddis@gmail.com>
 *   Copyright (c) 2022.
 */

namespace WoundCare;

require_once dirname(__DIR__, 3) . '/globals.php';

if(isset($_REQUEST['treatment']) && $_REQUEST['treatment']==1){
   $data = array();
   $list = new Lists();
   $data['treatmentTypes'] = $list->treatmentTypes();
   $data['treatments'] = $list->treatments();
   $data['quantities'] = $list->quantities();
   $data['strengthFormulation'] = $list->strengthFormulation();
   $data['forms'] = $list->forms();
   $data['sides'] = $list->sides();
   $data['anatomicalDirections'] = $list->anatomicalDirection();
   $data['locations'] = $list->locations();
   $data['woundTypes'] = $list->woundTypes();
   $data['woundThickness'] = $list->woundThickness();
   $data['drainageAmount'] = $list->drainageAmount();
   $data['drainageDescription'] = $list->drainageDescription();
   $data['surgically'] = $list->surgically();
   $data['treatmentTypes'] = $list->treatmentTypes();
   $data['treatments'] = $list->treatments();
   $data['quantities'] = $list->quantities();
   $data['strengthFormulation'] = $list->strengthFormulation();
   $data['forms'] = $list->forms();
   $data['procedureNotes'] = $list->procedureNotes();
   $data['assessments'] = $list->assessments();
   $data['dermatology'] = $list->dermatology();
   $data['cptCodes'] = $list->cptCodes();
   $data['icd10s'] = $list->icdCodes();
   $data['wound_template'] = $list->wound_template();
   
   echo json_encode($data);
}
class Lists
{
    public function sides(): array
    {
        return [
            'Center' => 'Center',
            'Right' => 'Right',
            'Left' => 'Left'
        ];
    }
    public function anatomicalDirection(): array
    {
        return [
            'N/A' => 'N/A',
            'Anterior' => 'Anterior',
            'Distal' => 'Distal',
            'Dorsal' => 'Dorsal',
            'Inferior' => 'Inferior',
            'Medial' => 'Medial',
            'Palmar' => 'Palmar',
            'Plantar' => 'Plantar',
            'Posterior' => 'Posterior',
            'Proximal' => 'Proximal',
            'Superior' => 'Superior',
            'Ventral' => 'Ventral',
        ];
    }
    public function locations(): array
    {
        return [
            'Other (Self Entry)' => 'Other (Self Entry)',
            'Abdomen' => 'Abdomen',
            'Ankle' => 'Ankle',
            'Arch' => 'Arch',
            'Arm, Upper' => 'Arm, Upper',
            'Arm, Lower' => 'Arm, Lower',
            'Ball of foot' => 'Ball of foot',
            'Back' => 'Back',
            'Buttock' => 'Buttock',
            'Calcaneus' => 'Calcaneus',
            'Calf' => 'Calf',
            'Cheek' => 'Cheek',
            'Chest' => 'Chest',
            'Chin' => 'Chin',
            'Coccyx' => 'Coccyx',
            'Digit' => 'Digit',
            'Elbow' => 'Elbow',
            'Finger' => 'Finger',
            'Foot' => 'Foot',
            'Forehead' => 'Forehead',
            'Groin' => 'Groin',
            'Gluteal Fold' => 'Gluteal Fold',
            'Hand' => 'Hand',
            'Head' => 'Head',
            'Heel' => 'Heel',
            'Hip' => 'Hip',
            'Ischium' => 'Ischium',
            'Knee' => 'Knee',
            'Leg, Lower' => 'Leg, Lower',
            'Leg, Upper' => 'Leg, Upper',
            'Lip' => 'Lip',
            'Malleolus' => 'Malleolus',
            'Neck' => 'Neck',
            'Nose' => 'Nose',
            'Perianal' => 'Perianal',
            'Pubis' => 'Pubis',
            'Sacrum' => 'Sacrum',
            'Sternum' => 'Sternum',
            'Shoulder' => 'Shoulder',
            'Thigh' => 'Thigh',
            'Trochanter' => 'Trochanter',
            'Toe 1' => 'Toe 1',
            'Toe 2' => 'Toe 2',
            'Toe 3' => 'Toe 3',
            'Toe 4' => 'Toe 4',
            'Toe 5' => 'Toe 5',
            'Wrist' => 'Wrist',
            'Ear' => 'Ear',
        ];
    }
    public function woundTypes(): array
    {
        return [
            'Other (Self Entry)' => 'Other (Self Entry)',
            'Abrasion' => 'Abrasion',
            'Burn - 2nd Degree' => 'Burn - 2nd Degree',
            'Burn - 3rd Degree' => 'Burn - 3rd Degree',
            'Deep tissue injury' => 'Deep tissue injury',
            'Dehisced Surgical' => 'Dehisced Surgical',
            'Diabetic Ulcer' => 'Diabetic Ulcer',
            'Maceration' => 'Maceration',
            'Malignant' => 'Malignant',
            'Medical Device Pressure Injury' => 'Medical Device Pressure Injury',
            'Neuropathic Ulcer' => 'Neuropathic Ulcer',
            'Pressure Injury' => 'Pressure Injury',
            'Puncture Wound' => 'Puncture Wound',
            'Radiation Burn' => 'Radiation Burn',
            'Skin Tear' => 'Skin Tear',
            'Traumatic Wound' => 'Traumatic Wound',
            'Vasculitis' => 'Vasculitis',
            'Venous Ulcer' => 'Venous Ulcer',
        ];
    }
    public function drainageAmount(): array
    {
       return [
           'None' => 'None',
           'Minimum' => 'Minimum',
           'Moderate' => 'Moderate',
           'Heavy' => 'Heavy',
       ];
    }
    public function surgically(): array
    {
        return [
            'Debrided' => 'Debrided',
            'Surgically Created' => 'Surgically Created',
            'No' => 'No',
        ];
    }
    public function woundThickness(): array
    {
        return [
            'Partial Thickness (Stage 1 or 2)' => 'Partial Thickness (Stage 1 or 2)',
            'Full Thickness (Stage 3 or 4)' => 'Full Thickness (Stage 3 or 4)',
            'Stalled Partial Thickness (Stage 1 or 2)' => 'Stalled Partial Thickness (Stage 1 or 2)',
            'Stalled Full Thickness (Stage 3 or 4)' => 'Stalled Full Thickness (Stage 3 or 4)',
            'Closed Partial Thickness (Stage 1 or 2)' => 'Closed Partial Thickness (Stage 1 or 2)',
            'Closed Full Thickness (Stage 3 or 4)' => 'Closed Full Thickness (Stage 3 or 4)',
            'Wagner Grade 1' => 'Wagner Grade 1',
            'Wagner Grade 2' => 'Wagner Grade 2',
            'Wagner Grade 3' => 'Wagner Grade 3',
            'Wagner Grade 4' => 'Wagner Grade 4',
            'Wagner Grade 5' => 'Wagner Grade 5',
            'Other (Self Entry)' => 'Other (Self Entry)',
        ];
    }
    public function drainageDescription(): array
    {
        return [
            'None' => 'None',
            'Serous' => 'Serous',
            'Sero-sanguineous' => 'Sero-sanguineous',
            'Sanguineous' => 'Sanguineous',
            'Purulent' => 'Purulent',
        ];
    }
    public function treatmentTypes():array
    {
        return [
            'Procenta' => 'Procenta',
            'Membrane' => 'Membrane',
            'Debridement' => 'Debridement',
            'Ultrasonic Debridement' => 'Ultrasonic Debridement',
            'Wound Dressing' => 'Wound Dressing',
            'Other (Self Entry)' => 'Other (Self Entry)',
        ];
    }
    public function treatments(): array
    {
        return [
            '1' =>'1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
            '11' => '11',
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23',
            '24' => '24',
            '25' => '25',
            '26' => '26',
            '27' => '27',
            '28' => '28',
            '29' => '29',
            '30' => '30',
            '31' => '31',
            '32' => '32',
            '33' => '33',
            '34' => '34',
            '35' => '35',
            '36' => '36',
            '37' => '37',
            '38' => '38',
            '39' => '39',
            '40' => '40',
            '41' => '41',
            '42' => '42',
            '43' => '43',
            '44' => '44',
            '45' => '45',
            '46' => '46',
            '47' => '47',
            '48' => '48',
            '49' => '49',
            '50' => '50',
            '51' => '51',
            '52' => '52',
        ];
    }
    public function quantities(): array
    {
        return [
            '1' =>'1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
            '11' => '11',
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23',
            '24' => '24',
            '25' => '25',
            '26' => '26',
            '27' => '27',
            '28' => '28',
            '29' => '29',
            '30' => '30',
        ];
    }
    public function strengthFormulation()
    {
        return [
            '200mg' => '200mg',
            '300mg' => '300mg',
            '2x2cm' => '2x2cm',
            '2x3cm' => '2x3cm',
            '2x4cm' => '2x4cm',
            '2x6cm' => '2x6cm',
            '2x8cm' => '2x8cm',
            'Other (Self Entry)' => 'Other (Self Entry)',
            'N/A' => 'N/A',
        ];
    }
    public function forms(): array
    {
        return [
            'Vial' => 'Vial',
            'Membrane' => 'Membrane',
            'Other (Self Entry)' => 'Other (Self Entry)',
            'N/A' => 'N/A',
        ];
    }
    public function procedureNotes(){
        $notes = sqlStatement("SELECT template, id FROM form_treatment_note");
        $procedureNotes = array();

        for ($iter = 0; $row = sqlFetchArray($notes); $iter++) {
    
              $row['id'] = $row['id'];
              $row['template'] = $row['template'];
              $procedureNotes[$iter] = $row;
          }

        return $procedureNotes;

    }

    public function cptCodes(){

        $notes = sqlStatement("SELECT cpt_code, id FROM cpt_codes");

        $cptCodes = array();

        for ($iter = 0; $row = sqlFetchArray($notes); $iter++) {
    
              $row['id'] = $row['id'];
              $row['cpt_code'] = $row['cpt_code'];
              $cptCodes[$iter] = $row;
          }

        return $cptCodes;

    }

    public function assessments(){
        $data = sqlStatement("SELECT assessment_name, id FROM assessment_template");
        $assessments = array();

        for ($iter = 0; $row = sqlFetchArray($data); $iter++) {
    
              $row['id'] = $row['id'];
              $row['assessment_name'] = $row['assessment_name'];
              $assessments[$iter] = $row;
          }

        return $assessments;

    }

    public function dermatology(){
        $data = sqlStatement("SELECT template_name, id FROM form_dermatology");
        $dermatology = array();

        for ($iter = 0; $row = sqlFetchArray($data); $iter++) {
    
              $row['id'] = $row['id'];
              $row['template_name'] = $row['template_name'];
              $dermatology[$iter] = $row;
          }

        return $dermatology;

    }

    public function wound_template(){
        $data = sqlStatement("SELECT wound_template_name, id FROM form_wound_template");
        $wound_template = array();

        for ($iter = 0; $row = sqlFetchArray($data); $iter++) {
    
              $row['id'] = $row['id'];
              $row['wound_template_name'] = $row['wound_template_name'];
              $wound_template[$iter] = $row;
          }

        return $wound_template;

    }

    public function icdCodes(){

        $notes = sqlStatement("SELECT icd_code, icd_name, id FROM icd_codes");

        $icdCodes = array();

        for ($iter = 0; $row = sqlFetchArray($notes); $iter++) {
    
              $row['id'] = $row['id'];
              $row['icd_code'] = $row['icd_code'];
              $row['icd_name'] = $row['icd_name'];
              $icdCodes[$iter] = $row;
          }

        return $icdCodes;

    }


}
