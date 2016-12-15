<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" href="style.css">
<title>努力値カウンター - 編集</title>
</head>
<body>

<?php
	session_start();
	$link = mysql_connect('localhost', 'ikeda', 'zxczxc973') or die('接続に失敗'.mysql_error());
	$select_db = mysql_select_db('pokemon_db',$link) or die('DBへ接続に失敗'.mysql_error());

	$sql = sprintf('SELECT * FROM effort_value WHERE pokemon_id="%s"',$_GET['pokemon_id']);
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	
	if($_SESSION['current_h'] == null){
		$_SESSION['memo'] = $row['memo'];
		$_SESSION['current_h'] = $row['current_h'];
		$_SESSION['current_a'] = $row['current_a'];
		$_SESSION['current_b'] = $row['current_b'];
		$_SESSION['current_c'] = $row['current_c'];
		$_SESSION['current_d'] = $row['current_d'];
		$_SESSION['current_s'] = $row['current_s'];
	}
	
	if(!empty($_POST)){
		$_SESSION['memo'] = $_POST['memo'];
		if($_POST['plus_h']){
			$_SESSION['current_h'] ++;
		}if($_POST['plus_a']){
			$_SESSION['current_a'] ++;
		}if($_POST['plus_b']){
			$_SESSION['current_b'] ++;
		}if($_POST['plus_c']){
			$_SESSION['current_c'] ++;
		}if($_POST['plus_d']){
			$_SESSION['current_d'] ++;
		}if($_POST['plus_s']){
			$_SESSION['current_s'] ++;
		}
		
		if($_POST['minus_h']){
			$_SESSION['current_h'] --;
		}if($_POST['minus_a']){
			$_SESSION['current_a'] --;
		}if($_POST['minus_b']){
			$_SESSION['current_b'] --;
		}if($_POST['minus_c']){
			$_SESSION['current_c'] --;
		}if($_POST['minus_d']){
			$_SESSION['current_d'] --;
		}if($_POST['minus_s']){
			$_SESSION['current_s'] --;
		}
		if($_POST['back']){
			unset($_SESSION['memo']);
			unset($_SESSION['current_h']);
			unset($_SESSION['current_a']);
			unset($_SESSION['current_b']);
			unset($_SESSION['current_c']);
			unset($_SESSION['current_d']);
			unset($_SESSION['current_s']);
			header('Location: pokemon_admin.php');
			exit();
		}else if($_POST['update']){
			$total = $_SESSION['current_h'] + $_SESSION['current_a'] + $_SESSION['current_b'] + $_SESSION['current_c'] + $_SESSION['current_d'] + $_SESSION['current_s'];
			
			$sql = sprintf('UPDATE effort_value SET  memo="%s",current_h="%s", current_a="%s", current_b="%s", current_c="%s", current_d="%s", current_s="%s", update_time=cast(now() as datetime), total_current="%s" WHERE pokemon_id="%s"',
			mysql_real_escape_string($_SESSION['memo']),
			$_SESSION['current_h'],
			$_SESSION['current_a'],
			$_SESSION['current_b'],
			$_SESSION['current_c'],
			$_SESSION['current_d'],
			$_SESSION['current_s'],
			$total,
			$row['pokemon_id']);
			mysql_query($sql) or die(mysql_error());
			unset($_SESSION['memo']);
			unset($_SESSION['current_h']);
			unset($_SESSION['current_a']);
			unset($_SESSION['current_b']);
			unset($_SESSION['current_c']);
			unset($_SESSION['current_d']);
			unset($_SESSION['current_s']);
			
			header('Location: pokemon_admin.php');
			exit();
		}
	}
	
	$close_flag = mysql_close($link) or die('切断に失敗'.mysql_error());
?>

<div id="header">
<p>◆ポケモンを編集</font></p>
</div>

<form action="" method="post">
<br />



ポケモン名：<?php echo $row['name']; ?><br />
<br />

メモ(20文字以内)<br />
<input type="text" name="memo" size="35" maxlength="20" value="<?php echo htmlspecialchars($_SESSION['memo']); ?>"/><br />
<br />

<table class="border">
<tr>
<td></td>
<td>現在値</td>
<td>目標値</td>
</tr>
<tr>
<td>HP努力値</td>
<td><?php print(''.htmlspecialchars($_SESSION['current_h']).'　　'); ?><Input type="submit" name="plus_h" value="▲" /><Input type="submit" name="minus_h" value="▼" /></td>
<td><?php echo htmlspecialchars($row['target_h']); ?></td>
</tr>
<tr>
<td>こうげき努力値</td>
<td><?php print(''.htmlspecialchars($_SESSION['current_a']).'　　'); ?><Input type="submit" name="plus_a" value="▲" /><Input type="submit" name="minus_a" value="▼" /></td>
<td><?php echo htmlspecialchars($row['target_a']); ?></td>
</tr><tr>
<td>ぼうぎょ努力値</td>
<td><?php print(''.htmlspecialchars($_SESSION['current_b']).'　　'); ?><Input type="submit" name="plus_b" value="▲" /><Input type="submit" name="minus_b" value="▼" /></td>
<td><?php echo htmlspecialchars($row['target_b']); ?></td>
</tr><tr>
<td>とくこう努力値</td>
<td><?php print(''.htmlspecialchars($_SESSION['current_c']).'　　'); ?><Input type="submit" name="plus_c" value="▲" /><Input type="submit" name="minus_c" value="▼" /></td>
<td><?php echo htmlspecialchars($row['target_c']); ?></td>
</tr><tr>
<td>とくぼう努力値</td>
<td><?php print(''.htmlspecialchars($_SESSION['current_d']).'　　'); ?><Input type="submit" name="plus_d" value="▲" /><Input type="submit" name="minus_d" value="▼" /></td>
<td><?php echo htmlspecialchars($row['target_d']); ?></td>
</tr><tr>
<td>すばやさ努力値</td>
<td><?php print(''.htmlspecialchars($_SESSION['current_s']).'　　'); ?><Input type="submit" name="plus_s" value="▲" /><Input type="submit" name="minus_s" value="▼" /></td>
<td><?php echo htmlspecialchars($row['target_s']); ?></td>
</tr></table>
<?php if($error['add'] == 'blank') : ?>
<p class="error"> * ポケモン名を記入してください。</p>
<?php endif; ?>
<?php if($error['add'] == 'too_many') : ?>
<p class="error"> * 努力値の合計を510以内にしてください</p>
<?php endif; ?>
<br />
<input class="add_button" type="submit" name="update" value="保存して戻る" /><input class="add_button" type="submit" name="back" value="保存せず戻る" />


</form>

</body>
</html>

