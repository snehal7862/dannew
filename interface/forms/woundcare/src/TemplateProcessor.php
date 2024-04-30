<?php

/**
 * Use this class to connect the template to other classess or process in the system.
 * This is just a starter class. We can build classes as needed for this project
 */

namespace WoundCare;

class TemplateProcessor
{
    public static function sendToChartUploaedImage($imageName, $image, $pid): void
    {
        require_once dirname(__DIR__, 4) . "/interface/globals.php";
        require_once dirname(__DIR__, 4) . "/controllers/C_Document.class.php";
        require_once dirname(__DIR__, 4) . "/library/documents.php";
        $size = filesize($image);
        $type = "application/jpeg";
        $category_id = 4677;

        addNewDocument($imageName, $type, $image, 0, $size, $pid, $pid, $category_id);

    }
}
