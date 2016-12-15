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
		if($_POST["user_name"] != '' && $_POST["password"] != ''){
			if(strlen($_POST["password"]) >= 8){
				$_SESSION['join'] = $_POST;
				
				//print($_SESSION['user_name']);
				header("Location: check.php");
				exit(); 
			}else{
				$error['join'] = 'failed';
			}
		}else{
			$error['join'] = 'blank';
		}
	}
	
	if(isset($_SESSION['check'])){
		$_POST = $_SESSION['check'];
	}
	
	$close_flag = mysql_close($link) or die('切断に失敗'.mysql_error());
?>

<div id="header">
<p>◆会員登録</font></p>
</div>

<form action="" method="post">

*ユーザー名(8文字以内)<br />
<input type="text" name="user_name" size="35" maxlength="8" value="<?php echo htmlspecialchars($_POST['user_name']); ?>" /><br>
*パスワード(10文字以内)<br>
<input type="password" name="password" size="35" maxlength="10" value="<?php echo htmlspecialchars($_POST['password']); ?>" /><br>
<?php if($error['join'] == 'blank') : ?>
<p class="error"> * ユーザー名とパスワードを記入してください。</p>
<?php endif; ?>
<?php if($error['join'] == 'failed') : ?>
<p class="error"> * 入力に誤りがあります。</p>
<?php endif; ?>
<br />

<input type="submit" name="check" value="確認画面へ" /><br>
<a href="./index.php">すでに登録済みの方はコチラ</a>

</form>

</body>
</html>

