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

function validateCVData($cvData) {
    return !empty($cvData['personal']['name']) && !empty($cvData['personal']['email']);
}

function getResume($id, $userId) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare('SELECT * FROM resumes WHERE id = ? AND (user_id = ? OR user_id IS NULL)');
    $stmt->execute([$id, $userId]);
    return $stmt->fetch();
}

function saveResume($cvData, $templateId, $userId, $sessionId) {
    $pdo = getDBConnection();
    $dataJson = json_encode($cvData);

    if (isset($_GET['id'])) { // Update existing
        $resumeId = $_GET['id'];
        $stmt = $pdo->prepare('UPDATE resumes SET data = ?, template_id = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND (user_id = ? OR guest_session_id = ?)');
        if ($stmt->execute([$dataJson, $templateId, $resumeId, $userId, $sessionId])) {
            return $resumeId;
        }
    } else { // Insert new
        $stmt = $pdo->prepare('INSERT INTO resumes (user_id, guest_session_id, template_id, data) VALUES (?, ?, ?, ?)');
        if ($stmt->execute([$userId, $userId ? null : $sessionId, $templateId, $dataJson])) {
            return $pdo->lastInsertId();
        }
    }
    return false;
}

/**
 * Get all resumes for a specific user.
 */
function getResumesForUser($userId) {
    if (!$userId) {
        return [];
    }
    $pdo = getDBConnection();
    $stmt = $pdo->prepare('SELECT id, template_id, updated_at FROM resumes WHERE user_id = ? ORDER BY updated_at DESC');
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

/**
 * Delete a resume.
 */
function deleteResume($resumeId, $userId) {
    if (!$resumeId || !$userId) {
        return false;
    }
    $pdo = getDBConnection();
    // Ensure the resume belongs to the user before deleting
    $stmt = $pdo->prepare('DELETE FROM resumes WHERE id = ? AND user_id = ?');
    return $stmt->execute([$resumeId, $userId]);
}
