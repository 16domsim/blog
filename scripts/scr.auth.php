<?php

const IDS_LOGIN_NOT_NECESSARY = [
    "1",
    "2",
    "3",
    "9",
    "18",
    "19",
    "20"
];
$id = $_GET["id"];
if (! isset($id))
    $id = 1;

if ($id == 101) {
    unset($_SESSION["loginUsername"]);
    header("Location:index.php");
    exit();
} else {
    if (array_search($id, IDS_LOGIN_NOT_NECESSARY, true) === false && ! isset($_SESSION["loginUsername"])) {
        if (! isset($_SESSION["request_id"])) {
            foreach ($_GET as $key => $value)
                $_SESSION["request_" . $key] = $value;
            $_SESSION["request_id"] = "100";
            unset($_SESSION["login_error"]);
            header("Location:index.php?id=2");
        } else {

            $username = filter_input(INPUT_POST, "loginUsername", FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, "loginPassword", FILTER_SANITIZE_STRING);
            if (! $_SESSION["userList"]->authUser($username, $password)) {
                $_SESSION["login_error"] = true;
                header("Location:index.php?id=2");
            } else {
                $_SESSION["loginUsername"] = $username;
                unset($_SESSION["login_error"]);
                if ($_SESSION["request_id"] == "100")
                    unset($_SESSION["request_id"]);
                $params = "";
                foreach ($_SESSION as $key => $value) {
                    if (strpos($key, "request_") === 0) {
                        if (! empty($params))
                            $params = $params . "&";
                        else
                            $params = "?";
                        $params = $params . substr($key, 10) . "=" . $value;
                        unset($_SESSION[$key]);
                    }
                    header("Location:index.php" . $params);
                }
            }
        }
        exit();
    }
}

?>