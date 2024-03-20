<?php
use App\Models\User;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class UsersExport{
public function export()
{
    // Fetch users from the database
    $users = User::all();

    // Create a new Spreadsheet instance
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set column headings
    $sheet->setCellValue('A1', 'Name');
    $sheet->setCellValue('B1', 'Email');

    // Populate data rows
    $row = 2;
    foreach ($users as $user) {
        $sheet->setCellValue('A' . $row, $user->name);
        $sheet->setCellValue('B' . $row, $user->email);
        // Add more columns as needed
        $row++;
    }

    // Set headers for download
    $filename = 'users.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Write the spreadsheet to a file
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit;
}
}