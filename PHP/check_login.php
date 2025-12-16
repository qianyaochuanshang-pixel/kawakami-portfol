<?php
session_start();
require_once "db_connect.php";//DB接続設定ファイル

// フォームから受け取る
$input_username = $_POST['username']??'';
$input_password = $_POST['password']??'';

$sql = "SELECT * FROM users WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username',$input_username, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// 判定
if($user && password_verify($input_password,$user['password'])){
    // 両方一致
    $_SESSION['username'] = $user['username'];
    header("Location: inventory.php");
    exit;

}elseif($user && $input_password !== $user['password']){
    // ユーザー名は一致、パスワードは不一致
    $_SESSION['error'] = "※ユーザー名またはパスワードが違います。";
    header("Location: login.php");
    exit;

}elseif(!$user){
    // ユーザー名不一致
    $_SESSION['error'] = "※ユーザー名またはパスワードが違います";
    header("Location: login.php");
    exit;
}
?>
 