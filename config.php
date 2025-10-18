<?php
header('Content-Type: text/html; charset=utf-8');

// 타임존 설정
date_default_timezone_set('Asia/Seoul');

// 세션 저장 경로 설정 (클라우드 환경 대응)
$session_dir = sys_get_temp_dir();
if (is_writable($session_dir)) {
    session_save_path($session_dir);
} else {
    $session_dir = __DIR__ . '/data/sessions';
    if (!is_dir($session_dir)) {
        @mkdir($session_dir, 0777, true);
    }
    if (is_writable($session_dir)) {
        session_save_path($session_dir);
    }
}

// 세션 설정
session_start();

// 요청 데이터 캐시 (php://input은 한 번만 읽을 수 있으므로)
$GLOBALS['request_data'] = null;

function getRequestData() {
    if ($GLOBALS['request_data'] === null) {
        $GLOBALS['request_data'] = json_decode(file_get_contents('php://input'), true) ?: [];
    }
    return $GLOBALS['request_data'];
}

// 데이터 저장 폴더
define('DATA_DIR', __DIR__ . '/data');
if (!is_dir(DATA_DIR)) {
    @mkdir(DATA_DIR, 0777, true);
}

// 사용자 데이터 파일
define('USERS_FILE', DATA_DIR . '/users.json');
define('REPORTS_FILE', DATA_DIR . '/reports.json');

// 사용자 데이터 불러오기
function loadUsers() {
    if (!file_exists(USERS_FILE)) {
        return [];
    }
    return json_decode(file_get_contents(USERS_FILE), true) ?: [];
}

// 사용자 데이터 저장
function saveUsers($users) {
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// 신고 데이터 불러오기
function loadReports() {
    if (!file_exists(REPORTS_FILE)) {
        return [];
    }
    return json_decode(file_get_contents(REPORTS_FILE), true) ?: [];
}

// 신고 데이터 저장
function saveReports($reports) {
    file_put_contents(REPORTS_FILE, json_encode($reports, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// 사용자 로그인 확인
function isLoggedIn() {
    // 세션 확인
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
        return true;
    }
    
    // 요청 데이터에서 user_id 확인
    $data = getRequestData();
    if (!empty($data['user_id'])) {
        return true;
    }
    
    // GET 파라미터에서 user_id 확인
    if (!empty($_GET['user_id'])) {
        return true;
    }
    
    // POST 파라미터에서 user_id 확인
    if (!empty($_POST['user_id'])) {
        return true;
    }
    
    return false;
}

// 현재 사용자 정보 가져오기
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    $users = loadUsers();
    return $users[$_SESSION['user_id']] ?? null;
}
