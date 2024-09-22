// untuk get data error atau success
const flashdata = $('.flash-data').data('flashdata');

if (flashdata == 'successAdd') {
    Swal.fire({
        title: 'Berhasil',
        text: 'Data berhasil ditambahkan',
        icon: 'success'
    });
}

if (flashdata == 'errorAdd') {
    Swal.fire({
        title: 'Gagal',
        text: 'Data gagal ditambahkan',
        icon: 'error'
    });
}

if (flashdata == 'successUpdate') {
    Swal.fire({
        title: 'Berhasil',
        text: 'Data berhasil diubah',
        icon: 'success'
    });
}

if (flashdata == 'errorUpdate') {
    Swal.fire({
        title: 'Gagal',
        text: 'Data gagal diubah',
        icon: 'error'
    });
}

if (flashdata == 'successDelete') {
    Swal.fire({
        title: 'Berhasil',
        text: 'Data berhasil dihapus',
        icon: 'success'
    });
}

if (flashdata == 'errorDelete') {
    Swal.fire({
        title: 'Gagal',
        text: 'Data gagal dihapus',
        icon: 'error'
    });
}

if (flashdata == 'errorAddExistingData') {
    Swal.fire({
        title: 'Gagal',
        text: 'Data sudah terdaftar di dalam database',
        icon: 'error'
    });
}

if (flashdata == 'passwordNotMatch') {
    Swal.fire({
        title: 'Gagal',
        text: 'Password tidak valid.',
        icon: 'error'
    });
}

if (flashdata == 'passwordMin8Char') {
    Swal.fire({
        title: 'Gagal',
        text: 'Password minimal 8 karakter.',
        icon: 'error'
    });
}

if (flashdata == 'passwordHaveSpace') {
    Swal.fire({
        title: 'Gagal',
        text: 'Password dilarang menggunakan spasi.',
        icon: 'error'
    });
}

if (flashdata == 'userAlreadyRegister') {
    Swal.fire({
        title: 'Gagal',
        text: 'Username sudah terdaftar, gunakan username lain.',
        icon: 'error'
    });
}

if (flashdata == 'usernameHaveSpace') {
    Swal.fire({
        title: 'Gagal',
        text: 'Username dilarang menggunakan spasi.',
        icon: 'error'
    });
}

if (flashdata == 'emptyField') {
    Swal.fire({
        title: 'Gagal',
        text: 'Formulir harus diisi semua.',
        icon: 'error'
    });
}

if (flashdata == 'passwordNotMatch') {
    Swal.fire({
        title: 'Gagal',
        text: 'Password tidak valid.',
        icon: 'error'
    });
}

if (flashdata == 'passwordMin8Char') {
    Swal.fire({
        title: 'Gagal',
        text: 'Password minimal 8 karakter.',
        icon: 'error'
    });
}

if (flashdata == 'passwordHaveSpace') {
    Swal.fire({
        title: 'Gagal',
        text: 'Password dilarang menggunakan spasi.',
        icon: 'error'
    });
}

if (flashdata == 'deleteErrorRelationData') {
    Swal.fire({
        title: 'Gagal',
        text: 'Data gagal dihapus, terdapat data terkait',
        icon: 'error'
    });
}

if (flashdata == 'incompleteData') {
    Swal.fire({
        title: 'Perhatian',
        text: 'Data rencana pengadaan belum lengkap. Segera lengkapi data pada fitur edit',
        icon: 'warning'
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buttonUpdateProfile').addEventListener('click', function() {
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
                document.getElementById('formUdpateUser').submit();
            }
        });
    });
});

function fetchUnreadNotifications() {
    fetch('/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            document.getElementById('notification-count').innerHTML = `<small>${data.unread_count}</small>`;
        })
        .catch(error => console.error('Error fetching notifications:', error));
}

// Fetch notifications every 10 seconds
setInterval(fetchUnreadNotifications, 10000);

// Initial fetch
fetchUnreadNotifications();

$(document).ready(function() {
    var role = $('#role').val();

    $('#notificationButton').hover(function() {
        // Fetch notifications via AJAX
        $.ajax({
            url: '/notifications/data', // Adjust to your API endpoint
            method: 'GET',
            success: function(response) {
                $('#notification-list').empty();
                if (response.notifications.length > 0) {
                    response.notifications.forEach(function(notification) {
                        $('#notification-list').append(
                            `<li class="list-group-item d-flex justify-content-between align-items-center mt-2">
                        ${notification.message}
                        <a href="/${role}/${notification.cta_url}" class="btn btn-primary btn-sm">Detail</a>
                    </li>`
                        );
                    });
                } else {
                    $('#notification-list').append(
                        `<li class="list-group-item">No new notifications</li>`
                    );
                }
                $('#notificationModal').modal('show');
            },
            error: function() {
                $('#notification-list').empty();
                $('#notification-list').append(
                    `<li class="list-group-item">Failed to fetch notifications</li>`
                );
                $('#notificationModal').modal('show');
            }
        });
    });
});