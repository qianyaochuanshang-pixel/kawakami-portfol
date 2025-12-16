<?php
session_start();
require_once "db_connect.php"; //PDO接続

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if(!$id){
    $_SESSION['error'] = "編集対象のデータが指定されていません。";
    header("Location: inventory.php");
    exit;
}

$sql = "SELECT * FROM inventory WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$item){
    $_SESSION['error'] = "対象の在庫データは存在しません。";
    header("Location: inventory.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>在庫編集</title>
</head> 
<body>
    <h2>在庫編集画面</h2>

    <form action="inventory_update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
        <label>数量: <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>"></label>
        <input type="submit" value="更新">
    </form>

    <p><a href="inventory.php">在庫一覧に戻る</a></p>
</body>
</html>