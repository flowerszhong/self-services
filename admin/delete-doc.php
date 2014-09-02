<?php
include '../dbc.php';
admin_page_protect();

// filter POST values
foreach ($_POST as $key => $value) {
	$data[$key] = filter($value);
}

if (isset($_POST['delete'])) {

	$doc_name = $data['doc_name'];

	$encode = mb_detect_encoding($doc_name, array("UTF-8", "GB2312", "GBK", 'BIG5'));
	if ($encode == 'GB2312') {
		$doc_name = iconv('GB2312', 'UTF-8', $doc_name);
	}
	$dir       = dirname(__FILE__) . "/docs/";
	$file_name = $dir . $doc_name;
	@unlink($file_name);
	$output = array(
		"state"    => "ok",
		'dir'      => $dir,
		"doc_name" => $doc_name,
	);
	echo json_encode($output);
	exit();
}

?>