<?php
$dsn = "mysql:host=localhost;dbname=company_system;charset=utf8";
$user = "root";      // XAMPPのデフォルトユーザー
$password = "";      // XAMPPのデフォルトは空パス

try {
    $pdo = new PDO($dsn, $user, $password);
    // echo "DB接続成功"; // デバッグ用
} catch (PDOException $e) {
    echo "DB接続失敗: " . $e->getMessage();
    exit;
}
?>