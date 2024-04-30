<?php

/*
 *   package OpenEMR
 *   link    https://www.open-emr.org
 *   author  Sherwin Gaddis <sherwingaddis@gmail.com>
 *   Copyright (c) 2022.
 */


require_once dirname(__DIR__) . "/vendor/autoload.php";

use WoundCare\Model;

$data = new Model();
$billingData = $data->getTodaysPrescription();