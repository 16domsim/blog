
<?php
$blog = $_SESSION["blog"];
$id = $_GET["id"];

?>
<script>
function onLeave() {
    if( confirm("Do you really want to delete this Blog? All Comments to this Blog will be deleted.")===true){
    	location.href='index.php?id=13';
    }
    return false;
}
</script>
<h1>
<?php
if ($id == 11 || $id == 12 || $id == 15)
    echo "Change";
else
    echo "Add blog";
?>
</h1>
<form method="post"
	action="<?php

if ($id == 11 || $id == 12 || $id == 15)
    echo "../index.php?id=12";
else
    echo "../index.php?id=8";
?>"
	enctype="multipart/form-data">

	<table style="border: hidden;">
		<tr>
			<td>Title:</td>
			<td><input type="text" name="title"
				placeholder="Input the title....." minlength="5" maxlength="30"
				size="50" required value="<?php echo $blog->getTitle(); ?>"></td>
			<td style="color: red;"><?php echo $blog->getTitleError(); ?></td>
		</tr>
		<tr>
			<td>Content:</td>
			<td><textarea name="description" placeholder="Input the content....."
					rows="20" cols="80" wrap="hard" minlength="15" maxlength="10000"
					required>
        <?php echo $blog->getContent(); ?>
         </textarea></td>
			<td style="color: red;"><?php echo $blog->getContentError(); ?></td>
		</tr>

		<tr>
			<td>Pictures:</td>

			<td>
			
				<?php
    if ($blog->getImages() !== null && count($blog->getImages()) > 0) {
        foreach ($blog->getImages() as $key => $value) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($value) . '"/>'?>	
	<input type="button"
				onclick="location.href='index.php?id=15&imageID=<?php echo $key?>'"
				value="Delete image">
						    <?php } }?>

 
    <table style="border: hidden;">
					<tr>
						<td><input multiple type="file" name="images[]"></td>

					</tr>
				</table>

			</td>
			<td style="color: red;"></td>
		</tr>

		<tr>
			<td></td>
			<td><input type="submit"
				value="<?php

    if ($id == 11 || $id == 12||$id==15)
        echo "Change";
    else
        echo "Add";
    ?>"> <input type="reset" value="Reset">
      <?php  if ($id == 11 || $id == 12 || $id==15){?>
    <input type="button" value="Delete Blog" onclick="return onLeave()">
    <?php }?>
    </td>
			<td style="color: red;"></td>
		</tr>

	</table>

</form>


