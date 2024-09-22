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

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        events: 'holidays-data',
        dateClick: function(info) {
            clearForm();
            document.getElementById('holiday-date').value = info.dateStr;
            var myModal = new bootstrap.Modal(document.getElementById('holidayModal'), {});
            myModal.show();
        },
        eventClick: function(info) {
            clearForm();
            var event = info.event;
            document.getElementById('holiday-id').value = event.id;
            document.getElementById('holiday-date').value = event.startStr;
            document.getElementById('holiday-name').value = event.title;
            var myModal = new bootstrap.Modal(document.getElementById('holidayModal'), {});
            myModal.show();
            document.getElementById('deleteHoliday').style.display = 'block';
        }
    });
    calendar.render();

    document.getElementById('saveHoliday').addEventListener('click', function() {
        var id = document.getElementById('holiday-id').value;
        var date = document.getElementById('holiday-date').value;
        var name = document.getElementById('holiday-name').value;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        if (id) {
            // Update existing holiday
            fetch('holidays/' + id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    date: date,
                    name: name
                })
            }).then(response => {
                if (response.ok) {
                    calendar.refetchEvents();
                    var myModalEl = document.getElementById('holidayModal');
                    var modal = bootstrap.Modal.getInstance(myModalEl);
                    modal.hide();
                    Swal.fire('Success', 'Data berhasil diubah!', 'success');
                }
            });
        } else {
            // Create new holiday
            fetch('holidays', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    date: date,
                    name: name
                })
            }).then(response => {
                if (response.ok) {
                    calendar.refetchEvents();
                    var myModalEl = document.getElementById('holidayModal');
                    var modal = bootstrap.Modal.getInstance(myModalEl);
                    modal.hide();
                    Swal.fire('Success', 'Data berhasil ditambahkan!', 'success');
                }
            });
        }
    });

    document.getElementById('deleteHoliday').addEventListener('click', function() {
        var id = document.getElementById('holiday-id').value;

        fetch('holidays/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        }).then(response => {
            if (response.ok) {
                calendar.refetchEvents();
                var myModalEl = document.getElementById('holidayModal');
                var modal = bootstrap.Modal.getInstance(myModalEl);
                modal.hide();
                Swal.fire('Success', 'Data berhasil dihapus!', 'success');
            }
        });
    });

    function clearForm() {
        document.getElementById('holidayForm').reset();
        document.getElementById('holiday-id').value = '';
        document.getElementById('deleteHoliday').style.display = 'none';
    }
});