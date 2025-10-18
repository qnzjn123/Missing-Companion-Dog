<?php
header('Content-Type: application/json; charset=utf-8');
// CORS 설정
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

session_start();

// 세션 디렉토리 (안전한 경로)
$sessionsDir = __DIR__ . '/data/sessions/';
if (!is_dir($sessionsDir)) {
    @mkdir($sessionsDir, 0755, true);
}

$action = $_GET['action'] ?? $_POST['action'] ?? 'get';

// 사용자 세션 정보 저장
function saveUserSession() {
    global $sessionsDir;
    
    $sessionFile = $sessionsDir . session_id() . '.json';
    
    // POST 요청에서 전송된 사용자 정보 가져오기
    $requestData = json_decode(file_get_contents('php://input'), true) ?? [];
    $userName = $requestData['userName'] ?? $_POST['userName'] ?? $_SESSION['userName'] ?? 'Anonymous_' . substr(session_id(), 0, 6);
    $userEmail = $requestData['userEmail'] ?? $_POST['userEmail'] ?? $_SESSION['userEmail'] ?? '';
    
    // 로그인한 사용자인 경우 이름 설정
    if (!empty($userName) && $userName !== 'Anonymous_' . substr(session_id(), 0, 6)) {
        $displayName = $userName;
    } else {
        $displayName = 'Anonymous_' . substr(session_id(), 0, 6);
    }
    
    $userData = [
        'session_id' => session_id(),
        'user_name' => $displayName,
        'user_email' => $userEmail,
        'last_active' => time(),
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown'
    ];
    
    file_put_contents($sessionFile, json_encode($userData));
}

// 사용자 세션 제거
function removeUserSession() {
    global $sessionsDir;
    $sessionFile = $sessionsDir . session_id() . '.json';
    if (file_exists($sessionFile)) {
        unlink($sessionFile);
    }
}

// 오래된 세션 정리 (15분 이상 활동 없음)
function cleanOldSessions() {
    global $sessionsDir;
    $timeout = 15 * 60; // 15분
    $now = time();
    
    if (is_dir($sessionsDir)) {
        $files = scandir($sessionsDir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $filePath = $sessionsDir . $file;
                if (is_file($filePath)) {
                    $data = json_decode(file_get_contents($filePath), true);
                    if ($data && ($now - $data['last_active'] > $timeout)) {
                        unlink($filePath);
                    }
                }
            }
        }
    }
}

// 온라인 사용자 조회
function getOnlineUsers() {
    global $sessionsDir;
    cleanOldSessions();
    
    $onlineUsers = [];
    
    if (is_dir($sessionsDir)) {
        $files = scandir($sessionsDir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $filePath = $sessionsDir . $file;
                if (is_file($filePath)) {
                    $data = json_decode(file_get_contents($filePath), true);
                    if ($data) {
                        // 이모지 추가 (무작위)
                        $emojis = ['🧑‍💻', '👨‍💻', '👩‍💻', '👤', '🐕', '🦮', '🐩'];
                        $emoji = $emojis[array_rand($emojis)];
                        
                        $onlineUsers[] = [
                            'session_id' => substr($data['session_id'], 0, 8),
                            'user_name' => $emoji . ' ' . $data['user_name'],
                            'last_active' => $data['last_active'],
                            'is_current' => $data['session_id'] === session_id()
                        ];
                    }
                }
            }
        }
    }
    
    // 최근 활동 순으로 정렬
    usort($onlineUsers, function($a, $b) {
        return $b['last_active'] - $a['last_active'];
    });
    
    // 최대 50명만 반환
    return array_slice($onlineUsers, 0, 50);
}

// 액션 처리
switch ($action) {
    case 'update':
        saveUserSession();
        echo json_encode(['status' => 'success']);
        break;
        
    case 'get':
        saveUserSession();
        $users = getOnlineUsers();
        echo json_encode([
            'status' => 'success',
            'total_users' => count($users),
            'users' => $users
        ]);
        break;
        
    case 'remove':
        removeUserSession();
        echo json_encode(['status' => 'success']);
        break;
        
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
?>
