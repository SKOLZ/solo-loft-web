<?php


/*

$Datos es un array multidimensional del tipo:
	$Datos = array("Titulo worksheet" => $array_datos_worksheet);
		$array_datos_worksheet es un array con los headers de las columnas y sus respectivos datos (el primer indice son los headers, todos los demas son datos)
		

El ancho de la columna se calcula automaticamente tomando el valor mas grande entre todos los datos.

*/
class Export{

	var $Titulo;
	var $Datos;
	var $Formato;
	var $FileName;
	
	
	function Export($Titulo, $Datos, $Formato, $FileName){
		$this->Titulo = $Titulo;
		$this->Datos = $Datos;
		$this->Formato = $Formato;
		$this->FileName = $FileName;
		return true;
	}

	function display(){
		switch($this->Formato){
			case "xls":
				//return Export::__generarXLS();
				return Export::__generarLightXLS();
			break;
		}
	}
	
		
	function __generarLightXLS(){
		global $PATH_ONAS;
		
		require($PATH_ONAS. "/classes/Spreadsheet/Excel/Writer.php");

		$workbook = new Spreadsheet_Excel_Writer();

		// sending HTTP headers
		$workbook->send($this->FileName.'.xls');
		
		// Creating a worksheet
		$worksheet =& $workbook->addWorksheet($this->Titulo);

		$i=0;
		foreach($this->Datos['datos_exportados'] as $datos){
			foreach($datos as $index => $value){
				$worksheet->write($i, $index, $value);
			}
			$i++;
		}
			
		// Let's send the file
		$workbook->close();
	}
	
	
	/*
	function __generarXLS(){
		
		global $PATH_INCLUDES;
		require($PATH_INCLUDES."PHPExcel/PHPExcel.php");
		include($PATH_INCLUDES."PHPExcel/Writer/Excel5.php");
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Promaker");
		$objPHPExcel->getProperties()->setTitle($this->Titulo);
		
		$sheets_cnt = 0;
		foreach($this->Datos as $Sheet_Name => $Sheet_Data){
			if($sheets_cnt > 0){
				$objPHPExcel->createSheet();
			}
			$objPHPExcel->setActiveSheetIndex($sheets_cnt); // foreach datos
			$objPHPExcel->getActiveSheet()->setTitle($Sheet_Name);
			$row_cnt = 3;
			$max_w = array();
			foreach($Sheet_Data as $Row_Data){
				$col_cnt = 65;
				$row_len = count($Row_Data);
				foreach($Row_Data as $Col_Data){
					$objPHPExcel->getActiveSheet()->setCellValue(chr($col_cnt) . $row_cnt, $Col_Data);
					
					if(isset($max_w[$col_cnt]) && PHPExcel_Shared_Font::calculateColumnWidth( 9, true, $Col_Data) > $max_w[$col_cnt]){
						$max_w[$col_cnt] = PHPExcel_Shared_Font::calculateColumnWidth( 9, true, $Col_Data);
					}
					
					if(($row_cnt != 1 && $this->Titulo == "") || ($row_cnt != 3 && $this->Titulo != "")){
						$objPHPExcel->getActiveSheet()->duplicateStyleArray(
								array(
									'font'    => array(
										'bold'      => false
									),
									'alignment' => array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
									),
									'borders' => array(
										'top'     => array(
											'style' => PHPExcel_Style_Border::BORDER_THIN
										),
										'left'     => array(
											'style' => PHPExcel_Style_Border::BORDER_THIN
										),
										'right'     => array(
											'style' => PHPExcel_Style_Border::BORDER_THIN
										),
										'bottom'     => array(
											'style' => PHPExcel_Style_Border::BORDER_THIN
										)
									),
									'fill' => array(
										'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
										'rotation'   => 90,
										'startcolor' => array(
											'argb' => 'FFFFFFFF'
										),
										'endcolor'   => array(
											'argb' => 'FFFFFFFF'
										)
									)
								),
								chr($col_cnt) . $row_cnt.':'. chr(65+$row_len-1) . $row_cnt
							);
					}else{
						$objPHPExcel->getActiveSheet()->duplicateStyleArray(
								array(
									'font'    => array(
										'bold'      => true
									),
									'alignment' => array(
										'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
									),
									'borders' => array(
										'top'     => array(
											'style' => PHPExcel_Style_Border::BORDER_THIN
										),
										'left'     => array(
											'style' => PHPExcel_Style_Border::BORDER_THIN
										),
										'right'     => array(
											'style' => PHPExcel_Style_Border::BORDER_THIN
										),
										'bottom'     => array(
											'style' => PHPExcel_Style_Border::BORDER_THIN
										)
									),
									'fill' => array(
										'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
										'rotation'   => 90,
										'startcolor' => array(
											'argb' => 'FFE6E6E6'
										),
										'endcolor'   => array(
											'argb' => 'FFE6E6E6'
										)
									)
								),
								chr($col_cnt) . $row_cnt.':'. chr(65+$row_len-1) . $row_cnt
							);
					}
					$col_cnt++;
				}
				foreach($max_w as $col => $width){
					$objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setWidth($width);
				}
				$objPHPExcel->getActiveSheet()->mergeCells('A1:'. chr(65+$row_len-1) .'1');
				$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
					array('font' => array('bold' => true, 'color' => array('rgb' => '000000')), 'alignment' => array(				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$objPHPExcel->getActiveSheet()->setCellValue('A1', $this->Titulo);
				
				$objPHPExcel->getActiveSheet()->mergeCells('A2:'. chr(65+$row_len-1) .'2');
				$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(8);
				$row_cnt++;
			}
			$sheets_cnt++;
		}

		header('Pragma: public');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                  // Date in the past   
		header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');     // HTTP/1.1
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');    // HTTP/1.1
		header ("Pragma: no-cache");
		header("Expires: 0");
		header('Content-Transfer-Encoding: none');
		header('Content-Type: application/vnd.ms-excel;');                 // This should work for IE & Opera
		header("Content-type: application/x-msexcel");                    // This should work for the rest
		header('Content-Disposition: attachment; filename="'. $this->FileName .'.xls"');
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
		$objWriter->save('php://output');
	}
	*/

}

?>
