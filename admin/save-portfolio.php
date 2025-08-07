<?php
session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

header('Content-Type: application/json');

// Simple file-based storage for demo (should use DB in production)
$dataFile = __DIR__ . '/portfolio-data.json';
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}
$data = json_decode(file_get_contents($dataFile), true);

$section = $_POST['section'] ?? '';

switch ($section) {
    case 'hero':
        $data['hero'] = [
            'name' => $_POST['name'] ?? '',
            'role' => $_POST['role'] ?? '',
            'department' => $_POST['department'] ?? '',
            'employee_id' => $_POST['employee_id'] ?? '',
        ];
        // Handle profile image upload
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $target = '../assets/images/profile_admin.' . $ext;
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) {
                $data['hero']['profile_image'] = $target;
            }
        }
        break;
    case 'about':
        $data['about'] = [
            'about' => $_POST['about'] ?? ''
        ];
        break;
    case 'skills':
        $data['skills'] = [
            'skills' => $_POST['skills'] ?? ''
        ];
        break;
    case 'projects':
        if (!isset($data['projects'])) $data['projects'] = [];
        $project = [
            'title' => $_POST['project_title'] ?? '',
            'icon' => $_POST['project_icon'] ?? '',
            'desc' => $_POST['project_desc'] ?? ''
        ];
        // Handle project media upload
        if (isset($_FILES['project_media']) && $_FILES['project_media']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['project_media']['name'], PATHINFO_EXTENSION);
            $target = '../assets/images/project_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['project_media']['tmp_name'], $target)) {
                $project['media'] = $target;
            }
        }
        $data['projects'][] = $project;
        break;
    case 'experience':
        $data['experience'] = [
            'experiences' => $_POST['experiences'] ?? ''
        ];
        break;
    case 'certificates':
        if (!isset($data['certificates'])) $data['certificates'] = [];
        $certificate = [
            'title' => $_POST['certificate_title'] ?? '',
            'issuer' => $_POST['certificate_issuer'] ?? '',
            'date' => $_POST['certificate_date'] ?? ''
        ];
        // Handle certificate file upload
        if (isset($_FILES['certificate_file']) && $_FILES['certificate_file']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['certificate_file']['name'], PATHINFO_EXTENSION);
            $target = '../assets/cv/certificate_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['certificate_file']['tmp_name'], $target)) {
                $certificate['file'] = $target;
            }
        }
        $data['certificates'][] = $certificate;
        break;
    case 'contact':
        $data['contact'] = [
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'github' => $_POST['github'] ?? '',
            'instagram' => $_POST['instagram'] ?? ''
        ];
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Section not found']);
        exit();
}

file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
echo json_encode(['success' => true, 'message' => 'Perubahan berhasil disimpan!']);
