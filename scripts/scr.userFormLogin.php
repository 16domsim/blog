
<?php
$user = $_SESSION["user"];

?>
<h1>Login</h1>


</head>
<body>



	<form method="post"
		action="<?php
$id = $_GET["id"];
if ($id == 5 || $id == 6 || $id == 8)
    echo "../index.php?id=6";
else
    echo "../index.php";
?>"
		enctype="multipart/form-data">
		<table style="border: hidden;">
	<?php

if (isset($_SESSION["login_error"])) {
    if ($_SESSION["login_error"] == true){?>
	<tr>
				<td style="color: red;" colspan=2>Invalid Login!</td>
			</tr>
	<?php
}
	}?>
		<tr>
				<td>Username:</td>
				<td><input type="text" name="loginUsername"></td>
				<td style="color: red;"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="loginPassword"></td>
				<td style="color: red;"></td>
			</tr>

			<tr>
				<td></td>
				<td><input type="submit"
					value="<?php

    if ($id == 5 || $id == 6 || $id == 8)
        echo "Change";
    else
        echo "Login";
    ?>"> <input type="reset" value="Reset"></td>
				<td style="color: red;"></td>
			</tr>
			<tr>
				<td colspan=2><a href="index.php?id=9">Do not have an account?</a></td>
			</tr>
		</table>
	</form>