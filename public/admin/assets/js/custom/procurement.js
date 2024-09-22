$(document).ready(function () {
    var procurementId = $('#id_procurementId').val();
    refreshProcurementStatuses(procurementId);
});

function confirmGenerateNumber() {
    // Ambil nilai id dan code dari atribut data pada tombol
    var id = $('#buttonGenerateNumber').data('id');
    var code = $('#buttonGenerateNumber').data('code');

    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah anda yakin akan melakukan generate nomor?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            generateNumber(id, code);
        }
    });
}

function generateNumber(id, code) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('#loadingOverlay').show();
    var procurementId = $('#id_procurementId').val();
    $.ajax({
        url: '/manajemen/procurement/generate-number/procurement',
        type: 'POST',
        data: {
            _token: csrfToken,
            code: code,
            id: id
        },
        success: function (response) {
            $('#loadingOverlay').hide();
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: response.message
            }).then(function () {
                window.location.reload();
            });
        },
        error: function (xhr, status, error) {
            $('#loadingOverlay').hide();
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: response.message
            }).then(function () {
                window.location.reload();
            });
            console.error('AJAX Error: ' + status + error);
        }
    });
}

function confirmVerifiedFile() {
    // Ambil nilai id dan code dari atribut data pada tombol
    var id = $('#buttonVerifiedFile').data('id');

    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah anda yakin akan memverifikasi file?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            verifiedFileAction(id);
        }
    });
}

function verifiedFileAction(id) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('#loadingOverlay').show();
    var procurementId = $('#id_procurementId').val();
    $.ajax({
        url: '/manajemen/procurement/offering-negotiation/verified',
        type: 'PUT',
        data: {
            _token: csrfToken,
            id_procurement_file: id
        },
        success: function (response) {
            $('#loadingOverlay').hide();
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: response.message
            }).then(function () {
                window.location.reload();
            });
        },
        error: function (xhr, status, error) {
            $('#loadingOverlay').hide();
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: response.message
            }).then(function () {
                window.location.reload();
            });
            console.error('AJAX Error: ' + status + error);
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    var filesEditModal = document.getElementById('filesEdit');
    filesEditModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var number = button.getAttribute('data-number');
        var type = button.getAttribute('data-type');
        var idNumber = button.getAttribute('data-id-number');

        var idInput = filesEditModal.querySelector('#id_procurement_file');
        var numberInput = filesEditModal.querySelector('#offering_number');
        var idNumberInput = filesEditModal.querySelector('#id_procurement_file_number');
        var typeInput = filesEditModal.querySelector('#type');
        var numberInput = filesEditModal.querySelector('#offering_number');

        idInput.value = id;
        numberInput.value = number;
        typeInput.value = type;
        idNumberInput.value = idNumber;
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var filesEditModal = document.getElementById('productEdit');
    filesEditModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        var price = button.getAttribute('data-price');

        var idInput = filesEditModal.querySelector('#id_procurement_product');
        var nameInput = filesEditModal.querySelector('#name');
        var basePriceInput = filesEditModal.querySelector('#base_price');

        idInput.value = id;
        nameInput.value = name;
        basePriceInput.value = price;
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var filesEditModal = document.getElementById('offerDeadlineEdit');
    filesEditModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id_procurement_product = button.getAttribute('data-id');
        var offer_deadline = button.getAttribute('data-date');

        var idInput = filesEditModal.querySelector('#id_procurement');
        var deadlineInput = filesEditModal.querySelector('#offer_deadline');

        idInput.value = id_procurement_product;
        deadlineInput.value = offer_deadline;
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var filesEditModal = document.getElementById('deliveryDeadlineEdit');
    filesEditModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id_procurement_product = button.getAttribute('data-id');
        var delivery_deadline = button.getAttribute('data-date');

        var idInput = filesEditModal.querySelector('#id_procurement');
        var deadlineInput = filesEditModal.querySelector('#delivery_deadline');

        idInput.value = id_procurement_product;
        deadlineInput.value = delivery_deadline;
    });
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buttonAddProcurementPlanning').addEventListener('click', function() {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah anda yakin akan menyimpan data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formAddProcurementPlanning').submit();
            }
        });
    });
});

function confirmDeletePhoto(id) {

    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah anda yakin akan menghapus bukti foto pengadaan?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            deletePhotoProcurement(id);
        }
    });
}

function deletePhotoProcurement(id) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('#loadingOverlay').show();
    var procurementId = $('#id_procurementId').val();
    $.ajax({
        url: '/manajemen/procurement/delete-photo-procurement',
        type: 'DELETE',
        data: {
            _token: csrfToken,
            id: id
        },
        success: function (response) {
            $('#loadingOverlay').hide();
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: response.message
            }).then(function () {
                window.location.reload();
            });
        },
        error: function (xhr, status, error) {
            $('#loadingOverlay').hide();
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: response.message
            }).then(function () {
                window.location.reload();
            });
            console.error('AJAX Error: ' + status + error);
        }
    });
}