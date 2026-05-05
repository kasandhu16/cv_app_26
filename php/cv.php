<?php
// CV-related functions

function getCVDataStructure() {
    return [
        'personal' => [
            'name' => '',
            'title' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
            'linkedin' => '',
            'github' => ''
        ],
        'summary' => '',
        'experience' => [],
        'education' => [],
        'skills' => []
    ];
}

function processCVData($postData) {
    $cvData = getCVDataStructure();

    // Sanitize and process personal details
    foreach ($cvData['personal'] as $key => $value) {
        $cvData['personal'][$key] = htmlspecialchars(trim($postData['personal'][$key] ?? ''), ENT_QUOTES, 'UTF-8');
    }

    // Sanitize summary
    $cvData['summary'] = htmlspecialchars(trim($postData['summary'] ?? ''), ENT_QUOTES, 'UTF-8');

    // Process work experience
    if (isset($postData['experience']) && is_array($postData['experience'])) {
        foreach ($postData['experience'] as $exp) {
            $cvData['experience'][] = [
                'title' => htmlspecialchars(trim($exp['title'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'company' => htmlspecialchars(trim($exp['company'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'dates' => htmlspecialchars(trim($exp['dates'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'description' => htmlspecialchars(trim($exp['description'] ?? ''), ENT_QUOTES, 'UTF-8'),
            ];
        }
    }

    // Process education
    if (isset($postData['education']) && is_array($postData['education'])) {
        foreach ($postData['education'] as $edu) {
            $cvData['education'][] = [
                'degree' => htmlspecialchars(trim($edu['degree'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'school' => htmlspecialchars(trim($edu['school'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'dates' => htmlspecialchars(trim($edu['dates'] ?? ''), ENT_QUOTES, 'UTF-8'),
            ];
        }
    }

    // Process skills
    if (!empty($postData['skills'])) {
        $skills = explode(',', $postData['skills']);
        foreach ($skills as $skill) {
            $cvData['skills'][] = htmlspecialchars(trim($skill), ENT_QUOTES, 'UTF-8');
        }
    }

    return $cvData;
}
