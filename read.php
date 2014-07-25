<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

// date_default_timezone_set('Europe/London');
date_default_timezone_set('Asia/ShangHai');
 


/** Include PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel/IOFactory.php';


if (!file_exists("test.xls")) {
	exit("Please run 05featuredemo.php first." . EOL);
}

echo date('H:i:s') , " Load from Excel2007 file" , EOL;
$callStartTime = microtime(true);

$objPHPExcel = PHPExcel_IOFactory::load("test.xls");

$sheet = $objPHPExcel->getSheet(0);
$highestColumm = $sheet->getHighestColumn(); // 取得总列数
$highestColumm= PHPExcel_Cell::columnIndexFromString(); //字母列转换为数字列 如:AA变为27

/** 循环读取每个单元格的数据 */
for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
    for ($column = 0; $column < $highestColumm; $column++) {//列数是以第0列开始
        $columnName = PHPExcel_Cell::stringFromColumnIndex($column);
        echo $columnName.$row.":".$sheet->getCellByColumnAndRow($column, $row)->getValue()."<br />";
    }
}



// Check prerequisites
if (!file_exists("test.xls")) {
	exit("not found 31excel5.xls.\n");
}
 
$reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
$PHPExcel = $reader->load("test.xls"); // 载入excel文件
$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
$highestRow = $sheet->getHighestRow(); // 取得总行数
$highestColumm = $sheet->getHighestColumn(); // 取得总列数

var_dump($highestColumm);
 
/** 循环读取每个单元格的数据 */
for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
    for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
        $dataset[] = $sheet->getCell($column.$row)->getValue();
        echo $column.$row.":".$sheet->getCell($column.$row)->getValue()."<br />";
    }
}
 
?>


