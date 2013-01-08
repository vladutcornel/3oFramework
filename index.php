<?php

/**
 * Description of index
 *
 * @author cornel
 */
class index {
    public function main(){
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>TrioFramework works</title>
        <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/test?request=css" />
    </head>
    <body>
        <h1>Trio Framework is up and running</h1>
        <p>That great! Now you can run <a href="<?php echo URL_ROOT; ?>/test/some/extra/params">the test file via GET</a> or <button type="submit" form="post-form" id="post-button">via POST</button>
    </p>
        <form method="post" action="<?php echo URL_ROOT; ?>/test/some/extra/params" id="post-form"></form>
        <p>You can test that <a href="javascript:loadTestAjax();">AJAX requests</a> run</p>
        <p id="ajax-output">The AJAX output will be shown here</p>
        <p>Tip: Use your browser`s Web inspector (or <a href="http://getfirebug.com/">Firebug</a>) to see everything that is going on</p>
        <p>
            Then you can start <strong>Making IT fun!</strong>
        </p>
        
        <script src="<?php echo URL_ROOT; ?>/test?request=js"></script>
    </body>
</html>
<?php
    }
}