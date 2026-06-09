<?php
// 自动检测本机局域网 IP 地址
$ip = '';

// 方法1: exec ipconfig（Windows）
if (function_exists('exec')) {
    @exec('ipconfig 2>&1', $output, $rc);
    if ($rc === 0) {
        foreach ($output as $line) {
            if (preg_match('/IPv4[^:]*:\s*(\d+\.\d+\.\d+\.\d+)/i', $line, $m)) {
                $candidate = $m[1];
                if ($candidate !== '127.0.0.1') {
                    $ip = $candidate;
                    break;
                }
            }
        }
    }
}

// 方法2: SERVER_ADDR（内置服务器）
if (empty($ip) && !empty($_SERVER['SERVER_ADDR'])) {
    $candidate = $_SERVER['SERVER_ADDR'];
    if ($candidate !== '127.0.0.1' && $candidate !== '::1' && $candidate !== '0.0.0.0') {
        $ip = $candidate;
    }
}

header('Content-Type: text/plain');
echo $ip;
