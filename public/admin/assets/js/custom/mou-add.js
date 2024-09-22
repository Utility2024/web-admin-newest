document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('buttonAddMou').addEventListener('click', function () {
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
                document.getElementById('formAddMou').submit();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('buttonUpdateMou').addEventListener('click', function () {
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
                document.getElementById('formUpdateMou').submit();
            }
        });
    });
});

function confirmDeleteMou(event) {
    event.preventDefault();
    const id = event.currentTarget.getAttribute('data-id');
    const role = event.currentTarget.getAttribute('data-role');
    console.log(id);
    let url = "/manajemen/mou/delete-action";
    if (role === "mou") {
        url = "/mou/mou/delete-action";
    }
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