<?php 
session_start();


//ログインチェック
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

//DB接続
require_once "db_connect.php";

// //POSTデータを受け取る
$id = $_POST['id'] ?? null;

if($id === null){
    $_SESSION['error'] = "※復元対象が指定されていません。";
    header("Location: inventory_deleted.php");
    exit;    
}

//復元処理(is_deletedを0に戻し、更新日時と更新者を記録)
$sql = "UPDATE inventory
        SET is_deleted = 0, updated_at = NOW(), updated_by = :updated_by
        WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':updated_by', $_SESSION['username'],PDO::PARAM_STR);
$stmt->execute();

if($stmt->rowCount() > 0 ){
    $_SESSION['success'] = "※ID:{$id}を復元しました。";
}else{
    $_SESSION['error'] = "※復元対象が存在しません。";
}

//削除済一覧に戻る
header("Location: inventory_deleted.php");
exit;
?>