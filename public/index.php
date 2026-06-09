<?php

// ============================================
// 检测是否为浏览器直接访问 → 返回 HTML 页面
// ============================================
$isBrowserRequest = (
    ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' &&
    empty($_GET['url']) &&
    empty($_POST['url']) &&
    !isset($_GET['ajax']) &&
    stripos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') === false
);

if ($isBrowserRequest) {
    require __DIR__ . '/template.php';
    exit;
}

// ============================================
// API 逻辑（原有代码保持不变）
// ============================================

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\VideoParser;
use App\Services\RateLimiter;
use App\Utils\Response;
use App\Utils\Config;
use App\Utils\Logger;

// 仅支持 GET 和 POST 方法
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if (!in_array($method, ['GET', 'POST'])) {
    Response::error('不支持的请求方法', 405);
}

// 速率限制检查
$ip = RateLimiter::getClientIp();
if (Config::get('rate_limit.enabled', true)) {
    $rateLimitResult = RateLimiter::check($ip);
    
    if (!$rateLimitResult['allowed']) {
        Response::error('请求过于频繁，请稍后再试', 429);
    }
}

// 获取并验证 URL 参数
$url = trim($_GET['url'] ?? $_POST['url'] ?? '');
if (empty($url)) {
    Response::validationError(['url' => 'URL 参数不能为空']);
}

// 先尝试从输入中提取 HTTP 链接（用户可能粘贴了整段分享文本）
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    preg_match('/https?:\/\/[^\s<>"\']+/i', $url, $matches);
    if (!empty($matches[0])) {
        $url = $matches[0];
    }
}

if (!filter_var($url, FILTER_VALIDATE_URL) || !preg_match('/^https?:\/\//i', $url)) {
    Response::validationError(['url' => '无效的 URL 格式']);
}

// 设置 AJAX 请求头
header('Content-Type: application/json; charset=utf-8');

// 解析视频
try {
    $parser = new VideoParser();
    $data = $parser->parse($url);
    Response::success($data, '解析成功');
    
} catch (\InvalidArgumentException $e) {
    Response::error($e->getMessage(), 400);
    
} catch (\RuntimeException $e) {
    Logger::error('解析失败', ['url' => $url, 'ip' => $ip ?? 'unknown', 'error' => $e->getMessage()]);
    Response::error($e->getMessage(), 500);
    
} catch (\Exception $e) {
    Logger::exception($e, ['url' => $url, 'ip' => $ip ?? 'unknown']);
    Response::error('服务器内部错误，请稍后再试', 500);
}
