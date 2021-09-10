<?php
    require_once(__DIR__."/../util.php");
    class Navigation extends Component {
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
                /* -- Your HTML Code here ... -- */
?>

                <!-- Your HTML Code here ...-->
                <nav>
                    <p>Your Name | My Fancy Navigation Bar | Links</p>
                </nav>

<?php
        }
        function end(){}
     }
?>