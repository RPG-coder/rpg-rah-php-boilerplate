<?php
    require_once(__DIR__."/../util.php");
    class Header extends Component {
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
                ****************************************/
        }
        function code(){
                /* -- HTML Code Here -- */
?>
                <h1>Hello World</h1>
<?php
        }
        function end(){}
     }
?>