<?php
session_start();

//ログインチェック
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

//メッセージ表示(1回だけ表示したら消す)
if(isset($_SESSION['success'])){
    echo "<p style='color: green;'>" . htmlspecialchars($_SESSION['success'],ENT_QUOTES,'UTF-8') ."</p>";
    unset($_SESSION['success']);
}

if(isset($_SESSION['error'])){
    echo "<p style='color: red;'> " .htmlspecialchars($_SESSION['error'],ENT_QUOTES, 'UTF-8') . "</p>";
    unset($_SESSION['error']);
}

//DB接続
require_once "db_connect.php";

//削除済データ取得
$sql = "SELECT * FROM inventory WHERE is_deleted = 1 ORDER BY updated_at DESC";
$stmt = $pdo->query($sql);
$deletedItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>削除済 在庫一覧</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin-bottom: 20px;}
        th, td { border: 1px soild #000; padding: 5px; text-align: center;}
        th { background-color: #f2f2f2; }

        .welcome-message{
            font-size: 1rem;
            color: #2c3e50;
            background-color: #f9f9f9;
            padding: 8px 12px;
            border-left: 4px solid #007BFF;
            margin: 10px 0 20px;
        }

        .welcome-message .username{
            font-weight: bold;
            color: #000;
        }
    </style>
</head>
<body>
    <h2>削除済 在庫一覧</h2>
    <p class="welcome-message">
        <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span> さん、ようこそ！
    </p>
    <!-- 削除済 在庫一覧 -->
    <h3 style="display: inline;">＜削除済 在庫一覧＞</h3>
    <p style="display: inline; margin-left: 20px;">
        <!-- 在庫管理に戻る -->
        <a href= "inventory.php">在庫管理に戻る</a>
    
        <!-- 成功メッセージ -->
    <?php if(!empty($_SESSION['success'])): ?>
        <p style="color:blue;"><?php echo $_SESSION['success']; ?></p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- エラーメッセージ -->
     <?php if(!empty($_SESSION['error'])): ?>
        <p style="color:red;"><?php echo $_SESSION['error']; ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>商品名</th>
            <th>数量</th>
            <th>登録日</th>
            <th>最終更新日</th>
            <th>最終更新者</th>
            <th>操作</th>
        </tr>
        <?php foreach($deletedItems as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['id']) ?></td>
            <td><?= htmlspecialchars($item['item_name']) ?></td>
            <td><?= htmlspecialchars($item['quantity']) ?></td>
            <td><?= htmlspecialchars($item['created_at']) ?></td>
            <td><?= htmlspecialchars($item['updated_at']) ?></td>
            <td><?= htmlspecialchars($item['updated_by']) ?></td>
            <td>
                <!-- 復元ボタン -->
                <form action="inventory_restore.php" method="POST" style="display:inline;" onsubmit="return confirm('本当に復元します？');">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">        
                    <input type="submit" value="復元">
                </form>    
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>

<style>
.top-right{
    position: absolute;
    top: 10px;
    right: 10px;
}
.top-right a{
    text-decoration: none;
    color: #007BFF;
    font-weight: bold;
}
.top-right a:hover {
    text-decoration: underline;
}
</style>

<div class="top-right">
    <a href="logout.php">ログアウト</a>
</div>


</html>