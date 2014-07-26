<?php 
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel/IOFactory.php';
// require_once 'PHPExcel/Classes/PHPExcel.php';
// require_once 'PHPExcel/Classes/PHPExcel/Writer/Excel5.php';
// require_once 'PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

class ChangeArrayToExcel
{
    
    private $excelName; //xls文件名，包括生成路径
    
    public function __construct($name = '/public/export/Excel/excel.xls')
    {
        if ($name != "") {
            $this->excelName = $name;
        }
    }
    /*通过PHPExcel类生成Excel文件
     *@param $data 包含excel文件内容的数组
     * @param $txArr 包含excel表头信息（中文)  例如array('编号',"姓名")
     * @param $txArrEn excel表头信息（英文） 例如array('id','username')
     * @param $excelVersion 生成excel文件的版本  可选值为other,2007
     * @param $width 单元格宽度，如果设置为‘auto’ 表示自适应宽度，也可是具体的数字，用来设置具体的单元格宽度
     * @renturn excel文件的绝对路径
     * **/
    public function getExcel($data, $txArr, $txArrEn, $excelVersion = "other", $width = "auto")
    {
        $excelObj = new PHPExcel();
        $excelObj->setActiveSheetIndex(0);
        $objActSheet = $excelObj->getActiveSheet();
        if (count($txArr) != count($txArrEn) && count($txArrEn) != count($data['0']) && !empty($data)) {
            echo "表头数组错误，请仔细检查！";
            exit();
        }
        /*确定表头宽度，将表头内容添加到excel文件里*/
        foreach ($txArr as $key => $value) {
            $objActSheet->setCellValue($this->numToEn($key) . "1", $value);
            /*设置对齐方式*/
            $objActSheet->getStyle($this->numToEn($key) . "1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            /*设置字体加粗*/
            $objActSheet->getStyle($this->numToEn($key) . "1")->getFont()->setBold(true);
            $width == "auto" ? $objActSheet->getColumnDimension($this->numToEn($key))->getAutoSize(true) : $objActSheet->getColumnDimension($this->numToEn($key))->setWidth($width);
        }
        /*将数据添加到excel里*/
        foreach ($data as $key => $value) {
            foreach ($txArrEn as $k => $val) {
                $objActSheet->getStyle($this->numToEn($k) . ($key + 2))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $objActSheet->setCellValue($this->numToEn($k) . ($key + 2), " " . $value[$val]); //在写入Excels单元格的内容之前加一个空格，防止长数字被转化成科学计数法
                $objActSheet->getStyle($this->numToEn($k) . ($key + 2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }
        /*判断生成excel文件版本*/
        $objWriter = "";
        if ($excelVersion == "other") {
        	// echo "xls";
            $objWriter = new PHPExcel_Writer_Excel5($excelObj);
        }
        if ($excelVersion == "2007") {
        	// echo "xlsx";
            $objWriter = new PHPExcel_Writer_Excel2007($excelObj);
        }
        $objWriter->save($this->excelName);
        return $this->excelName;
    }
    
    private function numToEn($num)
    {
        $asc = 0;
        $en  = "";
        $num = (int) $num + 1;
        if ($num < 26) //判断指定的数字是否需要用两个字母表示
            {
            if ((int) $num < 10) {
                $asc = ord($num);
                $en  = chr($asc + 16);
            } else {
                $num_g = substr($num, 1, 1);
                $num_s = substr($num, 0, 1);
                $asc   = ord($num_g);
                $en    = chr($asc + 16 + 10 * $num_s);
            }
        } else {
            $num_complementation = floor($num / 26);
            $en_q                = $this->numToEn($num_complementation);
            $en_h                = $num % 26 != 0 ? $this->numToEn($num - $num_complementation * 26) : "A";
            $en                  = $en_q . $en_h;
        }
        return $en;
    }
}
 ?>