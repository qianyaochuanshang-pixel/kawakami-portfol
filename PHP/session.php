<?php

// セッション開始
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// セッションにユーザー情報がない場合
if(!isset($_SESSION['username'])){
    // login.htmlにエラーパラメータをつけてリダイレクト
    header("Location: login.html?error=1");
    exit;
}
