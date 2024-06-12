
<?php
$user = $_SESSION["user"];

?>
<script>
function showHint(searchText) {
    if (searchText.length == 0) { 
        document.getElementById("txtHint").innerHTML = "";
        return '';
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "inc/classes/class.getHint.php?q=" + searchText, true);
        xmlhttp.send();
    }
}

function onLeave() {
    if( confirm("Do you really want to delete your profile? All your posted Blogs and Comments will be deleted.")===true){
    	location.href='index.php?id=7';
    }
    return false;
}
</script>


<h1>
<?php

if (isset($_SESSION["oldUserName"]))
    echo 'Change Profile';
else
    echo 'Register';
?>
</h1>
<form method="post"
	action="<?php
$id = $_GET["id"];
if ($id == 5 || $id == 6 || $id == 8)
    echo "../index.php?id=6";
else
    echo "../index.php?id=3";
?>"
	enctype="multipart/form-data">

	<table style="border: hidden;">
		<tr>
			<td>First name:</td>
			<td><input type="text" name="firstname" minlength="2" maxlength="30"
				size="30" required value="<?php echo $user->getFirstname(); ?>"></td>
			<td style="color: red;"><?php echo $user->getFirstnameError(); ?></td>
		</tr>
		<tr>
			<td>Last name:</td>
			<td><input type="text" name="lastname" minlength="2" maxlength="30"
				size="30" required value="<?php echo $user->getLastname(); ?>"></td>
			<td style="color: red;"><?php echo $user->getLastnameError(); ?></td>
		</tr>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username" onkeyup="showHint(this.value)"
				minlength="6" maxlength="20" size="30" required
				value="<?php echo $user->getUsername(); ?>"></td>
			<td style="color: red;"><?php echo $user->getUsernameError(); ?></td>
		</tr>
		<tr>
			<td colspan=2><b>Suggestions:</b> <span id="txtHint"></span></td>
		</tr>

		<tr>
			<td>Email*:</td>
			<td><input type="email" name="email" size="30"
				value="<?php echo $user->getEmail(); ?>"></td>
			<td style="color: red;"><?php echo $user->getEmailError(); ?></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password" minlength="6"
				maxlength="30" size="30" required></td>
			<td style="color: red;"><?php echo $user->getPasswordError(); ?></td>
		</tr>

		<tr>
			<td></td>
			<td><input type="submit"
				value="<?php

    if ($id == 5 || $id == 6)
        echo "Change";
    else
        echo "Add";
    ?>"> <input type="reset" value="Reset">
    
    <?php  if ($id == 5 || $id == 6){?>
    <input type="button" value="Delete Account"
				onclick="return onLeave()">
    <?php }?>
    </td>

			<td></td>
		</tr>
		<tr>
		<?php

if (! isset($_SESSION["oldUserName"]))
    echo "
			<td colspan=2><a href=\"index.php?id=2\">Already have an account?</a></td>
		";

?>
		</tr>
	</table>
</form>


