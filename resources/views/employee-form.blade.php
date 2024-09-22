<!-- resources/views/employee-form.blade.php -->
@extends('layouts.app') <!-- Adjust the layout as needed -->

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Employee Form</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('employee.form.submit') }}">
        @csrf

        <!-- NIK Field -->
        <div class="mb-4">
            <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
            <select
                id="nik"
                name="nik"
                required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            >
                <option value="">Select NIK</option>
                @foreach ($employees as $value => $displayName)
                    <option value="{{ $value }}">{{ $displayName }}</option>
                @endforeach
            </select>
        </div>

        <!-- Name Field (Disabled) -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input
                id="name"
                name="name"
                type="text"
                required
                disabled
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            />
        </div>

        <!-- Department Field (Disabled) -->
        <div class="mb-4">
            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
            <input
                id="department"
                name="department"
                type="text"
                required
                disabled
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            />
        </div>

        <!-- Shift Field -->
        <div class="mb-4">
            <label for="shift" class="block text-sm font-medium text-gray-700">Shift</label>
            <div class="flex space-x-4">
                @foreach(['Non Shift', 'Shift 1', 'Shift 2', 'Shift 3'] as $shift)
                    <div class="flex items-center">
                        <input
                            id="shift_{{ $shift }}"
                            name="shift"
                            type="radio"
                            value="{{ $shift }}"
                            class="mr-2"
                        />
                        <label for="shift_{{ $shift }}" class="text-sm">{{ $shift }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Alasan Terlambat Field -->
        <div class="mb-4">
            <label for="alasan_terlambat" class="block text-sm font-medium text-gray-700">Alasan Terlambat</label>
            <select
                id="alasan_terlambat"
                name="alasan_terlambat"
                required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            >
                <option value="">Select Reason</option>
                @foreach([
                    'Macet Lalulintas' => 'Macet Lalulintas',
                    'Masalah Kendaraan' => 'Masalah Kendaraan',
                    'Telat Berangkat' => 'Telat Berangkat',
                    'Keperluan Pribadi' => 'Keperluan Pribadi',
                    'Keperluan Keluarga' => 'Keperluan Keluarga'
                ] as $key => $reason)
                    <option value="{{ $key }}">{{ $reason }}</option>
                @endforeach
            </select>
        </div>

        <!-- Nama Security Field -->
        <div class="mb-4">
            <label for="nama_security" class="block text-sm font-medium text-gray-700">Nama Security</label>
            <input
                id="nama_security"
                name="nama_security"
                type="text"
                required
                maxLength="255"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            />
        </div>

        <!-- Tanggal Field -->
        <div class="mb-4">
            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input
                id="tanggal"
                name="tanggal"
                type="date"
                required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            />
        </div>

        <!-- Jam Field -->
        <div class="mb-4">
            <label for="jam" class="block text-sm font-medium text-gray-700">Jam</label>
            <input
                id="jam"
                name="jam"
                type="time"
                required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            />
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Submit
        </button>
    </form>
</div>
@endsection
