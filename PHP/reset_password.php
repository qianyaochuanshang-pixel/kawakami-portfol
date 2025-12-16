<?php
session_start();
require_once "db_connect.php";

$token = $_GET['token'] ?? '';

if(!$token){
    die("無効なリンクです");
}

//トークン確認
$stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = :token AND reset_token_expire > NOW()");
$stmt ->execute([':token' => $token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user){
    die("トークンが無効か期限切れです");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワード再設定</title>
</head>
<body>
    <h2>新しいパスワードを入力</h2>

    <form action="update_password.php" ,method="POST">
        <input type="hidden"  name="token" value="<? htmlspecialchars($token) ?>">
        <label>新しいパスワード:
            <input typt="password" name="password" required>
        </label><br><br>
        <input type="submit" value="パスワード更新">
    </form>
</body>

</html>