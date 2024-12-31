<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Absensi</h2>
    </x-slot>

    <main class="px-10 mt-10">

        <!-- Tabel Data Absensi -->
        <div class="table-container">
            <div class="overflow-x-auto w-full">
                <table id="data-absensi" class="table table-striped nowrap w-full">
                    <thead>
                        <tr class="text-white bg-gray-800">
                            <th class="text-center">No</th>
                            <th>Nama Petugas</th>
                            <th>Tanggal Masuk</th>
                            <th>Foto Pagar Depan</th>
                            <th>Foto Ruang Tengah</th>
                            <th>Foto Lorong Lab</th>
                            <th>Foto Pagar Belakang</th>
                            <th>Status Kehadiran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </main>


    <!-- Script DataTables -->
    <script>
        $(document).ready(function () {
            $('#data-absensi').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.data-absensi.data') }}',
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'foto_pagar_depan',
                    name: 'foto_pagar_depan',
                },
                {
                    data: 'foto_ruang_tengah',
                    name: 'foto_ruang_tengah',
                },
                {
                    data: 'foto_lorong_lab',
                    name: 'foto_lorong_lab',
                },
                {
                    data: 'foto_pagar_belakang',
                    name: 'foto_pagar_belakang',
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, row) {
                        const status = data.toUpperCase();
                        let statusClass = 'text-sm px-3 py-1 rounded-full';  // Ukuran font kecil dan bentuk lengkung

                        // Tentukan warna latar belakang dan teks berdasarkan status
                        if (status === 'DIVERIFIKASI') {
                            statusClass += ' bg-white text-green-500'; // Latar belakang putih, teks hijau
                        } else if (status === 'TIDAK VALID') {
                            statusClass += ' bg-white text-red-500'; // Latar belakang putih, teks merah
                        } else if (status === 'BELUM DIVERIFIKASI') {
                            statusClass += ' bg-white text-yellow-500'; // Latar belakang putih, teks kuning
                        }

                        return `<span class="${statusClass}">${status}</span>`;
                    }
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                }
                ]
            });
        });

        // Fungsi untuk mengubah status absensi
        function updateStatus(id, status) {
            fetch("{{ route('admin.absensi.update-status') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: id,
                    status: status
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Status berhasil diperbarui',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33' // Warna merah untuk tombol OK
                        }).then(() => {
                            $('#data-absensi').DataTable().ajax.reload(); // Muat ulang DataTable
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33' // Warna merah untuk tombol OK
                        });
                    }
                })
                .catch(xhr => {
                    console.error('Terjadi kesalahan:', xhr);
                    alert('Terjadi kesalahan saat memperbarui status.');
                });
        }

        // Fungsi untuk memverifikasi absensi
        function verifyRecord(id) {
            fetch("{{ route('admin.absensi.update-status') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: id,
                    status: 'DIVERIFIKASI'
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Absensi telah diverifikasi.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33' // Warna merah untuk tombol OK
                        }).then(() => {
                            $('#data-absensi').DataTable().ajax.reload(); // Muat ulang DataTable
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat memverifikasi.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33' // Warna merah untuk tombol OK
                        });
                    }
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                    alert('Terjadi kesalahan saat memverifikasi.');
                });
        }

        // Fungsi untuk menandai absensi sebagai tidak valid
        function markInvalid(id) {
            fetch("{{ route('admin.absensi.update-status') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: id,
                    status: 'TIDAK VALID'
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Absensi ditandai tidak valid.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33' // Warna merah untuk tombol OK
                        }).then(() => {
                            $('#data-absensi').DataTable().ajax.reload(); // Muat ulang DataTable
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menandai tidak valid.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33' // Warna merah untuk tombol OK
                        });
                    }
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                    alert('Terjadi kesalahan saat menandai tidak valid.');
                });
        }

        function deleteRecord(id) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tidak',
                confirmButtonColor: '#3085d6', // Warna tombol "Ya"
                cancelButtonColor: '#d33', // Warna tombol "Tidak"
                reverseButtons: true, // Mengubah posisi tombol "Tidak" dan "Ya"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('admin.data-absensi.destroy', ':id') }}".replace(':id', id), {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#3085d6' // Tombol OK berwarna biru
                                }).then(() => {
                                    $('#data-absensi').DataTable().ajax.reload(); // Muat ulang DataTable
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menghapus data.',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#d33' // Tombol OK berwarna merah
                                });
                            }
                        })
                        .catch(xhr => {
                            console.error('Terjadi kesalahan:', xhr);
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#d33' // Tombol OK berwarna merah
                            });
                        });
                }
            });
        }


    </script>
</x-app-layout>