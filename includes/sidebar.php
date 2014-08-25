 <div class="col-sm-3 col-md-2 sidebar">
        <?php if (isset($_SESSION['admin_id'])) {?>
          <ul class="nav nav-sidebar">
            <li><a href="statistics.php">统计面板</a></li>
            <li><a href="billing.php">按班收费</a></li>
            <li><a href="admin.php">管理学生信息</a></li>
            <li><a href="net-accounts.php">上网账号表</a></li>
            <li><a href="export.php">数据备份</a></li>
            <li><a href="create.php">创建账号</a></li>
            <li><a href="files.php">文档管理</a></li>
            <li><a href="logout.php">退出登录</a></li>
          </ul>
        <?php } ?>
        </div>