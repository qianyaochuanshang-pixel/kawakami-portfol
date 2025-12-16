<?php
session_start();
session_unset();
session_destroy();

//ログアウト完了メッセージをセッションに入れる
session_start();
$_SESSION['error'] = "※ログアウトしました。";

// ログイン画面に戻す
header("Location: login.php");
exit;
?>
