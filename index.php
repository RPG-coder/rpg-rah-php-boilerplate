<?php
    require_once(__DIR__."/res/php_scripts/util.php");
    require_once(__DIR__."/res/php_scripts/components/nav.php");
    require_once(__DIR__."/res/php_scripts/components/header.php");
    require_once(__DIR__."/res/php_scripts/components/main.php");
    require_once(__DIR__."/res/php_scripts/components/footer.php");

    class ProfilePage extends Document{
        function start(){
            /***************************************
             * Use following function in oraganizing the resource files and PHP Component(s)
             * public static int attachJS(string cssFilename)   : css filename related to this component
             * public static int attachJS(string jsFilename)    : js filename related to this component
             * public int attachChild(Component childComponent) : add child component objects under this component
             * 
             * All above function returns a int handler value that can be use for future reference, via 
             *   getChildComponent($handler)
             *   getCSSComponentFilename($cssHandler)
             *   getJSComponentFilename($jsHandler)
             * 
             * NOTE: On update to any CSS Files make sure to delete the files inside the ./res/minifified_bundle folder
             *       (Under improvement: for the auto-track css files for update)
             ****************************************/

            $navigationObject = new Navigation();
            $headerObject     = new Header();
            $mainObject       = new Main();
            $footerObject     = new Footer();
            $this->setNav($navigationObject);
            $this->setHeader($headerObject);
            $this->setMain($mainObject);
            $this->setFooter($footerObject);
        }
        function end(){
            /***************************************
             * USE CSSMINIFIER / JSMINIFIER functions to reduce the css/js code belonging to 
             * the respective component in to a minified and merge into a single css/js file.
             * Depending inside Head and inside Body decision made a css/js file generation
             * function creates the following file:
             *   all-head-tag.min.(css & js)
             *   all-body-tag.min.(css & js)
             * 
            ****************************************/
        }
    }
    $profile = new ProfilePage('tag',TRUE,TRUE);
    $profile->getHTMLCode();
?>