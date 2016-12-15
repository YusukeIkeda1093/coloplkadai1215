
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" href="style.css">
<title>努力値カウンター - ログイン</title>
</head>
<body>

<?php

	$link = mysql_connect('localhost', 'ikeda', 'zxczxc973') or die('接続に失敗'.mysql_error());
	$select_db = mysql_select_db('pokemon_db',$link) or die('DBへ接続に失敗'.mysql_error());
	
	/*$record = mysql_query('SELECT * FROM users');
	$row = mysql_fetch_assoc($record);
	print($row['id']);
	print($row['user_name']);
	print($row['password']);*/
	
		
	//mysqlに対する処理
	session_start();

	if(!empty($_POST)){
		if($_POST["user_name"] != '' && $_POST["password"] != ''){
			
			$sql = sprintf('SELECT * FROM users WHERE user_name="%s" AND password="%s"', 
			mysql_real_escape_string($_POST['user_name']),
			mysql_real_escape_string(sha1($_POST['password'])));
			
			$record = mysql_query($sql) or die(mysql_error());
			if($table = mysql_fetch_assoc($record)){
				//ログイン成功
				$_SESSION['id'] = $table['id'];
				$_SESSION['time'] = time(); 
				header('Location: pokemon_admin.php');
				exit();
			}else{
				$error['login'] = 'failed';
			}
		}else{
			$error['login'] = 'blank';
		}
	}
	
	
/*	$sql = sprintf('SELECT id FROM users WHERE user_name="ikeda"');
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	print($row['id']);
	$row = mysql_fetch_assoc($result);
	print($row['id']);
	print($cnt = mysql_num_rows($result));*/
	

	$close_flag = mysql_close($link);
	if(!$close_flag){
		print('<p>切断に失敗</p>');
	}


?>
<div id="header">
<p>◆ポケモン努力値チェッカー！</font></p>
</div>

<form action="" method="post">

ユーザー名<br>
<input type="text" name="user_name" size="35" maxlength="8" value="<?php echo htmlspecialchars($_POST['user_name']); ?>" /><br>

パスワード<br>
<input type="password" name="password" size="35" maxlength="10" value="<?php echo htmlspecialchars($_POST['password']); ?>" /><br>

<?php if($error['login'] == 'blank') : ?>
<p class="error"> * ユーザー名とパスワードを記入してください。</p>
<?php endif; ?>
<?php if($error['login'] == 'failed') : ?>
<p class="error"> * ユーザー名かパスワードが間違っています。</p>
<?php endif; ?>
<br />
<input type="submit" name="login" value="ログイン" /><br>
<a href="./join.php">会員登録がお済みでないかたはコチラ</a>

</form>


</body>
</html>
