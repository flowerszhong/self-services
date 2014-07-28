<?php 
include '../dbc.php';
admin_page_protect();

// filter POST values
foreach($_POST as $key => $value) {
	$post[$key] = filter($value);
}



$sql = "select * from students ";

$sql_select = "select count(id) from students";



$condition = array();
if(!empty($_POST['grade'])){
  // $condition['grade'] = $_POST['grade'];
  $condition[] = "grade = ". $_POST['grade'];

}

if(!empty($_POST['department'])){
  // $condition['department'] = $_POST['department'];
  // $condition[] = "department = ". $_POST['department'];
  $condition[] = "department ='$_POST[department]'";

}

if(!empty($_POST['major'])){
  // $condition['major'] = $_POST['major'];
  $condition[] = "major ='$_POST[major]'";


}

if(!empty($_POST['sub_major'])){
  // $condition['sub_major'] = $_POST['sub_major'];
  $condition[] = "sub_major ='$_POST[sub_major]'";


}

if(!empty($_POST['class'])){
  // $condition['class'] = $_POST['class'];
  $condition[] = "class = ". $_POST['class'];

}

if(!empty($_POST['student_id'])){
  // $condition['student_id'] = $_POST['student_id'];
  $condition[] = "student_id = ". $_POST['student_id'];

}

if(!empty($_POST['user_name'])){
  // $condition['user_name'] = $_POST['user_name'];
  $condition[] = "user_name ='$_POST[user_name]'";


}

if(!empty($_POST['user_email'])){
  // $condition['user_email'] = $_POST['user_email'];
  $condition[] = "user_email ='$_POST[user_email]'";

}

if(!empty($condition)){
  $sql .= " where ".implode(" and ", $condition);
  $sql_select .= " where ".implode(" and ", $condition);
}

$query = mysql_query($sql_select);

$row = mysql_fetch_row($query);

$rows = $row[0];

$page_rows = 10;

if(isset($_POST['page_limit'])){
  $page_rows = $_POST['page_limit'];
}


$last = ceil($rows/$page_rows);

if($last < 1){
  $last = 1;
}

$pagenum = 1;

if(isset($_POST['pn'])){
  $pagenum = $_POST['pn'];
}

if($pagenum < 1){
  $pagenum = 1;
}else if ($pagenum > $last) {
  $pagenum = $last;
}

$limit = 'LIMIT '. ($pagenum - 1) * $page_rows . ',' . $page_rows;

$order_by = "ORDER BY reg_date DESC";

$sql .= " ". $order_by . " " .$limit;



// echo json_encode($sql);
// exit();
$query = mysql_query($sql);

$page_state = "第<b>$pagenum</b>/ <b>$last</b>页,共 $rows 行";

$paginationCtrls = '';
if($last != 1){
  if ($pagenum > 1) {
        $previous = $pagenum - 1;
    $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">上一页</a> &nbsp; &nbsp; ';
    for($i = $pagenum-4; $i < $pagenum; $i++){
      if($i > 0){
            $paginationCtrls .= '<a href="#'.$i.'">'.$i.'</a> &nbsp; ';
      }
      }
    }
  $paginationCtrls .= ''.$pagenum.' &nbsp; ';
  for($i = $pagenum+1; $i <= $last; $i++){
    $paginationCtrls .= '<a href="#'.$i.'">'.$i.'</a> &nbsp; ';
    if($i >= $pagenum+4){
      break;
    }
  }
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a href="#'.$next.'">下一页</a> ';
    }
}

$rrows = array();
while($row = mysql_fetch_object($query)){
  $rrows[] = $row;
}


$output = array(
      "state" => "ok",
      "rows" => $rrows,
      "controls" => $paginationCtrls,
      "pageState" => $page_state
  );

echo json_encode($output);

exit();


?>
          
	 

   
