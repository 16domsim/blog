<?php
if ($_SESSION["showSearch"] == true) {
    echo "<script> location.replace(\"index.php?id=1\"); </script>";
    exit();
}

$blogs = $_SESSION["blogList"]->getBlogs();
if ($blogs === false) {
    echo "<p><b>Ups!</b><p>";
    echo "<p>It seem like no Blog has been published yet...<p>";
    echo "<td colspan=2><a href=\"index.php?id=10\">Be the first one, Add a Blog here -></a></td>";
} else {

    $searchTerm = "";
    $notvalid = true;
    if (isset($_SESSION["searchText"]) && strlen(trim($_SESSION["searchText"])) > 0) {
        $searchTerm = $_SESSION["searchText"];
        $notvalid = false;
    }

    $counter = 0;

    foreach ($blogs as $key => $value) {

        $valid = true;

        if ($notvalid === false) {
            $valid = strpos(strtolower($value->getTitle()), strtolower($searchTerm));
            if ($valid !== false)
                $valid = true;
        }

        if ($valid) {
            $counter ++;
            ?>

<div class="blog">
	<h1><?php echo $value->getTitle()?></h1>

	<a class="modify"
		href="<?php echo"../index.php?id=14&blog=".$value->getTitle()?>"> See
		more-> </a>

	<p><?php
            if (strlen($value->getContent()) > 180)
                echo substr($value->getContent(), 0, 180) . "...";
            else
                echo $value->getContent()?></p>
		<?php
            if (strcmp($value->getUsername(), $_SESSION["loginUsername"]) != 0) {
                ?>
	<div class="author">
		<i>written by <?php echo $value->getUsername()?></i>
	</div>
	<?php }?>
</div>
<?php
        }
    }

    if ($counter == 0) {
        ?>
<p>
	No results for the searchterm "<b><?php echo $searchTerm;?></b>"
<p>
    <?php
    }
}
?>
