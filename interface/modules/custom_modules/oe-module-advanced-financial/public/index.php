<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
/**
 *
 *  package   OpenEMR
 *  link      https://affordablecustomehr.como
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  All rights reserved
 *
 */

require_once dirname(__FILE__, 5) . "/globals.php";
require_once dirname(__FILE__) . "/../vendor/autoload.php";

use Juggernaut\Module\AdvancedFinancial\App\Controllers\MonthlyIncomeDataPoints;
use Juggernaut\Module\AdvancedFinancial\App\Controllers\InsuranceCompanies;

use OpenEMR\Core\Header;



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo xlt("Graphical Income Report"); ?></title>
    <?php Header::setupHeader(['common'])?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div class="container-lg mt-5">
        <h2 class="m-4"><?php echo xlt('Insurance Revenue'); ?></h2>
        <h3>($<?php echo text(oeFormatMoney(86203)); ?>)</h3>
        <p><?php echo xlt('Revenues paid out over the last 6 months') ?></p>
        <div>
            <canvas id="myChart"></canvas>
        </div>
        <div class="mt-3">
        </div>
		<div class="mt-5">
            &copy; <?php echo date('Y') . xlt(" Juggernaut Systems Express") ?>
		</div>
    </div>
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['HMSA', 'Blue Cross', 'TriCare', 'Anthem', 'Aloha Care', 'United Health Care'],
                datasets: [{
                    label: 'Revenue',
                    data: [12620, 35270, 3620, 26940, 5890, 1863],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
