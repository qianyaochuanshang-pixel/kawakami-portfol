<?php 
session_start();
?>
<!DOCTYPE html>
<html lang= "ja">
<head>
    <meta charset= "UTF-8">
    <title>ログイン</title>
</head>
<body>
    <h2>ログインフォーム</h2>


    <!-- 成功メッセージ(青) -->
    <?php if(!empty($_SESSION['success'])): ?>
        <p style="color:blue;"><?php echo $_SESSION['success']; ?></p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <!-- エラーメッセージ(赤) -->
    <?php if(!empty($_SESSION['error'])): ?>
        <p  id="errorMsg" style="color:red;"><?php echo $_SESSION['error']; ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action= "check_login.php" method= "post">
        <label>ユーザーID:<br> <input type= "text" name= "username" size="50"></label><br>
        <label>パスワード:<br> <input type= "password" name= "password" size="50"></label><br><br>
        <input type= "submit" value= "ログイン">


    </form>

    <hr>
    <p>アカウントをお持ちでない場合 <a href="register.php">新規登録はこちら</a></p>
    <p><a href="forgot_password.php">※パスワードをお忘れの場合はこちら</a></p>

    <!-- <script>
    // //ログアウトメッセージを3秒後に消す
    // window.addEventListener('DOMContentLoaded', () =>{
    //     const errorMsg = document.getElementById('errorMsg');
    //     if(errorMsg){
    //         setTimeout(() => {
    //             errorMsg.style.display = 'none';
    //         },3000);//3秒後に非表示
    //     }
    // });
    </script> -->
</body>
</html> 
