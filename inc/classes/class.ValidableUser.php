<?php
require_once 'class.User.php';

class ValidableUser extends User
{

    public function __construct($firstname = null, $lastname = null, $username = null, $email = null, $password = null)
    {
        $this->errors = array();
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    /**
     * Der Vorname muss gesetzt sein und nicht nur aus Leerzeichen bestehen.
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        if (isset($firstname) && ! empty(trim($firstname)))
            parent::setFirstname($firstname);
    }

    /**
     * Gibt die Fehlermeldung des Vornamen zurück.
     * Falls kein Fehler vorhanden ist wird ein leerer String zurückgegeben.
     *
     * @return string Fehlermeldung
     */
    public function getFirstnameError()
    {
        if (isset($this->errors["firstname"]))
            return $this->errors["firstname"];
        else
            return "";
    }

    /**
     * Der Nachname muss gesetzt sein und nicht nur aus Leerzeichen bestehen.
     *
     * @param string $lastName
     */
    public function setLastname($lastName)
    {
        if (isset($lastName) && ! empty(trim($lastName)))
            parent::setLastname($lastName);
    }

    /**
     * Gibt die Fehlermeldung des Nachnamen zurück.
     * Falls kein Fehler vorhanden ist wird ein leerer String zurückgegeben.
     *
     * @return string Fehlermeldung
     */
    public function getLastnameError()
    {
        if (isset($this->errors["lastName"]))
            return $this->errors["lastName"];
        else
            return "";
    }

    /**
     * Der Benutzername muss gesetzt sein und nicht nur aus Leerzeichen bestehen.
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        if (isset($username) && ! empty(trim($username)))
            parent::setUsername($username);
    }

    /**
     * Gibt die Fehlermeldung des Usernames zurück.
     * Falls kein Fehler vorhanden ist wird ein leerer String zurückgegeben.
     *
     * @return string Fehlermeldung
     */
    public function getUsernameError()
    {
        if (isset($this->errors["username"]))
            return $this->errors["username"];
        else
            return "";
    }

    /**
     * Setzt die Fehlermeldung des Usernames auf die übergebene Fehlermeldung wenn nicht
     * bereits eine andere Fehlermeldung des Usernames vorhanden ist und die übergebene
     * Fehlermeldung gesetzt ist, nicht nur aus Leerzeichen besteht und ein String ist.
     *
     * @param
     *            string Fehlermeldung
     */
    public function setUserNameError($error)
    {
        if (isset($error) && ! empty(trim($error)) && strcmp(gettype($error), "string") == 0) {
            if (! isset($this->errors["username"]) || empty($this->errors["username"]))
                $this->errors["username"] = $error;
        }
    }

    /**
     * Die Email muss gesetzt sein und nicht nur aus Leerzeichen bestehen.
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        if (isset($email) && ! empty(trim($email)))
            parent::setUsername($email);
    }

    /**
     * Gibt die Fehlermeldung der Email zurück.
     * Falls kein Fehler vorhanden ist wird ein leerer String zurückgegeben.
     *
     * @return string Fehlermeldung
     */
    public function getEmailError()
    {
        if (isset($this->errors["email"]))
            return $this->errors["email"];
        else
            return "";
    }

    /**
     * Das Password muss gesetzt sein und nicht nur aus Leerzeichen bestehen.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        if (isset($password) && ! empty(trim($password)))
            parent::setPassword($password);
    }

    /**
     * Gibt die Fehlermeldung des Passwords zurück.
     * Falls kein Fehler vorhanden ist wird ein leerer String zurückgegeben.
     *
     * @return string Fehlermeldung
     */
    public function getPasswordError()
    {
        if (isset($this->errors["password"]))
            return $this->errors["password"];
        else
            return "";
    }

    /**
     * Validiert die Parameter des Benutzers und speichert gegebenfalls
     * auftertende Fehlermeldungen in der Liste von den Fehler.
     */
    public function validate()
    {
        if (isset($this->firstname) && ! empty(trim($this->firstname)))
            $this->errors["firstname"] = "";
        else
            $this->errors["firstname"] = "Input your first name!";

        if (isset($this->lastname) && ! empty(trim($this->lastname)))
            $this->errors["lastname"] = "";
        else
            $this->errors["lastname"] = "Input your last name!";

        if (isset($this->username) && ! empty(trim($this->username)))
            $this->errors["username"] = "";
        else
            $this->errors["username"] = "Input the username!";
        // Check if email is valid
        if (isset($this->email) && ! empty(trim($this->email)))
            $this->errors["email"] = "";

        if (isset($this->password) && ! empty(trim($this->password)))
            $this->errors["password"] = "";
        else
            $this->errors["password"] = "Input the password!!";
    }

    /**
     * Gibt die Stringentsprechung des Objektes zurück.
     *
     * @return string
     */
    public function __toString()
    {
        return "first name: " . $this->firstname . "; last name: " . $this->lastname . "; username: " . $this->username . "; email: " . $this->email . "; password: " . $this->password;
    }

    /**
     * Gibt alle Fehlermeldunge in Form eines Arrays zurück.
     *
     * @return array Fehlermeldungen
     */
    public function getAllErrors()
    {
        $ret = array();
        if (! empty($this->getFirstnameError()))
            $ret["firstname"] = $this->getFirstnameError();
        if (! empty($this->getLastnameError()))
            $ret["lastname"] = $this->getLastnameError();
        if (! empty($this->getUsernameError()))
            $ret["username"] = $this->getUsernameError();
        if (! empty($this->getEmailError()))
            $ret["email"] = $this->getEmailError();
        if (! empty($this->getPasswordError()))
            $ret["password"] = $this->getPasswordError();

        return $ret;
    }
}
?>