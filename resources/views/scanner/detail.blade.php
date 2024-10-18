@extends('template.template')

@section('title', 'SCAN QR CODE FOR SEARCH ESD MEASUREMENT')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5>Data Detail Measurement ESD
        </div>
        <div class="card-body">
            <a href="http://portal.siix-ems.co.id/mainMenu" class="btn btn-success mb-3">Back To Main Menu</a>
            <a href="{{ route('indexScanner') }}" class="btn btn-danger mb-3">Scan Ulang</a>
            <!-- @if ($type != '')
                <a href="/download-pdf?search={{ $search }}" class="btn btn-primary mb-3">Download PDF</a>
            @endif -->
            <div class="table-responsive">
                @if ($type == 'eg')
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Machine Name</th>
                                <th>:</th>
                                <td>{{ $detail->machine_name }}</td>
                            </tr>
                            <tr>
                                <th>Area</th>
                                <th>:</th>
                                <td>{{ $detail->area }}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <th>:</th>
                                <td>{{ $detail->location }}</td>
                            </tr>
                            <tr>
                                <th>Measurement Type</th>
                                <th>:</th>
                                <th>Equipment Ground</th>
                            </tr>
                            <tr>
                                <th>Frequency</th>
                                <th>:</th>
                                <th>Monthly</th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <tbody>
                            <h5 class="card-header text-center">STANDARD ESD OF EQUIPMENT GROUND</h5>
                                <tr>
                                    <th>Measurement Ohm</th>
                                    <th>:</th>
                                    <td>< 1.0 Ohm</td>
                                </tr>
                                <tr>
                                    <th>Measurement Volts</th>
                                    <th>:</th>
                                    <td>< 2.0 Volts</td>
                                </tr>
                            <h5 class="card-footer text-center">Doc No : QR-ADM-22-K024</h5>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                        <h5 class="card-header text-center">All Measurement Data</h5>
                            <tr>
                                <th>No</th>
                                <th>Measure Results ohm</th>
                                <th>Judgement ohm</th>
                                <th>Measure Results volts</th>
                                <th>Judgement volts</th>
                                <th>Remarks</th>
                                <th>Tech</th>
                                <th>Date</th>
                                <th>Next Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->measure_results_ohm }}</td>
                                    <td>
                                        @if ($d->judgement_ohm == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_ohm }}</span>
                                        @elseif ($d->judgement_ohm == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_ohm }}</span>
                                        @else
                                            {{ $d->judgement_ohm }}
                                        @endif
                                    </td>
                                    <td>{{ $d->measure_results_volts }}</td>
                                    <td>
                                        @if ($d->judgement_volts == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_volts }}</span>
                                        @elseif ($d->judgement_volts == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_volts }}</span>
                                        @else
                                            {{ $d->judgement_volts }}
                                        @endif
                                    </td>
                                    <td>{{ $d->remarks }}</td>
                                    @php
                                        $user = \App\Models\User::find($d->created_by);
                                    @endphp
                                    <td>{{ optional($user)->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d F Y') }}</td>
                                    <td>{{ $d->next_date ? \Carbon\Carbon::parse($d->next_date)->format('d F Y') : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($type == 'f')
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Register NO</th>
                                <th>:</th>
                                <td>{{ $detail->register_no }}</td>
                            </tr>
                            <tr>
                                <th>Area</th>
                                <th>:</th>
                                <td>{{ $detail->area }}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <th>:</th>
                                <td>{{ $detail->location }}</td>
                            </tr>
                            <tr>
                                <th>Measurement Type</th>
                                <th>:</th>
                                <th>Flooring</th>
                            </tr>
                            <tr>
                                <th>Frequency</th>
                                <th>:</th>
                                <th>Yearly</th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <tbody>
                            <h5 class="card-header text-center">STANDARD ESD OF FLOORING</h5>
                                <tr>
                                    <th>( B1 ) Point To Ground</th>
                                    <th>:</th>
                                    <td>< 1.00E+9 Ohm</td>
                                </tr>
                            <h5 class="card-footer text-center">Doc No : QR-ADM-22-K016</h5>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                        <h5 class="card-header text-center">All Measurement Data</h5>
                            <tr>
                                <th>No</th>
                                <th>B1 Scientific</th>
                                <th>Judgement</th>
                                <th>Remarks</th>
                                <th>Tech</th>
                                <th>Date</th>
                                <th>Next Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->b1_scientific }}</td>
                                    <td>
                                        @if ($d->judgement == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement }}</span>
                                        @elseif ($d->judgement == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement }}</span>
                                        @else
                                            {{ $d->judgement }}
                                        @endif
                                    </td>
                                    <td>{{ $d->remarks }}</td>
                                    @php
                                        $user = \App\Models\User::find($d->created_by);
                                    @endphp
                                    <td>{{ optional($user)->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d F Y') }}</td>
                                    <td>{{ $d->next_date ? \Carbon\Carbon::parse($d->next_date)->format('d F Y') : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($type == 'wd')
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Register NO</th>
                                <th>:</th>
                                <td>{{ $detail->register_no }}</td>
                            </tr>
                            <tr>
                                <th>Area</th>
                                <th>:</th>
                                <td>{{ $detail->area }}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <th>:</th>
                                <td>{{ $detail->location }}</td>
                            </tr>
                            <tr>
                                <th>Measurement Type</th>
                                <th>:</th>
                                <th>Worksurface</th>
                            </tr>
                            <tr>
                                <th>Frequency</th>
                                <th>:</th>
                                <th>Yearly</th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <tbody>
                            <h5 class="card-header text-center">STANDARD ESD OF Mat Resitivity Work Surface (Table, Rack and Trolley)</h5>
                                <tr>
                                    <th>( A1 ) Mat Surface Point (A) To Ground</th>
                                    <th>:</th>
                                    <td>< 1.00E+9 Ohm</td>
                                </tr>
                                <tr>
                                    <th>( A2 ) Mat Surface Static Field Voltage Point (V)</th>
                                    <th>:</th>
                                    <td>< 100 Volts</td>
                                </tr>
                            <h5 class="card-footer text-center">Doc No : QR-ADM-22-K014</h5>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                        <h5 class="card-header text-center">All Measurement Data</h5>
                            <tr>
                                <th>No</th>
                                <th>Item</th>
                                <th>A1 Scientific</th>
                                <th>Judgement A1</th>
                                <th>A2</th>
                                <th>Judgement A2</th>
                                <th>Remarks</th>
                                <th>Tech</th>
                                <th>Date</th>
                                <th>Next Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->item }}</td>
                                    <td>{{ $d->a1_scientific }}</td>
                                    <td>
                                        @if ($d->judgement_a1 == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_a1 }}</span>
                                        @elseif ($d->judgement_a1 == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_a1 }}</span>
                                        @else
                                            {{ $d->judgement_a1 }}
                                        @endif
                                    </td>
                                    <td>{{ $d->a2 }}</td>
                                    <td>
                                        @if ($d->judgement_a2 == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_a2 }}</span>
                                        @elseif ($d->judgement_a2 == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_a2 }}</span>
                                        @else
                                            {{ $d->judgement_a2 }}
                                        @endif
                                    </td>
                                    <td>{{ $d->remarks }}</td>
                                    @php
                                        $user = \App\Models\User::find($d->created_by);
                                    @endphp
                                    <td>{{ optional($user)->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d F Y') }}</td>
                                    <td>{{ $d->next_date ? \Carbon\Carbon::parse($d->next_date)->format('d F Y') : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($type == 'gm')
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Register NO</th>
                                <th>:</th>
                                <td>{{ $detail->register_no }}</td>
                            </tr>
                            <tr>
                                <th>Area</th>
                                <th>:</th>
                                <td>{{ $detail->area }}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <th>:</th>
                                <td>{{ $detail->location }}</td>
                            </tr>
                            <tr>
                                <th>Measurement Type</th>
                                <th>:</th>
                                <th>Ground Monitor Box</th>
                            </tr>
                            <tr>
                                <th>Frequency</th>
                                <th>:</th>
                                <th>Yearly</th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <tbody>
                            <h5 class="card-header text-center">STANDARD ESD OF GROUND MONITOR BOX</h5>
                                <tr>
                                    <th>G1</th>
                                    <th>:</th>
                                    <td>Periksa menggunakan Wave Distortion Monitor Verification Tester Putar selector ke arah High Pass, dan hubungkan grounding wire ke Terminal Grounding. LED Hijau akan menyala pada constant monitor (menandakan BAGUS / YES) Jika Tidak NO</td>
                                </tr>
                                <tr>
                                    <th>G2</th>
                                    <th>:</th>
                                    <td>Periksa menggunakan Wave Distortion Monitor Verification Tester Putar selector ke arah High Low, dan hubungkan grounding wire ke Terminal Grounding. LED Hijau akan menyala pada constant monitor (menandakan BAGUS / YES) Jika Tidak NO</td>
                                </tr>
                            <h5 class="card-footer text-center">Doc No : QR-ADM-22-K018</h5>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                        <h5 class="card-header text-center">All Measurement Data</h5>
                            <tr>
                                <th>No</th>
                                <th>G1</th>
                                <th>G2</th>
                                <th>Tech</th>
                                <th>Date</th>
                                <th>Next Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($d->g1 == 'YES')
                                            <span class="badge bg-success">{{ $d->g1 }}</span>
                                        @elseif ($d->g1 == 'NO')
                                            <span class="badge bg-danger">{{ $d->g1 }}</span>
                                        @else
                                            {{ $d->g1 }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->g2 == 'YES')
                                            <span class="badge bg-success">{{ $d->g2 }}</span>
                                        @elseif ($d->g2 == 'NO')
                                            <span class="badge bg-danger">{{ $d->g2 }}</span>
                                        @else
                                            {{ $d->g2 }}
                                        @endif
                                    </td>
                                    @php
                                        $user = \App\Models\User::find($d->created_by);
                                    @endphp
                                    <td>{{ optional($user)->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d F Y') }}</td>
                                    <td>{{ $d->next_date ? \Carbon\Carbon::parse($d->next_date)->format('d F Y') : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @elseif ($type == 'g')
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>SAP Code</th>
                                <th>:</th>
                                <td>{{ $detail->sap_code }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <th>:</th>
                                <td>{{ $detail->description }}</td>
                            </tr>
                            <tr>
                                <th>Delivery</th>
                                <th>:</th>
                                <td>{{ $detail->delivery }}</td>
                            </tr>
                            <tr>
                                <th>Measurement Type</th>
                                <th>:</th>
                                <th>Glove</th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <tbody>
                            <h5 class="card-header text-center">STANDARD ESD OF GLOVE</h5>
                                <tr>
                                    <th>( C1 ) Glove Point To Point</th>
                                    <th>:</th>
                                    <td>1.00E+5 - 1.00E+11 Ohm</td>
                                </tr>
                            <h5 class="card-footer text-center">Doc No : QR-ADM-24-K013</h5>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                        <h5 class="card-header text-center">All Measurement Data</h5>
                            <tr>
                                <th>No</th>
                                <th>C1 Scientific</th>
                                <th>Judgement</th>
                                <th>Remarks</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->c1_scientific }}</td>
                                    <td>
                                        @if ($d->judgement == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement }}</span>
                                        @elseif ($d->judgement == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement }}</span>
                                        @else
                                            {{ $d->judgement }}
                                        @endif
                                    </td>
                                    <td>{{ $d->remarks }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d F Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @elseif ($type == 'garment')
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>NIK</th>
                                <th>:</th>
                                <td>{{ $detail->user_login }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <th>:</th>
                                <td>{{ $detail->Display_Name }}</td>
                            </tr>
                            <tr>
                                <th>Measurement Type</th>
                                <th>:</th>
                                <th>Garment</th>
                            </tr>
                            <tr>
                                <th>Frequency</th>
                                <th>:</th>
                                <th>Yearly</th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <tbody>
                            <h5 class="card-header text-center">STANDARD ESD OF GARMENT</h5>
                                <tr>
                                    <th>( D1 ) Shirt Point To Point</th>
                                    <th>:</th>
                                    <td>1.00E+5 - 1.00E+11 Ohm</td>
                                </tr>
                                <tr>
                                    <th>( D2 ) Pants Point To Point</th>
                                    <th>:</th>
                                    <td>1.00E+5 - 1.00E+11 Ohm</td>
                                </tr>
                                <tr>
                                    <th>( D3 ) Cap Point To Point</th>
                                    <th>:</th>
                                    <td>1.00E+5 - 1.00E+11 Ohm</td>
                                </tr>
                                <tr>
                                    <th>( D4 ) Hijab Point To Point</th>
                                    <th>:</th>
                                    <td>1.00E+5 - 1.00E+11 Ohm</td>
                                </tr>
                            <h5 class="card-footer text-center">Doc No : QR-ADM-22-K020</h5>
                        </tbody>
                    </table>
                    <hr>
                    <!-- Tabel detail garment -->
                    <table class="table table-striped">
                        <thead>
                        <h5 class="card-header text-center">All Measurement Data</h5>
                            <tr>
                                <th>No</th>
                                <th>D1 Scientific</th>
                                <th>Judgement D1</th>
                                <th>D2 Scientific</th>
                                <th>Judgement D2</th>
                                <th>D3 Scientific</th>
                                <th>Judgement D3</th>
                                <th>D4 Scientific</th>
                                <th>Judgement D4</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->d1_scientific }}</td>
                                    <td>
                                        @if ($d->judgement_d1 == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_d1 }}</span>
                                        @elseif ($d->judgement_d1 == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_d1 }}</span>
                                        @else
                                            {{ $d->judgement_d1 }}
                                        @endif
                                    </td>
                                    <td>{{ $d->d2_scientific }}</td>
                                    <td>
                                        @if ($d->judgement_d2 == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_d2 }}</span>
                                        @elseif ($d->judgement_d2 == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_d2 }}</span>
                                        @else
                                            {{ $d->judgement_d2 }}
                                        @endif
                                    </td>
                                    <td>{{ $d->d3_scientific }}</td>
                                    <td>
                                        @if ($d->judgement_d3 == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_d3 }}</span>
                                        @elseif ($d->judgement_d3 == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_d3 }}</span>
                                        @else
                                            {{ $d->judgement_d3 }}
                                        @endif
                                    </td>
                                    <td>{{ $d->d4_scientific }}</td>
                                    <td>
                                        @if ($d->judgement_d4 == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_d4 }}</span>
                                        @elseif ($d->judgement_d4 == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_d4 }}</span>
                                        @else
                                            {{ $d->judgement_d4 }}
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d F Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">Data tidak tersedia</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @elseif ($type == 'sd')
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Register NO</th>
                                <th>:</th>
                                <td>{{ $detail->register_no }}</td>
                            </tr>
                            <tr>
                                <th>Area</th>
                                <th>:</th>
                                <td>{{ $detail->area }}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <th>:</th>
                                <td>{{ $detail->location }}</td>
                            </tr>
                            <tr>
                                <th>Measurement Type</th>
                                <th>:</th>
                                <th>Soldering Iron</th>
                            </tr>
                            <tr>
                                <th>Frequency</th>
                                <th>:</th>
                                <th>Yearly</th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <tbody>
                            <h5 class="card-header text-center">STANDARD ESD OF SOLDERING</h5>
                                <tr>
                                    <th>( E1 ) Tip Solder To Ground</th>
                                    <th>:</th>
                                    <td>< 10 Ohm</td>
                                </tr>
                            <h5 class="card-footer text-center">Doc No : QR-ADM-22-K022</h5>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                            <h5 class="card-header text-center">All Measurement Data</h5>
                            <tr>
                                <th>No</th>
                                <th>E1</th>
                                <th>Judgement</th>
                                <th>Remarks</th>
                                <th>Tech</th>
                                <th>Date</th>
                                <th>Next Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->e1 }}</td>
                                    <td>
                                        @if ($d->judgement == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement }}</span>
                                        @elseif ($d->judgement == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement }}</span>
                                        @else
                                            {{ $d->judgement }}
                                        @endif
                                    </td>
                                    <td>{{ $d->remarks }}</td>
                                    @php
                                        $user = \App\Models\User::find($d->created_by);
                                    @endphp
                                    <td>{{ optional($user)->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d F Y') }}</td>
                                    <td>{{ $d->next_date ? \Carbon\Carbon::parse($d->next_date)->format('d F Y') : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($type == 'p')
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Register NO</th>
                                <th>:</th>
                                <th>{{ $detail->register_no }}</th>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <th>:</th>
                                <th>{{ $detail->status }}</th>
                            </tr>
                            <tr>
                                <th>Measurement Type</th>
                                <th>:</th>
                                <th>Packaging</th>
                            </tr>
                            <tr>
                                <th>Frequency</th>
                                <th>:</th>
                                <th>Yearly</th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <tbody>
                            <h5 class="card-header text-center">STANDARD ESD OF PACKAGING</h5>
                                <tr>
                                    <th>( F1 ) Dissipative Packaging Point To Point</th>
                                    <th>:</th>
                                    <td>1.00E+4 - 1.00E+11 Ohm</td>
                                </tr>
                                <tr>
                                    <th>( F2 ) Surface static field voltage</th>
                                    <th>:</th>
                                    <td>( < +/- 100 Volts )</td>
                                </tr>
                            <h5 class="card-footer text-center">Doc No : QR-ADM-22-K023</h5>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                            <h5 class="card-header text-center">All Measurement Data</h5>
                            <tr>
                                <th>No</th>
                                <th>Item</th>
                                <th>F1 Scientific</th>
                                <th>Judgement F1</th>
                                <th>F2</th>
                                <th>Judgement F2</th>
                                <th>Remark</th>
                                <th>Tech</th>
                                <th>Date</th>
                                <th>Next Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->item }}</td>
                                    <td>{{ $d->f1_scientific }}</td>
                                    <td>
                                        @if ($d->judgement_f1 == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_f1 }}</span>
                                        @elseif ($d->judgement_f1 == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_f1 }}</span>
                                        @else
                                            {{ $d->judgement_f1 }}
                                        @endif
                                    </td>
                                    <td>{{ $d->f2 }}</td>
                                    <td>
                                        @if ($d->judgement_f2 == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_f2 }}</span>
                                        @elseif ($d->judgement_f2 == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_f2 }}</span>
                                        @else
                                            {{ $d->judgement_f2 }}
                                        @endif
                                    </td>
                                    <td>{{ $d->remarks }}</td>
                                    @php
                                        $user = \App\Models\User::find($d->created_by);
                                    @endphp
                                    <td>{{ optional($user)->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d F Y') }}</td>
                                    <td>{{ $d->next_date ? \Carbon\Carbon::parse($d->next_date)->format('d F Y') : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($type == 'i')
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Register NO</th>
                                <th>:</th>
                                <th>{{ $detail->register_no }}</th>
                            </tr>
                            <tr>
                                <th>Area</th>
                                <th>:</th>
                                <th>{{ $detail->area }}</th>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <th>:</th>
                                <th>{{ $detail->location }}</th>
                            </tr>
                            <tr>
                                <th>Measurement Type</th>
                                <th>:</th>
                                <th>Ionization</th>
                            </tr>
                            <tr>
                                <th>Frequency</th>
                                <th>:</th>
                                <th>Monthly</th>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <tbody>
                            <h5 class="card-header text-center">STANDARD ESD OF IONIZATION</h5>
                                <tr>
                                    <th>( PM 1 )</th>
                                    <th>:</th>
                                    <td>Periksa lampu H.V Berkedip? Jika lampu berkedip, segera lakukan inspeksi.</td>
                                </tr>
                                <tr>
                                    <th>( PM 2 )</th>
                                    <th>:</th>
                                    <td>Periksa dan bersihkan jarum elektroda discharge? OK/NO</td>
                                </tr>
                                <tr>
                                    <th>( PM 3 )</th>
                                    <th>:</th>
                                    <td>Clean UP Filter and Fan? YES/NO. Lakukan verifikasi setelah PM (Preventive Maintenance).</td>
                                </tr>
                                <tr>
                                    <th>( C1 )</th>
                                    <th>:</th>
                                    <td>Measure Charge Decay Time (-), From 1.000V To 100V < 8.0 Sec.</td>
                                </tr>
                                <tr>
                                    <th>( C2 )</th>
                                    <th>:</th>
                                    <td>Measure Charge Decay Time (-), From 1.000V To 100V < 8.0 Sec.</td>
                                </tr>
                                <tr>
                                    <th>( C3 )</th>
                                    <th>:</th>
                                    <td>Measure Offset Voltage, Volts Swing < + / - 35V , 30 Sec.</td>
                                </tr>
                            <h5 class="card-footer text-center">Doc No : QR-ADM-22-K017</h5>
                        </tbody>
                    </table>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                            <h5 class="card-header text-center">All Measurement Data</h5>
                            <tr>
                                <th>No</th>
                                <th>PM 1</th>
                                <th>PM 2</th>
                                <th>PM 3</th>
                                <th>C1</th>
                                <th>C1 Judgement</th>
                                <th>C2</th>
                                <th>C2 Judgement</th>
                                <th>C3</th>
                                <th>C3 Judgement</th>
                                <th>Remark</th>
                                <th>Tech</th>
                                <th>Date</th>
                                <th>Next Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($d->pm_1 == 'NO')
                                            <span class="badge bg-success">{{ $d->pm_1 }}</span>
                                        @elseif ($d->pm_1 == 'FLASH')
                                            <span class="badge bg-danger">{{ $d->pm_1 }}</span>
                                        @else
                                            {{ $d->pm_1 }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->pm_2 == 'OK')
                                            <span class="badge bg-success">{{ $d->pm_2 }}</span>
                                        @elseif ($d->pm_2 == 'NO')
                                            <span class="badge bg-danger">{{ $d->pm_2 }}</span>
                                        @else
                                            {{ $d->pm_2 }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->pm_3 == 'YES')
                                            <span class="badge bg-success">{{ $d->pm_3 }}</span>
                                        @elseif ($d->pm_3 == 'NO')
                                            <span class="badge bg-danger">{{ $d->pm_3 }}</span>
                                        @else
                                            {{ $d->pm_3 }}
                                        @endif
                                    </td>
                                    <td>{{ $d->c1 }}</td>
                                    <td>
                                        @if ($d->judgement_c1 == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_c1 }}</span>
                                        @elseif ($d->judgement_c1 == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_c1 }}</span>
                                        @else
                                            {{ $d->judgement_c1 }}
                                        @endif
                                    </td>
                                    <td>{{ $d->c2 }}</td>
                                    <td>
                                        @if ($d->judgement_c2 == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_c2 }}</span>
                                        @elseif ($d->judgement_c2 == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_c2 }}</span>
                                        @else
                                            {{ $d->judgement_c2 }}
                                        @endif
                                    </td>
                                    <td>{{ $d->c3 }}</td>
                                    <td>
                                        @if ($d->judgement_c3 == 'OK')
                                            <span class="badge bg-success">{{ $d->judgement_c3 }}</span>
                                        @elseif ($d->judgement_c3 == 'NG')
                                            <span class="badge bg-danger">{{ $d->judgement_c3 }}</span>
                                        @else
                                            {{ $d->judgement_c3 }}
                                        @endif
                                    </td>
                                    <td>{{ $d->remarks }}</td>
                                    @php
                                        $user = \App\Models\User::find($d->created_by);
                                    @endphp
                                    <td>{{ optional($user)->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d F Y') }}</td>
                                    <td>{{ $d->next_date ? \Carbon\Carbon::parse($d->next_date)->format('d F Y') : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h3>Data tidak tersedia</h3>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
