<?php
    require_once(__DIR__.'/vendor/JSMin.php');
    
    trait Logging{
        protected static function writeToLogFile($message){
            file_put_contents(__DIR__."/../logs/log.txt",$message, FILE_APPEND|LOCK_EX);
        }
    }

    class Component{
        use Logging;

        private $childArray;
        private $counter;
        protected static $jsArray=array(), $cssArray=array(), $jsCounter=0, $cssCounter=0;

        /* -- user-support functions (For for a users to use direct)-- */
        public function __construct(){ 
            $this->childArray = array(); 
            $this->counter = 0; 
        }

        /* -- @Note-1: Later Version To-do. Reduce the code below ... introduce reusability -- */
        protected function attachChildComponent($childComponent){
            /*************************
             * @functionName: attachChildComponent
             * @argument: 
             *   $childComponent: child "Component" class object 
             * @details: 
             *   At time of generateComponentCode() is called, all child code is appended in the order of attachment,
             *   and generates the final htmlCode belonging to the component.
             * @returns:
             *   handler: a handler to the child-element attached, for any future reference
             *************************/
            if(is_a($childComponent, "Component") !== TRUE){
                throw new Exception(
                    "<h2/>500 Internal Server Error<h2>".
                    "<script>console.log('Error: (".get_class($this)." class | ".var_dump("__METHOD__").") : ".
                    "Could not resolve the 'non-Component' class type parameter passed.');</script>"
                );
            }
            $handle = $this->counter++;
            $childArray[$handle] = $childComponent;
            return $handle;
        }protected function detachChildComponent($handler){
            /*************************
             * @functionName: detachChildComponent
             * @argument: 
             *   $handler: handle to the detaching child "Component" class object
             * @returns:
             *   bool: success or fail for detach
             *************************/
            if(isset($childArray[$handle])){
                unset($childArray[$handle]);
                return TRUE;
            }return FALSE;
        }
        protected static function attachCSS($cssFilename){
            if(gettype($cssFilename, 'string') !== TRUE){
                throw new Exception(
                    "<h2/>500 Internal Server Error<h2>".
                    "<script>console.log('Error: (".get_class($this)." class | ".var_dump("__METHOD__").") : ".
                    "Could not resolve the 'string' type parameter passed.');</script>"
                );
            }
            $cssHandle = $this->cssCounter++;
            $cssArray[$cssHandle] = $cssFilename;
            return $csshandle;
        }protected static function detachCSS($cssHandle){
            if(isset($cssArray[$cssHandle])){
                unset($cssArray[$cssHandle]);
                return TRUE;
            }return FALSE;
        }
        protected static function attachJS($jsFilename){
            if(gettype($jsFilename, 'string') !== TRUE){
                throw new Exception(
                    "<h2/>500 Internal Server Error<h2>".
                    "<script>console.log('Error: (".get_class($this)." class | ".var_dump("__METHOD__").") : ".
                    "Could not resolve the 'string' type parameter passed.');</script>"
                );
            }
            $jsHandle = $this->jsCounter++;
            $jsArray[$jsHandle] = $jsFilename;
            return $jshandle;
        }protected static function detachJS($jsHandle){
            if(isset($jsArray[$jsHandle])){
                unset($jsArray[$jsHandle]);
                return TRUE;
            }return FALSE;
        }

        /* -- defined at user-level -- */
        /* *****************************
           public/private function start();
           public/private function code();
           public/private function end();
         * ***************************** */

        /* -- in-utility functions (Not for a users to use direct)-- */
        protected function _generateComponentCode(){
            /*************************
             * @functionName: generateComponentCode()
             * @argument: 
             *   aggregates all child code code to single component;
             * @returns:
             *   
             *************************/
            if(method_exists(get_class($this),"start")) $this->start();
            if(method_exists(get_class($this),"code")) $this->code();
            if(method_exists(get_class($this),"end")) $this->end();   
        }
    }

    trait CSSMinifier{
        protected static function writeCSSFile($writeLocation, $contentBuffer){
            file_put_contents($writeLocation, $contentBuffer="");
        }protected static function getMinifiedCSS($filename){
            $buffer = file_get_contents($filename);
            /* -- CSS minify logic -- */
            $buffer = preg_replace("!/\*[^*]*\*+([^/][^*]*\*+)*/!", "", $buffer);
            $buffer = str_replace(": ", ":", $buffer);
            $buffer = str_replace(array("\r\n", "\r", "\n", "\t", "  ", "    ", "    "), "", $buffer);
            /* -- (Source: https://stackoverflow.com/questions/5389822/how-to-minify-js-or-css-on-the-fly) -- */
            return $buffer;
        }
    }

    trait JSMinifier{ /* -- Note: make sure the JS code has semicolumns for indicating the end of line -- */
        protected static function writeJSFile($writeLocation, $contentBuffer=""){
            file_put_contents($writeLocation, $contentBuffer);            
        }protected static function getMinifiedJS($filename){
            $js = file_get_contents($filename);
            $minifiedJs = JSMin::minify($js);
            return $minifiedJs;
        }
    }

    trait MetaContent{
        private $ignoreDefaultMeta;
        public function __construct($ignoreDefaultMeta=FALSE){
            $this->ignoreDefaultMeta = $ignoreDefaultMeta;
            $this->title = "Hello World!";
        }

        public function setTitle($value){$this->title=$value;}
        public function setMetaKeyword($value){$this->metaKeyword=$value;}
        public function setMetaDescription($value){$this->metaDescription=$value;}
        public function setMetaSubject($value){$this->metaSubject=$value;}
        public function setMetaCompanyCopyright($value){$this->metaCompanyCopyright=$value;}
        public function setMetaRobots($value){$this->metaRobots=$value;}
        public function setMetaAuthor($value){$this->metaAuthor=$value;}
        public function setMetaDesigner($value){$this->metaDesigner=$value;}
        public function setMetaOwner($value){$this->metaOwner=$value;}
        public function setMetaURL($value){$this->metaURL=$value;}
        public function setMetaPragma($value){$this->metaPragma=$value;}
        public function setMetaExpires($value){$this->metaExpires=$value;}
        public function setMetaCacheControl($value){$this->metaCacheControl=$value;}
        private function _defaultMeta(){     
?>
            <meta charset="UTF-8">
            <meta http-equiv = "Content-Type" content = "text/html; charset = UTF-8" />
            <?php if($this->metaKeyword): ?><meta name="keywords" content="<?php echo $this->metaKeyword; ?>"> <?php endif ?>
            <?php if($this->metaDescription): ?><meta name="description" content="<?php echo $this->metaDesription; ?>"> <?php endif ?>
            <?php if($this->metaSubject): ?><meta name="subject" content="<?php echo $this->metaSubject; ?>"> <?php endif ?>
            <?php if($this->metaCompanyCopyright): ?><meta name="copyright" content="<?php echo $this->metaCompanyCopyright; ?>"> <?php endif ?>
            <?php if($this->metaRobots): ?><meta name="robots" content="<?php echo $this->metaRobots; ?>"><?php endif ?>
            <?php if($this->metaAuthor): ?><meta name="author" content="<?php echo $this->metaAuthor; ?>"> <?php endif ?>
            <?php if($this->metaDesigner): ?><meta name="designer" content="<?php echo $this->metaDesigner; ?>"> <?php endif ?>
            <?php if($this->metaOwner): ?><meta name="owner" content="<?php echo $this->metaOwner; ?>"> <?php endif ?>
            <?php if($this->metaURL): ?><meta name="url" content="<?php echo $this->metaURL; ?>"> <?php endif ?>
            <?php if($this->metaExpires): ?><meta http-equiv="Expires" content="<?php echo $this->metaExpires; ?>"> <?php endif ?>
            <?php if($this->metaPragma): ?><meta http-equiv="Pragma" content="<?php echo $this->metaPragma; ?>"> <?php endif ?>
            <?php if($this->metaCacheControl): ?><meta http-equiv="Cache-Control" content="<?php echo $this->metaCacheControl; ?>"> <?php endif ?>
<?php
        }

        public function getTitle(){return $this->title;}
        public function generateMetaContent(){
            if($this->ignoreDefaultMeta!==FALSE) $this->_defaultMeta();
            if(method_exists(get_class($this),"code")) $this->code();
        }
        /* -- user-defined function -- */
        /* public/private function code() */

    }

    trait View{
        public function __construct(){}
        private function raiseComponentError($documentName, $funcName){
            throw new Exception(
                "<h2/>500 Internal Server Error<h2>".
                "<script>console.log('Error: (".$documentName." class | ".$funcName.") : ".
                "Could not resolve the 'non-Component' class type parameter passed.');</script>"
            );
        }

        /* -- Setters -- */
        protected function setNav($navigationComponent){
            if(is_a($navigationComponent,"Component")!==TRUE){raiseComponentError(get_class($this), var_dump("__METHOD__"));}
            $this->navigation = $navigationComponent;
        }
        protected function setHeader($headerComponent){
            if(is_a($headerComponent,"Component")!==TRUE){raiseComponentError(get_class($this), var_dump("__METHOD__"));}
            $this->header = $headerComponent;
        }
        protected function setMain($mainComponent){
            if(is_a($mainComponent,"Component")!==TRUE){raiseComponentError(get_class($this), var_dump("__METHOD__"));}
            $this->main = $mainComponent;
        }
        protected function setFooter($footerComponent){
            if(is_a($footerComponent,"Component")!==TRUE){raiseComponentError(get_class($this), var_dump("__METHOD__"));}
            $this->footer = $footerComponent;
        }

        /* -- Getters -- */
        protected function _getNav(){isset($this->navigation)?$this->navigation->_generateComponentCode():null;}
        protected function _getHeader(){echo isset($this->header)?$this->header->_generateComponentCode():null;}
        protected function _getMain(){isset($this->main)?$this->main->_generateComponentCode():null;}
        protected function _getFooter(){isset($this->footer)?$this->footer->_generateComponentCode():null;}
    }


    class Document extends Component{ 
        use View{
            View::__construct as private __viewConstruct;
        }
        use MetaContent{
            MetaContent::__construct as private __metaConstruct;
        }
        use CSSMinifier, JSMinifier;

        private $meta, $nav, $header, $main, $footer,$tag,$minifyCSS,$minifyJS;
        public function __construct($tag,$minifyCSS=FALSE,$minifyJS=FALSE,$ignoreDefaultMeta=FALSE){
            $this->__viewConstruct();
            $this->__metaConstruct($ignoreDefaultMeta);
            $this->minifyCSS = $minifyCSS;
            $this->minifyJS  = $minifyJS;
            $this->tag       = $tag;
        }

        protected static function generateMinifiedCSS($tag){
            if(file_exists(__DIR__."/../minified_bundle/all-body-".$tag.".min.css")!==TRUE){
                $cssInBodyBuffer = "";
                foreach( static::$cssArray as $cssFile){
                    $cssInBodyBuffer .= static::getMinifiedCSS($cssFile);
                }
                static::writeCSSFile(__DIR__."/../minified_bundle/all-body-".$tag.".min.css", $cssInBodyBuffer);
            }else{
                static::writeToLogFile("[Info]:".date("l jS \of F Y h:i:s A").": CSS In-Body File Exists!\n");
            }
        }
        protected static function generateMinifiedJS($tag){
            if(file_exists(__DIR__."/../minified_bundle/all-body-".$tag.".min.js")!==TRUE){
                $jsInBodyBuffer = "";
                foreach(static::$jsArray as $jsFile){
                    $jsInBodyBuffer .= static::getMinifiedJS($jsFile);
                }
                static::writeCSSFile(__DIR__."/../minified_bundle/all-body-".$tag.".min.js", $jsInBodyBuffer);
            }else{
                static::writeToLogFile("[Info]:".date("l jS \of F Y h:i:s A").": JS In-Body File Exists!\n");
            }
        }
        public function getHTMLCode(){
            if(method_exists(get_class($this),"start")) $this->start();

?>
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <?php $this->generateMetaContent(); ?>
                    <title><?php echo $this->getTitle(); ?></title>
                    <?php $this->_getInHeadCSS(); ?>
                    <?php $this->_getInHeadJS(); ?>
                </head>
                <body>
                    <?php $this->_contentDisplay(); ?>
                    <?php $this->_getInBodyCSS(); ?>
                    <?php $this->_getInBodyJS(); ?>
                </body>
            </html>
<?php
            if(method_exists(get_class($this),"end")) $this->end();
            if($this->minifyCSS) $this->generateMinifiedCSS($this->tag);
            if($this->minifyJS) $this->generateMinifiedJS($this->tag);
        }

        private function _contentDisplay(){$this->_getNav();$this->_getHeader();$this->_getMain();$this->_getFooter();}
        private function _getInHeadCSS(){echo "<link rel='stylesheet' type='text/css' href='./res/minified_bundle/all-head-".$this->tag.".min.css' />";}
        private function _getInBodyCSS(){echo "<link rel='stylesheet' type='text/css' href='./res/minified_bundle/all-body-".$this->tag.".min.css' />";}
        private function _getInHeadJS(){echo "<script src='./res/minified_bundle/all-head-".$this->tag.".min.js'></script>";}
        private function _getInBodyJS(){echo "<script src='./res/minified_bundle/all-body-".$this->tag.".min.js'></script>";}
    }



/*
    To-do:
    1. bug-fix: handle error thrown (non-strict working mode) : Make the errors directed to the logs (not shown when page is displayed)
    2. bug-fix: Component-level decision for in-head or in-body and Document-level seperation and merging of css and js files
    3. bug-fix: type checking of parameters
    4. reduce Component code, refer to @Note-1
*/
?>