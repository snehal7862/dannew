<?php
    require "../../globals.php";

    use OpenEMR\Common\Csrf\CsrfUtils;
    use OpenEMR\Common\Acl\AclMain;
    use OpenEMR\Common\Twig\TwigContainer;

    $twig = new TwigContainer(null, $GLOBALS['kernel']);

if (!AclMain::aclCheckCore('patients', 'med')) {
    exit;
}
    $sql = "SELECT * FROM prescriptions WHERE patient_id = ? " .
            "AND indication IS NOT NULL";
    $res = sqlStatement($sql, array($pid));

function getProviderByWenoId($external_id)
{
    $provider = sqlQuery("SELECT fname, mname, lname FROM users WHERE weno_prov_id = ? ", array($external_id));
    if ($provider) {
            return $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'];
    } else {
            return "";
    }
}
?>
<style>
    .btr {
            background-color: var(--primary);
            padding: 1px;
            color: white;
            text-decoration: none;
            border-radius: 10px;
    }
    .btr:hover {
            color:white;
            text-decoration: none;
    }

</style>



<div class="row float-right mr-2">
        <div class="mr-3 click" onclick="sync_weno()">
            <u><span><i id="ro" class="fa-solid fa-rotate-right" style="color: #34b76d;"></i></span>synch</u>
        </div>
        <a href="<?php echo $GLOBALS['webroot'] ?>/interface/weno/indexrx.php">
            <span><i class="fa-solid fa-pen" style="color:#289df4"></i></span>
        </a>
</div>

<div>
    <table width='100%'>
        <tr style='border-bottom:2px solid #000;'>
            <th><?php echo xlt("Drug Name"); ?></th>
            <th><?php echo xlt("Prescriber"); ?></th>
            <th><?php echo xlt("Status"); ?></th>
        </tr>
        <?php
        while ($row = sqlFetchArray($res)) { ?>
            <tr>
                <td><?php echo $row["drug"]?></td>
                <td><?php echo getProviderByWenoId($row['external_id']); ?></td>
                <td><?php echo $row["status"]?></td>
            </tr>
        <?php } ?>
            
    </table>
</div>
