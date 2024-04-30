<?php

/*
 *   package OpenEMR
 *   link    https://www.open-emr.org
 *   author  Sherwin Gaddis <sherwingaddis@gmail.com>
 *   Copyright (c) 2022.
 */

require_once __DIR__ . "/../../globals.php";
require ('vendor/autoload.php');

use OpenEMR\Common\Csrf\CsrfUtils;
use WoundCare\TemplateProcessor;

if (!CsrfUtils::verifyCsrfToken($_POST["csrf_token_form"])) {
    echo "Token not found!";
    CsrfUtils::csrfNotVerified();
}

try {
    if (!empty($_FILES)) {

        $file = dirname(__DIR__, 3) . "/sites/default/documents/temp/woundimages";
        if (!is_dir($file)) {
            mkdir($file);
            if (!is_dir($file)) {
                die('Check document folder permissions and set to www-data or apache:apache ' . $file);
            }
        }
        
        // File path configuration
        $tempFIle = $_FILES['file']['tmp_name'];
        $uploadDir = dirname(__DIR__, 3) . "/sites/default/documents/temp/woundimages/";
        $fileName = basename($_FILES['file']['name']);
        $ext = explode(".", $fileName);
        $rename =  md5(uniqid(rand(), true)) . '.' . end($ext);
        $uploadFilePath = $uploadDir . $rename;
        move_uploaded_file($tempFIle, $uploadFilePath);

        TemplateProcessor::sendToChartUploaedImage($fileName, $uploadFilePath, $_SESSION['pid']);
        echo "File Uploaded! " . $_SESSION['encounter'] . "-" . $fileName;
        unlink($uploadFilePath);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
