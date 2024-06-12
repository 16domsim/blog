<?php
$blog = $_SESSION["blog"];
?>

<div class="blog">
	<h1><?php echo $blog->getTitle()?></h1>
	<?php
if (strcmp($blog->getUsername(), $_SESSION["loginUsername"]) == 0) {
    ?>
	<a class="modify"
		href="<?php echo"../index.php?id=11&blog=".$blog->getTitle()?>">
		Update </a>
	<?php }?>
	<p><?php echo $blog->getContent()?></p>

	<div class="slideshow-container">
<?php

$imagesLength = count($blog->getImages());

$counter = 0;

for ($j = 0; $j < $blog->getImageId(); $j ++) {

    if (isset($blog->getImages()[$j])) {

        $counter ++;

        ?>
      

  <div class="mySlides fade">
  <?php if($imagesLength>1){?>
			<div class="numbertext"><?php echo $counter.' / '.$imagesLength?></div>
			
			
				<?php  } echo '<img src="data:image/jpeg;base64,' . base64_encode($blog->getImages()[$j]) . '" style="width: 100%"/>';?>

		</div>
  
  <?php } }?>

	</div>

	<br>


	<div style="text-align: center">
	  <?php if($imagesLength>1){?>
<?php
    for ($j = 0; $j < $imagesLength; $j ++) {
        ?>
<span class="dot" onclick="currentSlide(<?php echo ($j+1)?>)"></span> 

 
  <?php } }?>
  <script>
  var slideIndex = 1;
  showSlides(slideIndex);

  function currentSlide(n) {
    showSlides(slideIndex = n);
  }

  function showSlides(n) {
	  var i;
	  var slides = document.getElementsByClassName("mySlides");
	  var dots = document.getElementsByClassName("dot");
	  if (n > slides.length) {slideIndex = 1}    
	  if (n < 1) {slideIndex = slides.length}
	  for (i = 0; i < slides.length; i++) {
	      slides[i].style.display = "none";  
	  }
	  for (i = 0; i < dots.length; i++) {
	      dots[i].className = dots[i].className.replace(" active", "");
	  }
	  slides[slideIndex-1].style.display = "block";  
	  dots[-(-slideIndex+1)].className += " active";
  }
</script>
	</div>


	

		<?php
if (strcmp($blog->getUsername(), $_SESSION["loginUsername"]) != 0) {
    ?>
	<div class="author">
		<i>written by <?php echo $blog->getUsername()?></i>
	</div>
	<?php }?>
	
	
	<h3>Commets:</h3>
	<div class="comment">

		<form method="post" action="<?php
echo "../index.php?id=16";
?>"
			enctype="multipart/form-data">

			<table style="border: hidden;">
				<tr>
					<td>Write a comment:</td>
					<td><input type="text" name="comment"
						placeholder="Input your comment....." minlength="3"
						maxlength="100" size="100%" overflow="hidden" required></td>
					<td><input type="submit" value="Send"> <input type="reset"
						value="Reset">
				
				</tr>



			</table>
		</form>

		<hr>
	
	<?php

if ($blog->getComments() === false) {
    ?>
	    	<p>
			<i>No commets available</i>
		</p>
	    <?php
} else {
    ?>
  
  <table>
    
  <?php

    foreach ($blog->getComments() as $key => $value) {

        ?>
        <tr>
				<td>
					<p>
						<b>
            <?php echo $value->getUserName().':';?>
            </b>
          
                 <?php echo $value->getContent();?>
          
            </p>
				</td>
				
          
            <?php

        if (strcmp($value->getUserName(), $_SESSION["loginUsername"]) == 0) {
            ?>
     
                <td><input type="button"
					onclick="location.href='index.php?id=17&commentID=<?php echo $key?>'"
					value="Delete comment"></td>
    <?php
        }
        ?>   </tr><?php
    }

    ?> </table><?php
}
?>
</div>
</div>


