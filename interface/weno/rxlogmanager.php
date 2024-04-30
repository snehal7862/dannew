<?php

/*
 *  @package OpenEMR
 *  @link    http://www.open-emr.org
 *  @author  Sherwin Gaddis <sherwingaddis@gmail.com>
 *  @copyright Copyright (c) 2021 Sherwin Gaddis <sherwingaddis@gmail.com>
 *  @license https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

require_once("../globals.php");

use OpenEMR\Common\Acl\AclMain;
use OpenEMR\Rx\Weno\Container;
use OpenEMR\Rx\Weno\LogProperties;

/*
 * access control is on Weno side based on the user login
 */
if (!AclMain::aclCheckCore('patient', 'med')) {
    echo xlt('Prescriptions Review Not Authorized');
    exit;
}

$log_properties = new LogProperties();
$logurlparam = $log_properties->logReview();
$provider_info = $log_properties->getProviderEmail();

if ($logurlparam == 'error') {
    echo xlt("Cipher failure check encryption key");
    exit;
}

$url = "https://online.wenoexchange.com/en/EPCS/RxLog?useremail=";

//**warning** do not add urlencode to  $provider_info['email']
$urlOut = $url . $provider_info['email'] . "&data=" . urlencode($logurlparam);
header("Location: " . $urlOut);

?>

<div class="mt-3">
    <iframe id="wenoIfram"
            title="Weno IFRAME"
            width="100%"
            height="100%"
            src="<?php echo $urlOut; ?>">
    </iframe>
</div>
