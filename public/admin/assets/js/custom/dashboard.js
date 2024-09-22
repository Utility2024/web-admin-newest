$(document).ready(function() {
    // Cek apakah data sudah diambil
    if (!window.dataFetched) {
        // Ambil nilai dari elemen 'role' dan 'year' saat dokumen siap
        var role = $('#role').val();
        var year = $('#year').val();

        // Get data awal
        $.ajax({
            url: role + '/get-data-graph/' + year,
            method: 'GET',
            success: function(response) {
                var ctx = document.getElementById('myChart').getContext('2d');
                window.myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                                label: 'Belum Selesai',
                                data: response.belum_selesai,
                                backgroundColor: 'orange'
                            },
                            {
                                label: 'Sudah Selesai',
                                data: response.sudah_selesai,
                                backgroundColor: 'green'
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 50
                            }
                        }
                    }
                });
                // Tandai bahwa data sudah diambil
                window.dataFetched = true;
            }
        });
    }

    // Get data saat di klik
    $('#search-data-dashboard').on('click', function(event) {
        event.preventDefault(); // Mencegah pengiriman form secara default

        // Ambil nilai dari elemen 'role' dan 'year' saat tombol diklik
        var role = $('#role').val();
        var year = $('#year').val();

        // Lakukan request AJAX untuk mendapatkan data dari server
        $.ajax({
            url: role + '/get-data-graph/' + year,
            method: 'GET',
            success: function(response) {
                // Hapus chart lama jika ada
                if (window.myChart) {
                    window.myChart.destroy();
                }

                // Buat chart baru dengan data yang diterima dari server
                var ctx = document.getElementById('myChart').getContext('2d');
                window.myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                                label: 'Belum Selesai',
                                data: response.belum_selesai,
                                backgroundColor: 'orange'
                            },
                            {
                                label: 'Sudah Selesai',
                                data: response.sudah_selesai,
                                backgroundColor: 'green'
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 50
                            }
                        }
                    }
                });
            }
        });
    });
});
