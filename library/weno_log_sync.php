<?php

/*
 *  @package OpenEMR
 *  @link    http://www.open-emr.org
 *  @author  Sherwin Gaddis <sherwingaddis@gmail.com>
 *  @copyright Copyright (c) 2021 Sherwin Gaddis <sherwingaddis@gmail.com>
 *  @license https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */
//require "../interface/globals.php";
use OpenEMR\Rx\Weno\Container;
use OpenEMR\Rx\Weno\LogProperties;
use OpenEMR\Rx\Weno\WenoPharmaciesJson;
use OpenEMR\Rx\Weno\TransmitProperties;
use OpenEMR\Common\Crypto\CryptoGen;
use OpenEMR\Common\Logging\EventAuditLogger;


if(isset($_GET['key']) && !empty(isset($_GET['key']))){
    start_weno();
}
function start_weno()
{
    $logsync = new LogProperties();
    $logsync->logSync();
}

function download_weno_pharmacy(){
    $cryptoGen = new CryptoGen();
    $localPharmacyJson = new WenoPharmaciesJson(
        $cryptoGen
    );

    //check if the background service is active and set intervals to once a day
    //Weno has decided to not force the import of pharmacies since they are using the iframe
    //and the pharmacy can be selected at the time of creating the prescription.
    $value = $localPharmacyJson->checkBackgroundService();
    if ($value == 'active' || $value == 'live') {
        $status = $localPharmacyJson->storePharmacyDataJson();
        error_log('Weno pharmacies download complete');
        die;
    }
}
