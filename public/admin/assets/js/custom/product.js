
// alert
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('buttonAddProduct').addEventListener('click', function () {
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
                document.getElementById('formAddProduct').submit();
            }
        });
    });
});
// alert
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('buttonAddBulkProduct').addEventListener('click', function () {
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
                document.getElementById('formAddBulkProduct').submit();
            }
        });
    });
});
function confirmDeleteProduct(event) {
    event.preventDefault();
    const id = event.currentTarget.getAttribute('data-id');
    console.log(id);
    const url = "/manajemen/vendor/product/delete-action";
    console.log(url);
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menghapus data?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url + "/" + id;
        }
    });
}

// alert
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buttonUpdateProduct').addEventListener('click', function() {
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
                document.getElementById('formUpdateProduct').submit();
            }
        });
    });
});