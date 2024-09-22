document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buttonAddUser').addEventListener('click', function() {
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
                document.getElementById('formAddUser').submit();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buttonUpdateUser').addEventListener('click', function() {
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
                document.getElementById('formUpdateUser').submit();
            }
        });
    });
});

function confirmDeleteUser(event) {
    event.preventDefault();
    const id = event.currentTarget.getAttribute('data-id');
    console.log(id);
    const url = "/administrator/user/delete-action";
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