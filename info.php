<?php 
include 'dbc.php';
page_protect();

$err = array();
$msg = array();
 
$rs_settings = mysql_query("select * from students where student_id='$_SESSION[student_id]'") or die(mysql_error()); 
$row_settings = mysql_fetch_array($rs_settings);

if($_POST['doUpdate'])  
{
  $rs_pwd = mysql_query("select pwd from students where id='$_SESSION[user_id]'");
  $rs_pwd_row = mysql_fetch_array($rs_pwd);
  $old = $rs_pwd_row['pwd'];
  $old_salt = substr($old,0,9);

  //check for old password in md5 format
  	if($old === PwdHash($_POST['pwd_old'],$old_salt))
  	{
    	$newsha1 = PwdHash($_POST['pwd_new']);
    	mysql_query("update students set pwd='$newsha1' where id='$_SESSION[user_id]'");
    	$msg[] = "你的账号已经更新";
  	} else {
  	 $err[] = "你输入的旧密码不正确";
  	}

}


include 'includes/head.php';
include 'includes/errors.php';
 ?>
<div class="container">

	<h3 class="title">上网账号信息</h3>
		<table id="net-account-table">
			<tr>
				<td width="120">上网账号</td>
				<td>
					<?php if($row_settings['net_id']){ ?>

					<input name="student_id" type="text" id="student_id" value="<? echo $row_settings['net_id']; ?>" disabled></td>
					<?php  } else{?>
					你尚未分配上网账号
					<?php } ?>
			</tr>
			<tr>
				<td>账号密码</td>
				<td>
				<?php if($row_settings['net_id']){ ?>
					<button class="btn">查看账号密码</button>
					<label for=""><?php echo $row_settings['net_pwd']; ?></label>
				<?php } ?>
				</td>
			</tr>
			<tr>
				<td>账号过期时间</td>
				<td>
					<label for=""><?php echo $row_settings['expire_date']; ?></label>
				</td>
			</tr>

			
		</table>


	<h3 class="title">你的缴费记录</h3>
	

	<h3 class="title">修改密码</h3>
        <div class="table-responsive">
        <form name="resetForm" id="reset-form" method="post" action="info.php">
          <table class="table table-striped">
            <tr> 
              <td width="120">旧密码</td>
              <td><input name="pwd_old" type="password" class="required password" minlength="6" id="pwd_old"></td>
            </tr>
            <tr> 
              <td>输入新密码</td>
              <td><input name="pwd_new" type="password" id="pwd_new" class="required password"  ></td>
            </tr>

            <tr> 
              <td>再次输入新密码</td>
              <td><input name="pwd_new" type="password" id="pwd_new" class="required password"  ></td>
            </tr>
            <tr>
            <td></td>
              <td>
                <input name="doUpdate" type="submit" id="doUpdate" class="btn btn-success" value="更新">
              </td>
            </tr>
          </table>
        </form>
      </div>


	</div>





<script src="assets/js/settings.js"></script>


<?php 
	include 'includes/footer.php';
 ?>