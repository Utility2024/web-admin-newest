<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QrScannerController extends Controller
{
    public function index()
    {
        return view('scanner.index');
    }

    public function getData(Request $request)
    {
        $search = $request->input('search');
        $type = "";
        $detail = "";
        // Cek dan ambil data dari tabel equipment_grounds dan detail-nya
        $data = DB::connection('mysql_esd')->table('equipment_grounds')
            ->join('equipment_ground_details', 'equipment_grounds.id', '=', 'equipment_ground_details.equipment_ground_id')
            ->where('equipment_grounds.machine_name', $search)
            ->select('equipment_grounds.*', 'equipment_ground_details.*')
            ->orderBy('equipment_ground_details.created_at', 'desc')
            ->get();

        if (count($data) > 0) {
            $type = "eg";
            $detail = DB::connection('mysql_esd')->table('equipment_grounds')
                ->where('equipment_grounds.machine_name', $search)
                ->first();
            return view('scanner.detail', compact('data', 'type', 'search','detail'));
        }

        // Cek dan ambil data dari tabel floorings dan detail-nya
        $data = DB::connection('mysql_esd')->table('floorings')
            ->join('flooring_details', 'floorings.id', '=', 'flooring_details.flooring_id')
            ->where('floorings.register_no', $search)
            ->select('floorings.*', 'flooring_details.*')
            ->orderBy('flooring_details.created_at', 'desc')
            ->get();

        if (count($data) > 0) {
            $type = "f";
            $detail = DB::connection('mysql_esd')->table('floorings')
                ->where('floorings.register_no', $search)
                ->first();
            return view('scanner.detail', compact('data', 'type', 'search','detail'));
        }

        // Cek dan ambil data dari tabel worksurfaces dan detail-nya
        $data = DB::connection('mysql_esd')->table('worksurfaces')
            ->join('worksurface_details', 'worksurfaces.id', '=', 'worksurface_details.worksurface_id')
            ->where('worksurfaces.register_no', $search)
            ->select('worksurfaces.*', 'worksurface_details.*')
            ->orderBy('worksurface_details.created_at', 'desc')
            ->get();

        if (count($data) > 0) {
            $type = "wd";
            $detail = DB::connection('mysql_esd')->table('worksurfaces')
                ->where('worksurfaces.register_no', $search)
                ->first();
            return view('scanner.detail', compact('data', 'type', 'search','detail'));
        }

        // Cek dan ambil data dari tabel ground_monitor_boxes dan detail-nya
        $data = DB::connection('mysql_esd')->table('ground_monitor_boxes')
            ->join('ground_monitor_box_details', 'ground_monitor_boxes.id', '=', 'ground_monitor_box_details.ground_monitor_box_id')
            ->where('ground_monitor_boxes.register_no', $search)
            ->select('ground_monitor_boxes.*', 'ground_monitor_box_details.*')
            ->orderBy('ground_monitor_box_details.created_at', 'desc')
            ->get();

        if (count($data) > 0) {
            $type = "gm";
            $detail = DB::connection('mysql_esd')->table('ground_monitor_boxes')
                ->where('ground_monitor_boxes.register_no', $search)
                ->first();
            return view('scanner.detail', compact('data', 'type', 'search','detail'));
        }

        // Cek dan ambil data dari tabel gloves dan detail-nya
        $data = DB::connection('mysql_esd')->table('gloves')
            ->join('glove_details', 'gloves.id', '=', 'glove_details.glove_id')
            ->where('gloves.sap_code', $search)
            ->select('gloves.*', 'glove_details.*')
            ->orderBy('glove_details.created_at', 'desc')
            ->get();

        if (count($data) > 0) {
            $type = "g";
            $detail = DB::connection('mysql_esd')->table('gloves')
                ->where('gloves.sap_code', $search)
                ->first();
            return view('scanner.detail', compact('data', 'type', 'search','detail'));
        }

        // Cek dan ambil data dari tabel garments dan detail-nya
        $data = DB::connection('mysql_employee')->table('v_employee')
            ->join('garment_details', 'v_employee.ID', '=', 'garment_details.nik')
            ->where('v_employee.user_login', $search)
            ->select('v_employee.*', 'garment_details.*')
            ->orderBy('garment_details.created_at', 'desc')
            ->get();
        if (count($data) > 0) {
            $type = "garment";
            $detail = DB::connection('mysql_employee')->table('v_employee')
                ->where('v_employee.user_login', $search)
                ->first();
            return view('scanner.detail', compact('data', 'type', 'search','detail'));
        }

        // Cek dan ambil data dari tabel garments dan detail-nya
        $data = DB::connection('mysql_esd')->table('solderings')
            ->join('soldering_details', 'solderings.id', '=', 'soldering_details.soldering_id')
            ->where('solderings.register_no', $search)
            ->select('solderings.*', 'soldering_details.*')
            ->orderBy('soldering_details.created_at', 'desc')
            ->get();
        if (count($data) > 0) {
            $type = "sd";
            $detail = DB::connection('mysql_esd')->table('solderings')
                ->where('solderings.register_no', $search)
                ->first();
            return view('scanner.detail', compact('data', 'type', 'search','detail'));
        }

        // Cek dan ambil data dari tabel packaging dan detail-nya
        $data = DB::connection('mysql_esd')->table('packagings')
            ->join('packaging_details', 'packagings.id', '=', 'packaging_details.packaging_id')
            ->where('packagings.register_no', $search)
            ->select('packagings.*', 'packaging_details.*')
            ->orderBy('packaging_details.created_at', 'desc')
            ->get();
        if (count($data) > 0) {
            $type = "p";
            $detail = DB::connection('mysql_esd')->table('packagings')
                ->where('packagings.register_no', $search)
                ->first();
            return view('scanner.detail', compact('data', 'type', 'search','detail'));
        }

        // Cek dan ambil data dari tabel ionizers dan detail-nya
        $data = DB::connection('mysql_esd')->table('ionizers')
            ->join('ionizer_details', 'ionizers.id', '=', 'ionizer_details.ionizer_id')
            ->where('ionizers.register_no', $search)
            ->select('ionizers.*', 'ionizer_details.*')
            ->orderBy('ionizer_details.created_at', 'desc')
            ->get();
        if (count($data) > 0) {
            $type = "i";
            $detail = DB::connection('mysql_esd')->table('ionizers')
                ->where('ionizers.register_no', $search)
                ->first();
            return view('scanner.detail', compact('data', 'type', 'search','detail'));
        }

        return view('scanner.detail', compact('data', 'type', 'search'));
    }

    public function downloadDocument(Request $request)
    {
        $search = $request->input('search');
        $type = "";
        // Cek dan ambil data dari tabel equipment_grounds dan detail-nya
        $data = DB::connection('mysql_esd')->table('equipment_grounds')
            ->join('equipment_ground_details', 'equipment_grounds.id', '=', 'equipment_ground_details.equipment_ground_id')
            ->where('equipment_grounds.machine_name', $search)
            ->select('equipment_grounds.*', 'equipment_ground_details.*')
            ->get();

        if (count($data) > 0) {
            $type = "eg";
            $detail = DB::connection('mysql_esd')->table('equipment_grounds')
                ->where('equipment_grounds.machine_name', $search)
                ->first();
            $pdf = PDF::loadView('pdf.' . $type, ['data' => $data, 'detail' => $detail])
                ->setOptions(['defaultFont' => 'sans-serif']);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('data_' . $type . '.pdf');
        }

        // Cek dan ambil data dari tabel floorings dan detail-nya
        $data = DB::connection('mysql_esd')->table('floorings')
            ->join('flooring_details', 'floorings.id', '=', 'flooring_details.flooring_id')
            ->where('floorings.register_no', $search)
            ->select('floorings.*', 'flooring_details.*')
            ->get();

        if (count($data) > 0) {
            $type = "f";
            $detail = DB::connection('mysql_esd')->table('floorings')
                ->where('floorings.register_no', $search)
                ->first();
            $pdf = PDF::loadView('pdf.' . $type, ['data' => $data, 'detail' => $detail])
                ->setOptions(['defaultFont' => 'sans-serif']);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('data_' . $type . '.pdf');
        }

        // Cek dan ambil data dari tabel worksurfaces dan detail-nya
        $data = DB::connection('mysql_esd')->table('worksurfaces')
            ->join('worksurface_details', 'worksurfaces.id', '=', 'worksurface_details.worksurface_id')
            ->where('worksurfaces.register_no', $search)
            ->select('worksurfaces.*', 'worksurface_details.*')
            ->get();

        if (count($data) > 0) {
            $type = "wd";
            $detail = DB::connection('mysql_esd')->table('worksurfaces')
                ->where('worksurfaces.register_no', $search)
                ->first();
            $pdf = PDF::loadView('pdf.' . $type, ['data' => $data, 'detail' => $detail])
                ->setOptions(['defaultFont' => 'sans-serif']);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('data_' . $type . '.pdf');
        }

        // Cek dan ambil data dari tabel ground_monitor_boxes dan detail-nya
        $data = DB::connection('mysql_esd')->table('ground_monitor_boxes')
            ->join('ground_monitor_box_details', 'ground_monitor_boxes.id', '=', 'ground_monitor_box_details.ground_monitor_box_id')
            ->where('ground_monitor_boxes.register_no', $search)
            ->select('ground_monitor_boxes.*', 'ground_monitor_box_details.*')
            ->get();

        if (count($data) > 0) {
            $type = "gm";
            $detail = DB::connection('mysql_esd')->table('ground_monitor_boxes')
                ->where('ground_monitor_boxes.register_no', $search)
                ->first();
            $pdf = PDF::loadView('pdf.' . $type, ['data' => $data, 'detail' => $detail])
                ->setOptions(['defaultFont' => 'sans-serif']);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('data_' . $type . '.pdf');
        }

        // Cek dan ambil data dari tabel gloves dan detail-nya
        $data = DB::connection('mysql_esd')->table('gloves')
            ->join('glove_details', 'gloves.id', '=', 'glove_details.glove_id')
            ->where('gloves.sap_code', $search)
            ->select('gloves.*', 'glove_details.*')
            ->get();

        if (count($data) > 0) {
            $type = "g";
            $detail = DB::connection('mysql_esd')->table('gloves')
                ->where('gloves.sap_code', $search)
                ->first();
            $pdf = PDF::loadView('pdf.' . $type, ['data' => $data, 'detail' => $detail])
                ->setOptions(['defaultFont' => 'sans-serif']);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('data_' . $type . '.pdf');
        }

        // Cek dan ambil data dari tabel garments dan detail-nya
        $data = DB::connection('mysql_employee')->table('v_employee')
            ->join('garment_details', 'v_employee.ID', '=', 'garment_details.nik')
            ->where('v_employee.user_login', $search)
            ->select('v_employee.*', 'garment_details.*')
            ->get();
        if (count($data) > 0) {
            $type = "garment";
            $detail = DB::connection('mysql_employee')->table('v_employee')
                ->where('v_employee.user_login', $search)
                ->first();
            $pdf = PDF::loadView('pdf.' . $type, ['data' => $data, 'detail' => $detail])
                ->setOptions(['defaultFont' => 'sans-serif']);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('data_' . $type . '.pdf');
        }

        // Cek dan ambil data dari tabel garments dan detail-nya
        $data = DB::connection('mysql_esd')->table('solderings')
            ->join('soldering_details', 'solderings.id', '=', 'soldering_details.soldering_id')
            ->where('solderings.register_no', $search)
            ->select('solderings.*', 'soldering_details.*')
            ->get();
        if (count($data) > 0) {
            $type = "sd";
            $detail = DB::connection('mysql_esd')->table('solderings')
                ->where('solderings.register_no', $search)
                ->first();
            $pdf = PDF::loadView('pdf.' . $type, ['data' => $data, 'detail' => $detail])
                ->setOptions(['defaultFont' => 'sans-serif']);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('data_' . $type . '.pdf');
        }

        // Cek dan ambil data dari tabel packaging dan detail-nya
        $data = DB::connection('mysql_esd')->table('packagings')
            ->join('packaging_details', 'packagings.id', '=', 'packaging_details.packaging_id')
            ->where('packagings.register_no', $search)
            ->select('packagings.*', 'packaging_details.*')
            ->get();
        if (count($data) > 0) {
            $type = "p";
            $detail = DB::connection('mysql_esd')->table('packagings')
                ->where('packagings.register_no', $search)
                ->first();
            $pdf = PDF::loadView('pdf.' . $type, ['data' => $data, 'detail' => $detail])
                ->setOptions(['defaultFont' => 'sans-serif']);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('data_' . $type . '.pdf');
        }

        // Cek dan ambil data dari tabel ionizers dan detail-nya
        $data = DB::connection('mysql_esd')->table('ionizers')
            ->join('ionizer_details', 'ionizers.id', '=', 'ionizer_details.ionizer_id')
            ->where('ionizers.register_no', $search)
            ->select('ionizers.*', 'ionizer_details.*')
            ->get();
        if (count($data) > 0) {
            $type = "i";
            $detail = DB::connection('mysql_esd')->table('ionizers')
                ->where('ionizers.register_no', $search)
                ->first();
            $pdf = PDF::loadView('pdf.' . $type, ['data' => $data, 'detail' => $detail])
                ->setOptions(['defaultFont' => 'sans-serif']);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('data_' . $type . '.pdf');
        }
    }
}