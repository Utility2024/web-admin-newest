document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('buttonAddProcurement').addEventListener('click', function () {
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
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var id_procurement = document.getElementById('procurementId').value;
                var code = document.getElementById('code').value;
                var id_procurement_planning = document.getElementById('id_procurement_planning').value;
                var planning_officer = document.getElementById('planning_officer') ? document.getElementById('planning_officer').value : null;
                var number_sk = document.getElementById('number_sk') ? document.getElementById('number_sk').value : null;
                var date_sk = document.getElementById('date_sk') ? document.getElementById('date_sk').value : null;
                var executor_officer = document.getElementById('executor_officer').value;
                var pjkp = document.getElementById('pjkp') ? document.getElementById('pjkp').value : null;
                var tkp_leader = document.getElementById('tkp_leader') ? document.getElementById('tkp_leader').value : null;
                var tkp_secretary = document.getElementById('tkp_secretary') ? document.getElementById('tkp_secretary').value : null;
                var tkp_member_1 = document.getElementById('tkp_member_1') ? document.getElementById('tkp_member_1').value : null;
                var tkp_member_2 = document.getElementById('tkp_member_2') ? document.getElementById('tkp_member_2').value : null;
                var tkp_member_3 = document.getElementById('tkp_member_3') ? document.getElementById('tkp_member_3').value : null;
                var tphp_leader = document.getElementById('tphp_leader') ? document.getElementById('tphp_leader').value : null;
                var tphp_secretary = document.getElementById('tphp_secretary') ? document.getElementById('tphp_secretary').value : null;
                var tphp_member_1 = document.getElementById('tphp_member_1') ? document.getElementById('tphp_member_1').value : null;
                var tphp_member_2 = document.getElementById('tphp_member_2') ? document.getElementById('tphp_member_2').value : null;
                var tphp_member_3 = document.getElementById('tphp_member_3') ? document.getElementById('tphp_member_3').value : null;
                var supervisor_unit = document.getElementById('supervisor_unit') ? document.getElementById('supervisor_unit').value : null;
                var supervisor_leader_unit = document.getElementById('supervisor_leader_unit') ? document.getElementById('supervisor_leader_unit').value : null;
                var offer_deadline = document.getElementById('offer_deadline').value;
                var delivery_deadline = document.getElementById('delivery_deadline').value;
                var vendor = document.getElementById('vendorSelect').value;

                $.ajax({
                    url: '/manajemen/procurement/add-action',
                    type: 'POST', // Make sure to specify the request type
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: JSON.stringify({
                        id_procurement: id_procurement,
                        code: code,
                        id_procurement_planning: id_procurement_planning,
                        planning_officer: planning_officer,
                        number_sk: number_sk,
                        date_sk: date_sk,
                        executor_officer: executor_officer,
                        pjkp: pjkp,
                        tkp_leader: tkp_leader,
                        tkp_secretary: tkp_secretary,
                        tkp_member_1: tkp_member_1,
                        tkp_member_2: tkp_member_2,
                        tkp_member_3: tkp_member_3,
                        tphp_leader: tphp_leader,
                        tphp_secretary: tphp_secretary,
                        tphp_member_1: tphp_member_1,
                        tphp_member_2: tphp_member_2,
                        tphp_member_3: tphp_member_3,
                        supervisor_unit: supervisor_unit,
                        supervisor_leader_unit: supervisor_leader_unit,
                        offer_deadline: offer_deadline,
                        delivery_deadline: delivery_deadline,
                        vendor: vendor
                    }),
                    beforeSend: function() {
                        $('#loadingOverlay').show();
                    },
                    success: function () {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Data berhasil ditambahkan',
                            icon: 'success'
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: 'Gagal',
                            text: 'Data gagal ditambahkan',
                            icon: 'error'
                        });
                        var response = xhr.responseJSON;
                        if (response.status === 'error') {
                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').remove();

                            $.each(response.errors, function(field, messages) {
                                var input = $('input[name=' + field + ']');
                                if (input.length) {
                                    input.addClass('is-invalid');
                                    input.after('<div class="invalid-feedback">' + messages.join('<br>') + '</div>');
                                } else {
                                    var select = $('select[name=' + field + ']');
                                    if (select.length) {
                                        select.addClass('is-invalid');
                                        select.after('<div class="invalid-feedback">' + messages.join('<br>') + '</div>');
                                    }
                                }
                            });
                        }
                    },
                    complete: function() {
                        $('#loadingOverlay').hide();
                    }
                });
                return false;
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('buttonUpdateProcurement').addEventListener('click', function () {
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
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var id_procurement = document.getElementById('procurementId').value;
                var code = document.getElementById('code').value;
                var id_procurement_planning = document.getElementById('id_procurement_planning').value;
                var planning_officer = document.getElementById('planning_officer') ? document.getElementById('planning_officer').value : null;
                var number_sk = document.getElementById('number_sk') ? document.getElementById('number_sk').value : null;
                var date_sk = document.getElementById('date_sk') ? document.getElementById('date_sk').value : null;
                var executor_officer = document.getElementById('executor_officer').value;
                var pjkp = document.getElementById('pjkp') ? document.getElementById('pjkp').value : null;
                var tkp_leader = document.getElementById('tkp_leader') ? document.getElementById('tkp_leader').value : null;
                var tkp_secretary = document.getElementById('tkp_secretary') ? document.getElementById('tkp_secretary').value : null;
                var tkp_member_1 = document.getElementById('tkp_member_1') ? document.getElementById('tkp_member_1').value : null;
                var tkp_member_2 = document.getElementById('tkp_member_2') ? document.getElementById('tkp_member_2').value : null;
                var tkp_member_3 = document.getElementById('tkp_member_3') ? document.getElementById('tkp_member_3').value : null;
                var tphp_leader = document.getElementById('tphp_leader') ? document.getElementById('tphp_leader').value : null;
                var tphp_secretary = document.getElementById('tphp_secretary') ? document.getElementById('tphp_secretary').value : null;
                var tphp_member_1 = document.getElementById('tphp_member_1') ? document.getElementById('tphp_member_1').value : null;
                var tphp_member_2 = document.getElementById('tphp_member_2') ? document.getElementById('tphp_member_2').value : null;
                var tphp_member_3 = document.getElementById('tphp_member_3') ? document.getElementById('tphp_member_3').value : null;
                var supervisor_unit = document.getElementById('supervisor_unit') ? document.getElementById('supervisor_unit').value : null;
                var supervisor_leader_unit = document.getElementById('supervisor_leader_unit') ? document.getElementById('supervisor_leader_unit').value : null;
                var offer_deadline = document.getElementById('offer_deadline').value;
                var delivery_deadline = document.getElementById('delivery_deadline').value;
                var vendor = document.getElementById('vendorSelect').value;

                $.ajax({
                    url: '/manajemen/procurement/update-action',
                    type: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: JSON.stringify({
                        id_procurement: id_procurement,
                        code: code,
                        id_procurement_planning: id_procurement_planning,
                        planning_officer: planning_officer,
                        number_sk: number_sk,
                        date_sk: date_sk,
                        executor_officer: executor_officer,
                        pjkp: pjkp,
                        tkp_leader: tkp_leader,
                        tkp_secretary: tkp_secretary,
                        tkp_member_1: tkp_member_1,
                        tkp_member_2: tkp_member_2,
                        tkp_member_3: tkp_member_3,
                        tphp_leader: tphp_leader,
                        tphp_secretary: tphp_secretary,
                        tphp_member_1: tphp_member_1,
                        tphp_member_2: tphp_member_2,
                        tphp_member_3: tphp_member_3,
                        supervisor_unit: supervisor_unit,
                        supervisor_leader_unit: supervisor_leader_unit,
                        offer_deadline: offer_deadline,
                        delivery_deadline: delivery_deadline,
                        vendor: vendor
                    }),
                    beforeSend: function() {
                        $('#loadingOverlay').show();
                    },
                    success: function () {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Data berhasil ditambahkan',
                            icon: 'success'
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: 'Gagal',
                            text: 'Data gagal ditambahkan',
                            icon: 'error'
                        });
                        var response = xhr.responseJSON;
                        if (response.status === 'error') {
                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').remove();

                            $.each(response.errors, function(field, messages) {
                                var input = $('input[name=' + field + ']');
                                if (input.length) {
                                    input.addClass('is-invalid');
                                    input.after('<div class="invalid-feedback">' + messages.join('<br>') + '</div>');
                                } else {
                                    var select = $('select[name=' + field + ']');
                                    if (select.length) {
                                        select.addClass('is-invalid');
                                        select.after('<div class="invalid-feedback">' + messages.join('<br>') + '</div>');
                                    }
                                }
                            });
                        }
                    },
                    complete: function() {
                        $('#loadingOverlay').hide();
                    }
                });
                return false;
            }
        });
    });
});

$(document).ready(function () {
    var procurementId = $('#procurementId').val();
    refreshProcurementProducts(procurementId);
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    function fetchProducts() {
        var vendorId = $('#vendorSelect').val();
        var searchTerm = $('#searchTerm').val();
        var procurementId = $('#procurementId').val();

        if (vendorId) {
            $.ajax({
                url: '/manajemen/procurement/get-products-by-vendor/' + vendorId,
                type: 'GET',
                data: {
                    search: searchTerm
                },
                dataType: 'json',
                success: function (data) {
                    $('#productTable tbody').empty();
                    $.each(data, function (key, product) {
                        var addToCartUrl = '/procurement/add/product/' + product.id + '/vendor/' + vendorId;
                        var formattedPrice = formatRupiah(product.base_price, 'Rp. ');
                        $('#productTable tbody').append(
                            '<tr>' +
                            '<td>' + product.name + ' - (' + formattedPrice + '/' + product.unit + ')</td>' +
                            '<td><button class="btn btn-success btn-sm add-to-cart" data-id="' + product.id_vendor_product + '" data-vendor="' + vendorId + '"data-procurement="' + procurementId + '"><i class="ti ti-plus"></i></button></td>' +
                            '</tr>'
                        );
                    });
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);
                }
            });
        } else {
            $('#productTable tbody').empty();
        }
    }

    $(document).on('click', '.add-to-cart', function () {
        var productId = $(this).data('id');
        var vendorId = $(this).data('vendor');
        var procurementId = $(this).data('procurement');
        $('#loadingOverlay').show(); // Show loading overlay
        $.ajax({
            url: '/manajemen/procurement/' + procurementId + '/add/product/' + productId + '/vendor/' + vendorId,
            type: 'POST',
            data: {
                _token: csrfToken // Include CSRF token
            },
            success: function (response) {
                $('#loadingOverlay').hide(); // Hide loading overlay
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                }).then(function () {
                    refreshProcurementProducts(procurementId);
                });
            },
            error: function (xhr, status, error) {
                $('#loadingOverlay').hide(); // Hide loading overlay
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add product to cart.'
                });
                console.error('AJAX Error: ' + status + error);
            }
        });
    });

    $('#vendorSelect').on('change', fetchProducts);
    $('#searchTerm').on('keyup', fetchProducts);
});

function refreshProcurementProducts(procurementId) {
    $.ajax({
        url: '/manajemen/procurement/get-products-procurement/' + procurementId,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#procurementProducts tbody').empty();
            $.each(data, function (key, product) {
                var formattedPrice = formatRupiah(product.total_price, 'Rp. ');
                var basePrice = formatRupiah(product.base_price, 'Rp. ');
                $('#procurementProducts tbody').append(
                    '<tr>' +
                    '<td>' +
                    '<button class="quantity-btn" onclick="deleteQuantity(\'' + product.id_procurement_product + '\',\'' + procurementId + '\')"><i class="ti ti-trash-x-filled"></i></button>' +
                    '<span class="quantity">' + product.name + '</span>' + '</td>' +
                    '<td>' + basePrice + '</td>' +
                    '<td>' +
                    '<button class="quantity-btn" onclick="updateQuantity(\'' + product.id_procurement_product + '\', \'decrement\',\'' + procurementId + '\')">-</button>' +
                    '<span class="quantity">' + product.quantity + '</span>' +
                    '<button class="quantity-btn" onclick="updateQuantity(\'' + product.id_procurement_product + '\', \'increment\',\'' + procurementId + '\')">+</button>' +
                    '</td>' +
                    '</td>' +
                    '<td>' + formattedPrice + '</td>' +

                    '</tr>'
                );
            });
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error: ' + status + error);
        }
    });
}

function formatRupiah(angka, prefix) {
    var number_string = angka.toString().replace(/[^,\d]/g, ''),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function updateQuantity(procurementProductId, action, procurementId) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('#loadingOverlay').show();
    $.ajax({
        url: '/manajemen/procurement/product/update-quantity/' + procurementProductId + '/' + action,
        type: 'PUT',
        data: {
            _token: csrfToken
        },
        success: function (response) {
            $('#loadingOverlay').hide();
            refreshProcurementProducts(procurementId);
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: response.message
            });
        },
        error: function (xhr, status, error) {
            $('#loadingOverlay').hide();
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: response.message
            });
            console.error('AJAX Error: ' + status + error);
        }
    });
}

function deleteQuantity(procurementProductId, procurementId) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('#loadingOverlay').show();
    $.ajax({
        url: '/manajemen/procurement/product/delete/' + procurementProductId,
        type: 'DELETE',
        data: {
            _token: csrfToken
        },
        success: function (response) {
            $('#loadingOverlay').hide();
            refreshProcurementProducts(procurementId);
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: response.message
            });
        },
        error: function (xhr, status, error) {
            $('#loadingOverlay').hide();
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: response.message
            });
            console.error('AJAX Error: ' + status + error);
        }
    });
}