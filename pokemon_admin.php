<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" href="style.css">
<title>努力値カウンター - 管理</title>
</head>
<body>

<?php
	session_start();
	$link = mysql_connect('localhost', 'ikeda', 'zxczxc973') or die('接続に失敗'.mysql_error());
	$select_db = mysql_select_db('pokemon_db',$link) or die('DBへ接続に失敗'.mysql_error());
	
	unset($_SESSION['current_h']);
	unset($_SESSION['current_a']);
	unset($_SESSION['current_b']);
	unset($_SESSION['current_c']);
	unset($_SESSION['current_d']);
	unset($_SESSION['current_s']);

	if(!empty($_POST)){
		if($_POST['logout']){
			header('Location: index.php');
		}else	if($_POST['add']){
			header('Location: pokemon_add.php');
		}else if($_POST['isdelete']){
			$isDelete = !$Delete;
		}else if($_POST['delete']){
			$sql = sprintf('SELECT * FROM effort_value WHERE user_id="%s"',$_SESSION['id']);
			$result = mysql_query($sql);

			while($row = mysql_fetch_assoc($result)){
				$postname = 'delete'.$row['pokemon_id'];
				if($_POST[$postname]){
					$sql = sprintf('DELETE FROM effort_value WHERE pokemon_id="%s"',$row['pokemon_id']);
					mysql_query($sql);
				}
			}
		}
	}
	
	$close_flag = mysql_close($link) or die('切断に失敗'.mysql_error());
?>

<div id="header">
<p>◆管理ページ</font></p>
</div>

<form action="" method="post">
<input class="logout_button" type="submit" name="logout" value="ログアウト"/><br />
<br />

<br />
<input class="admin_button" type="submit" name="add" value="追加" />
<?php
	if(!$isDelete){
		print('<input class="admin_button" type="submit" name="isdelete" value="削除" />');
	}else{
		print('<input class="admin_button" type="submit" name="disabledelete" value="削除をキャンセル" />');
	}
?>

<!--input class="admin_button" type="submit" name="add" value="追加" /--><br />
<br />

<table class="border">
<tr>
<td width="160px">ポケモン名</td>
<td width="350px">メモ</td>
<td width="80px">現在値合計</td>
<td width="80px">目標値合計</td>
<td width="200px">最終更新日時</td>
</tr>
<?php
	session_start();
	$link = mysql_connect('localhost', 'ikeda', 'zxczxc973') or die('接続に失敗'.mysql_error());
	$select_db = mysql_select_db('pokemon_db',$link) or die('DBへ接続に失敗'.mysql_error());
	
	//$_SESSION = array();

	$sql = sprintf('SELECT * FROM effort_value WHERE user_id="%s"',$_SESSION['id']);
	$result = mysql_query($sql);
	
	while($row = mysql_fetch_assoc($result)){
		print('<tr>');
		if($isDelete){
			print('<td><input type="checkbox" name="delete'.$row['pokemon_id'].'" /></td>');
		}
		print('	<td><a href="./pokemon_edit.php?pokemon_id='.$row['pokemon_id'].'">'.$row['name'].'</td>');
		print('	<td>'.$row['memo'].'</td>
		<td>'.$row['total_current'].'</td>
		<td>'.$row['total_target'].'</td>
		<td>'.$row['update_time'].'</td>
		</tr>');
	}
	
	$close_flag = mysql_close($link) or die('切断に失敗'.mysql_error());
?>

</table>
<br />
<?php if(mysql_num_rows($result) == 0){
		print('<p>ポケモンが登録されていません</p>');
	}
	?>
<br />

<?php
	if($isDelete){
		print('<input class="admin_button" type="submit" name="delete" value="選択したポケモンを削除" />');
	}
?>

<!--ユーザー名<br>
<?php print(htmlspecialchars($_SESSION['join']['user_name'])); ?><br>
パスワード<br>
<?php print(htmlspecialchars($_SESSION['join']['password'])); ?><br>
<?php if($error['join'] == 'blank') : ?>
<p class="error"> * ユーザー名とパスワードを記入してください。</p>
<?php endif; ?>
<?php if($error['join'] == 'failed') : ?>
<p class="error"> * 入力に誤りがあります。</p>
<?php endif; ?>
<br />

</form>

</body>
</html>

