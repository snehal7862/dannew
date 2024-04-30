<?php
 use OpenEMR\Common\Crypto\CryptoGen;
 use OpenEMR\Rx\Weno\LogDataInsert;
 require_once(__DIR__ . '/globals.php');

$cryptogen = new CryptoGen();
// $weno_username = "kkappiah@medsov.com";
// $weno_password = "{{Pauli@45}}";
// $encryption_key = $cryptoGen->decryptStandard($GLOBALS['weno_encryption_key']);
// $baseurl = "https://online.wenoexchange.com/en/EPCS/DownloadPharmacyDirectory";

$data = array(
    "UserEmail"             => $weno_username,
    "MD5Password"           => md5($weno_password),
    "ExcludeNonWenoTest"    => "N",
    "Daily"                 => "N"
);

if(date("l") == "Sunday"){ //if today is Sunday download the weekly file
    $data["Daily"] = "N"; 
}
// $json_object = json_encode($data);
// $method = 'aes-256-cbc';

// $key = substr(hash('sha256', $encryption_key, true), 0, 32);

// $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

// $encrypted = base64_encode(openssl_encrypt($json_object, $method, $key, OPENSSL_RAW_DATA, $iv));

// $fileUrl = $baseurl . "?useremail=" . $weno_username . "&data=" . urlencode($encrypted);

// $storelocation = $GLOBALS['web_root'] . "/sites/" . $_SESSION['site_id'] . "/documents/logs_and_misc/";
// $storelocation = $GLOBALS['web_root'] . "/sites/" . $_SESSION['site_id'] . "/documents/logs_and_misc/weno.zip";


// //takes URL of image and Path for the image as parameter
// function download_image1($image_url, $image_file){
//     $fp = fopen ($image_file, 'w+');              // open file handle

//     $ch = curl_init($image_url);
//     // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // enable if you want
//     curl_setopt($ch, CURLOPT_FILE, $fp);          // output to file
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//     curl_setopt($ch, CURLOPT_TIMEOUT, 1000);      // some large value to allow curl to run for a long time
//     curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
//     // curl_setopt($ch, CURLOPT_VERBOSE, true);   // Enable this line to see debug prints
//     curl_exec($ch);

//     curl_close($ch);                              // closing curl handle
//     fclose($fp);                                  // closing file handle
// }


// download_image1("https://images.pexels.com/photos/1532771/pexels-photo-1532771.jpeg", "../contrib/weno/local_image1.jpg");

$zip = new ZipArchive;

$path_to_extract = $GLOBALS['fileroot'] . "/contrib/weno/";
$storelocation = $GLOBALS['fileroot'] . "/contrib/weno/weno_pharmacy.zip";
if ($zip->open($storelocation) === TRUE) {
    $files = glob($path_to_extract . "/*.csv");
    if($files){
        $csvFile = $files[1];
        $filename = basename($csvFile);
        $csvFilename = $filename;
    }
    // Just commented this out
    // for ($i = 0; $i < $zip->numFiles; $i++) {
    //     $filename = $zip->getNameIndex($i);
    //     if (pathinfo($filename, PATHINFO_EXTENSION) === 'csv') {
    //         $csvFilename = $filename;
    //         break;
    //     }
    // }

    if ($csvFilename !== '') {
        $zip->extractTo($path_to_extract);
        $zip->close();
        echo 'File extracted successfully.';
        echo 'CSV filename: ' . $csvFilename;
    } else {
        echo 'No CSV file found in the zip archive.';
    }
} else {
    echo 'Failed to extract the file.';
}

// $csvFile = "20230524_weno_pharmacy_daily.csv";
// $csvFile = "../contrib/weno/20230602_weno_pharmacy_lite_full.csv";
// $csvDelimiter = ","; // Specify the delimiter used in your CSV file
// echo $csvFile;
// $insertPharmacy = new LogDataInsert();
// $insertdata=[];

// $l = 0;
//         if (file_exists($csvFile)) {
//             $records = fopen($csvFile, "r");

//             while (!feof($records)) {
//                 $line = fgetcsv($records);

//                 if ($l <= 1) {
//                     $l++;
//                     continue;
//                 }
//                 if (!isset($line[1])) {
//                     continue;
//                 }
//                 if (!isset($line[1])) {
//                     continue;
//                 }
//                 if (!empty($line)) {
//                     //kofi

//                     if($data['Daily'] == 'N'){
//                         $ncpdp = str_replace(['[', ']'], '', $line[3]);
//                         $npi = str_replace(['[', ']'], '', $line[5]);
//                         $business_name = $line[6];
//                         $address_line_1 = $line[7];
//                         $address_line_2 = $line[8];
//                         $city = $line[9];
//                         $state = $line[10];
//                         $zipcode = str_replace(['[', ']'], '', $line[11]);
//                         $country = $line[12];
//                         $international = $line[13];
//                         $pharmacy_phone = str_replace(['[', ']'], '', $line[16]);
//                         $on_weno = $line[21];
//                         $test_pharmacy = $line[17];
//                         $state_wide_mail = $line[18];
//                         $fullDay = $line[22];
//                     } else {
//                         $ncpdp = str_replace(['[', ']'], '', $line[3]);
//                         $npi = str_replace(['[', ']'], '', $line[7]);
//                         $business_name = $line[8];
//                         $city = $line[11];
//                         $state = $line[12];
//                         $zipcode = str_replace(['[', ']'], '', $line[14]);
//                         $country = $line[15];
//                         $address_line_1 = $line[9];
//                         $address_line_2 = $line[10];
//                         $international = $line[16];
//                         $pharmacy_phone = str_replace(['[', ']'], '', $line[20]);
//                         $county = $line[33];
//                         $on_weno = $line[37];
//                         $compounding = $line[41];
//                         $medicaid_id = $line[45];
//                         $dea = $line[44];
//                         $test_pharmacy = $line[29];
//                         $fullDay = $line[40];
//                         $state_wide_mail = $line[47];
//                     }

//                     $insertdata['ncpdp'] = $ncpdp;
//                     $insertdata['npi'] = $npi;
//                     $insertdata['business_name'] = $business_name;
//                     $insertdata['address_line_1'] = $address_line_1;
//                     $insertdata['address_line_2'] = $address_line_2;
//                     $insertdata['city'] = $city;
//                     $insertdata['state'] = $state;
//                     $insertdata['zipcode'] = $zipcode;
//                     $insertdata['country'] = $country;
//                     $insertdata['international'] = $international;
//                     $insertdata['pharmacy_phone'] = $pharmacy_phone;
//                     $insertdata['on_weno'] = $on_weno;
//                     $insertdata['test_pharmacy'] = $test_pharmacy;
//                     $insertdata['state_wide_mail'] = $state_wide_mail;
//                     $insertdata['fullDay'] = $fullDay;

//                     //echo $on_weno . "<br/>";
//                     $insertPharmacy->insertPharmacies($insertdata);
//                     //sqlInsert("INSERT IGNORE INTO weno_pharmacy(ncpdp, npi, business_name, address_line_1, address_line_2,city, state, zipcode, country_code, international, pharmacy_phone, on_weno, test_pharmacy,state_wide_mail_order, 24hr) VALUES('$ncpdp','$npi','$business_name','$address_line_1','$address_line_2','$city','$state','$zipcode','$country','$international','$pharmacy_phone','$on_weno','$test_pharmacy','$state_wide_mail','$fullDay')");

//                     ++$l;
//                 }
//             }
//             fclose($records);
//         }else {
//             echo "file missing";
//         }


?>
