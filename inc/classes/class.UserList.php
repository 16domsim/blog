<?php

class UserList
{

    protected $users = array();

    public function addUser($user)
    {
        $ret = false;
        if (isset($user)) {
            $user->validate();
            if (empty($user->getUsernameError())) {
                $ret = true;
                if (isset($this->users[$user->getUsername()])) {
                    $user->setUserNameError("Username already used");
                    $ret = false;
                }
            }
            if (count($user->getAllErrors()) == 0 && $ret)
                $this->users[$user->getUsername()] = $user;
            else
                $ret = false;
        }
        return $ret;
    }

    public function updateUser($oldUsername, $user)
    {
        $ret = false;
        if (isset($oldUsername) && isset($this->users[$oldUsername]) && isset($user)) {
            $user->validate();
            if (count($user->getAllErrors()) == 0) {
                if ($oldUsername != $user->getUserName()) {
                    if (isset($this->users[$user->getUsername()])) {
                        $user->setUserNameError("Username already used");
                    } else {
                        unset($this->users[$oldUsername]);
                        $this->users[$user->getUsername()] = $user;
                        $ret = true;
                    }
                } else {
                    $this->users[$user->getUsername()] = $user;
                    $ret = true;
                }
            }
        }
        return $ret;
    }

    public function getUsers()
    {
        return count($this->users) == 0 ? false : $this->users;
    }

    public function getUser($username)
    {
        $ret = false;
        if (isset($username) && isset($this->users[$username]))
            $ret = clone $this->users[$username];
        return $ret;
    }

    public function deleteUser($username)
    {
        $ret = false;
        if (isset($username) && isset($this->users[$username])) {
            unset($this->users[$username]);
            $ret = true;
        }
        return $ret;
    }

    public function authUser($username, $password)
    {
        $ret = false;
        if (isset($password) && isset($username) && isset($this->users[$username])) {
            $password =  hash("sha512", $password);
            if ($password == $this->users[$username]->getPassword())
                $ret = true;
        }
        return $ret;
    }
}