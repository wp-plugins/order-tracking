<?php
function EWD_OTP_Export_To_Excel() {
		global $wpdb;
		global $EWD_OTP_orders_table_name, $EWD_OTP_fields_table_name, $EWD_OTP_fields_meta_table_name;
		
		include_once('../wp-content/plugins/order-tracking/PHPExcel/Classes/PHPExcel.php');
		
		// Instantiate a new PHPExcel object 
		$objPHPExcel = new PHPExcel();  
		// Set the active Excel worksheet to sheet 0 
		$objPHPExcel->setActiveSheetIndex(0);  

		// Print out the regular order field labels
		$objPHPExcel->getActiveSheet()->setCellValue("A1", "Name");
		$objPHPExcel->getActiveSheet()->setCellValue("B1", "Number");
		$objPHPExcel->getActiveSheet()->setCellValue("C1", "Order Status");
		$objPHPExcel->getActiveSheet()->setCellValue("D1", "Order Status Updated");
		$objPHPExcel->getActiveSheet()->setCellValue("E1", "Display");
		$objPHPExcel->getActiveSheet()->setCellValue("F1", "Notes Public");
		$objPHPExcel->getActiveSheet()->setCellValue("G1", "Notes Private");
		$objPHPExcel->getActiveSheet()->setCellValue("H1", "Email");

		//start of printing column names as names of custom fields  
		$column = 'I';
		$Sql = "SELECT * FROM $EWD_OTP_fields_table_name";
		$Custom_Fields = $wpdb->get_results($Sql);
		foreach ($Custom_Fields as $Custom_Field) {
     		$objPHPExcel->getActiveSheet()->setCellValue($column."1", $Custom_Field->Field_Name);
    		$column++;
		}  

		//start while loop to get data  
		$rowCount = 2;  
		$Orders = $wpdb->get_results("SELECT * FROM $EWD_OTP_orders_table_name");
		foreach ($Orders as $Order)  
		{  
    	 	$objPHPExcel->getActiveSheet()->setCellValue("A" . $rowCount, $Order->Order_Name);
				$objPHPExcel->getActiveSheet()->setCellValue("B" . $rowCount, $Order->Order_Number);
				$objPHPExcel->getActiveSheet()->setCellValue("C" . $rowCount, $Order->Order_Status);
				$objPHPExcel->getActiveSheet()->setCellValue("D" . $rowCount, $Order->Order_Status_Updated);
				$objPHPExcel->getActiveSheet()->setCellValue("E" . $rowCount, $Order->Order_Display);
				$objPHPExcel->getActiveSheet()->setCellValue("F" . $rowCount, $Order->Order_Notes_Public);
				$objPHPExcel->getActiveSheet()->setCellValue("G" . $rowCount, $Order->Order_Notes_Private);
				$objPHPExcel->getActiveSheet()->setCellValue("H" . $rowCount, $Order->Order_Email);
				
				$column = 'I';
    		foreach ($Custom_Fields as $Custom_Field) {  
        	  $MetaValue = $wpdb->get_var($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order->Order_ID, $Custom_Field->Field_ID));

        		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $MetaValue);
        		$column++;
    		}  
    		$rowCount++;
		} 


		// Redirect output to a client’s web browser (Excel5) 
		if ($Format_Type == "CSV") {
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="Order_Export.csv"'); 
			header('Cache-Control: max-age=0'); 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
			$objWriter->save('php://output');
		}
		else {
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="Order_Export.xls"'); 
			header('Cache-Control: max-age=0'); 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
			$objWriter->save('php://output');
		}

}
?>