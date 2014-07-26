<?php 
include '../dbc.php';
admin_page_protect();

ini_set('max_execution_time', 1000);

// filter GET values
foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

// filter POST values
foreach($_POST as $key => $value) {
	$post[$key] = filter($value);
}

$sql_select = "select count(id) from students2013";
$query = mysql_query($sql_select);

$row = mysql_fetch_row($query);

$rows = $row[0];

$page_rows = 20;

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


$sql = "select * from students2013 ". $limit;
$query = mysql_query($sql);

$textline1 = "Testimonials (<b>$rows</b>)";
$textline2 = "Page <b>$pagenum</b> of <b>$last</b>";

$paginationCtrls = '';
if($last != 1){
  if ($pagenum > 1) {
        $previous = $pagenum - 1;
    $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">上一页</a> &nbsp; &nbsp; ';
    for($i = $pagenum-4; $i < $pagenum; $i++){
      if($i > 0){
            $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
      }
      }
    }
  $paginationCtrls .= ''.$pagenum.' &nbsp; ';
  for($i = $pagenum+1; $i <= $last; $i++){
    $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
    if($i >= $pagenum+4){
      break;
    }
  }
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">下一页</a> ';
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
      "text1" => $textline1,
      "text2" => $textline2
  );

echo json_encode($output);

exit();





?>
          
	 

   
