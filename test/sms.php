<!DOCTYPE html>
<html>
<head>
	<title>Way2SMS Sender</title>
</head>
<body>
<form action="../sendsms.php" method="get">
	<table>
		<tr>
			<td>Username</td>
			<td><input type="text" name="uid" /></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="text" name="pwd" /></td>
		</tr>
		<tr>
			<td>Mobile</td>
			<td><input type="text" name="phone" /></td>
		</tr>
		<tr>
			<td>Message</td>
			<td><input type="text" value="Hi this is a test message" name="msg" /></td>
		</tr>
		<tr>
			<td><input type="submit" /></td>
		</tr>
	</table>
</form>
</body>
</html>