<?php
	if (isset($_COOKIE['UserId']))
	{
		unset($_COOKIE['UserId']);
		unset($_COOKIE['UserName']);
		setcookie('UserId', null, -1, '/');
		setcookie('UserName', null, -1, '/');
		echo "<script>window.location.href='login.php'</script>";
	}
	else
	{
		echo "<script>window.location.href='login.php'</script>";
	}
?>