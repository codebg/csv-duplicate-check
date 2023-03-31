<?php
/*
*  :USAGE
*  php check.php file-1 column-number file-2 column-number
*  Array, COLUMNS starting from 0
*  Duplicated rows are exported to duplicate.csv
*/
ini_set('max_execution_time', 0);


$file1 = $argv[1];
$file2 = $argv[3];

$col1 = $argv[2];
$col2 = $argv[4];


$data1 = array_map('str_getcsv', file($file1));
$data2 = array_map('str_getcsv', file($file2));


$header1 = array_shift($data1);
$header2 = array_shift($data2);


$duplicates = array();


foreach ($data1 as $row1) {


  $value1 = $row1[$col1];


  foreach ($data2 as $row2) {


    $value2 = $row2[$col2];


    if ($value1 == $value2) {
      $duplicates[] = array_merge($row1, $row2);
    }
  }
}


if (!empty($duplicates)) {


  array_unshift($duplicates, array_merge($header1, $header2));


  $fp = fopen('duplicates.csv', 'w');


  foreach ($duplicates as $row) {
    fputcsv($fp, $row);
  }


  fclose($fp); 

  echo "Duplicates found and saved to 'duplicates.csv'.";
} else {
  echo "No duplicates found.";
}

?>
