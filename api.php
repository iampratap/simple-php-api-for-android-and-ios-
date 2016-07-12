<?php


//mysql_connect('localhost','root','');
//mysql_select_db('jainum');

error_reporting(0);

if (isset($_POST['type'])) {
    if ($_POST['type'] == 'login') {
        $where = mysql_real_escape_string($_POST['where']);
        $username = mysql_real_escape_string($_POST['username']);
        $password = mysql_real_escape_string($_POST['password']);
        $query = "SELECT * FROM `user` WHERE `$where` LIKE '$username' AND `password` LIKE '$password' LIMIT 1";
        $rows = mysql_query($query);
        if (mysql_num_rows($rows)) {
            $row = mysql_fetch_array($rows);
            $id = $row['user_id'];
            $key = md5($id . $row['password']);
            $json = array('error' => 0, 'result' => array('id' => $id, 'key' => $key));
            $query = "UPDATE `user` SET `key` = '$key' WHERE `user_id` = $id;";
            mysql_query($query);
        } else {
            $json = array('error' => 1, 'result' => 0);
        }
        print_r(json_encode($json));
    }

    if ($_POST['type'] == 'upload') {
        $key = mysql_real_escape_string($_POST['key']);
        if (empty($key)) {
            die(json_encode($json = array('error' => 1, 'result' => 'Key Empty')));
        } else {
            $query = "SELECT * FROM `user` WHERE `key` LIKE '$key'";
            $key_result = mysql_query($query);
            if (mysql_num_rows($key_result)) {
                //echo '<pre>', print_r($_FILES),'</pre>';
                $name = $_FILES['file']['name'];
                $type = $_FILES['file']['type'];
                $size = $_FILES['file']['size'];
                $cname = str_replace(" ", "_", $name);
                $tmp_name = $_FILES['file']['tmp_name'];
                $target_path = "upload/" . $_POST['path'] . "/";
                if (!is_dir($target_path)) {
                    mkdir($target_path);
                }
                $target_path = $target_path . rand() . basename($cname);
                if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
                    $json = array('error' => 0, 'result' => $target_path);

                } else {
                    $json = array('error' => 1, 'result' => "Error To Upload File");
                }
                print_r(json_encode($json));
            }
        }
    }

    if ($_POST['type'] == 'delete') {
        $key = mysql_real_escape_string($_POST['key']);
        if (empty($key)) {
            die(json_encode($json = array('error' => 1, 'result' => 'Key Empty')));
        } else {
            $query = "SELECT * FROM `user` WHERE `key` LIKE '$key'";
            $key_result = mysql_query($query);
            if (mysql_num_rows($key_result)) {
                $path = $_POST['path'];
                if (unlink($path)) {
                    $json = array('error' => 0, 'result' => $path . " Deleted.");

                } else {
                    $json = array('error' => 1, 'result' => "Error To Delete " . $path);
                }
                print_r(json_encode($json));
            }
        }
    }

}

if (isset($_POST['sql'])) {
    $json = array();
    $query = $_POST['sql'];
    $key = mysql_real_escape_string($_POST['key']);
    if (empty($key)) {
        die(json_encode($json = array('error' => 1, 'result' => 'Key Empty')));
    } else {
        $query = "SELECT * FROM `user` WHERE `key` LIKE '$key'";
        $key_result = mysql_query($query);
        if (mysql_num_rows($key_result)) {
            if ($_POST['type'] == 'GET') {
                if ($rows = mysql_query($query)) {
                    if (!mysql_num_rows($rows)) {
                        $json = array('error' => 0, 'result' => 0);
                    } else {
                        while ($row = mysql_fetch_array($rows)) {
                            $result[] = $row;
                        }
                        $json = array('error' => 0, 'result' => $result);
                    }
                } else {
                    $json = array('error' => 1, 'result' => mysql_error());
                }
            }

            if ($_POST['type'] == 'SET') {

                if (mysql_query($query)) {
                    $json = array('error' => 0, 'result' => "success");
                } else {
                    $json = array('error' => 0, 'result' => mysql_error());
                }
            }

            print_r(json_encode($json));
        }
    }
}

mysql_close();

if (isset($_GET['help'])) {
    ?>
    <h1>simple-php-api-for-android-and-ios &nbsp;</h1>

    <p>var string&nbsp;type = login;</p>

    <p><strong>1.type = login</strong></p>

    <p>var string&nbsp;type = login;</p>

    <p>var where = where; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; // for datafild name&nbsp;such like username, email or mobile, it will replace where;</p>

    <p>var username = username; &nbsp; &nbsp; &nbsp; &nbsp; // it will filter&nbsp;from datafild name given &lt;where&gt;&nbsp;</p>

    <p>var password = password; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;//Password</p>

    <p>&nbsp;</p>

    <p>The query will like&nbsp;</p>

    <pre>
SELECT * FROM `user` WHERE `&lt;where&gt;` LIKE &#39;&lt;username&gt;&#39; AND `password` LIKE &#39;&lt;password&gt;&#39; 
</pre>

    <p>&nbsp;</p>

    <p>On Success it will return JSON string</p>

    <pre>
 {[&#39;error&#39; =&gt; 0, &#39;result&#39; =&gt; [&#39;id&#39; =&gt; &#39;1&#39;, &#39;key&#39; =&gt; &#39;key3k4ji45kj3hi4yhrf90&#39;]]}</pre>

    <p>on error it will return JSON&nbsp;</p>

    <pre>
{[&#39;error&#39; =&gt; 1, &#39;result&#39; =&gt; 0]}</pre>

    <hr />
    <p>&nbsp;</p>

    <p><strong>2.type = &nbsp;GET</strong></p>

    <p>var string&nbsp;type = GET;</p>

    <p>var key = key; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; // Key form login function;</p>

    <p>var sql&nbsp;= Query; &nbsp; &nbsp; &nbsp; &nbsp; // A valide SQL query.</p>

    <p>&nbsp;</p>

    <p>On Success it will return JSON string</p>

    <pre>
 {[&#39;error&#39; =&gt; 0, &#39;result&#39; =&gt; &#39;JSON STRING OF DATA&#39;}</pre>

    <p>on error it will return JSON&nbsp;</p>

    <pre>
{[&#39;error&#39; =&gt; 1, &#39;result&#39; =&gt; &#39;Mysql Error&#39;]}</pre>

    <hr />
    <p>&nbsp;</p>

    <p><strong>3.type = SET</strong></p>

    <p>var string&nbsp;type = SET;</p>

    <p>var key = key; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; // Key form login function;</p>

    <p>var sql&nbsp;= Query; &nbsp; &nbsp; &nbsp; &nbsp; // A valide SQL query.</p>

    <p>&nbsp;</p>

    <p>On Success it will return JSON string</p>

    <pre>
 {[&#39;error&#39; =&gt; 0, &#39;result&#39; =&gt; &#39;success&#39;}</pre>

    <p>on error it will return JSON&nbsp;</p>

    <pre>
{[&#39;error&#39; =&gt; 1, &#39;result&#39; =&gt; &#39;Mysql Error&#39;]}</pre>

    <hr />
    <p>&nbsp;</p>

    <p><strong>4. type = upload</strong></p>

    <p>var string&nbsp;type = uplead;</p>

    <p>var key = key; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; // Key form login function;</p>

    <p>var path= path; &nbsp; &nbsp; &nbsp; &nbsp; // folder name where file will store such as userid or username.</p>

    <p>var file= file; &nbsp; &nbsp; &nbsp; &nbsp; // file to upload.</p>

    <p>On Success it will return JSON string</p>

    <pre>
 {[&#39;error&#39; =&gt; 0, &#39;result&#39; =&gt; &#39;file link&#39;}</pre>

    <p>on error it will return JSON&nbsp;</p>

    <pre>
{[&#39;error&#39; =&gt; 1, &#39;result&#39; =&gt; &#39;Error To Upload File&#39;]}</pre>

    <hr />
    <p>&nbsp;</p>

    <p><strong>5. type = delete</strong></p>

    <p>var string&nbsp;type = uplead;</p>

    <p>var key = key; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; // Key form login function;</p>

    <p>var path= path; &nbsp; &nbsp; &nbsp; &nbsp; //Link Of file which to be deleted</p>

    <p>.</p>

    <p>On Success it will return JSON string</p>

    <pre>
 {[&#39;error&#39; =&gt; 0, &#39;result&#39; =&gt; &#39;Deleted&#39;}</pre>

    <p>on error it will return JSON&nbsp;</p>

    <pre>
{[&#39;error&#39; =&gt; 1, &#39;result&#39; =&gt; &#39;Error To Delete File&#39;]}</pre>

    <hr />

    <?php
}
?>