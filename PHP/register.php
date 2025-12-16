<?php 
session_start();
?>

<!DOCTYPE html>
<html lang = "ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>
    <h2>新規登録フォーム</h2>
    
    <?php 
    if(!empty($_SESSION['error'])): ?>
        <p style="color:red;"><?php echo $_SESSION['error']; ?></p>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

    <form action="register_check.php" method="post">
        <label>ユーザーID(必須):<br>
            <input type="text" name="username" placeholder="(※英数字含む、6文字以上で入力してください)" size="50"required></label><br>

        <label>パスワード(必須):<br>
            <input type="password" name="password" placeholder="(※英大文字、小文字、数字含む8文字以上で入力してください)" size="50"required>
        </label><br>

        <label>パスワード再入力(必須):<br>
            <input type="password" name="password_confirm" placeholder="※(英大文字、小文字、数字含む8文字以上で入力してください)" size="50"required></label><br><br>

            <input type="submit" value="登録">
    </from>

    <p>すでにアカウントをお持ちの場合 <a href="login.php">ログインはこちら</a></p>
    <p><a href="forgot_password.php">※パスワードをお忘れの場合はこちら</a></p>
</body>
</html>



