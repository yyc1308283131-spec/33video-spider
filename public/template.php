<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Video Spider - 短视频去水印下载工具</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --bg: oklch(0.145 0 0);
  --bg-card: oklch(0.205 0 0);
  --bg-card-hover: oklch(0.235 0 0);
  --bg-input: oklch(0.17 0 0);
  --fg: oklch(0.985 0 0);
  --fg-muted: oklch(0.556 0 0);
  --primary: oklch(0.685 0.169 237.32);
  --primary-hover: oklch(0.585 0.169 237.32);
  --success: oklch(0.627 0.194 149.21);
  --error: oklch(0.577 0.245 27.33);
  --border: oklch(0.269 0 0);
  --border-focus: oklch(0.685 0.169 237.32);
  --radius: 0.75rem;
  --radius-sm: 0.5rem;
  --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.3), 0 1px 2px -1px rgb(0 0 0 / 0.3);
  --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.4), 0 4px 6px -4px rgb(0 0 0 / 0.3);
  --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
  --font-mono: 'JetBrains Mono', monospace;
}

html { font-size: 16px; }
body {
  font-family: var(--font-sans);
  background: var(--bg);
  color: var(--fg);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  line-height: 1.6;
}

/* ========== HEADER ========== */
header {
  border-bottom: 1px solid var(--border);
  padding: 0 1.5rem;
  position: sticky;
  top: 0;
  z-index: 50;
  background: oklch(0.145 0 0 / 0.85);
  backdrop-filter: blur(12px);
}
.header-inner {
  max-width: 720px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  height: 60px;
  gap: 0.75rem;
}
.header-logo {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: linear-gradient(135deg, var(--primary), oklch(0.585 0.245 277.23));
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.header-logo svg { width: 18px; height: 18px; color: white; }
.header-title { font-weight: 700; font-size: 1.05rem; }
.header-badge {
  margin-left: auto;
  font-size: 0.7rem;
  padding: 0.2rem 0.6rem;
  border-radius: 999px;
  background: oklch(0.269 0 0);
  color: var(--fg-muted);
  font-weight: 500;
}

/* ========== MAIN ========== */
main { flex: 1; padding: 2.5rem 1.5rem 3rem; }
.main-inner {
  max-width: 720px;
  margin: 0 auto;
}

/* ========== HERO ========== */
.hero { text-align: center; margin-bottom: 2rem; }
.hero h1 {
  font-size: 1.6rem;
  font-weight: 800;
  background: linear-gradient(135deg, var(--fg) 40%, var(--primary));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 0.5rem;
}
.hero p {
  color: var(--fg-muted);
  font-size: 0.9rem;
}

/* ========== INPUT AREA ========== */
.input-card {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 1.25rem;
  box-shadow: var(--shadow);
  transition: border-color 0.2s, box-shadow 0.2s;
}
.input-card:focus-within {
  border-color: var(--border-focus);
  box-shadow: 0 0 0 3px oklch(0.685 0.169 237.32 / 0.15);
}
.input-row {
  display: flex;
  gap: 0.625rem;
  align-items: stretch;
}
.input-row input {
  flex: 1;
  background: var(--bg-input);
  border: 1px solid var(--border);
  border-radius: var(--radius-sm);
  padding: 0.75rem 1rem;
  font-size: 0.9rem;
  font-family: var(--font-sans);
  color: var(--fg);
  outline: none;
  transition: border-color 0.2s;
}
.input-row input::placeholder { color: var(--fg-muted); }
.input-row input:focus { border-color: var(--border-focus); }

.btn {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.75rem 1.25rem;
  border: none;
  border-radius: var(--radius-sm);
  font-size: 0.875rem;
  font-weight: 600;
  font-family: var(--font-sans);
  cursor: pointer;
  transition: all 0.15s ease;
  white-space: nowrap;
}
.btn:active { transform: scale(0.97); }
.btn-primary {
  background: var(--primary);
  color: white;
}
.btn-primary:hover { background: var(--primary-hover); }
.btn-primary:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  transform: none;
}
.btn-secondary {
  background: var(--bg-input);
  color: var(--fg);
  border: 1px solid var(--border);
}
.btn-secondary:hover { background: var(--bg-card-hover); }
.btn-success {
  background: var(--success);
  color: white;
}
.btn-success:hover { filter: brightness(0.9); }

.input-hint {
  margin-top: 0.5rem;
  font-size: 0.78rem;
  color: var(--fg-muted);
  display: flex;
  gap: 0.5rem;
  align-items: center;
  flex-wrap: wrap;
}
.input-hint span { display: inline-flex; align-items: center; gap: 0.2rem; }
.platform-dot {
  display: inline-block;
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--success);
  margin-right: 0.15rem;
}

/* ========== RESULT CARD ========== */
.result-card {
  margin-top: 1.25rem;
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
  box-shadow: var(--shadow);
  animation: slideUp 0.35s ease-out;
}
@keyframes slideUp {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}

.result-header {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 1rem 1.25rem;
  border-bottom: 1px solid var(--border);
  font-weight: 600;
  font-size: 0.9rem;
}
.result-header.success { color: var(--success); }
.result-header.error { color: var(--error); }

.result-body { padding: 1.25rem; }

.result-main {
  display: flex;
  gap: 1.25rem;
}
.result-cover {
  width: 140px;
  height: 190px;
  flex-shrink: 0;
  border-radius: var(--radius-sm);
  overflow: hidden;
  background: var(--bg-input);
  position: relative;
}
.result-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.result-info { flex: 1; min-width: 0; }
.result-info .title {
  font-size: 1rem;
  font-weight: 600;
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  margin-bottom: 0.75rem;
}
.result-meta {
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 0.35rem 0.75rem;
  font-size: 0.82rem;
  margin-bottom: 1rem;
}
.result-meta .label { color: var(--fg-muted); white-space: nowrap; }
.result-meta .value { color: var(--fg); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.result-meta .value a { color: var(--primary); text-decoration: none; }
.result-meta .value a:hover { text-decoration: underline; }

.result-actions {
  display: flex;
  gap: 0.625rem;
  flex-wrap: wrap;
  padding-top: 1rem;
  border-top: 1px solid var(--border);
}

/* ========== LOADING ========== */
.loading {
  display: none;
  align-items: center;
  justify-content: center;
  gap: 0.625rem;
  padding: 2rem 0;
  color: var(--fg-muted);
  font-size: 0.9rem;
}
.loading.active { display: flex; }
.spinner {
  width: 20px; height: 20px;
  border: 2px solid var(--border);
  border-top-color: var(--primary);
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ========== ERROR STATE ========== */
.error-detail {
  padding: 0.5rem 0;
  color: var(--error);
  font-size: 0.9rem;
}

/* ========== FOOTER ========== */
footer {
  border-top: 1px solid var(--border);
  padding: 1rem 1.5rem;
  text-align: center;
  font-size: 0.78rem;
  color: var(--fg-muted);
}
footer a { color: var(--primary); text-decoration: none; }
footer a:hover { text-decoration: underline; }

/* ========== RESPONSIVE ========== */
@media (max-width: 600px) {
  main { padding: 1.5rem 1rem 2rem; }
  .hero h1 { font-size: 1.3rem; }
  .input-row { flex-direction: column; }
  .btn { justify-content: center; }
  .result-main { flex-direction: column; align-items: center; text-align: center; }
  .result-cover { width: 120px; height: 160px; }
  .result-meta { grid-template-columns: 1fr; text-align: center; }
  .result-actions { justify-content: center; }
}
</style>
</head>
<body>
<header>
  <div class="header-inner">
    <div class="header-logo">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polygon points="23 7 16 12 23 17 23 7"/>
        <rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
      </svg>
    </div>
    <span class="header-title">Video Spider</span>
    <span class="header-badge">v1.1</span>
  </div>
</header>

<main>
  <div class="main-inner">
    <div class="hero">
      <h1>短视频去水印下载</h1>
      <p>粘贴短视频链接，一键获取无水印视频</p>
    </div>

    <!-- Input -->
    <div class="input-card">
      <div class="input-row">
        <input type="url" id="videoUrl" placeholder="在此粘贴短视频分享链接，例如 https://v.douyin.com/xxxxx/" autofocus spellcheck="false">
        <button class="btn btn-primary" id="parseBtn" onclick="parseVideo()">
          <i data-lucide="search" style="width:16px;height:16px;"></i>
          解析视频
        </button>
      </div>
      <div class="input-hint">
        <span><span class="platform-dot"></span>抖音</span>
        <span><span class="platform-dot"></span>最右</span>
        <span><span class="platform-dot"></span>皮皮虾</span>
        <span><span class="platform-dot"></span>皮皮搞笑</span>
        <span><span class="platform-dot" style="background:var(--fg-muted);"></span>微博(有水印)</span>
      </div>
    </div>

    <!-- Loading -->
    <div class="loading" id="loading">
      <div class="spinner"></div>
      <span>正在解析视频...</span>
    </div>

    <!-- Result -->
    <div id="result"></div>

    <!-- Phone Guide Toggle -->
    <div style="margin-top:1.5rem;text-align:center;">
      <button class="btn btn-secondary" onclick="togglePhoneGuide()" style="font-size:0.8rem;">
        <i data-lucide="smartphone" style="width:14px;height:14px;"></i>
        📱 手机使用指南
      </button>
    </div>
    <div id="phoneGuide" style="display:none;margin-top:0.75rem;background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius);padding:1.25rem;animation:slideUp 0.3s ease-out;">
      <h3 style="font-size:1rem;margin-bottom:0.75rem;">📱 在手机上使用</h3>
      <ol style="margin:0;padding-left:1.25rem;font-size:0.85rem;color:var(--fg);line-height:1.8;">
        <li>确保手机和电脑连接<strong>同一个 WiFi</strong></li>
        <li>在电脑上启动服务后，查看电脑的 IP 地址（在桌面程序日志中可见）</li>
        <li>手机浏览器打开 <code style="background:var(--bg-input);padding:0.1rem 0.4rem;border-radius:4px;font-family:var(--font-mono);font-size:0.8rem;" id="phoneUrl">http://电脑IP:8000</code></li>
        <li>点击 Chrome 菜单 → 「<strong>添加到主屏幕</strong>」→ 安装为应用</li>
        <li>之后即可从桌面直接打开使用 🎉</li>
      </ol>
      <div style="margin-top:0.75rem;padding:0.75rem;background:var(--bg-input);border-radius:var(--radius-sm);font-size:0.8rem;color:var(--fg-muted);">
        💡 电脑 IP 地址查看方法：电脑上打开 cmd，输入 <code style="background:oklch(0.15 0 0);padding:0.1rem 0.3rem;border-radius:3px;">ipconfig</code>，找到 <strong>IPv4 地址</strong>（如 192.168.x.x）
      </div>
    </div>
  </div>
</main>

<footer>
  基于 <a href="https://github.com/5ime/video_spider" target="_blank">Video Spider</a> 构建 &middot; 仅供个人学习使用
</footer>

<script>
lucide.createIcons();

// 智能提取 URL：自动从粘贴的文本中提取视频链接
document.getElementById('videoUrl').addEventListener('paste', function(e) {
  setTimeout(() => {
    const raw = this.value.trim();
    const urlMatch = raw.match(/https?:\/\/[^\s]+/);
    if (urlMatch) {
      this.value = urlMatch[0];
    }
  }, 10);
});

// Enter 键触发解析
document.getElementById('videoUrl').addEventListener('keydown', function(e) {
  if (e.key === 'Enter') parseVideo();
});

async function parseVideo() {
  const url = document.getElementById('videoUrl').value.trim();
  const btn = document.getElementById('parseBtn');
  const result = document.getElementById('result');
  const loading = document.getElementById('loading');

  if (!url) {
    result.innerHTML = '<div class="result-card"><div class="result-header error"><i data-lucide="alert-circle" style="width:18px;height:18px;"></i> 请输入视频链接</div></div>';
    lucide.createIcons();
    return;
  }

  // 验证 URL — 先尝试从文本中提取链接
  let finalUrl = url;
  const urlMatch = url.match(/https?:\/\/[^\s]+/);
  if (urlMatch) {
    finalUrl = urlMatch[0];
    document.getElementById('videoUrl').value = finalUrl;
  }

  try { new URL(finalUrl); } catch {
    result.innerHTML = '<div class="result-card"><div class="result-header error"><i data-lucide="alert-circle" style="width:18px;height:18px;"></i> 链接格式不正确</div><div class="result-body"><div class="error-detail">💡 你可以直接粘贴分享文本（如"0.76 :1pm...https://v.douyin.com/..."），系统会自动识别链接</div></div></div>';
    lucide.createIcons();
    return;
  }

  btn.disabled = true;
  btn.innerHTML = '<i data-lucide="loader" style="width:16px;height:16px;animation:spin 0.7s linear infinite;"></i> 解析中...';
  lucide.createIcons();
  result.innerHTML = '';
  loading.classList.add('active');

  try {
    const res = await fetch('?ajax=1', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'url=' + encodeURIComponent(finalUrl)
    });
    const json = await res.json();

    loading.classList.remove('active');

    if (json.success && json.data) {
      renderResult(json.data);
    } else {
      result.innerHTML = `
        <div class="result-card">
          <div class="result-header error"><i data-lucide="x-circle" style="width:18px;height:18px;"></i> ${escapeHtml(json.message || '解析失败')}</div>
          <div class="result-body"><div class="error-detail">请检查链接是否有效，或尝试其他平台视频</div></div>
        </div>`;
      lucide.createIcons();
    }
  } catch (err) {
    loading.classList.remove('active');
    result.innerHTML = `
      <div class="result-card">
        <div class="result-header error"><i data-lucide="wifi-off" style="width:18px;height:18px;"></i> 网络错误</div>
        <div class="result-body"><div class="error-detail">无法连接到服务器，请确认服务已启动</div></div>
      </div>`;
    lucide.createIcons();
  } finally {
    btn.disabled = false;
    btn.innerHTML = '<i data-lucide="search" style="width:16px;height:16px;"></i> 解析视频';
    lucide.createIcons();
  }
}

function renderResult(data) {
  const author = escapeHtml(data.author || '未知');
  const title = escapeHtml(data.title || '无标题');
  const cover = data.cover ? escapeHtml(data.cover) : '';
  const videoUrl = data.url ? escapeHtml(data.url) : '';
  const avatar = data.avatar ? escapeHtml(data.avatar) : '';
  const like = data.like != null ? Number(data.like).toLocaleString() : '';
  const uid = escapeHtml(data.uid || '');
  const musicAuthor = data.music && data.music.author ? escapeHtml(data.music.author) : '';

  document.getElementById('result').innerHTML = `
    <div class="result-card">
      <div class="result-header success">
        <i data-lucide="check-circle" style="width:18px;height:18px;"></i>
        解析成功
      </div>
      <div class="result-body">
        <div class="result-main">
          <div class="result-cover">
            ${cover ? '<img src="' + cover + '" alt="封面" loading="lazy">' : '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--fg-muted);font-size:0.75rem;">无封面</div>'}
          </div>
          <div class="result-info">
            <div class="title">${title}</div>
            <div class="result-meta">
              ${author ? '<span class="label">👤 作者</span><span class="value">' + author + '</span>' : ''}
              ${uid ? '<span class="label">🆔 ID</span><span class="value">' + uid + '</span>' : ''}
              ${like ? '<span class="label">❤️ 点赞</span><span class="value">' + like + '</span>' : ''}
              ${musicAuthor ? '<span class="label">🎵 音乐</span><span class="value">' + musicAuthor + '</span>' : ''}
              ${avatar ? '<span class="label">🖼️ 头像</span><span class="value"><a href="' + avatar + '" target="_blank">查看头像</a></span>' : ''}
            </div>
          </div>
        </div>
        <div class="result-actions">
          ${videoUrl ? '<a href="' + videoUrl + '" target="_blank" class="btn btn-success"><i data-lucide="download" style="width:16px;height:16px;"></i> 下载无水印视频</a>' : ''}
          ${cover ? '<a href="' + cover + '" target="_blank" class="btn btn-secondary"><i data-lucide="image" style="width:16px;height:16px;"></i> 下载封面</a>' : ''}
        </div>
      </div>
    </div>`;
  lucide.createIcons();
}

function escapeHtml(str) {
  const div = document.createElement('div');
  div.textContent = str;
  return div.innerHTML;
}

// 手机使用指南
function togglePhoneGuide() {
  const guide = document.getElementById('phoneGuide');
  guide.style.display = guide.style.display === 'none' ? 'block' : 'none';
}

// 自动检测 IP 地址
fetch('/ip.php?' + Date.now()).then(r => r.text()).then(ip => {
  if (ip) document.getElementById('phoneUrl').textContent = 'http://' + ip.trim() + ':8000';
}).catch(() => {});

// 注册 Service Worker（PWA 安装支持）
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js').catch(() => {});
  });
}

// 检测 PWA 安装状态
let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
  e.preventDefault();
  deferredPrompt = e;
});
</script>
</body>
</html>
