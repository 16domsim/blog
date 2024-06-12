<?php
require_once 'class.Blog.php';

class ValidableBlog extends Blog
{

    public function __construct($title = null, $content = null, $username = null)
    {
        $this->errors = array();
        $this->setTitle($title);
        $this->setcontent($content);
        $this->setUserName($username);
    }

    /**
     * Der Titel muss gesetzt sein und nicht nur aus Leerzeichen bestehen.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        if (isset($title) && ! empty(trim($title)))
            parent::setTitle($title);
    }

    /**
     * Gibt die Fehlermeldung des Titels zurück.
     * Falls kein Fehler vorhanden ist wird ein leerer String zurückgegeben.
     *
     * @return string Fehlermeldung
     */
    public function getTitleError()
    {
        if (isset($this->errors["title"]))
            return $this->errors["title"];
        else
            return "";
    }

    /**
     * Setzt die Fehlermeldung des Titels auf die übergebene Fehlermeldung wenn nicht
     * bereits eine andere Fehlermeldung des Titels vorhanden ist und die übergebene
     * Fehlermeldung gesetzt ist, nicht nur aus Leerzeichen besteht und ein String ist.
     *
     * @param
     *            string Fehlermeldung
     */
    public function setTitleError($error)
    {
        if (isset($error) && ! empty(trim($error)) && strcmp(gettype($error), "string") == 0) {
            if (! isset($this->errors["title"]) || empty($this->errors["title"]))
                $this->errors["title"] = $error;
        }
    }

    /**
     * Der Inhalt muss gesetzt sein und nicht nur aus Leerzeichen bestehen.
     *
     * @param string $content
     */
    public function setContent($content)
    {
        if (isset($content) && ! empty(trim($content)))
            parent::setContent($content);
    }

    /**
     * Gibt die Fehlermeldung des Inhaltes zurück.
     * Falls kein Fehler vorhanden ist wird ein leerer String zurückgegeben.
     *
     * @return string Fehlermeldung
     */
    public function getContentError()
    {
        if (isset($this->errors["content"]))
            return $this->errors["content"];
        else
            return "";
    }

    /**
     * Der Inhalt muss gesetzt sein und nicht nur aus Leerzeichen bestehen.
     *
     * @param string $userName
     */
    public function setUsername($userName)
    {
        if (isset($userName) && ! empty(trim($userName)))
            parent::setUserName($userName);
    }

    /**
     * Das Bild muss gesetzt sein.
     *
     * Nur Bilder dürfen raufgeladen werden.
     *
     * Die maximale größe des Bildes darf nicht die maximale vorgesehene größe überstreiten.
     *
     * @param
     *            $image
     *            
     * @param string $imageType
     *
     * @param int $imageSize
     *
     *
     */
    public function addImage($image, $imageType, $imageSize)
    {
        if (isset($image) && isset($imageType) && ! empty(trim($imageType)) && isset($imageSize) && strcmp(gettype($imageSize), "integer") == 0)
            parent::addImage($image, $imageType, $imageSize);
    }

    /**
     * Setz das Bild über die übergebene Superglobal.
     *
     * @param
     *            $image
     */
    public function setImagesFromSuperglobal($images)
    {
        if (isset($images)) {

            $file_count = count($images["images"]["name"]);
            echo $file_count;

            if ($file_count > 0) {

                for ($i = 0; $i < $file_count; $i ++) {

                    if ($images["images"]["error"][$i] == UPLOAD_ERR_OK) {
                        if ($images["images"]["size"][$i] > 0) {
                            $file = fopen($images["images"]["tmp_name"][$i], "rb");
                            $this->addImage(fread($file, $images["images"]["size"][$i]), $images["images"]["type"][$i], $images["images"]["size"][$i]);
                            fclose($file);
                        }
                    }
                }
            }
        }
    }
    
    

    /**
     * Gibt die Fehlermeldungen des Bildes zurück.
     * Falls keine Fehler vorhanden ist wird ein leerer String zurückgegeben
     *
     * @return string Fehlermeldungen
     */
    public function getImageErrors()
    {
        $error = array();
        foreach ($this->imageTypes as $key) {
            if (isset($this->errors["image1"][$key]))
                $error[$key] = $error[$key] . $this->errors["image1"][$key];
            if (isset($this->errors["image2"][$key]))
                $error[$key] = $error[$key] . $this->errors["image2"][$key];
        }
        return $error;
    }

    /**
     * Validiert die Parameter des Blogs und speichert gegebenfalls
     * auftertende Fehlermeldungen in der Liste von den Fehler.
     */
    public function validate()
    {
        if (isset($this->title) && ! empty(trim($this->title)))
            $this->errors["title"] = "";
        else
            $this->errors["title"] = "Input your first name!";

        if (isset($this->content) && ! empty(trim($this->content)))
            $this->errors["content"] = "";
        else
            $this->errors["content"] = "Input your last name!";

        if (isset($this->imageTypes)) {

            foreach ($this->imageTypes as $key => $value) {
                if (strcmp($value, "image\png") == 0 || strcmp($value, "image\jpg") == 0 || strcmp($value, "image/jpeg") == 0)
                    $this->errors["image1"][$key] = "";
                else
                    $this->errors["image1"][$key] = "You can only upload images of the following format: png, jpg and jpeg!";
            }
        }

        if (isset($this->imageSizes)) {
            foreach ($this->imageSizes as $key => $value) {
                if (strcmp(gettype($value), "integer") == 0 && $value <= parent::MAX_IMAGE_SIZE)
                    $this->errors["image2"][$key] = "";
                else
                    $this->errors["image2"][$key] = "This image is to big!";
            }
        }
    }

    /**
     * Gibt die Stringentsprechung des Objektes zurück.
     *
     * @return string
     */
    public function __toString()
    {
        return "title: " . $this->title . "; content: " . $this->content;
    }

    /**
     * Gibt alle Fehlermeldunge in Form eines Arrays zurück.
     *
     * @return array Fehlermeldungen
     */
    public function getAllErrors()
    {
        $ret = array();
        if (! empty($this->getTitleError()))
            $ret["title"] = $this->getTitleError();
        if (! empty($this->getContentError()))
            $ret["content"] = $this->getContentError();
        if (! empty($this->getImageErrors()))
            $ret["image"] = $this->getImageErrors();

        return $ret;
    }
}
?>