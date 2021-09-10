<?php
    require_once(__DIR__."/util.php");
    require_once(__DIR__."/components/header.php");

    class ProfilePage extends Document{
        function start(){
            $headerObject = new Header();
            $this->setHeader($headerObject);
        }
        function end(){
            
        }
    }
    $profile = new ProfilePage('tag');
    $profile->getHTMLCode();
?>