<?php
    require_once(__DIR__."/../util.php");
    class Main extends Component {
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
                <main>
                    <h2>This is the main section</h2>
                </main>

<?php
        }
        function end(){}
     }
?>