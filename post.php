<?php
/**
 * Copyright (c) 2010 Ian Burris
 * 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

if ($_POST) {
    $url = $_POST['url'];
    
    $fields = array();
    $fields_string = '';
    
    foreach ($_POST['data'] as $keyvalue) {
        $fields[$keyvalue[0]] = $keyvalue[1];
        $fields_string .= $keyvalue[0].'='.$keyvalue[1].'&';
    }
    
    rtrim($fields_string, '&');

    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);

    $result = curl_exec($ch);

    curl_close($ch);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HTTP Post</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('a[name="add"]').click(function() {
        var fields = '<div><b>Key:</b> <input type="text" name="data[][0]" />&nbsp;&nbsp;<b>Value:</b> <input type="text" name="data[][1]" /> <a name="remove">- Remove</a></div>';
        $('div#fields').append(fields);
        return false;
    });

    $('a[name="remove"]').live('click', function() {
        $(this).parent().remove()
        return false;
    });
});
</script>
<style type="text/css">
<!--
div#result {
    background-color=#ccc;
    border=1px solid #eee;
}
-->
</style>
</head>

<body>
<h1>HTTP Post</h1>
<form action="post.php" method="post" name="data_form">
    <b>URL:</b> <input type="text" name="url" /><br /><br />
    <div id="fields">
        <div><b>Key:</b> <input type="text" name="data[][0]" />&nbsp;&nbsp;<b>Value:</b> <input type="text" name="data[][1]" /></div>
    </div>
    <a name="add">+ Add another key/value pair</a><br /><br />
    <input type="submit" name="submit" value="POST" />
</form>
<?php
if (isset($result)) {
    echo '<br /><br /><b>Result</b>:<div id=result><pre>'.htmlentities($result).'</pre></div>';
}
?>
</body>
</html>