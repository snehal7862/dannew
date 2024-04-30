<?php

/*
 *  @package OpenEMR
 *  @link    http://www.open-emr.org
 *  @author  Sherwin Gaddis <sherwingaddis@gmail.com>
 *  @copyright Copyright (c) 2023 Sherwin Gaddis <sherwingaddis@gmail.com>
 *
 */

namespace OpenEMR\Rx\Weno;

use OpenEMR\Rx\Weno\LogDataInsert;
use OpenEMR\Common\Logging\EventAuditLogger;
use OpenEMR\Services\WenoLogService;
use OpenEMR\Services\PharmacyService;
use OpenEMR\Rx\Weno\wenoPharmaciesImport;

class DownloadWenoPharmacies
{
    public function RetrieveDataFile($url, $storelocation)
    {
        $path_to_extract = $storelocation;
        $storelocation .= "weno_pharmacy.zip";
        $fp = fopen($storelocation, 'w+');            
    
        $ch = curl_init($url);
    
        curl_setopt($ch, CURLOPT_FILE, $fp);          
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000); 
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
        curl_exec($ch);
    
        curl_close($ch);                              
        fclose($fp);  
        
        $result = $this->extractFile($path_to_extract,$storelocation);
        if($result == "Imported"){
            return "complete";
        } else {
            return "failed";
        }
    }
    
    public function extractFile($path_to_extract, $storelocation){
        $zip = new \ZipArchive();
        $wenolog = new WenoLogService();
        $import = new wenoPharmaciesImport();
        
        if ($zip->open($storelocation) === true) {
            $zip->extractTo($path_to_extract);
        
            $files = glob($path_to_extract . "/*.csv");
            if ($files) {
                $csvFile = $files[1];
                $filename = basename($csvFile);
                $csvFilename = $filename;
        
                EventAuditLogger::instance()->newEvent("prescriptions_log", 
                    $_SESSION['authUser'], 
                    $_SESSION['authProvider'], 
                    1, 
                    "File extracted successfully."
                );
                echo 'File extracted successfully.';
                echo 'CSV filename: ' . $csvFilename;
                
                $zip->close();
                unlink($storelocation);
                $result = $import->importPharmacy($csvFile, $files);
                if($result == "Imported"){
                    $wenolog->insertWenoLog("pharmacy", "Success");
                }

                return "Imported";
            } else {
                EventAuditLogger::instance()->newEvent("prescriptions_log", 
                    $_SESSION['authUser'], 
                    $_SESSION['authProvider'], 
                    1, 
                    "No CSV file found in the zip archive."
                );
                $wenolog->insertWenoLog("pharmacy", "Failed");
                return "Failed";
            }
        } else {
            EventAuditLogger::instance()->newEvent("prescriptions_log", $_SESSION['authUser'], $_SESSION['authProvider'], 1, "Failed to extract the file.");
            echo 'Failed to extract the file.';
            error_log("Failed to extract the file.");
            $wenolog->insertWenoLog("pharmacy", "Failed");
        }
    }
}
