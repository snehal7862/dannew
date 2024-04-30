<?php

/**
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  All rights reserved
 *
 */


require_once dirname(__FILE__, 4) . "/globals.php";

use OpenEMR\Core\Header;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo xlt('Advanced Financial Analytics'); ?></title>
    <?php echo Header::setupHeader() ?>
</head>
<body>
<div class="container">
<div>
    <h1><?php echo xlt('Welcome to Advanced Financial Analytics'); ?></h1>
    <p><?php echo xlt('The goal here is to provide you with a visual view of the financial data for better forecasting'); ?></p>
    <p><?php echo xlt('and knowledge of the health of your business.'); ?></p>
</div>
</div>
</body>
</html>




