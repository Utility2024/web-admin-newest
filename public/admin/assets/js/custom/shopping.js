function confirmDeleteShoppingType(event) {
    event.preventDefault();
    const id = event.currentTarget.getAttribute('data-id');
    console.log(id);
    const url = "/manajemen/shopping-type/delete-action";
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
    document.getElementById('buttonAddShoppingType').addEventListener('click', function() {
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
                document.getElementById('formAddShoppingType').submit();
            }
        });
    });
});

// alert
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.buttonUpdateShoppingType');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
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
                    document.getElementById('formUpdateShoppingType' + itemId).submit();
                }
            });
        });
    });
});