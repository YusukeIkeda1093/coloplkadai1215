<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" href="style.css">
<title>努力値カウンター - 登録</title>
</head>
<body>

<?php
	session_start();
	$link = mysql_connect('localhost', 'ikeda', 'zxczxc973') or die('接続に失敗'.mysql_error());
	$select_db = mysql_select_db('pokemon_db',$link) or die('DBへ接続に失敗'.mysql_error());

	if(!empty($_POST)){
		header('Location: index.php');
		exit();
	}
	
	$close_flag = mysql_close($link) or die('切断に失敗'.mysql_error());
?>

<div id="header">
<p>◆会員登録</font></p>
</div>

<form action="" method="post">
<br />
<font color="red"><p>登録が完了しました！</p></font><br />


<input type="submit" name="back" value="ログイン画面へ" />
</form>

</body>
</html>