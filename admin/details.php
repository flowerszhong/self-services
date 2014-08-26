<?php
include '../dbc.php';
admin_page_protect();

// filter POST values
foreach ($_POST as $key => $value) {
    $data[$key] = filter($value);
}

foreach ($_GET as $key => $value) {
    $data[$key] = filter($value);
}



$sql = "select * from accounts where available=1";

$page_rows = 10;
$account_num = $data['account_num'];

if (isset($data['page_limit'])) {
    $page_rows = $data['page_limit'];
}


$last = ceil($account_num / $page_rows);

if ($last < 1) {
    $last = 1;
}

$pagenum = 1;

if (isset($data['pn'])) {
    $pagenum = $data['pn'];
}

if ($pagenum < 1) {
    $pagenum = 1;
} else if ($pagenum > $last) {
    $pagenum = $last;
}

$limit = 'LIMIT ' . ($pagenum - 1) * $page_rows . ',' . $page_rows;

$month_start = $data['begin_date'];
// echo $month_start;
$month_end = date("Y-m-t", strtotime($month_start));
// echo $month_end;


$begin_datetime = new DateTime($month_start);
$begin_datetime->modify("-1 month");
$last_month_end = $begin_datetime->format("Y-m-t");

// echo $last_month_end;


if ($data['account_type'] == 1) {
    $sql .= " and end_date = '$last_month_end'";
}

if ($data['account_type'] == 2) {
    $sql .= " and start_date between '$month_start' and '$month_end'";
}

if ($data['account_type'] == 3) {
    $sql .= " and end_date >='$month_end'";
}


$sql .= " " . $limit;



// echo json_encode($sql);
// exit();
$query = mysql_query($sql);

$page_state = "第<b>$pagenum</b>/ <b>$last</b>页,共 $account_num 行";

$paginationCtrls = '';
if ($last != 1) {
    if ($pagenum > 1) {
        $previous = $pagenum - 1;
        $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '">上一页</a> &nbsp; &nbsp; ';
        for ($i = $pagenum - 4; $i < $pagenum; $i++) {
            if ($i > 0) {
                $paginationCtrls .= '<a href="#' . $i . '">' . $i . '</a> &nbsp; ';
            }
        }
    }
    $paginationCtrls .= '' . $pagenum . ' &nbsp; ';
    for ($i = $pagenum + 1; $i <= $last; $i++) {
        $paginationCtrls .= '<a href="#' . $i . '">' . $i . '</a> &nbsp; ';
        if ($i >= $pagenum + 4) {
            break;
        }
    }
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a href="#' . $next . '">下一页</a> ';
    }
}

$rrows = array();
while ($row = mysql_fetch_object($query)) {
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
          
   

   
