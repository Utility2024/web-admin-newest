document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buttonUpdateProcurementPlanning').addEventListener('click', function() {
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
                document.getElementById('formUpdateProcurementPlanning').submit();
            }
        });
    });
});