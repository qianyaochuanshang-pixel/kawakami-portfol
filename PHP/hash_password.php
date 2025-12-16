<?php
// 変換したいパスワード
$password = "test1234";

// パスワードをハッシュ化
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 結果を表示
echo "ユーザー: admin<br>";
echo "ハッシュ化されたパスワード: " . $hashed_password;
?>