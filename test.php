<?php
/**
 * A test script testing Trio Framework Core.
 * You can have an ideea on how the default methods are handled
 */
class PageTest{
    /**
     * We will store the methods we call before any output is sent
     * @var array
     */
    public static $methods = array();
    
    /**
     * The constructor method is called on any page request.
     * This is a good place to prepare data needed by all the other methods.
     * 
     * We just test the ability to parse other viewable classes.
     * @param array $params all extra parts from the URL are passed to this array
     */
    public function __construct($params) {
        array_push(self::$methods, __METHOD__);
        
        // designate another class to be parsed:
        TOCore::parse('AnotherTestClass');
    }
    
    /**
     * The get_request is loaded always if the page is requested with GET.
     * That meens ALWAYS, even if it's requesting CSS or JavaScript.
     * The main method (or css or javascript methods) will still be loaded after this
     * It won't be loaded for AJAX requests.
     * @param array $params all extra parts from the URL are passed to this array
     */
    public function get_request($params){
        array_push(self::$methods, __METHOD__);
    }
    
    /**
     * post_request in loaded  if the page is requested via POST request instead
     * of the get_request. So it will probably run only for the main html script
     * and not for CSS or JavaScript.
     * It won't be loaded for AJAX requests
     * @param array $params all extra parts from the URL are passed to this array
     */
    public function post_request($params){
        array_push(self::$methods, __METHOD__);
    }
    
    /**
     * this method will be loaded if the page is requested with AJAX.
     * The simplest way to mark an AJAX request is to append ?request=ajax to the url.
     * Another way is to set the X_REQUESTED_WITH request header to "XMLHttpRequest"
     * jQuery does this for you. See the Javascript code from index.php to see 
     * how you can do this in classic AJAX requests.
     * 
     * No other methods are loaded on AJAX requests (except the constructor, obviously)
     * @param array $params all extra parts from the URL are passed to this array
     */
    public function ajax($params){
        array_push(self::$methods, __METHOD__);
        $this->print_method_chain("This was a AJAX request and had this method chain: \n",'');
    }
    
    /**
     * This method is loaded if a CSS code is requested.
     * You can request a CSS code by appending ?request=css to the URL.
     * @param array $params all extra parts from the URL are passed to this array
     */
    public function css($params){
        header('Content-Type: text/css');
        array_push(self::$methods, __METHOD__);
        $this->print_method_chain("/* This was a CSS request and had this method chain: \n",'*/');
?>
#post-button{
    display:inline;
    background: none;
    border:none;
    display: inline;
    color: #00E;
    cursor: pointer;
    height: auto;
    text-decoration: underline;
    width: auto;
}
#post-button:active{
    color: red;
}
<?php
    }
    
    /**
     * This method is loaded if a JavaScript code is requested.
     * You can request a JavaScript code by appending ?request=js to the URL.
     * @param array $params all extra parts from the URL are passed to this array
     */
    public function javascript($params){
        header('Content-Type: application/javascript');
        array_push(self::$methods, __METHOD__);$this->print_method_chain("/* This was a JavaScript request and had this method chain: \n",'*/');
?>
window.onload = function(){
    //alert('Document loaded. This message comes from the JavaScript method');
    
}

function loadTestAjax()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("ajax-output").innerHTML='The ajax request was succesfull. This is the output:<br><pre>' + xmlhttp.responseText + '</pre>';
        }
    }
    xmlhttp.open("GET","<?php echo URL_ROOT; ?>/test.php",true);
    // set the "AJAX header" so we don't have to send a GET parameter
    xmlhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xmlhttp.send();
}
<?php
    }
    
    /**
     * The main method should be present in all page classes as it is the fallback.
     * It's the perfect place to display the main (probablly HTML) output
     * @param array $params all extra parts from the URL are passed to this array
     */
    public function main($params){
        array_push(self::$methods, __METHOD__);
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>TrioFramework Tests</title>
        <!-- You should always include the CSS link if you need it -->
        <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/test/sending some extra data to CSS?request=css" />
    </head>
    <body>
        <h1>Trio Framework Test Script</h1>
        <p>
            You can check this page's script to see some different features TrioFramework has to offer (and this is just it's core).
            Meanwhile, you should have your browser's inspector opened and you should check the CSS and JavaScript output.
        </p>
        <?php 
        /*
         * TGlobal gives you easy access to PHP's global varibles and it does 
         * error checking for you
         */
        if ('POST' == TGlobal::server('REQUEST_METHOD')): ?>
            <p>You have requested this with POST, you can also check <a href="<?php echo URL_ROOT; ?>/test/some/extra/params">the GET method</a></p>
        <?php else: ?>
            <p>
                You have requested this with GET, you can also check 
                <!-- Ok. This example does not work on old browsers that have no idea about HTML5 -->
                <button type="submit" form="post-form" id="post-button">the POST method</button>
            </p>
        <form method="post" action="<?php echo URL_ROOT; ?>/test/some/extra/params" id="post-form"></form>
        <?php endif;?>
        
        <p>You can test that <a href="javascript:loadTestAjax();">AJAX requests</a> run</p>
        <p id="ajax-output">The AJAX output will be shown here</p>
        
        <p>This request went trough this methods:</p>
        <pre><?php $this->print_method_chain('','','<br />'); ?></pre>
        
        <p>The main method (like all the others) can also play with this extra parameters extracted from the URL:</p>
        <pre><?php var_dump($params);?></pre>
        
        <!-- we can add the .php extension to PHP scripts, we we like it like that -->
        <script src="<?php echo URL_ROOT; ?>/test.php?request=js"></script>
    </body>
</html>
        
<?php
    }
    
    /**
     * A helper method to print the requested methods for different situations.
     * @param string $start
     * @param string $end
     * @param string $nl
     */
    private function print_method_chain($start = '', $end = '', $nl = "\n"){
        echo $start;
        
        foreach (self::$methods as $m){
            echo $m, $nl;
        }
        
        echo $end;
    }
}

/**
 * A new class to show how TOCore::parse can be used to manually call 
 * other classes to display things
 */
class AnotherTestClass{
    public function main($params){
        array_push(PageTest::$methods, __METHOD__);
        if (count ($params) > 0){
            array_push(PageTest::$methods, 'Offnote: '.__METHOD__.' also recived this params: '.  implode(',', $params));
        }
    }
    
    public function css($params){
        array_push(PageTest::$methods, __METHOD__);
        if (count ($params) > 0){
            array_push(PageTest::$methods, 'Offnote: '.__METHOD__.' also recived this params: '.  implode(',', $params));
        }
    }
}