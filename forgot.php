<?php 
include 'dbc.php';

if (isset($_POST['doReset']))
{
  $err = array();
  $msg = array();

  foreach($_POST as $key => $value) {
  	$data[$key] = filter($value);
  }
  if(!isEmail($data['user_email'])) {
    $err[] = "ERROR - 请输入正确的邮箱地址"; 
  }

  $user_email = $data['user_email'];

  //check if activ code and user is valid as precaution
  $rs_check = mysql_query("select student_id,user_name from students where user_email='$user_email'") or die (mysql_error()); 
  $num = mysql_num_rows($rs_check);

  // Match row found with more than 1 results  - the user is authenticated. 
  if ($num !== 1) { 
    $err[] = "错误 - 该邮箱未注册.";
  }


  if(empty($err)) {

      $new_pwd = GenPwd();
      $pwd_reset = PwdHash($new_pwd);
      //$sha1_new = sha1($new);	
      //set update sha1 of new password + salt
      $rs_activ = mysql_query("update students set pwd='$pwd_reset' WHERE 
      						 user_email='$user_email'") or die("重置密码失败");
      						 
      $host  = $_SERVER['HTTP_HOST'];
      $host_upper = strtoupper($host);	

      $row = mysql_fetch_array($rs_check);
      $student_id = $row['student_id'];
      $student_name = $row['user_name'];

      						 
      //send email
      $message = 
      "<h1>$student_name 同学</h1>
      <p>你好!</p>
      <p>以下账号新密码</p>
      <ul>
          <li>邮箱: $user_email </li>
          <li>密码: $new_pwd</li>
      </ul>
      ";

      $subject = "你的密码已经重置";
      sendEmail($subject, $message, $user_email);
      $msg[] = "你的密码已经重置成功，请查看你的邮箱";

   }
}
include 'includes/head.php';
include 'includes/errors.php';


?>
<div class="container">
 
  <h3 class="title">重置密码</h3>
        <p>新的密码将会发送至你的注册邮箱</p>
     
        <form action="forgot.php" method="post" name="actForm" id="actForm" >
              <label>请输入注册邮箱：</label>
              <input name="user_email" type="text" class="required email form-control custom-input">
              <input name="doReset" type="submit" class="btn btn-success" id="doLogin3" value="重置密码">
        </form>
</div>

<?php 
include 'includes/footer.php';
 ?>
