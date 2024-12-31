<x-app-layout>
    <div class="bg-gray-100 flex justify-center items-center min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h1 class="text-2xl font-bold mb-4">Form Absensi</h1>
            <form method="POST" action="{{ route('absensi.store') }}" enctype="multipart/form-data">
                @csrf
                <div id="waktu_batas_pagar_depan" class="text-gray-700 mt-2">
                    Waktu Batas: <span id="waktu_batas_text" class="font-bold">00:00:00</span>
                </div>

                <!-- Foto Pagar Depan -->
                <div class="foto-section mb-4" data-section="pagar_depan">
                    <label for="foto_pagar_depan" class="block text-gray-700 font-medium mb-2">Foto Pagar Depan</label>
                    <video id="video_pagar_depan" class="w-full h-auto border rounded mb-2"></video>
                    <canvas id="canvas_pagar_depan" class="hidden"></canvas>
                    <button type="button" id="capture_pagar_depan"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ambil Foto</button>
                    <input type="hidden" id="foto_pagar_depan" name="foto_pagar_depan">
                    <img id="foto_preview_pagar_depan" class="mt-2 w-full h-auto rounded hidden" />
                    <button type="button" id="ulang_foto_pagar_depan"
                        class="bg-gray-500 text-white px-4 py-2 rounded mt-2 hidden">Ulangi Foto</button>
                    <button type="button" id="selanjutnya_pagar_depan"
                        class="bg-green-500 text-white px-4 py-2 rounded mt-2 hidden">Selanjutnya</button>
                </div>

                <!-- Foto Pagar Belakang -->
                <div class="foto-section mb-4 hidden" data-section="pagar_belakang">
                    <label for="foto_pagar_belakang" class="block text-gray-700 font-medium mb-2">Foto Pagar
                        Belakang</label>
                    <video id="video_pagar_belakang" class="w-full h-auto border rounded mb-2"></video>
                    <canvas id="canvas_pagar_belakang" class="hidden"></canvas>
                    <button type="button" id="capture_pagar_belakang"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ambil Foto</button>
                    <input type="hidden" id="foto_pagar_belakang" name="foto_pagar_belakang">
                    <img id="foto_preview_pagar_belakang" class="mt-2 w-full h-auto rounded hidden" />
                    <button type="button" id="ulang_foto_pagar_belakang"
                        class="bg-gray-500 text-white px-4 py-2 rounded mt-2 hidden">Ulangi Foto</button>
                    <button type="button" id="selanjutnya_pagar_belakang"
                        class="bg-green-500 text-white px-4 py-2 rounded mt-2 hidden">Selanjutnya</button>
                </div>

                <!-- Foto Lorong Lab -->
                <div class="foto-section mb-4 hidden" data-section="lorong_lab">
                    <label for="foto_lorong_lab" class="block text-gray-700 font-medium mb-2">Foto Lorong Lab</label>
                    <video id="video_lorong_lab" class="w-full h-auto border rounded mb-2"></video>
                    <canvas id="canvas_lorong_lab" class="hidden"></canvas>
                    <button type="button" id="capture_lorong_lab"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ambil Foto</button>
                    <input type="hidden" id="foto_lorong_lab" name="foto_lorong_lab">
                    <img id="foto_preview_lorong_lab" class="mt-2 w-full h-auto rounded hidden" />
                    <button type="button" id="ulang_foto_lorong_lab"
                        class="bg-gray-500 text-white px-4 py-2 rounded mt-2 hidden">Ulangi Foto</button>
                    <button type="button" id="selanjutnya_lorong_lab"
                        class="bg-green-500 text-white px-4 py-2 rounded mt-2 hidden">Selanjutnya</button>
                </div>

                <!-- Foto Ruang Tengah -->
                <div class="foto-section mb-4 hidden" data-section="ruang_tengah">
                    <label for="foto_ruang_tengah" class="block text-gray-700 font-medium mb-2">Foto Ruang
                        Tengah</label>
                    <video id="video_ruang_tengah" class="w-full h-auto border rounded mb-2"></video>
                    <canvas id="canvas_ruang_tengah" class="hidden"></canvas>
                    <button type="button" id="capture_ruang_tengah"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ambil Foto</button>
                    <input type="hidden" id="foto_ruang_tengah" name="foto_ruang_tengah">
                    <img id="foto_preview_ruang_tengah" class="mt-2 w-full h-auto rounded hidden" />
                    <button type="button" id="ulang_foto_ruang_tengah"
                        class="bg-gray-500 text-white px-4 py-2 rounded mt-2 hidden">Ulangi Foto</button>
                    <button type="submit" id="simpan_absensi"
                        class="bg-green-500 text-white px-4 py-2 rounded mt-2 hidden">Simpan Absensi</button>
                </div>

                <div class="mb-4 flex justify-between">
                    <a href="{{ route('absensi.index') }}"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <script>

        function setupCamera(videoId, canvasId, buttonId, inputId, previewId, ulangiButtonId, selanjutnyaButtonId, simpanButtonId) {
            const video = document.getElementById(videoId);
            const canvas = document.getElementById(canvasId);
            const captureButton = document.getElementById(buttonId);
            const fotoInput = document.getElementById(inputId);
            const fotoPreview = document.getElementById(previewId);
            const ulangiButton = document.getElementById(ulangiButtonId);
            const selanjutnyaButton = document.getElementById(selanjutnyaButtonId);
            const simpanButton = document.getElementById(simpanButtonId);

            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(error => {
                    console.error('Error accessing camera:', error);
                });

            captureButton.addEventListener('click', () => {
                // Mendapatkan koordinat GPS
                navigator.geolocation.getCurrentPosition(position => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Mendapatkan waktu saat ini
                    const now = new Date();
                    const timestamp = `${now.toLocaleDateString()} ${now.toLocaleTimeString()}`;
                    const geoInfo = `Lat: ${latitude.toFixed(5)}, Long: ${longitude.toFixed(5)}`;

                    const context = canvas.getContext('2d');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    // Menambahkan watermark timestamp dan koordinat GPS
                    context.font = '24px Arial';
                    context.fillStyle = 'white';
                    context.fillText(`Tanggal: ${timestamp}`, 10, canvas.height - 40);
                    context.fillText(geoInfo, 10, canvas.height - 10);

                    const photoData = canvas.toDataURL('image/png');
                    fotoInput.value = photoData;
                    fotoPreview.src = photoData;
                    fotoPreview.classList.remove('hidden');
                    captureButton.classList.add('hidden');
                    ulangiButton.classList.remove('hidden');
                    if (selanjutnyaButton) selanjutnyaButton.classList.remove('hidden');
                    if (simpanButton) simpanButton.classList.remove('hidden');
                    video.classList.add('hidden');
                }, error => {
                    console.error('Error getting geolocation:', error);
                });
            });

            ulangiButton.addEventListener('click', () => {
                video.classList.remove('hidden');
                fotoPreview.classList.add('hidden');
                captureButton.classList.remove('hidden');
                ulangiButton.classList.add('hidden');
                if (selanjutnyaButton) selanjutnyaButton.classList.add('hidden');
                if (simpanButton) simpanButton.classList.add('hidden');
            });
        }
        document.getElementById('capture_pagar_depan').addEventListener('click', function () {
            captureAndSaveImage('video_pagar_depan', 'canvas_pagar_depan', 'foto_pagar_depan');
        });

        document.getElementById('capture_lorong_lab').addEventListener('click', function () {
            captureAndSaveImage('video_lorong_lab', 'canvas_lorong_lab', 'foto_lorong_lab');
        });

        document.getElementById('capture_ruang_tengah').addEventListener('click', function () {
            captureAndSaveImage('video_ruang_tengah', 'canvas_ruang_tengah', 'foto_ruang_tengah');
        });

        document.getElementById('capture_pagar_belakang').addEventListener('click', function () {
            captureAndSaveImage('video_pagar_belakang', 'canvas_pagar_belakang', 'foto_pagar_belakang');
        });

        function captureAndSaveImage(videoId, canvasId, hiddenInputId) {
            var video = document.getElementById(videoId);
            var canvas = document.getElementById(canvasId);
            var context = canvas.getContext('2d');

            // Gambar frame dari video ke dalam canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Konversi gambar canvas ke base64
            var dataUrl = canvas.toDataURL('image/jpeg');

            // Isi input tersembunyi dengan data URL base64
            document.getElementById(hiddenInputId).value = dataUrl;

            // Tampilkan foto preview
            var imgPreview = document.getElementById('foto_preview_' + canvasId);
            imgPreview.src = dataUrl;
            imgPreview.classList.remove('hidden');
        }


        // Set up cameras for each section
        setupCamera('video_pagar_depan', 'canvas_pagar_depan', 'capture_pagar_depan', 'foto_pagar_depan', 'foto_preview_pagar_depan', 'ulang_foto_pagar_depan', 'selanjutnya_pagar_depan');
        setupCamera('video_pagar_belakang', 'canvas_pagar_belakang', 'capture_pagar_belakang', 'foto_pagar_belakang', 'foto_preview_pagar_belakang', 'ulang_foto_pagar_belakang', 'selanjutnya_pagar_belakang');
        setupCamera('video_lorong_lab', 'canvas_lorong_lab', 'capture_lorong_lab', 'foto_lorong_lab', 'foto_preview_lorong_lab', 'ulang_foto_lorong_lab', 'selanjutnya_lorong_lab');
        setupCamera('video_ruang_tengah', 'canvas_ruang_tengah', 'capture_ruang_tengah', 'foto_ruang_tengah', 'foto_preview_ruang_tengah', 'ulang_foto_ruang_tengah', 'simpan_absensi');

        // Logic for switching sections
        document.getElementById('selanjutnya_pagar_depan').addEventListener('click', () => {
            document.querySelector('[data-section="pagar_depan"]').classList.add('hidden');
            document.querySelector('[data-section="pagar_belakang"]').classList.remove('hidden');
        });

        document.getElementById('selanjutnya_pagar_belakang').addEventListener('click', () => {
            document.querySelector('[data-section="pagar_belakang"]').classList.add('hidden');
            document.querySelector('[data-section="lorong_lab"]').classList.remove('hidden');
        });

        document.getElementById('selanjutnya_lorong_lab').addEventListener('click', () => {
            document.querySelector('[data-section="lorong_lab"]').classList.add('hidden');
            document.querySelector('[data-section="ruang_tengah"]').classList.remove('hidden');
        });

        const now = new Date(); // Waktu sekarang
        const startTime = new Date(now); // Membuat salinan dari waktu sekarang
        startTime.setHours(10, 0, 0, 0); // Set waktu mulai pada pukul 10:00

        const endTime = new Date(now); // Membuat salinan lagi untuk end time
        endTime.setHours(11, 0, 0, 0); // Set waktu akhir pada pukul 11:00

        let countdownTime = endTime - now; // Selisih waktu dari sekarang sampai pukul 11:00
        const countdownElement = document.getElementById('waktu_batas_text'); // ID untuk waktu batas

        let countdownInterval = setInterval(() => {
            countdownTime -= 1000; // Kurangi setiap detik
            const remainingTime = new Date(countdownTime);
            const hours = String(remainingTime.getUTCHours()).padStart(2, '0');
            const minutes = String(remainingTime.getUTCMinutes()).padStart(2, '0');
            const seconds = String(remainingTime.getUTCSeconds()).padStart(2, '0');

            // Menampilkan waktu yang tersisa, atau tetap menampilkan interval 10:00 - 11:00
            if (countdownTime > 0) {
                countdownElement.textContent = `${hours}:${minutes}:${seconds}`;
            } else {
                countdownElement.textContent = `10:00 - 11:00`; // Menampilkan interval tetap setelah waktu habis
                countdownElement.style.color = "red"; // Mengubah warna teks menjadi merah
                clearInterval(countdownInterval); // Hentikan interval setelah waktu habis
            }

        }, 1000);

    </script>
</x-app-layout>