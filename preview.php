<?php
require_once 'php/config.php';
require_once 'php/functions.php';
require_once 'php/cv.php';

// Handle AJAX preview requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['cv_data']) && isset($input['template_id'])) {
        $cvData = processCVData($input['cv_data']);
        $templateId = (int)$input['template_id'];

        // Make sure personal_info exists and has a name
        if (!isset($cvData['personal_info']['full_name'])) {
            $cvData['personal_info']['full_name'] = 'Your Name';
        }

        $html = renderCVTemplate($cvData, $templateId);
        echo $html;
        exit;
    }
}

// Fallback for direct access
redirect('/create-cv');
exit;
?>