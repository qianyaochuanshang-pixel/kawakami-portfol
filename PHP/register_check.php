<?php
session_start();
require_once "db_connect.php"; // PDO接続ファイル

// 入力を受け取る
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

// 入力チェック
if (empty($username) || empty($password) || empty($password_confirm)) {
    $_SESSION['error'] = "※全ての項目を入力してください。";
    header("Location: register.php");
    exit;
}

//ユーザーIDのバリデーション(英数字6文字以上)
if(!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{6,}$/', $username)){
    $_SESSION['error'] = "※ユーザーIDは英数字を含む6文字以上で入力してください。";
    header("Location: register.php");
    exit;
}

//パスワードと確認の一致
if ($password !== $password_confirm) {
    $_SESSION['error'] = "※パスワードが一致しません。";
    header("Location: register.php");
    exit;
}

//パスワードのバリデーション(英大文字、小文字、数字含む8文字以上)
if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/',$password)){
    $_SESSION['error'] = "※パスワードは英大文字、小文字、数字を含む8文字以上で入力してください。";
    header("Location: register.php");
    exit;
}

// ユーザー名の重複チェック
$sql = "SELECT * FROM users WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->execute();
$existingUser = $stmt->fetch();

if ($existingUser) {
    $_SESSION['error'] = "※このユーザーIDは使用されています。";
    header("Location: register.php");
    exit;
}

// パスワードをハッシュ化
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// DBに登録
$sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
$stmt->execute();

// 登録完了 → ログイン画面へ
$_SESSION['success'] = "登録が完了しました。ログインしてください。";
header("Location: login.php");
exit;
