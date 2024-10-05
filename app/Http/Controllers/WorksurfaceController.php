<?php

namespace App\Http\Controllers;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use App\Models\Record;

class WorksurfaceController extends Controller
{
    public function generatePdf()
    {
        $records = Record::all(); // Fetch records from your model

        foreach ($records as $record) {
            // Generate QR code
            $renderer = new ImageRenderer(
                new SvgImageBackEnd(),
                new RendererStyle(30)
            );
            $writer = new Writer($renderer);
            $qrCode = base64_encode($writer->writeString($record->register_no));

            // Debug: Check if QR code is correctly generated
            if (!$qrCode) {
                return 'QR Code generation failed for record: ' . $record->register_no;
            }

            // Attach the generated QR code as a base64 string to each record
            $record->qrCode = $qrCode;
        }

        // Pass records with QR code to the view
        return view('Worksurfacepdf', compact('records'));
    }

}
