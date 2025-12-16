<?php
session_start();
require_once "db_connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'] ?? '';

    //ユーザー確認
    $stmt = $pdo->prepare("SELECT id, email FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        //トークン生成
        $token = bin2hex(random_bytes(16));
        $stmt = $pdo->prepare("UPDATE users SET reset_token = :token, reset_token_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id = :id");
        $stmt->execute([
            ':token' => $token,
            ':id' => $user['id']
        ]);
        
        //PHPMailerで送信
        $mail = new PHPMailer(true);
        try{
            $mail->isSMTP();
            $mail->Host = 'localhost';
            $mail->Port = 2525;
            $mail->SMTPAuth = false;      
            $mail->SMTPSecure  = false;
            

            $mail->setFrom('no-reply@example.com', '在庫管理システム');
            $mail->addAddress($user['email']);

            $mail->isHTML(true);
            $mail->Subject      = 'パスワードリセットのご案内';
            $mail->Body         = "以下のリンクからパスワードをリセットしてください:<br>
                                  <a href='http://localhost/reset_password.php?token=$token'>リセットはこちら</a>";
            
            $mail->send();
            $_SESSION['success'] = "パスワードリセット用のメールを送信しました。";
        }catch(\Exception $e){
            $_SESSION['error'] = "メール送信に失敗しました: {$mail->ErrorInfo}";
        }
    }else{
        $_SESSION['error'] = "このメールアドレスは登録されていません。";
    }
    header("Location: password_reset_request.php");
    exit;
}
?>

