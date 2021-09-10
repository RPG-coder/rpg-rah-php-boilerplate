<?php
    class Component{
        private $childArray;
        private static $jsArray=array(), $cssArray=array(), $jsCounter=0, $cssCounter=0;
        private $counter;

        /* -- user-support functions (For for a users to use direct)-- */
        public function __construct(){ 
            $this->childArray = array(); 
            $this->counter = 0; 
        }

        /* -- Later Version To-do: Reduce the code below ... introduce reusability -- */
        protected function attachChildComponent($childComponent){
            /*************************
             * @functionName: attachChildComponent
             * @argument: 
             *   $childComponent: child 'Component' class object 
             * @details: 
             *   At time of generateComponentCode() is called, all child code is appended in the order of attachment,
             *   and generates the final htmlCode belonging to the component.
             * @returns:
             *   handler: a handler to the child-element attached, for any future reference
             *************************/
            if(is_a($childComponent, 'Component') !== TRUE){
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
             *   $handler: handle to the detaching child 'Component' class object
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
           public start();
           public code();
           public end();
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
            if(method_exists(get_class($this),'start')) $this->start();
            if(method_exists(get_class($this),'code')) $this->code();
            if(method_exists(get_class($this),'end')) $this->end();   
        }
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
            if(is_a($navigationComponent,'Component')!==TRUE){raiseComponentError(get_class($this), var_dump("__METHOD__"));}
            $this->navigation = $navigationComponent;
        }
        protected function setHeader($headerComponent){
            if(is_a($headerComponent,'Component')!==TRUE){raiseComponentError(get_class($this), var_dump("__METHOD__"));}
            $this->header = $headerComponent;
        }
        protected function setMain($mainComponent){
            if(is_a($mainComponent,'Component')!==TRUE){raiseComponentError(get_class($this), var_dump("__METHOD__"));}
            $this->main = $mainComponent;
        }
        protected function setFooter($footerComponent){
            if(is_a($footerComponent,'Component')!==TRUE){raiseComponentError(get_class($this), var_dump("__METHOD__"));}
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
        //use MetaContent;
        //use CSSMinifier, JSMinifier;

        private $meta, $nav, $header, $main, $footer,$tag,$minifyCSS,$minifyJS;
        public function __construct($tag,$minifyInBodyCSS=FALSE,$minifyInBodyJS=FALSE){
            $this->__viewConstruct();
            $this->minifyCSS = $minifyInBodyCSS;
            $this->minifyJS  = $minifyInBodyJS;
            $this->tag       = $tag;
        }

        //public generateCSS(){}
        //public generateJS(){}
        public function getHTMLCode(){
            if(method_exists(get_class($this),'start')) $this->start();

?>
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <?php /*$this->getMeta();*/ ?>
                    <title><?php /*echo $this->getTitle();*/ ?></title>
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
            if(method_exists(get_class($this),'end')) $this->end();;
        }

        private function _contentDisplay(){$this->_getNav();$this->_getHeader();$this->_getMain();$this->_getFooter();}
        private function _getInHeadCSS(){echo "<link rel='stylesheet' type='text/css' href='all-head-".$this->tag.".min.css' />";}
        private function _getInBodyCSS(){echo "<link rel='stylesheet' type='text/css' href='all-body-".$this->tag.".min.css' />";}
        private function _getInHeadJS(){echo "<script src='all-head-".$this->tag.".min.js'></script>";}
        private function _getInBodyJS(){echo "<script src='all-body-".$this->tag.".min.js'></script>";}
    }
?>