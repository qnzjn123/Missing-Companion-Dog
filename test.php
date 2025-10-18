<?php
// 서버 정상 작동 테스트 페이지
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'status' => 'OK',
    'message' => '서버가 정상 작동 중입니다',
    'php_version' => phpversion(),
    'timestamp' => date('Y-m-d H:i:s'),
    'server_name' => $_SERVER['SERVER_NAME'] ?? 'Unknown',
    'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'Unknown'
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
