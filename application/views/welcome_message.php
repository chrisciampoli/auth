<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ChrisChross Referencer</title>
	<link rel="stylesheet" href="<?=base_url();?>assets/css/styles.css">
</head>
<body>

<div id="container">
	<div align="center">
<h1>Referencer</h1>
<!--<form enctype="multipart/form-data" action="chris_process.php" method="POST">
	<table>
		<tr>
			<th>Choose a TW file to upload:</th>
			
			<td><input name="tw_file" type="file" /></td>
		</tr>
		<tr>
			<th>Choose a Powerplay file to upload:</th>
			<td><input name="pp_file" type="file" /></td>
		</tr>
		<tr>
			<td><input type="submit" value="Run!" /></td>
		</tr>
	</table>
</form>-->
<!--<?=$error;?>-->
<?=form_open_multipart('welcome/upload');?>
	<input type="file" name="userfile" size="20"/>
	<input type="submit" value="upload"/>
</form>
</div>
	<p><a href="<?=base_url('index.php/admin/logout');?>">Logout</a></p>
	<p class="footer">ChrisChross Referencer</p>
	<?php echo $_SESSION['username'];?>
</div>
</body>
</html>
