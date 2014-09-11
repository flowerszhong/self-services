<?php
include '../dbc.php';
admin_page_protect();
?>


<?php
$page_title = "管理学生信息";
include '../includes/head.php';
include '../includes/sidebar.php';
include '../includes/errors.php';
?>
<div class="main">

<h3 class="title">账号搜索
<a href="inquery/index.php?r=students/admin">(点击切换到高级搜索)</a>
</h3>

<form id="search-form">
  <table class="search-table">
  <tr>
    <td></td>
    <td>
      <b>按学号|姓名|邮箱查找</b>
    </td>
  </tr>
    <tr>
      <td width="80" class="th">
        学号
      </td>
      <td>
        <input type="text" value="" class="form-control" id="student_id" />
      </td>
    </tr>
    <tr>
      <td class="th">
        姓名
      </td>
      <td>
        <input type="text" value="" class="form-control" id="user_name" />

      </td>
    </tr>

    <tr>
      <td class="th">
        邮箱
      </td>
      <td>
        <input type="text" value="" class="form-control" id="user_email" />

      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="button" class="btn btn-success" id="btn-search-one" value="查询" />
      </td>
    </tr>
  </table>

   <table class="search-table">
  <tr>
    <td></td>
    <td>
      <b>按年级|系别|班级查找</b>
    </td>
  </tr>
    <tr>
      <td width="80" class="th">
        年级
      </td>
      <td>
        <select name="grade" id="grade-select" class="form-control">
         <option name="" value="">
             请选择年级
           </option>
           <option name="" value="2013">
             2013
           </option>

           <option name="" value="2014">
             2014
           </option>
         </select>
      </td>
    </tr>
    <tr>
      <td class="th">
        系
      </td>
      <td>
        <select name="department" id="department" class="form-control">
           <option name="" value="">
             请选择系别
           </option>
         </select>

      </td>
    </tr>

    <tr>
      <td class="th">
        专业
      </td>
      <td>
       <select name="major" id="major" class="form-control">
           <option name="" value="">
             请选择专业
           </option>
         </select>

      </td>
    </tr>

    <tr>
      <td class="th">
        专业方向
      </td>
      <td>
        <select name="sub-major" id="sub-major" class="form-control">
           <option name="" value="">
             请选择专业方向
           </option>
         </select>


      </td>
    </tr>

    <tr>
      <td class="th">
        班级
      </td>
      <td>
        <select name="class" id="class" class="form-control">
           <option name="class" value=""></option>
               <option name="class" value="1班">1班</option>
               <option name="class" value="2班">2班</option>
               <option name="class" value="3班">3班</option>
               <option name="class" value="4班">4班</option>
               <option name="class" value="5班">5班</option>
               <option name="class" value="6班">6班</option>
               <option name="class" value="7班">7班</option>
               <option name="class" value="8班">8班</option>
               <option name="class" value="9班">9班</option>
               <option name="class" value="10班">10班</option>
         </select>


      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        <input type="button" class="btn btn-success" id="btn-search-many" value="查询" />
      </td>
    </tr>
  </table>
  <div class="clear"></div>
</form>


<br>
      <div class="">
        <span id="page-state">

        </span>


         <select id="row-limit">
           <option value="10">10</option>
           <option value="20">20</option>
           <option value="50">50</option>
           <option value="100">100</option>
         </select>行/页
      </div>

      <div class="toolbar">



          <input name="checkall" type="submit" id="checkall" value="全选">
          <input name="uncheckall" type="submit" id="uncheckall" value="全不选">
          <input name="doApprove" type="submit" id="doApprove" value="激活">
          <input name="doDelete" type="submit" id="doDelete" value="删除">
          <input name="doAllocation" type="submit" id="doAllocation" value="关联上网账号">
      </div>




        <table>
        <thead>
          <tr>
            <td>ID</td>
            <td>学号</td>
            <td>姓名</td>
            <td>邮箱</td>
            <td>年级</td>
            <td>系</td>
            <td>专业</td>
            <td>专业方向</td>
            <td>班级</td>
            <td>是否关联<br>
            上网账号</td>
            <td>已激活</td>
          </tr>
          <tr>
        </thead>

          <tbody id="students-list">

          </tbody>
        </table>

     <div id="page-controls">

     </div>


    </div>

<?php

$footer_scripts = array("assets/lib/jquery.tmpl.min.js", "assets/js/admin.js");

include '../includes/footer.php'

?>