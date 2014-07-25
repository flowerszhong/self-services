<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="广东环境保护工程职业学院-上网自助服务">
    <meta name="author" content="flowerszhong@gmail.com">

    <title><?php if($page_title){
            echo $page_title."-自助上网服务";
        }else{
            echo "自助上网服务-广东环境保护工程职业学院";
            } ?></title>

    <link href="assets/css/btn.css" rel="stylesheet" type='text/css' media='all' />
    <link href="assets/css/table.css" rel="stylesheet" type='text/css' media='all' />
    <link href="assets/css/main.css" rel="stylesheet" type='text/css' media='all' />


</head>

<body>
    <div class="color-bar"></div>

    <div class="navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <div id="header-logo">
                     <h1>
                        <a class="navbar-brand" href="index.php">上网自助服务</a>
                    </h1>
                    <h2>广东环境保护工程职业学院</h2>
                </div>
               

                <div id="topnav">
                  <ul>
                  <?php if(isset($_SESSION['student_id'])){ ?>
                    <li><a href="logout.php">退出</a><span>Logout</span></li>
                    <li><a href="info.php">账号信息</a><span>Accounts</span></li>
                    <li><a href="mysettings.php">个人资料</a><span>Profiles</span></li>
                  <?php } ?>
                    <li><a href="#">使用需知</a><span>Notices</span></li>
                    <li><a href="index.php">首页</a><span>Home</span></li>
                  </ul>
                </div>
              </div>
            </div>
    </div>