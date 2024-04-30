<?php

/**
 * Handles the display of the address list datatype in LBF
 *
 * @package   OpenEMR
 * @link      https://www.open-emr.org
 *
 * @author    Kofi Appiah <kkappiah@medsov.com>
 * @copyright Copyright (c) 2023 Omega Systems Group International. <info@omegasystemsgroup.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

use OpenEMR\Services\PharmacyService;

$pharmacyService = new PharmacyService();
$prim_pharmacy = $pharmacyService->getWenoPrimaryPharm($_SESSION['pid']) ?? [];
$alt_pharmacy = $pharmacyService->getWenoAlternatePharm($_SESSION['pid']) ?? [];

$primary_pharmacy = $prim_pharmacy['business_name'] ?? '' . ' - ' . $prim_pharmacy['address_line_1'] ?? '';
$alternate_pharmacy = $alt_pharmacy['business_name'] ?? '' . ' - ' . $alt_pharmacy['address_line_1'] ?? '';
?>

<div class="row col-12">
    <div>
        <label><b><?php echo text("Weno Primary Pharmacy:"); ?></b></label>
        <span><?php echo text($primary_pharmacy); ?></span>
    </div>
    <div>
        <label><b><?php echo text("Weno Alt Pharmacy:"); ?></b></label>
        <span><?php echo text($alternate_pharmacy); ?></span>
    </div>
</div>