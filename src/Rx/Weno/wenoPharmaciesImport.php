<?php

/*
 *  @package OpenEMR
 *  @link    http://www.open-emr.org
 *  @author  Sherwin Gaddis <sherwingaddis@gmail.com>
 *  @copyright Copyright (c) 2020 Sherwin Gaddis <sherwingaddis@gmail.com>
 *  @license https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

namespace OpenEMR\Rx\Weno;

use Pharmacy;
use OpenEMR\Rx\Weno\LogDataInsert;
use OpenEMR\Services\WenoLogService;
use OpenEMR\Services\PharmacyService;

class wenoPharmaciesImport
{
    private $filename;
    private $state;

    public function __construct()
    {
        $this->filename = $GLOBALS['fileroot'] . "/contrib/weno/WenoPharmacyDirectory2020-12-13.csv";
        $this->state = $this->getState();
    }

    public function importPharmacy($csvFile, $files){
        $insertPharmacy = new LogDataInsert();
        $insertdata = [];
        $checkWenoDb = new LogDataInsert();
        $has_data = $checkWenoDb->checkWenoDb();

        $l = 0;
        if (file_exists($csvFile)) {
            $records = fopen($csvFile, "r");

            while (!feof($records)) {
                $line = fgetcsv($records);

                if ($l <= 1) {
                    $l++;
                    continue;
                }
                if (!isset($line[1])) {
                    continue;
                }
                if (!isset($line[1])) {
                    continue;
                }
                if (!empty($line)) {
                    if (date("l") == 'Monday' || !$has_data) { //build for weekly file
                        $ncpdp = str_replace(['[', ']'], '', $line[3]);
                        $npi = str_replace(['[', ']'], '', $line[5]);
                        $business_name = $line[6];
                        $address_line_1 = $line[7];
                        $address_line_2 = $line[8];
                        $city = $line[9];
                        $state = $line[10];
                        $zipcode = str_replace(['[', ']'], '', $line[11]);
                        $country = $line[12];
                        $international = $line[13];
                        $pharmacy_phone = str_replace(['[', ']'], '', $line[16]);
                        $on_weno = $line[21];
                        $test_pharmacy = $line[17];
                        $state_wide_mail = $line[18];
                        $fullDay = $line[22];
                    } else {
                        $ncpdp = str_replace(['[', ']'], '', $line[3]);
                        $npi = str_replace(['[', ']'], '', $line[7]);
                        $business_name = $line[8];
                        $city = $line[11];
                        $state = $line[12];
                        $zipcode = str_replace(['[', ']'], '', $line[14]);
                        $country = $line[15];
                        $address_line_1 = $line[9];
                        $address_line_2 = $line[10];
                        $international = $line[16];
                        $pharmacy_phone = str_replace(['[', ']'], '', $line[20]);
                        $county = $line[33];
                        $on_weno = $line[37];
                        $compounding = $line[41];
                        $medicaid_id = $line[45];
                        $dea = $line[44];
                        $test_pharmacy = $line[29];
                        $fullDay = $line[40];
                        $state_wide_mail = $line[47];
                    }

                    $insertdata['ncpdp'] = $ncpdp;
                    $insertdata['npi'] = $npi;
                    $insertdata['business_name'] = $business_name;
                    $insertdata['address_line_1'] = $address_line_1;
                    $insertdata['address_line_2'] = $address_line_2;
                    $insertdata['city'] = $city;
                    $insertdata['state'] = $state;
                    $insertdata['zipcode'] = $zipcode;
                    $insertdata['country'] = $country;
                    $insertdata['international'] = $international;
                    $insertdata['pharmacy_phone'] = $pharmacy_phone;
                    $insertdata['on_weno'] = $on_weno;
                    $insertdata['test_pharmacy'] = $test_pharmacy;
                    $insertdata['state_wide_mail'] = $state_wide_mail;
                    $insertdata['fullDay'] = $fullDay;
                        if($has_data && date("l") == 'Monday'){
                            $insertPharmacy->updatePharmacies($insertdata);
                        }
                        if($has_data && date("l") != 'Monday'){
                            $insertPharmacy->updatePharmacies($insertdata);
                        }
                        if(!$has_data) {
                            $insertPharmacy->insertPharmacies($insertdata);
                        }

                    ++$l;
                }
            }
            fclose($records);
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            return "Imported";
        } else {
            error_log("file missing");
        }
    }

    private function getState()
    {
        $sql = "select state from facility";
        $res = sqlQuery($sql);
        return $res['state'];
    }
}
