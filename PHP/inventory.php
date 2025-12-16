<?php
session_start();

//ログインしていなければログイン画面へ
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

//データベース接続
require_once "db_connect.php"; // PDO接続ファイル

//---------------------------
//在庫一覧用データを取得(削除済を除外)
//---------------------------
$sqlItems = "SELECT * FROM inventory WHERE is_deleted = 0 ORDER BY created_at";
$stmtItems = $pdo->query($sqlItems);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);


//---------------------------
//削除済 在庫一覧を取得
//---------------------------
$sqlDeleted = "SELECT * FROM inventory WHERE is_deleted = 1 ORDER BY updated_at DESC";
$stmtDeleted = $pdo->query($sqlDeleted);
$deletedItems = $stmtDeleted->fetchAll(PDO::FETCH_ASSOC);


//---------------------------
//商品別 合計数量と最新更新日・最新更新者を取得
//---------------------------
$sqlsummary = "SELECT item_name, SUM(quantity) AS total_quantity, MAX(updated_at) AS last_updated_at, SUBSTRING_INDEX(GROUP_CONCAT(updated_by ORDER BY updated_at DESC), ',',1) AS last_updated_by FROM inventory WHERE is_deleted = 0 GROUP BY item_name ORDER BY item_name ";
$stmtsummary = $pdo->query($sqlsummary);
$summary = $stmtsummary->fetchAll(PDO::FETCH_ASSOC);

// $sql = "SELECT * FROM inventory WHERE is_deleted = 0";
// $stmt = $pdo->query($sql);

?>

<!DOCTYPE html>
<html lang= "ja">
<head>
    <meta charset="UTF-8">
    <title>在庫管理画面</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin-bottom: 20px;}
        th, td{ border: 1px soild #000; padding: 5px; text-align: center;}
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

        .add-button{
            display:  inline-block;
            margin-left: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #007BFF;
            text-decoration: none;
            border: 1px solid #007BFF;
            border-radius: 50%;
            padding: 2px 8px;
            transition: 0.2s;
        }

    .add-button:hover{
        background-color: #007BFF;
        color: #fff;
    }
    </style>
</head>
<body>
    <h2>在庫管理画面</h2>
    <p class="welcome-message">
        <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span> さん、ようこそ！
    </p>

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

  <!-- 商品別 合計数量 -->
    <h3 style="display: inline;">＜商品別 合計数量＞</h3>
    <table border="1" cellpadding="8">
        <tr>
            <th>商品名</th>
            <th>合計数量</th>
            <th>最終更新日</th>
            <th>最終更新者</th>
        </tr>    
        <?php foreach ($summary as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['item_name']); ?></td>
            <td><?php echo htmlspecialchars($row['total_quantity']); ?></td>
            <td><?php echo htmlspecialchars($row['last_updated_at']); ?></td>
            <td><?php echo htmlspecialchars($row['last_updated_by']); ?></td>
        </tr>       
        <?php endforeach; ?>
    </table>

    <!-- 在庫一覧 -->
    <h3 style="display: inline;">＜在庫一覧＞</h3>
    <a href="inventory_add_from.php" class="add-button">+</a>
    <p style="display: inline; margin-left: 20px;">
        <!-- 削除済在庫一覧 -->
        <a href= "inventory_deleted.php">削除済 在庫一覧はこちら</a>
    </p>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>商品名</th>
            <th>数量</th>
            <th>登録日</th>
            <th>最終更新日</th>
            <th>最終更新者</th>
            <th>操作</th> <!-- 編集用の列を追加 -->
        </tr>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item["id"]); ?></td>
            <td><?php echo htmlspecialchars($item["item_name"]); ?></td>
            <td><?php echo htmlspecialchars($item["quantity"]); ?></td>
            <td><?php echo htmlspecialchars($item["created_at"]); ?></td>
            <td><?php echo htmlspecialchars($item["updated_at"]); ?></td>
            <td><?php echo htmlspecialchars($item["updated_by"]); ?></td>

            <td>
                <!-- 編集ボタン -->
                <form action="inventory_edit.php" method="GET" style="display:inline,">
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    <input type="submit" value="編集">    
                </form>

                <!-- 削除ボタン -->
                <form action="inventory_delete.php" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                    <input type="hidden" name="id" value="<?php echo $item['id'];?>">
                    <input type="submit" value="削除">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>


    <!-- 在庫追加フォーム -->
    <h3>＜在庫追加＞</h3>
    <form action="inventory_add.php" method="POST">
        <label>商品名: <input type="text" name="item_name" required></label><br><br>
        <label>数量: <input type="number" name="quantity" required></label><br><br>
        <input type="submit" value="追加">
    </form>

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
