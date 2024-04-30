<?php

/**
 * package   OpenEMR
 *  link      http//www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https//github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

namespace Juggernaut\Module\AdvancedFinancial\App\Controllers;

class InsuranceCompanies
{
    public static function insuranceCompaniesReceivables()
    {
        $payers = [];
        $companiesQuery = "SELECT DISTINCT description FROM `ar_session`" .
            " WHERE `adjustment_code` = 'insurance_payment' AND `description` != ''";
        $list = sqlStatement($companiesQuery);
        while ($iter = sqlFetchArray($list)) {
            $payers[] = $iter['description'];
        }
        return $payers;
    }

    public static function payerID($payerName)
    {
        $query = "SELECT `id` FROM `insurance_companies` WHERE `name` = ?";
        return sqlQuery($query, [$payerName]);
    }

//    public static function insuranceCompanies($selectedCompany): string
//    {
//        $companies = [];
//        $query = self::companiesQuery();
//        $sql = sqlStatement($query);
//        while ($iter = sqlFetchArray($sql)) {
//            $companies[] = $iter;
//        }
//        $select = "<select name='icompany' id='icompany' class='select2-search--dropdown'>";
//        $select .= "<option></option>";
//        foreach ($companies as $company) {
//            $select .= "<option value='" . $company['id'] . "'";
//            if (!empty($selectedCompany) && $selectedCompany == $company['id']) {
//                $select .= ' selected ';
//            }
//            $select .= ">";
//            $select .= $company['name'];
//            $select .= "</option>";
//        }
//        $select .= "</select>";
//        return $select;
//    }
//
//    public static function firstInsuaranceCompany(): bool|array|null
//    {
//        $query = self::companiesQuery();
//        return sqlQuery($query . " ORDER BY ic.id ASC LIMIT 1");
//    }
//
//    private static function companiesQuery(): string
//    {
//        return "SELECT DISTINCT ic.id, ic.name " .
//            "FROM insurance_companies AS ic, insurance_data AS ind WHERE ic.id = ind.provider ";
//    }
}
