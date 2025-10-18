<?php
header('Content-Type: text/html; charset=utf-8');
// 디버그 정보 표시
echo "<h1>System Debug Information</h1>";
echo "<pre>";

echo "=== PHP 정보 ===\n";
echo "PHP 버전: " . phpversion() . "\n";
echo "OS: " . php_uname() . "\n";
echo "SAPI: " . php_sapi_name() . "\n";

echo "\n=== 디렉토리 정보 ===\n";
echo "현재 디렉토리: " . getcwd() . "\n";
echo "스크립트 디렉토리: " . __DIR__ . "\n";

echo "\n=== 세션 정보 ===\n";
echo "세션 저장 경로: " . session_save_path() . "\n";
echo "임시 디렉토리: " . sys_get_temp_dir() . "\n";
echo "임시 디렉토리 쓰기 가능: " . (is_writable(sys_get_temp_dir()) ? 'YES' : 'NO') . "\n";

echo "\n=== 데이터 디렉토리 ===\n";
$data_dir = __DIR__ . '/data';
echo "경로: " . $data_dir . "\n";
echo "존재: " . (is_dir($data_dir) ? 'YES' : 'NO') . "\n";
echo "쓰기 가능: " . (is_writable($data_dir) ? 'YES' : 'NO') . "\n";

if (is_dir($data_dir)) {
    echo "파일 목록: " . implode(', ', scandir($data_dir)) . "\n";
}

echo "\n=== 환경 변수 ===\n";
echo "PORT: " . ($_ENV['PORT'] ?? $_SERVER['PORT'] ?? '미설정') . "\n";
echo "ENVIRONMENT: " . ($_ENV['ENVIRONMENT'] ?? '미설정') . "\n";

echo "</pre>";
?>
