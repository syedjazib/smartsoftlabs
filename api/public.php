<?php
// api/public.php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Apne config folder ko yahan link kiya hai (ek folder peeche jaa kar)
require_once __DIR__ . '/../config/db.php';

// Database connect
if (function_exists('getDB')) {
    $db = getDB();
} elseif (isset($pdo)) {
    $db = $pdo;
} elseif (isset($db)) {
    // Agar db.php me $db variable pehle se bana hua hai
} else {
    echo json_encode(['success' => false, 'error' => 'Database connection variable not found in db.php']);
    exit;
}

$action = $_GET['action'] ?? '';

try {
    if ($action === 'testimonials') {
        $stmt = $db->query("SELECT * FROM testimonials ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $rows]);
    } 
    elseif ($action === 'staff') {
        $stmt = $db->query("SELECT * FROM team_members ORDER BY id ASC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $rows]);
    } 
    else {
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>