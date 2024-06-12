<?php
require_once 'inc/classes/class.ValidableUser.php';
require_once 'inc/classes/class.UserList.php';
require_once 'inc/classes/class.BlogList.php';
require_once 'inc/classes/class.ValidableBlog.php';
require_once 'inc/classes/class.Comment.php';

const MAX_INACTIVITY_SECONDS = 5*60;
session_start();
if (isset($_SESSION["lastActivity"]) && (time() - $_SESSION["lastActivity"]) > MAX_INACTIVITY_SECONDS)
    session_destroy();
$_SESSION["lastActivity"] = time();

require_once 'scripts/scr.auth.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="Simone Domenici">
<meta name="description"
	content="This Page describes Simone Domenici and is very reliable as it was wrote from Simone Domenici himselfe!">
<link rel="stylesheet" type="text/css" href="inc/css/html5reset.css">
<link rel="stylesheet" type="text/css" href="inc/css/usermanagement.css">
<title>Hypercar Blog</title>
</head>

<body>


<?php

if (! isset($_SESSION["userList"])) {
    $h1 = file_get_contents('users');
    if ($h1 === false)
        $_SESSION["userList"] = new UserList();
    else
        $_SESSION["userList"] = unserialize($h1);
} else {

    $userList = $_SESSION["userList"];
    $h1 = serialize($userList);
    file_put_contents('users', $h1);
}

if (! isset($_SESSION["user"]))
    $_SESSION["user"] = new ValidableUser();
$user = $_SESSION["user"];

if (! isset($_SESSION["blogList"])) {

    $h2 = file_get_contents('blogs');
    if ($h2 === false)
        $_SESSION["blogList"] = new BlogList();
    else
        $_SESSION["blogList"] = unserialize($h2);
} else {
    $blogList = $_SESSION["blogList"];
    $h2 = serialize($blogList);
    file_put_contents('blogs', $h2);
}

if (! isset($_SESSION["blog"]))
    $_SESSION["blog"] = new ValidableBlog();
$blog = $_SESSION["blog"];

if (! isset($_SESSION["showSearch"]))
    $_SESSION["showSearch"] = false;

$id = 1;
if (isset($_GET["id"]))
    $id = $_GET["id"];

?>

<div class="header">
		<h1>Hypercar Bolg</h1>
	</div>

<?php if(!isset($_SESSION["registred"])||$_SESSION["registred"]==false){?>

<nav class="navbar">
		<a class="home" href="index.php?id=1">Home</a>
		<?php

    if ($id == "1" || $_SESSION["showSearch"] == true) {
        $_SESSION["showSearch"] = false;
        $searchText = trim(filter_input(INPUT_POST, "search", FILTER_SANITIZE_STRING));
        if (isset($searchText) && strlen($searchText) > 0)
            $_SESSION["searchText"] = $searchText;
        else
            unset($_SESSION["searchText"]);

        ?>
    <div class="search">
			<form action="index.php?id=1" method="post"
				enctype="multipart/form-data">
				<input type="text" placeholder="Search..." name="search"
					value="<?php echo $searchText?>"
					>
				<button type="submit">⌕</button>
			</form>
		</div>
		<?php }?>
		 <a href="index.php?id=10">Add</a> <a href="index.php?id=18">About</a>
		<a href="index.php?id=19">Contacts</a> <a href="index.php?id=20">Privacy</a>
	
		<?php
    if (! isset($_SESSION["loginUsername"])) {
        ?>
	<a class="right" href="index.php?id=100">Login</a> <a class="right"
			href="index.php?id=9">Register</a>
	<?php } else { ?> 
	<a class="right" href="index.php?id=101">Logout -></a> <a class="right"
			href="<?php echo "index.php?id=5&username=".$user->getUsername() ?>">Profile</a>	
	<?php }?>
		
	</nav>
<?php
}
?>

<?php

if ($id == "1") {
    require_once 'scripts/scr.blogList.php';
} else if ($id == "2") {
    $user = new ValidableUser();
    require_once 'scripts/scr.userFormLogin.php';
} elseif ($id == "9") {
    $user = new ValidableUser();
    $_SESSION["user"] = $user;
    require_once 'scripts/scr.userFormRegister.php';
} elseif ($id == "10") {
    $blog = new ValidableBlog();
    $_SESSION["blog"] = $blog;
    require_once 'scripts/scr.blogFormAdd.php';
} else if ($id == "3") {
    $user->setFirstname(filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING));
    $user->setLastname(filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_STRING));
    $user->setUsername(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING));
    $user->setEmail(filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING));
    $_SESSION["help"] = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    $user->setPassword(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
    $user->validate();
    if (count($user->getAllErrors()) != 0 || ! $userList->addUser($user))
        require_once 'scripts/scr.userFormRegister.php';
    else
        require_once 'scripts/scr.userFormLogin.php';
} else if ($id == "4") {
    if (! isset($_GET["username"]) || strlen($_GET["username"]) == 0) {
        $_SESSION["showSearch"] = true;
        require_once 'scripts/scr.blogList.php';
    } else {
        $user = $userList->getUser($_GET["username"]);
        if (! $user) {
            $_SESSION["showSearch"] = true;
            require_once 'scripts/scr.blogList.php';
        } else {
            $_SESSION["user"] = $user;
            require_once 'scripts/scr.userFormLogin.php';
        }
    }
} elseif ($id == "5") {
    if (isset($_GET["username"]) && strlen($_GET["username"]) > 0) {
        $username = filter_input(INPUT_GET, "username", FILTER_SANITIZE_STRING);
        $userH = $userList->getUser($username);
        if ($userH !== false) {
            $_SESSION["oldUserName"] = $userH->getUsername();
            $user->setFirstname($userH->getFirstname());
            $user->setLastname($userH->getLastname());
            $user->setUsername($userH->getUsername());
            $user->setEmail($userH->getEmail());
            $user->setPassword($userH->getPassword());

            require_once 'scripts/scr.userFormRegister.php';
        } else {
            $_SESSION["showSearch"] = true;
            require_once 'scripts/scr.blogList.php';
        }
    } else {
        $_SESSION["showSearch"] = true;
        require_once 'scripts/scr.blogList.php';
    }
} elseif ($id == "6") {
    $oldUserName = $_SESSION["oldUserName"];
    if (isset($oldUserName) && strlen($oldUserName) > 0) {
        $user->setFirstname(filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING));
        $user->setLastname(filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_STRING));
        $user->setUsername(filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING));
        $user->setEmail(filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING));
        $user->setPassword(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
        $user->validate();
        if (count($user->getAllErrors()) != 0 || ! $userList->updateUser($oldUserName, $user))
            require_once 'scripts/scr.userFormRegister.php';
        else {
            unset($_SESSION["oldUserName"]);
            unset($oldUserName);
            $_SESSION["showSearch"] = true;
            require_once 'scripts/scr.blogList.php';
        }
    } else {
        $_SESSION["showSearch"] = true;
        require_once 'scripts/scr.blogList.php';
    }
} elseif ($id == "7") {

    if ($userList->deleteUser($_SESSION["loginUsername"])) {
        $blogList->deleteBlogsByUsername($_SESSION["loginUsername"]);
        unset($_SESSION["user"]);
        unset($user);
        unset($_SESSION["loginUsername"]);
        echo "<script> location.replace(\"index.php\"); </script>";
    } else {
        $_SESSION["showSearch"] = true;
        require_once 'scripts/scr.blogList.php';
    }
} else if ($id == "8") {
    $blog->setTitle(filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING));
    $blog->setContent(filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING));
    $blog->setUsername($user->getUsername());

    $blog->setImagesFromSuperglobal($_FILES);

    $blog->validate();

    if (count($blog->getAllErrors()) != 0 || ! $blogList->addBlog($blog))
        require_once 'scripts/scr.blogFormAdd.php';
    else {
        $_SESSION["showSearch"] = true;
        require_once 'scripts/scr.blogList.php';
    }
} elseif ($id == "11") {
    if (isset($_GET["blog"]) && strlen($_GET["blog"]) > 0) {
        $blogName = filter_input(INPUT_GET, "blog", FILTER_SANITIZE_STRING);
        $blogH = $blogList->getBlog($blogName);
        if ($blogH !== false) {
            $_SESSION["oldBlog"] = $blogH->getTitle();
            $blog->setTitle($blogH->getTitle());
            $blog->setContent($blogH->getContent());
            require_once 'scripts/scr.blogFormAdd.php';
        } else {
            $_SESSION["showSearch"] = true;
            require_once 'scripts/scr.blogList.php';
        }
    } else {
        $_SESSION["showSearch"] = true;
        require_once 'scripts/scr.blogList.php';
    }
} elseif ($id == "12") {
    $oldBlogName = $_SESSION["oldBlog"];
    if (isset($oldBlogName) && strlen($oldBlogName) > 0) {
        $blog->setTitle(filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING));
        $blog->setContent(filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING));
        
        $blog->setImagesFromSuperglobal($_FILES);

        $blog->validate();

        if (count($blog->getAllErrors()) != 0 || ! $blogList->updateBlog($oldBlogName, $blog))
            require_once 'scripts/scr.blogFormAdd.php.php';
        else {
            unset($_SESSION["oldBlog"]);
            unset($oldBlogName);
            $_SESSION["showSearch"] = true;
            require_once 'scripts/scr.blogList.php';
        }
    } else {
        $_SESSION["showSearch"] = true;
        require_once 'scripts/scr.blogList.php';
    }
} elseif ($id == "13") {

    if ($blogList->deleteBlog($blog->getTitle())) {
        unset($_SESSION["blog"]);
        unset($blog);
    }
    $_SESSION["showSearch"] = true;
    require_once 'scripts/scr.blogList.php';
} elseif ($id == "14") {
    if (isset($_GET["blog"]) && strlen($_GET["blog"]) > 0) {
        $blogName = filter_input(INPUT_GET, "blog", FILTER_SANITIZE_STRING);
        $blogH = $blogList->getBlog($blogName);

        if ($blogH !== false) {

            $_SESSION["blog"] = $blogH;
            require_once 'scripts/scr.blogDetail.php';
        } else {
            $_SESSION["showSearch"] = true;
            require_once 'scripts/scr.blogList.php';
        }
    } else {
        $_SESSION["showSearch"] = true;
        require_once 'scripts/scr.blogList.php';
    }
} elseif ($id == "15") {
    if (isset($_GET["imageID"]) && isset($blog)) {

        $blogImageToDelete = intval(filter_input(INPUT_GET, "imageID", FILTER_SANITIZE_STRING));

        $blog->deleteImage($blogImageToDelete);
        $blogList->updateBlog($blog->getTitle(), $blog);
        require_once 'scripts/scr.blogFormAdd.php';
    } else {
        $_SESSION["showSearch"] = true;
        require_once 'scripts/scr.blogList.php';
    }
} elseif ($id == "16") {
    if (isset($blog)) {

        $blogComment = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_STRING);

        $comment = new Comment();
        $comment->setUserName($_SESSION["loginUsername"]);
        $comment->setContent($blogComment);

        $blog->addComment($comment);

        $blogList->updateBlog($blog->getTitle(), $blog);
        require_once 'scripts/scr.blogDetail.php';
    } else {
        $_SESSION["showSearch"] = true;
        require_once 'scripts/scr.blogList.php';
    }
} elseif ($id == "17") {
    if (isset($_GET["commentID"]) && isset($blog)) {

        $blogCommentToDelete = intval(filter_input(INPUT_GET, "commentID", FILTER_SANITIZE_STRING));

        $blog->deleteComment($blogCommentToDelete);
        $blogList->updateBlog($blog->getTitle(), $blog);
        require_once 'scripts/scr.blogDetail.php';
    } else {
        $_SESSION["showSearch"] = true;
        require_once 'scripts/scr.blogList.php';
    }
} elseif ($id == "18") {

    require_once 'scripts/scr.about.php';
} elseif ($id == "19") {

    require_once 'scripts/scr.contacts.php';
} elseif ($id == "20") {

    require_once 'scripts/scr.privacy.php';
} else {
    $_SESSION["showSearch"] = true;
    require_once 'scripts/scr.blogList.php';
}

?>
</body>
</html>