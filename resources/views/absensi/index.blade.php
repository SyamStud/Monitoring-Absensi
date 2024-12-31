<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Absensi</h2>
    </x-slot>

    <main class="px-10 mt-10">
        <!-- Tombol Tambah Absensi -->
        <div class="mb-4 flex justify-end">
            <a href="{{ route('absensi.add-absensi') }}"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                Tambah Absensi
            </a>
        </div>

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
                ajax: '{{ route('absensi.data') }}', // Ganti dengan route yang sesuai untuk mengambil data absensi
                columns: [
                    {
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
                        name: 'tanggal',

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
                        searchable: false,
                        render: function (data, type, row) {
                            return '<form action="{{ route('absensi.destroy', '') }}/' + row.id + '" method="POST" class="inline" id="deleteForm-' + row.id + '">' +
                                '@csrf' +
                                '@method('DELETE')' +
                                '<button type="button" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg" onclick="confirmDelete(' + row.id + ')">Hapus</button>' +
                                '</form>';
                        }
                    }
                ],
            });
        });
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan AJAX untuk menghapus data
                    fetch('/absensi/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Dihapus!', 'Data telah dihapus.', 'success');
                                // Perbarui tabel atau hapus baris
                                $('#data-absensi').DataTable().ajax.reload();
                            } else {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Terjadi Kesalahan!', 'Coba lagi nanti.', 'error');
                        });
                }
            });
        }

        // Fungsi untuk membuka modal dan menampilkan gambar besar
        function openImageModal(imageUrl) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageUrl; // Set gambar besar
            modal.classList.remove('hidden'); // Tampilkan modal
        }

        // Fungsi untuk menutup modal
        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden'); // Sembunyikan modal
        }
    </script>

    <!-- Modal Gambar Besar -->
    <div id="imageModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="relative bg-white p-4 rounded-lg shadow-lg">
            <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white text-2xl">&times;</button>
            <img id="modalImage" src="" alt="Foto" class="max-w-2xl max-h-96 mx-auto">
        </div>
    </div>
</x-app-layout>