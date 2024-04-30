<?php

require_once(__DIR__ . "/../../globals.php");
require ('vendor/autoload.php');
require_once("$srcdir/api.inc");
require_once("$srcdir/forms.inc");
require_once($srcdir . "/documents.php");

use Google\Service\Script;
use WoundCare\Model;
use OpenEMR\Common\Csrf\CsrfUtils;

if (!CsrfUtils::verifyCsrfToken($_POST["csrf_token_form"])) {
    CsrfUtils::csrfNotVerified();
}

$zone = $_REQUEST['zone'] ?? '';

if ($_REQUEST['canvas'] ?? '') {
    if (!$zone || !$_POST["imgBase64"]) {
        exit;
    }

    $base_name = $zone . time();
    $filename = $base_name . ".jpg";

    $type = "image/jpeg";
    $data = $_POST["imgBase64"];
    $data = substr($data, strpos($data, ",") + 1);
    $data = base64_decode($data);
    $size = strlen($data);

    $return = addNewDocument($filename, $type, $_POST["imgBase64"], 0, $size, $_SESSION['authUserID']);
    
    $doc_id = $return['doc_id'];

    if ( $doc_id !== false ) {
        echo 'Image uploaded successfully';
    } else {
        echo 'Error uploading image';
    }

    exit;
}

