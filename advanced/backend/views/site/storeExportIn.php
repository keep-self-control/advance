<?php

$fileName='C:\Users\DELL\Desktop\2020-01\_202001101141451578656505.xlsx';
$data = \moonland\phpexcel\Excel::import($fileName); // $config is an optional



echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);






//$data = \moonland\phpexcel\Excel::widget([
//    'mode' => 'import',
//    'fileName' => $fileName,
//    'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
//    'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
//    'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
//]);
//
//$data = \moonland\phpexcel\Excel::import($fileName, [
//    'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
//    'setIndexSheetByName' => false, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
//    'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
//]);



