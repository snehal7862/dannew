<?php

/**
 *
 *   package OpenEMR
 *   link    https://www.open-emr.org
 *   author  Sherwin Gaddis <sherwingaddis@gmail.com>
 *   Copyright (c) 2022.
 *
 */

require_once dirname(__DIR__)."/../globals.php";

function woundcare_report($pid, $encounter, $cols, $id)
{
    $userid = $_SESSION['authUserID'];

    $fetch_data = sqlStatement("SELECT * FROM  form_wound_care WHERE `id` = $id");
    $woundcar_form = sqlFetchArray($fetch_data);
 
    if($woundcar_form['edited_by'] == $userid){
        $query = "UPDATE form_wound_care SET is_edit = 0, edited_by = null WHERE id = $id";
    
        sqlStatement($query);
    }

    $data = formFetch("form_wound_care", $id);
    $woundId = $data['id'];
    $location = sqlStatement("SELECT * FROM form_wound_location WHERE wound_id = $woundId");
    $problem = sqlStatement("SELECT * FROM form_wound_problem WHERE wound_id = $woundId");

    if ($data) {
        
        echo "<table class='table table-striped w-60-l'>";
        $i = 0;
    
        foreach ($data as $key => $value) {
            if ($i > 9) {
                echo "<tr><td class='col-1'></td><td class='col-2 font-weight-bolder'><h5>" . ucwords(substr($key, 3)) . "</h5></td><td class='col-8'>$value</td><td class='col-1'></td></tr>";
            }
            $i++;
        }
    
        if (!empty($location)) {
            foreach ($location as $keyw => $singleLocation) {
               

                echo "<table class='table table-dark'>";
                $locationtreatmentId = $singleLocation['id'];
                $locationTreatment = sqlStatement("SELECT * FROM form_wound_treatment WHERE location_id = $locationtreatmentId");
        
                // Move the heading inside the table-responsive div
                echo "<tr><td colspan='4'><h3 class='text-center'>Woundcare</h3></td></tr>";
        
                $excludedColumns = ['id', 'pid', 'groupname', 'user', 'authorized', 'activity', 'date', 'wound_id'];
        
                foreach ($singleLocation as $item => $itemValue) {
                    if (in_array($item, $excludedColumns)) {
                        continue;
                    }
                    echo "<tr><td><span class='bold'>" . xlt(str_replace('wc_', '', $item)) . ": </span><span class='text'>" . xlt($itemValue) . "</span></td></tr>";

                }
                echo "</table>";
            
                foreach ($locationTreatment as $singleTreatment) {
                if(!empty($singleTreatment)){
                    echo "<h3 class='text-center'>Woundcare Treatment</h3>";
                }
                break;
                }   
                echo "<table class='table table-dark'>";
                echo "<thead><tr>";
        
                $excludedColumns = ['id', 'pid', 'groupname', 'user', 'authorized', 'activity', 'date', 'location_id'];
        
                foreach ($locationTreatment as $singleTreatment) {
                    foreach ($singleTreatment as $itemTreatment => $itemValueTreatment) {
                        if (in_array($itemTreatment, $excludedColumns)) {
                            continue;
                        }
                        echo "<th>" . xlt(str_replace('wc_', '', $itemTreatment)) . "</th>";
                    }
                    break;
                }
                echo "</tr></thead>";
        
                echo "<tbody>";
                foreach ($locationTreatment as $singleTreatment) {
                    echo "<tr>";
                    foreach ($singleTreatment as $itemTreatment => $itemValueTreatment) {
                        if (in_array($itemTreatment, $excludedColumns)) {
                            continue;
                        }
                        echo "<td><span class='text'>" . xlt($itemValueTreatment) . "</span></td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody></table>";
        
            }
        }
        
    
        if (!empty($problem)) {
            foreach ($problem as $keyw => $singleProblem) {
                echo "<h3 class='text-center'>Dermatology</h3>";
                echo "<table class='table table-dark'>";
                $problemtreatmentId = $singleProblem['id'];
                $problemTreatment = sqlStatement("SELECT * FROM form_dermitology_treatment WHERE problem_id = $problemtreatmentId");
                $excludedColumns = ['id', 'pid', 'groupname', 'user', 'authorized', 'activity', 'date', 'wound_id'];
    
                foreach ($singleProblem as $item => $itemValue) {
                    if (in_array($item, $excludedColumns)) {
                        continue;
                    }
                    echo "<tr><td><span class='bold'>" . xlt(str_replace('dr_', '', $item)) . ": </span><span class='text'>" . xlt($itemValue) . "</span></td></tr>";
                }
                echo "</table>";
                foreach ($problemTreatment as $singleTreatment) {
                if(!empty($singleTreatment)){
                    echo "<h3 class='text-center'>Dermatology Treatment</h3>";
                }
                break;
                }
                echo "<table class='table table-dark'>";
                echo "<thead><tr>";
    
                $excludedColumns = ['id', 'pid', 'groupname', 'user', 'authorized', 'activity', 'date', 'problem_id'];
    
                foreach ($problemTreatment as $singleTreatment) {
                    foreach ($singleTreatment as $itemTreatment => $itemValueTreatment) {
                        if (in_array($itemTreatment, $excludedColumns)) {
                            continue;
                        }
                        echo "<th>" . xlt(str_replace('dr_', '', $itemTreatment)) . "</th>";
                    }
                    break;
                }
                echo "</tr></thead>";
    
                echo "<tbody>";
                foreach ($problemTreatment as $singleTreatment) {
                    echo "<tr>";
                    foreach ($singleTreatment as $itemTreatment => $itemValueTreatment) {
                        if (in_array($itemTreatment, $excludedColumns)) {
                            continue;
                        }
                        echo "<td><span class='text'>" . xlt($itemValueTreatment) . "</span></td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody></table>";
    

            }
        }
    
        echo "</table>";
    } else {
        echo "<table class='table'>";
        print "<tr><td>No data found in the database. We are clueless!</td></tr>";
        echo "</table>";
    }
}

function getFormDataBack($encounter, $pid)
{
    $sql = sqlStatement("SELECT *
    FROM form_wound_care AS fwc
    LEFT JOIN form_wound_location AS fwloc ON fwc.id = fwloc.wound_id
    LEFT JOIN form_wound_problem AS fwprob ON fwc.id = fwprob.wound_id
    LEFT JOIN form_dermitology_treatment AS fdt ON fwprob.id = fdt.problem_id
    LEFT JOIN form_wound_treatment AS fwt ON fwloc.id = fwt.location_id
    WHERE fwc.encounter = $encounter AND fwc.pid = $pid");

    return sqlFetchArray($sql);

}
