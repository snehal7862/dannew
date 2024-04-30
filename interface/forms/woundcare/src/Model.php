<?php

/**
 *   package OpenEMR
 *   link    https://www.open-emr.org
 *   author  Sherwin Gaddis <sherwingaddis@gmail.com>
 *   Copyright (c) 2022.
 */

namespace WoundCare;

require_once dirname(__DIR__, 3) . "/globals.php";


/**
 * use this class for the database layer
 * all database calls should have a method here
 */

class Model
{
    private $data;

    public function __construct()
    {
        /*
         * future use I hope
         */
    }

    /**
     * @return false|string
     */
    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this->data;
    }

    public function getFormId()
    {
        $res2 = sqlStatement("SELECT MAX(id) as largestId FROM `form_care_plan`");
        $getMaxid = sqlFetchArray($res2);
        if ($getMaxid['largestId']) {
            return $getMaxid['largestId'] + 1;
        } else {
            return 1;
        }
    }

    public function storeProgressNote($newid)
    {
        sqlStatement("INSERT INTO `form_woundcare` SET " .
            "id = ?, " .
            "date = ?, " .
            "pid = ?, " .
            "encounter = ?, " .
            "user = ?, " .
            "groupname = ?, " .
            "authorized = ?, " .
            "activity = ?, " .
            "json_data = ? ",
        [
          $newid,
            'NOW()',
            $_SESSION['pid'],
            $_SESSION['encounter'],
            $_SESSION['authUser'],
            'default',
            $_SESSION['userauthorized'],
            1,
            self::getData()
        ]
        );
    }

    public function getTodaysBilling(): array
    {
        $sql = "SELECT * FROM billing WHERE encounter = ? and activity = ?";
        $billing = sqlStatement($sql, [$_SESSION['encounter'], 1]);
        $billing_data = [];
        while ($row = sqlFetchArray($billing)) {
            if(is_array($row)) {
                array_push($billing_data, $row);
            }
        }

        echo(json_encode($billing_data));
        exit();
    }

    public function getTodaysPrescription(): array
    {

        $sql = 'SELECT p.id,p.date_added,p.drug,p.dosage,p.quantity,p.size,p.unit,p.refills,p.note,l1.title AS title1,
                l2.title AS title2, l3.title AS title3, l4.title AS title4,
                CONCAT_WS(fname, \' \', mname, \' \', lname) AS docname
                FROM prescriptions AS p
                LEFT JOIN users AS u ON p.provider_id = u.id
                LEFT JOIN list_options AS l1 ON l1.list_id = \'drug_form\' AND l1.option_id = p.form
                LEFT JOIN list_options AS l2 ON l2.list_id = \'drug_route\' AND l2.option_id = p.route
                LEFT JOIN list_options AS l3 ON l3.list_id = \'drug_interval\' AND l3.option_id = p.interval
                LEFT JOIN list_options AS l4 ON l4.list_id = \'drug_units\' AND l4.option_id = p.unit
                WHERE encounter = ? AND patient_id = ?';


        $prescriptions = sqlStatement($sql, [$_SESSION['encounter'],$_SESSION['pid'] ]);
        $prescriptions_data = [];
        while ($row = sqlFetchArray($prescriptions)) {
            if(is_array($row)) {
                array_push($prescriptions_data, $row);
            }
        }
        
        echo(json_encode($prescriptions_data));
        exit();
    }
}
