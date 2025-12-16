<?php
session_start();
// echo "<pre>";
// print_r($_POST); //フォームが送られてきたデータを表示
// echo "</pre>";
// exit;

//ログインチェック
if(!isset($_SESSION['username'])){
    header('Location: login.php');
    exit;
}

//DB接続
require_once "db_connect.php";

//POSTデータを受け取る
$id = $_POST['id'] ?? null;
$quantity = $_POST['quantity'] ?? null;

if($id === null || $quantity === null){
    $_SESSION['error'] = "※不正なアクセスです。";
    header("Location: inventory.php");
    exit;
}

$updated_by = $_SESSION['username'];

try{
    //更新SQL
    $sql = "UPDATE inventory
            SET quantity = :quantity, updated_at = NOW(),updated_by = :updated_by
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindValue(':updated_by', $updated_by, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $_SESSION['success'] = "※在庫を更新しました。"; 
}catch (Exception $e){
    $_SESSION['error'] = "※更新に失敗しました: " . $e->getMessage();
}

//一覧へ戻る
header("Location: inventory.php");
exit;

?>