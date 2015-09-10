<?
//– On inclus les fichiers PHPExel
include 'Classes/PHPExcel.php';
include 'Classes/PHPExcel/Writer/Excel2007.php';

//– Go !
$objPHPExcel = new PHPExcel();

$styleArray = array(
	'font' => array(
		'bold' => true,
    'name' => 'Arial',
    'size' => '12',
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	),
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
      'color' => array(
        'argb' => '00000000'      
		  ),    
    ),
    'inside' => array(
			'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
      'color' => array(
        'argb' => '00000000'      
		  ),
    ),
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'startcolor' => array(
			'argb' => 'FFA0A0A0',
		),
	),
);

//– Quelques propriétées
$objPHPExcel->getProperties()->setCreator("DevZone");
$objPHPExcel->getProperties()->setLastModifiedBy("DevZone");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX");
$objPHPExcel->getProperties()->setDescription("Office 2007 XLSX – By DevZone – With PHPExel");

//– Les Données
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'La cellule A1');
$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'La cellule B2');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'La cellule C1');
$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'La cellule D2');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,3, 'La cellule E3');

$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray);
//– On nomme notre feuillet
$objPHPExcel->getActiveSheet()->setTitle('Exemple');

//– On sauvegarde notre fichier (Format Excel 2007)
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('Office 2007 XLSX.xlsx');
?>
ok

