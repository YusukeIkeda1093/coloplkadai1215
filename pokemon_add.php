<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" href="style.css">
<title>努力値カウンター - 追加</title>
</head>
<body>

<?php
	session_start();
	$link = mysql_connect('localhost', 'ikeda', 'zxczxc973') or die('接続に失敗'.mysql_error());
	$select_db = mysql_select_db('pokemon_db',$link) or die('DBへ接続に失敗'.mysql_error());

	if(!empty($_POST)){
		if($_POST['back']){
			header('Location: pokemon_admin.php');
			exit();
		}else{
			if($_POST['name'] != ''){
				$effort = $_POST['target_a'] + $_POST['target_b'] + $_POST['target_c'] + $_POST['target_d'] + $_POST['target_h'] + $_POST['target_s'];
				if($effort <= 510){
					$total = $_POST['target_h'] + $_POST['target_a'] + $_POST['target_b'] + $_POST['target_c'] + $_POST['target_d'] + $_POST['target_s'];
					
					$sql = sprintf('INSERT INTO effort_value
					(user_id,name,memo,target_a,target_b,target_c,target_d,target_h,target_s,update_time,total_current,total_target) VALUES
					("%s","%s","%s","%s","%s","%s","%s","%s","%s",cast(now() as datetime),0,"%s")',
					mysql_real_escape_string($_SESSION['id']),
					mysql_real_escape_string($_POST['name']),
					mysql_real_escape_string($_POST['memo']),
					mysql_real_escape_string($_POST['target_a']),
					mysql_real_escape_string($_POST['target_b']),
					mysql_real_escape_string($_POST['target_c']),
					mysql_real_escape_string($_POST['target_d']),
					mysql_real_escape_string($_POST['target_h']),
					mysql_real_escape_string($_POST['target_s']),
					$total
					);
					
					$result = mysql_query($sql) or die(mysql_error());
					header('Location: pokemon_admin.php');
					exit();
				}else{
					$error['add'] = 'too_many';
				}	
			}else{
				$error['add'] = 'blank';
			}
		}
		
	}
	
	$close_flag = mysql_close($link) or die('切断に失敗'.mysql_error());
?>

<div id="header">
<p>◆ポケモンを追加</font></p>
</div>

<form action="" method="post">
<br />


<table>
<tr>
<td>ポケモン名</td>
<td><input type="text" name="name" size="35" maxlength="10" /></td>
</tr>
<tr>
<td>メモ(20文字以内)</td>
<td><input type="text" name="memo" size="35" maxlength="20" /></td>
</tr>
<tr>
<td>目標HP努力値</td>
<td><input type="number" name="target_h" size="35" maxlength="3" value="0"/></td>
</tr>
<tr>
<td>目標こうげき努力値</td>
<td><input type="number" name="target_a" size="35" maxlength="3" value="0"/></td>
</tr>
<tr>
<td>目標ぼうぎょ努力値</td>
<td><input type="number" name="target_b" size="35" maxlength="3" value="0" /></td>
</tr>
<tr>
<td>目標とうこう努力値</td>
<td><input type="number" name="target_c" size="35" maxlength="3" value="0"/></td>
</tr>
<tr>
<td>目標とくぼう努力値</td>
<td><input type="number" name="target_d" size="35" maxlength="3" value="0"/></td>
</tr>
<tr>
<td>目標すばやさ努力値</td>
<td><input type="number" name="target_s" size="35" maxlength="3" value="0"/></td>
</tr>
</table>
<?php if($error['add'] == 'blank') : ?>
<p class="error"> * ポケモン名を記入してください。</p>
<?php endif; ?>
<?php if($error['add'] == 'too_many') : ?>
<p class="error"> * 努力値の合計を510以内にしてください</p>
<?php endif; ?>
<br />
<input class="add_button" type="submit" name="add" value="追加する" /><input class="add_button" type="submit" name="back" value="戻る" />


</form>

</body>
</html>


<style>
input{
	margin-left:15px;
}
</style>

