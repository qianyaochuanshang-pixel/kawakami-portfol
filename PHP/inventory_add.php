<?php
session_start();
require_once "db_connect.php";//DB接続

//ログイン確認
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

//フォーム入力を受ける
$item_name = isset($_POST['item_name']) ? trim($_POST['item_name']) : '';
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] :0;

//バリデーション
if($item_name === '' || $quantity < 0){
    $_SESSION['error'] = "商品名と数量を正しく入力してください。" ;
    header("Location: inventory.php");
    exit;
}

try{
    //データベースに追加
    $sql = "INSERT INTO inventory (item_name, quantity, created_at, updated_at,updated_by) VALUES (:item_name, :quantity, NOW(), NOW(), :updated_by)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':item_name', $item_name, PDO::PARAM_STR);
    $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindValue(':updated_by', $_SESSION['username'], PDO::PARAM_STR);
    $stmt->execute();

    //成功メッセージをセット
    $_SESSION['success'] = "※商品を追加しました。";

    //在庫一覧へ戻る
    header("Location: inventory.php");
    exit;

}catch (PDOException $e){
    //デバッグ用ログ
    //error_log($e->getMessage());

    // $_SESSION['error'] = "データベースエラーが発生しました。";
    // header("Location: inventory.php");

    echo "SQLエラー:" . $e->getMessage();
    exit;
}
?>