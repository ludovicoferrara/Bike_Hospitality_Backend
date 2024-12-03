<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

                $fcsv = fopen("_csv/$fnamecsv","r");
                $irow = 0;
                $axls = array();
                while($row=fgets($fcsv))
                {
                    $icols=65;
                    $a = explode(";",$row);
                    if(is_array($a))
                        $axls[$irow++] = $a;
                        
                        foreach($a as $k => $v)
                        {
                            $cell = mb_chr($icols++).$irow;
                            $sheet->setCellValue($cell, $v);
                        }
                    
                }
                

$writer = new Xlsx($spreadsheet);
$writer->save('_csv/'.$fnamexls);