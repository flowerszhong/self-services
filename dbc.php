<?php

/************* MYSQL DATABASE SETTINGS *****************
1. Specify Database name in $dbname
2. MySQL host (localhost or remotehost)
3. MySQL user name with ALL previleges assigned.
4. MySQL password

Note: If you use cpanel, the name will be like account_database
*************************************************************/
//for local
define("DB_HOST", "localhost"); // set database host
define("DB_USER", "root"); // set database user
define("DB_PASS", "root"); // set database password
define("DB_NAME", "school_db"); // set database name



declare (encoding = 'UTF-8');

// error_reporting(E_ALL);


//for local
define("SERVER_HOST", $_SERVER['HTTP_HOST']);
define("SITE_DIR", '/self-services');
define('SITE_ROOT', "http://" . SERVER_HOST . SITE_DIR);

//for live
// define("SERVER_HOST", $_SERVER['HTTP_HOST']);
// define("SITE_DIR", '');
// define('SITE_ROOT', "http://" . SERVER_HOST . SITE_DIR);


$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
mysql_query("SET NAMES 'UTF8'");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");


/* Registration Type (Automatic or Manual) 
1 -> Automatic Registration (Users will receive activation code and they will be automatically approved after clicking activation link)
0 -> Manual Approval (Users will not receive activation code and you will need to approve every user manually)
*/
$user_registration = 1; // set 0 or 1

define("COOKIE_TIME_OUT", 10); //specify cookie timeout in days (default is 10 days)
define('SALT_LENGTH', 9); // salt for password

//define ("ADMIN_NAME", "admin"); // sp

/* Specify user levels */
define("ADMIN_LEVEL", 5);
define("HEADER_LEVEL", 2);
define("USER_LEVEL", 1);
define("GUEST_LEVEL", 0);



/*************** reCAPTCHA KEYS****************/
$publickey  = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$privatekey = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";


/**** PAGE PROTECT CODE  ********************************
This code protects pages to only logged in users. If users have not logged in then it will redirect to login page.
If you want to add a new page and want to login protect, COPY this from this to END marker.
Remember this code must be placed on very top of any html or php page.
********************************************************/

function page_protect()
{
    session_start();
    
    global $db;
    
    /* Secure against Session Hijacking by checking user agent */
    if (isset($_SESSION['HTTP_USER_AGENT'])) {
        if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) {
            logout();
            exit;
        }
    }
    
    // before we allow sessions, we need to check authentication key - ckey and ctime stored in database
    
    /* If session not set, check for cookies set by Remember me */
    if (!isset($_SESSION['student_id']) && !isset($_SESSION['student_name'])) {
        if (isset($_COOKIE['student_id']) && isset($_COOKIE['user_key'])) {
            /* we double check cookie expiry time against stored in database */
            
            $cookie_student_id = filter($_COOKIE['student_id']);
            $rs_ctime = mysql_query("select 'ckey','ctime' from 'students' where 'student_id' ='$cookie_user_id'") or die(mysql_error());
            
            list($ckey, $ctime) = mysql_fetch_row($rs_ctime);
            
            // var_dump($ckey);
            
            // coookie expiry
            if ((time() - $ctime) > 60 * 60 * 24 * COOKIE_TIME_OUT) {
                logout();
            }
            /* Security check with untrusted cookies - dont trust value stored in cookie.       
            /* We also do authentication check of the 'ckey' stored in cookie matches that stored in database during login*/
            
            if (!empty($ckey) && is_numeric($_COOKIE['user_id']) && isUserName($_COOKIE['student_name']) && $_COOKIE['user_key'] == sha1($ckey)) {
                session_regenerate_id(); //against session fixation attacks.
                
                $_SESSION['student_id']         = $_COOKIE['student_id'];
                $_SESSION['student_name']       = $_COOKIE['student_name'];
                $rs_userlevel                = mysql_query("select user_level from students where id='$_SESSION[user_id]'");
                $user_level_row              = mysql_fetch_row($rs_userlevel);
                $user_level                  = $user_level_row['user_level'];
                $_SESSION['user_level']      = $user_level;
                $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
                
            } else {
                logout();
            }
            
        } else {
            header("Location: index.php");
            exit();
        }
    }

    // else{
    //     header("Location: myaccount.php");
    //     exit();
    // }
}


function admin_page_protect()
{
    session_start();
    
    global $db;
    
    /* Secure against Session Hijacking by checking user agent */
    if (isset($_SESSION['HTTP_USER_AGENT'])) {
        if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])) {
            logout();
            exit;
        }
    }
    
    // before we allow sessions, we need to check authentication key - ckey and ctime stored in database
    
    /* If session not set, check for cookies set by Remember me */
    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['admin_name'])) {
        if (isset($_COOKIE['admin_id']) && isset($_COOKIE['admin_key'])) {
            /* we double check cookie expiry time against stored in database */
            
            $admin_id = filter($_COOKIE['admin_id']);
            $rs_ctime = mysql_query("select 'ckey','ctime' from 'students' where 'id' ='$admin_id'") or die(mysql_error());
            
            list($ckey, $ctime) = mysql_fetch_row($rs_ctime);
            
            // var_dump($ckey);
            
            // coookie expiry
            if ((time() - $ctime) > 60 * 60 * 24 * COOKIE_TIME_OUT) {
                logout();
            }
            /* Security check with untrusted cookies - dont trust value stored in cookie.       
            /* We also do authentication check of the 'ckey' stored in cookie matches that stored in database during login*/
            
            if (!empty($ckey) && is_numeric($_COOKIE['admin_id']) && isAdminName($_COOKIE['admin_name']) && $_COOKIE['admin_key'] == sha1($ckey)) {
                session_regenerate_id(); //against session fixation attacks.
                
                $_SESSION['admin_id']         = $_COOKIE['admin_id'];
                $_SESSION['admin_name']       = $_COOKIE['admin_name'];
                $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
                
            } else {
                admin_logout();
            }
            
        } else {
            header("Location: index.php");
            exit();
        }
    }

    // else{
    //     header("Location: myaccount.php");
    //     exit();
    // }
}


function filter($data)
{
    // $data = trim(htmlentities(strip_tags($data)));//fuck htmlentities,not for chinese
    $data = trim(htmlspecialchars(strip_tags($data)));
    
    
    
    if (get_magic_quotes_gpc())
        $data = stripslashes($data);
    
    $data = mysql_real_escape_string($data);
    
    return $data;
}



function EncodeURL($url)
{
    $new = strtolower(ereg_replace(' ', '_', $url));
    return ($new);
}

function DecodeURL($url)
{
    $new = ucwords(ereg_replace('_', ' ', $url));
    return ($new);
}

function ChopStr($str, $len)
{
    if (strlen($str) < $len)
        return $str;
    
    $str = substr($str, 0, $len);
    if ($spc_pos = strrpos($str, " "))
        $str = substr($str, 0, $spc_pos);
    
    return $str . "...";
}

function isEmail($email)
{
    return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}

function isUserID($username)
{
    if (preg_match('/^[a-z\d_]{5,20}$/i', $username)) {
        return true;
    } else {
        return false;
    }
}

function get_Datetime_Now()
{
    $tz_object = new DateTimeZone('Asia/Shanghai');

    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d');
}

function format_date($date,$format_str="Y-m-d")
{
    $d = strtotime($date);
    return date($format_str,$d);
}

function isUserName($username)
{
    return true;
}

function isAdminName($adminName)
{
    if(strlen($adminName) >8){
        return true;
    }
    return false;
}

function isStudentId($id)
{   
    if(is_numeric($id) && strlen($id) == 8){
        return true;
    }
    return false;
}

function isURL($url)
{
    if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
        return true;
    } else {
        return false;
    }
}

function checkPwd($x, $y)
{
    if (empty($x) || empty($y)) {
        return false;
    }
    if (strlen($x) < 4 || strlen($y) < 4) {
        return false;
    }
    
    if (strcmp($x, $y) != 0) {
        return false;
    }
    return true;
}

function GenPwd($length = 7)
{
    $password = "";
    $possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels
    
    $i = 0;
    
    while ($i < $length) {
        
        
        $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
        
        
        if (!strstr($password, $char)) {
            $password .= $char;
            $i++;
        }
        
    }
    
    return $password;
    
}

function GenKey($length = 7)
{
    $password = "";
    $possible = "0123456789abcdefghijkmnopqrstuvwxyz";
    
    $i = 0;
    
    while ($i < $length) {
        
        
        $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
        
        if (!strstr($password, $char)) {
            $password .= $char;
            $i++;
        }
        
    }
    
    return $password;
    
}




function logout()
{
    global $db;
    session_start();
    // var_dump($db);
    
    $sess_user_id = strip_tags(mysql_real_escape_string($_SESSION['student_id']));
    $cook_user_id = strip_tags(mysql_real_escape_string($_COOKIE['student_id']));
    
    if (isset($sess_user_id) || isset($cook_user_id)) {
        // echo $sess_user_id;
        // echo $cook_user_id;
        // $sql_clear = "update students set 'ckey'= '', 'ctime'= '' where 'student_id'='$sess_user_id' OR 'student_id' = '$cook_user_id'";
        $sql_update = "UPDATE students SET ckey= '', ctime=0 where id='$sess_user_id' OR id = '$cook_user_id'";
        // $sql_clear = "update 'students' set 'ckey'= '', 'ctime'= '' where 'student_id'='$sess_user_id'";
        // echo $sql_clear;
        $update_result = mysql_query($sql_update) or die(mysql_error());
        
    }
    
    /************ Delete the sessions****************/
    unset($_SESSION['student_id']);
    unset($_SESSION['student_name']);
    unset($_SESSION['user_id']);
    unset($_SESSION['user_level']);
    unset($_SESSION['HTTP_USER_AGENT']);
    session_unset();
    session_destroy();
    
    /* Delete the cookies*******************/
    setcookie("student_id", '', time() - 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
    setcookie("student_name", '', time() - 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
    setcookie("user_key", '', time() - 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
    
    header("Location: index.php");
}

function admin_logout()
{
    global $db;
    session_start();
    
    $sess_admin_id = strip_tags(mysql_real_escape_string($_SESSION['admin_id']));
    $cook_admin_id = strip_tags(mysql_real_escape_string($_COOKIE['admin_id']));
    
    if (isset($sess_admin_id) || isset($cook_admin_id)) {
        $sql_update = "UPDATE admin SET ckey= '', ctime=0 where id='$sess_user_id' OR id = '$cook_user_id'";
        $update_result = mysql_query($sql_update) or die(mysql_error());
        
    }
    
    /************ Delete the sessions****************/
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_name']);
    unset($_SESSION['HTTP_USER_AGENT']);
    session_unset();
    session_destroy();
    
    /* Delete the cookies*******************/
    setcookie("admin_id", '', time() - 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
    setcookie("admin_name", '', time() - 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
    setcookie("admin_key", '', time() - 60 * 60 * 24 * COOKIE_TIME_OUT, "/");
    
    header("Location: index.php");
}

// Password and salt generation
function PwdHash($pwd, $salt = null)
{
    if ($salt === null) {
        $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
    } else {
        $salt = substr($salt, 0, SALT_LENGTH);
    }
    return $salt . sha1($pwd . $salt);
}

function checkAdmin()
{
    // var_dump($_SESSION);
    // echo 'user_level'.$_SESSION['user_level'];
    if ($_SESSION['user_level'] == ADMIN_LEVEL) {
        return 1;
    } else {
        return 0;
    }
}

function strToUtf8($vector)
{
    $from_chr = mb_detect_encoding($vector, array(
        'UTF-8',
        'ASCII',
        'EUC-CN',
        'CP936',
        'BIG-5',
        'GB2312',
        'GBK'
    ));
    // echo $from_chr;
    if ($from_chr != "UTF-8") {
        $vector = iconv($from_chr, "UTF-8", $vector);
    }
    return $vector;
}

function getLastInsertID()
{
    global $db;
    $sql_select = "SELECT last_insert_rowid() as last_insert_cid";
    
    $rrows = $db->query($sql_select) or die(mysql_error());
    
    $rows = $rrows->fetch();
    
    if ($rows['last_insert_cid'] !== false) {
        return $rows['last_insert_cid'];
    } else {
        return false;
    }
}

function getUserName()
{
    global $db;
    $id         = $_SESSION['user_id'];
    $sql_select = "SELECT user_name as user_name from students where id=$id";
    $rrows = mysql_query($sql_select) or die(mysql_error());
    $rows = mysql_fetch_array($rrows);
    
    if ($rows['user_name'] !== '') {
        $_SESSION['user_name'] = $rows['user_name'];
        return $rows['user_name'];
    } else {
        return $_SESSION['user_name'];
        
    }
    
}


function sendEmail($subject, $message, $email)
{
    $message .= "
    <p>Administrator</p>
      <p>______________________________________________________</p>
      该邮件为系统自动发现，请不要回复。<br/>
      THIS IS AN AUTOMATED RESPONSE. <br/>
      ***DO NOT RESPOND TO THIS EMAIL****<br/>
      ";
    require("smtp/smtp.php");
    ########################################## 
    $smtpserver     = "smtp.163.com"; //SMTP服务器 
    $smtpserverport = 25; //SMTP服务器端口 
    $smtpusermail   = "no_reply_gdepc@163.com"; //SMTP服务器的用户邮箱 
    $smtpemailto    = $email; //发送给谁 
    $smtpuser       = "no_reply_gdepc"; //SMTP服务器的用户帐号 
    $smtppass       = "flowerszhong"; //SMTP服务器的用户密码 
    $mailsubject    = $subject; //邮件主题 
    $mailbody       = $message; //邮件内容 
    $mailtype       = "HTML"; //邮件格式（HTML/TXT）,TXT为文本邮件 
    ########################################## 
    
    $smtp        = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass); //这里面的一个true是表示使用身份验证,否则不使用身份验证. 
    $smtp->debug = false; //是否显示发送的调试信息 
    $smtpOK      = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
    
    return $smtpOK;
}



?>