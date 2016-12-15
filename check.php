<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" href="style.css">
<title>努力値カウンター - 登録確認</title>
</head>
<body>

<?php
	session_start();
	$link = mysql_connect('localhost', 'ikeda', 'zxczxc973') or die('接続に失敗'.mysql_error());
	$select_db = mysql_select_db('pokemon_db',$link) or die('DBへ接続に失敗'.mysql_error());

	if(!empty($_POST)){
		if(!empty($_POST['back'])){
			$_POST = $_SESSION['join'];
			$_SESSION['check'] = $_POST;
			header('Location: join.php');
			exit();
		}else{
			$sql = sprintf('INSERT INTO users (user_name, password) VALUE ("%s", "%s")',mysql_real_escape_string($_SESSION['join']['user_name']),mysql_real_escape_string(sha1($_SESSION['join']['password'])));
			$record = mysql_query($sql) or die(mysql_error());
			header('Location: join_done.php');
			exit();
		}
	}
	
	$close_flag = mysql_close($link) or die('切断に失敗'.mysql_error());
?>

<div id="header">
<p>◆会員登録</font></p>
</div>

<form action="" method="post">
<br />
<font color="red"><p>まだ登録は完了していません！</p></font><br />


ユーザー名<br>
<?php print(htmlspecialchars($_SESSION['join']['user_name'])); ?><br>
パスワード<br>
<?php 
$str = '';
for($i = 0; $i < strlen($_SESSION['join']['password']); $i++){
	$str = $str.'*';
}
print(htmlspecialchars($str)); 
?><br>
<?php if($error['join'] == 'blank') : ?>
<p class="error"> * ユーザー名とパスワードを記入してください。</p>
<?php endif; ?>
<?php if($error['join'] == 'failed') : ?>
<p class="error"> * 入力に誤りがあります。</p>
<?php endif; ?>
<br />

<input type="submit" name="back" value="戻って訂正" /><input type="submit" name="join" value="確認して登録" /><br>

</form>

</body>
</html>

