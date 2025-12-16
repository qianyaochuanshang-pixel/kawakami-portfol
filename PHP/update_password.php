<?php
session_start();
require_once "db_connect.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $token = $_POst['token'] ?? '';
    $password = $_POST['password'] ?? '';

    if(!$token || !$password){
        die("不正なアクセスです");
    }

    //トークン確認
    $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = :token AND reset_token_expire > NOW()");
    $stmt ->execute([':token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$user){
    die("トークンが無効か期限切れです");
    }

    //パスワード更新
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = :password, reset_token = NULL, reset_token_expire = NULL WHERE id = :id");
    $stmt->execute([
        ':password' => $hash,
        ':id' => $user['id']
    ]);

    $_SESSION['success'] = "パスワードを更新しました。ログインしてください。";
    header("Location: login.php");
    exit;
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