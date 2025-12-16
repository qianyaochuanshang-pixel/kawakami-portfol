<?php
session_start();

//ログインチェック
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

require_once "db_connect.php";

// POSTデータ受け取り
$id = $_POST['id'] ?? null;

if($id === null){
    $_SESSION['error'] = "※削除対象が指定されていません。";
    header("Location: inventory.php");
    exit;
}

// 論理削除処理
$sql = "UPDATE inventory 
        SET is_deleted = 1, updated_at = NOW(), updated_by = :updated_by
        WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':updated_by', $_SESSION['username'], PDO::PARAM_STR);
$stmt->execute();

if($stmt->rowCount() > 0){
    $_SESSION['success'] = "※ID:{$id} を削除しました。";
} else {
    $_SESSION['error'] = "※削除対象が存在しません。";
}

header("Location: inventory.php");
exit;
?>
