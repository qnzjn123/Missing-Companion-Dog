<?php
require 'config.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'login':
        handleLogin();
        break;
    case 'signup':
        handleSignup();
        break;
    case 'logout':
        handleLogout();
        break;
    case 'getCurrentUser':
        getCurrentUserData();
        break;
    case 'saveReport':
        saveReportData();
        break;
    case 'getReports':
        getReportsData();
        break;
    case 'addOnlineUser':
        addOnlineUserSession();
        break;
    case 'getOnlineUsers':
        getOnlineUsersSession();
        break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
}

function handleLogin() {
    $data = getRequestData();
    
    // 세션 복원 모드 (클라이언트가 이미 로그인 정보를 가지고 있을 때)
    if (!empty($data['skip_password']) && !empty($data['user_id'])) {
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['user_email'] = $data['user_email'];
        $_SESSION['user_name'] = $data['user_name'];
        
        echo json_encode([
            'success' => true,
            'message' => '세션 복원됨',
            'user' => [
                'id' => $data['user_id'],
                'name' => $data['user_name'],
                'email' => $data['user_email']
            ]
        ]);
        return;
    }
    
    // 일반 로그인
    if (empty($data['email']) || empty($data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => '이메일과 비밀번호를 입력하세요.']);
        return;
    }

    $users = loadUsers();
    
    foreach ($users as $id => $user) {
        if ($user['email'] === $data['email']) {
            if (password_verify($data['password'], $user['password'])) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                
                echo json_encode([
                    'success' => true,
                    'message' => '로그인 성공',
                    'user' => [
                        'id' => $id,
                        'name' => $user['name'],
                        'email' => $user['email']
                    ]
                ]);
                return;
            }
        }
    }

    http_response_code(401);
    echo json_encode(['error' => '이메일 또는 비밀번호가 일치하지 않습니다.']);
}

function handleSignup() {
    $data = getRequestData();
    
    // 유효성 검사
    if (empty($data['name']) || empty($data['email']) || empty($data['password']) || empty($data['phone'])) {
        http_response_code(400);
        echo json_encode(['error' => '모든 필수 항목을 입력하세요.']);
        return;
    }

    // 이메일 형식 확인
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => '유효한 이메일 주소를 입력하세요.']);
        return;
    }

    // 비밀번호 길이 확인
    if (strlen($data['password']) < 8) {
        http_response_code(400);
        echo json_encode(['error' => '비밀번호는 8자 이상이어야 합니다.']);
        return;
    }

    $users = loadUsers();

    // 중복 이메일 확인
    foreach ($users as $user) {
        if ($user['email'] === $data['email']) {
            http_response_code(400);
            echo json_encode(['error' => '이미 가입된 이메일 주소입니다.']);
            return;
        }
    }

    // 새 사용자 추가
    $userId = uniqid('user_');
    $users[$userId] = [
        'id' => $userId,
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'address' => $data['address'] ?? '',
        'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        'created_at' => date('Y-m-d H:i:s')
    ];

    saveUsers($users);

    $_SESSION['user_id'] = $userId;
    $_SESSION['user_email'] = $data['email'];
    $_SESSION['user_name'] = $data['name'];

    echo json_encode([
        'success' => true,
        'message' => '회원 가입 성공',
        'user' => [
            'id' => $userId,
            'name' => $data['name'],
            'email' => $data['email']
        ]
    ]);
}

function handleLogout() {
    session_destroy();
    echo json_encode(['success' => true, 'message' => '로그아웃 되었습니다.']);
}

function getCurrentUserData() {
    if (isLoggedIn()) {
        $user = getCurrentUser();
        echo json_encode([
            'success' => true,
            'user' => [
                'id' => $_SESSION['user_id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'phone' => $user['phone'] ?? '',
                'address' => $user['address'] ?? ''
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'user' => null]);
    }
}

function saveReportData() {
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['error' => '로그인이 필요합니다.']);
        return;
    }

    $data = getRequestData();
    
    if (empty($data['type']) || empty($data['title']) || empty($data['description'])) {
        http_response_code(400);
        echo json_encode(['error' => '필수 항목을 입력하세요.']);
        return;
    }

    // 사용자 정보 가져오기
    $userId = $data['user_id'] ?? $_SESSION['user_id'] ?? null;
    $userName = $data['user_name'] ?? $_SESSION['user_name'] ?? 'Unknown';
    $userEmail = $data['user_email'] ?? $_SESSION['user_email'] ?? 'Unknown';

    if (!$userId) {
        http_response_code(401);
        echo json_encode(['error' => '사용자 정보가 없습니다.']);
        return;
    }

    $reports = loadReports();
    
    $reportId = uniqid('report_');
    $reports[$reportId] = [
        'id' => $reportId,
        'type' => $data['type'], // 'missing' 또는 'sighting'
        'title' => $data['title'],
        'description' => $data['description'],
        'latitude' => $data['latitude'] ?? 0,
        'longitude' => $data['longitude'] ?? 0,
        'location' => $data['location'] ?? '',
        'breed' => $data['breed'] ?? '',
        'color' => $data['color'] ?? '',
        'image' => $data['image'] ?? '', // base64
        'phone' => $data['phone'] ?? '',
        'user_id' => $userId,
        'user_name' => $userName,
        'user_email' => $userEmail,
        'created_at' => date('Y-m-d H:i:s'),
        'status' => 'active'
    ];

    saveReports($reports);

    echo json_encode([
        'success' => true,
        'message' => '신고가 등록되었습니다.',
        'id' => $reportId,
        'report_id' => $reportId
    ]);
}

function getReportsData() {
    $type = $_GET['type'] ?? null; // 'missing', 'sighting', 또는 null (모두)
    
    $reports = loadReports();
    
    if ($type) {
        $reports = array_filter($reports, function($r) use ($type) {
            return $r['type'] === $type;
        });
    }

    // 최신순 정렬
    usort($reports, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });

    echo json_encode([
        'success' => true,
        'reports' => array_values($reports)
    ]);
}

function addOnlineUserSession() {
    if (!isLoggedIn()) {
        return;
    }

    if (!isset($_SESSION['online_users'])) {
        $_SESSION['online_users'] = [];
    }

    $userId = $_SESSION['user_id'];
    if (!in_array($userId, $_SESSION['online_users'])) {
        $_SESSION['online_users'][] = $userId;
    }

    echo json_encode(['success' => true]);
}

function getOnlineUsersSession() {
    if (!isset($_SESSION['online_users'])) {
        echo json_encode(['success' => true, 'users' => []]);
        return;
    }

    $users = loadUsers();
    $onlineUsers = [];

    foreach ($_SESSION['online_users'] as $userId) {
        if (isset($users[$userId])) {
            $onlineUsers[] = [
                'id' => $userId,
                'name' => $users[$userId]['name'],
                'email' => $users[$userId]['email']
            ];
        }
    }

    echo json_encode([
        'success' => true,
        'users' => $onlineUsers
    ]);
}
