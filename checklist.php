<?php
header('Content-Type: text/html; charset=utf-8');
/**
 * Cloudtype 배포 체크리스트
 * https://your-domain/checklist.php 에서 확인하세요
 */

echo "<h1>🔍 Cloudtype 배포 체크리스트</h1>";
echo "<hr>";

$checks = [
    '✅ PORT 환경변수' => isset($_SERVER['PORT']) || isset($_ENV['PORT']),
    '✅ 0.0.0.0 바인딩' => $_SERVER['SERVER_ADDR'] ?? 'Unknown',
    '✅ PHP 버전' => phpversion(),
    '✅ 현재 디렉토리' => getcwd(),
    '✅ index.php 존재' => file_exists('index.php') ? 'YES' : 'NO',
    '✅ config.php 존재' => file_exists('config.php') ? 'YES' : 'NO',
    '✅ data 폴더' => is_dir('data') ? 'EXISTS' : 'MISSING',
    '✅ data 쓰기 권한' => is_writable('data') ? 'WRITABLE' : 'READ-ONLY',
    '✅ 세션 경로' => session_save_path(),
    '✅ 임시 폴더' => sys_get_temp_dir(),
];

echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr style='background: #f0f0f0;'><th>항목</th><th>상태</th></tr>";

foreach ($checks as $name => $value) {
    $bg = (strpos($value, 'NO') !== false || strpos($value, 'MISSING') !== false) ? '#ffcccc' : '#ccffcc';
    echo "<tr style='background: $bg;'>";
    echo "<td>$name</td>";
    echo "<td><strong>" . (is_bool($value) ? ($value ? 'OK' : 'ERROR') : $value) . "</strong></td>";
    echo "</tr>";
}

echo "</table>";
echo "<hr>";
echo "<p style='color: green; font-weight: bold;'>✅ 모두 정상이면 503 에러가 나타나지 않습니다!</p>";
?>
