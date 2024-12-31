<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Pengguna</h2>
    </x-slot>

    <main class="px-10 mt-10">
        <div class="overflow-x-auto">
            <table id="data-pengguna" class="table table-striped nowrap w-full">
                <thead>
                    <tr class="text-white bg-gray-800">
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                            <td class="text-center">
                                <!-- <button class="btn btn-sm btn-primary">Edit</button> -->
                                <button class="btn btn-sm btn-danger" onclick="deleteUser ({{ $user->id }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
            
            </table>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#data-pengguna').DataTable();
        });
        function deleteUser (id) {
        if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
            $.ajax({
                url: '{{ url('/data-pengguna') }}/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#data-pengguna').DataTable().ajax.reload(); // Refresh DataTable
                    } else {
                        alert('Terjadi kesalahan: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menghapus pengguna.');
                }
            });
        }
    }
    </script>
</x-app-layout>