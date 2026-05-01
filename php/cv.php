<?php
require_once 'functions.php';

/**
 * Get CV data structure
 */
function getCVDataStructure() {
    return [
        'personal_info' => [
            'full_name' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
            'website' => '',
            'linkedin' => '',
            'summary' => ''
        ],
        'work_experience' => [],
        'education' => [],
        'skills' => [],
        'languages' => [],
        'certifications' => []
    ];
}

/**
 * Validate and sanitize CV data
 */
function processCVData($data) {
    $cvData = getCVDataStructure();

    // Personal info
    if (isset($data['personal_info'])) {
        $personalInfo = array_map('sanitizeInput', $data['personal_info']);
        $cvData['personal_info'] = array_replace($cvData['personal_info'], $personalInfo);
    }

    // Work experience
    if (isset($data['work_experience']) && is_array($data['work_experience'])) {
        foreach ($data['work_experience'] as $exp) {
            if (!empty($exp['job_title']) || !empty($exp['company'])) {
                $cvData['work_experience'][] = [
                    'job_title' => sanitizeInput($exp['job_title'] ?? ''),
                    'company' => sanitizeInput($exp['company'] ?? ''),
                    'location' => sanitizeInput($exp['location'] ?? ''),
                    'start_date' => sanitizeInput($exp['start_date'] ?? ''),
                    'end_date' => sanitizeInput($exp['end_date'] ?? ''),
                    'current' => isset($exp['current']),
                    'description' => sanitizeInput($exp['description'] ?? '')
                ];
            }
        }
    }

    // Education
    if (isset($data['education']) && is_array($data['education'])) {
        foreach ($data['education'] as $edu) {
            if (!empty($edu['degree']) || !empty($edu['school'])) {
                $cvData['education'][] = [
                    'degree' => sanitizeInput($edu['degree'] ?? ''),
                    'school' => sanitizeInput($edu['school'] ?? ''),
                    'location' => sanitizeInput($edu['location'] ?? ''),
                    'graduation_date' => sanitizeInput($edu['graduation_date'] ?? ''),
                    'gpa' => sanitizeInput($edu['gpa'] ?? ''),
                    'description' => sanitizeInput($edu['description'] ?? '')
                ];
            }
        }
    }

    // Skills
    if (isset($data['skills']) && is_array($data['skills'])) {
        foreach ($data['skills'] as $skill) {
            if (!empty($skill['name'])) {
                $cvData['skills'][] = [
                    'name' => sanitizeInput($skill['name']),
                    'level' => sanitizeInput($skill['level'] ?? 'Beginner')
                ];
            }
        }
    }

    // Languages
    if (isset($data['languages']) && is_array($data['languages'])) {
        foreach ($data['languages'] as $lang) {
            if (!empty($lang['name'])) {
                $cvData['languages'][] = [
                    'name' => sanitizeInput($lang['name']),
                    'proficiency' => sanitizeInput($lang['proficiency'] ?? 'Basic')
                ];
            }
        }
    }

    // Certifications
    if (isset($data['certifications']) && is_array($data['certifications'])) {
        foreach ($data['certifications'] as $cert) {
            if (!empty($cert['name'])) {
                $cvData['certifications'][] = [
                    'name' => sanitizeInput($cert['name']),
                    'issuer' => sanitizeInput($cert['issuer'] ?? ''),
                    'date' => sanitizeInput($cert['date'] ?? ''),
                    'url' => sanitizeInput($cert['url'] ?? '')
                ];
            }
        }
    }

    return $cvData;
}

/**
 * Render CV template
 */
function renderCVTemplate($cvData, $templateId) {
    $templateFile = __DIR__ . '/../templates/template' . $templateId . '.php';

    if (!file_exists($templateFile)) {
        return '<p>Template not found</p>';
    }

    ob_start();
    include $templateFile;
    return ob_get_clean();
}

/**
 * Generate PDF from CV data
 */
function generateCVPDF($cvData, $templateId) {
    require_once __DIR__ . '/../vendor/autoload.php'; // Dompdf autoload

    $html = renderCVTemplate($cvData, $templateId);

    $dompdf = new Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return $dompdf->output();
}

/**
 * Save PDF to cache
 */
function savePDFToCache($pdfContent, $filename) {
    $filepath = PDF_CACHE_DIR . $filename . '.pdf';
    file_put_contents($filepath, $pdfContent);
    return $filepath;
}

/**
 * Get cached PDF
 */
function getCachedPDF($filename) {
    $filepath = PDF_CACHE_DIR . $filename . '.pdf';
    if (file_exists($filepath)) {
        return file_get_contents($filepath);
    }
    return false;
}

/**
 * Clean old PDF cache files (older than 24 hours)
 */
function cleanPDFCache() {
    $files = glob(PDF_CACHE_DIR . '*.pdf');
    $now = time();

    foreach ($files as $file) {
        if ($now - filemtime($file) > 86400) { // 24 hours
            unlink($file);
        }
    }
}
?>