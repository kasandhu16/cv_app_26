<?php
require_once 'php/config.php';
require_once 'php/cv.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo 'Resume ID required';
    exit;
}

$resumeId = (int)$_GET['id'];
$userId = getCurrentUserId();

// Get resume data
$resume = getResume($resumeId, $userId);
if (!$resume) {
    http_response_code(404);
    echo 'Resume not found';
    exit;
}

$cvData = json_decode($resume['data'], true);
$templateId = $resume['template_id'];

// Check if user has premium access for PDF export
if (!hasPremiumAccess($userId, 'pdf_export')) {
    // Redirect to payment page
    header('Location: payment.php?feature=pdf_export&resume_id=' . $resumeId);
    exit;
}

// Generate PDF
try {
    $pdfContent = generateCVPDF($cvData, $templateId);

    // Cache the PDF
    $filename = 'cv_' . $resumeId . '_' . time();
    savePDFToCache($pdfContent, $filename);

    // Output PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="cv.pdf"');
    header('Content-Length: ' . strlen($pdfContent));
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');

    echo $pdfContent;
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo 'PDF generation failed: ' . $e->getMessage();
    exit;
}
?>