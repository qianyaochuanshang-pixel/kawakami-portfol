<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset= "UTF-8">
    <title>パスワードリセット</title>
</head>
<body>
    <h2>パスワードをお忘れの方</h2>
    <form action="send_reset_email.php" method="POST">
        <label>登録メールアドレス:<br>
            <input type="email" name="email" required size="50"><br><br>
        </label>
        <input type="submit" value="メール送信">
    </form>
    <p><a href="login.php">ログイン画面に戻る</a></p>
</body>
</html>