<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ZipArchive;

class ExcelSplitController extends Controller
{

    public function index()
    {
        return view('excel_split.index');
    }

    //

    public function splitExcelFile(Request $request)
    {
        $inputFile      = $request->file('excel_file');
        $columnToSplit  = $request->input('split_column');

        // Load the input Excel file
        $spreadsheet    = IOFactory::load($inputFile->getPathname());
        $worksheet      = $spreadsheet->getActiveSheet();
        $data           = $worksheet->toArray();

        // Group rows by the specified column value
        $groups                 =   [];

        $header                 =   [];
        $columnToSplitIndex     =   0;

        foreach ($data as $index => $row) {

            if($index   !=  0) {

                $columnValue = $row[$columnToSplitIndex];

                if (!isset($groups[$columnValue])) {

                    $groups[$columnValue][] = $header;
                    $groups[$columnValue][] = $row;
                }

                else {

                    $groups[$columnValue][] = $row;
                }
            }

            else {

                $header =   $row;
                
                foreach ($header as $columnIndex => $columnTexte) {

                    if($columnTexte ==  $columnToSplit) {

                        $columnToSplitIndex =   $columnIndex;
                    }
                }
            }
        }

        // Create a new Excel file for each group
        foreach ($groups as $columnValue => $groupData) {

            $newSpreadsheet = new Spreadsheet();
            $newWorksheet   = $newSpreadsheet->getActiveSheet();
            $newWorksheet->fromArray($groupData);

            $writer         = new Xlsx($newSpreadsheet);

            if($columnValue ==  "") {

                $outputFile     = "C:\Users/DELL/Downloads/Empty.xlsx";
            }

            else {

                $outputFile     = "C:\Users/DELL/Downloads/{$columnValue}.xlsx";
            }

            $writer->save($outputFile);
        }

        return true;
    }

    //
}