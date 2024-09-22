document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buttonAddVendor').addEventListener('click', function() {
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
                document.getElementById('formAddVendor').submit();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buttonAddProduct').addEventListener('click', function() {
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

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buttonAddBulkProduct').addEventListener('click', function() {
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

$(document).ready(function() {
    function fetchProducts(url) {
        $.ajax({
            url: url,
            method: 'GET',
            data: $('#search-form').serialize(),
            success: function(response) {
                updateTable(response.dataProducts, response.current_page, response.per_page);
                $('#pagination-links').html(response.pagination);
            }
        });
    }

    function formatRupiah(value) {
        let formatted = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        return 'Rp. ' + formatted;
    }

    function updateTable(products, currentPage, perPage) {
        let tbody = $('#product-tbody');
        tbody.empty();
        $.each(products, function(index, item) {
            let rowNumber = (currentPage - 1) * perPage + index + 1;
            tbody.append(`
            <tr>
                <th scope="row">${rowNumber}</th>
                <td>${item.code}</td>
                <td>${item.name}</td>
                <td>${item.unit}</td>
                <td>${formatRupiah(item.base_price)}</td>
                <td>${item.min}</td>
                <td>${item.max}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="/manajemen/vendor/product/form-update/${item.id_vendor_product}" class="btn btn-success"><i class="ti ti-edit"></i></a>
                        <a data-id="${item.id_vendor_product}" onclick="confirmDeleteProduct(event)" type="button" class="btn btn-danger"><i class="ti ti-trash-x-filled"></i></a>
                    </div>
                </td>
            </tr>
        `);
        });
    }

    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        fetchProducts("{{ route('detailVendor', $data->id_vendor) }}");
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        fetchProducts(url);
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

// alert
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('buttonUpdateVendor').addEventListener('click', function() {
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
                document.getElementById('formUpdateVendor').submit();
            }
        });
    });
});

function confirmDeleteVendor(event) {
    event.preventDefault();
    const id = event.currentTarget.getAttribute('data-id');
    console.log(id);
    const url = "/manajemen/vendor/delete-action";
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
    document.getElementById('buttonAddBulkVendor').addEventListener('click', function() {
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
                document.getElementById('formAddBulkVendor').submit();
            }
        });
    });
});