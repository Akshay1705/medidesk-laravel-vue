<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;

class AppointmentExportController extends Controller
{
    public function export()
    {
        $appointments = Appointment::where('is_done', true)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Name');
        $sheet->setCellValue('B1', 'Phone');
        $sheet->setCellValue('C1', 'Date');
        $sheet->setCellValue('D1', 'Time');

        $row = 2;
        foreach ($appointments as $appointment) {
            $sheet->setCellValue("A$row", $appointment->name);
            $sheet->setCellValue("B$row", $appointment->phone);
            $sheet->setCellValue("C$row", Carbon::parse($appointment->appointment_date)->format('d-m-Y'));
            $sheet->setCellValue("D$row", Carbon::parse($appointment->appointment_time)->format('h:i A'));
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'completed_appointments_' . now()->format('Ymd_His') . '.xlsx';

        // Create temporary path
        $tempPath = storage_path("app/public/$filename");
        $writer->save($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
