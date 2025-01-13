@extends('utama.layouts.main')
@section('head')
<meta charset="UTF-8">
<!-- Website Icon -->
<link rel="icon" type="image/png" href="{{ asset('images/logotani.png') }}">
<!-- AOS CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
    integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Swiper JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<!-- Iconify JavaScript -->
<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- Weather Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('css/kalkulasi.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection


@section('main')
<div class="container-fluid">
    <!-- Header -->
    <div class="header">
        <!-- IMAGE HEADER -->
    </div>
    <!-- SECTION 1 -->
    <div class="section1">
        <div class="awal pb-5">
            <h1 class="pt-5" style="margin-bottom: 20px;" data-aos="fade-up" data-aos-duration="2000"> Temukan Tanggal Panen Pertanian Anda</h1>
            <p data-aos="fade-in" data-aos-duration="3000" data-aos-delay="500">Ketahui Waktu Panen dengan Tepat! Prediksi tanggal
                panen tanaman Anda secara akurat untuk hasil yang maksimal.
                Kelola pertanian Anda dengan lebih cerdas dan terencana!</p><br>
            <!-- card  -->
            <div class="card-container">
                <div class="card data" class="shadow p-3 mb-5 bg-body rounded">
                    <h2>Input Data Pertanian Anda</h2>
                    <p>Input Data Pertanian Anda dengan Akurat dan Real-Time! Pastikan semua informasi dimasukkan dengan benar untuk hasil prediksi dan analisis yang optimal.</p>
                    <form id="agriculture-form" method="POST" action="{{ route('save-crop') }}">
                        @csrf
                        <label for="field-name">Nama Lahan</label>
                        <input type="text" id="field-name" name="fieldName" placeholder="Masukkan Nama Lahan" required>

                        <div class="form-group">
                            <label for="crop-type">Jenis Tanaman</label>
                            <select id="crop-type" name="cropType" required>
                                <option value="">Pilih Jenis Tanaman</option>
                                <option value="Padi">Padi</option>
                                <option value="Jagung">Jagung</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="field-mass">Luas Lahan (HA)</label>
                            <input type="number" id="field-mass" name="fieldMass" placeholder="Masukkan Luas Lahan" required>
                        </div>

                        <div class="form-group">
                            <label for="plant-date">Tanggal Tanam</label>
                            <input type="date" id="plant-date" name="plantDate" required>
                        </div>

                        <div class="form-group">
                            <label for="soil-moisture">Kelembapan Tanah</label>
                            <select id="soil-moisture" name="soilMoisture" required>
                                <option value="">Pilih Kelembapan Tanah</option>
                                <option value="Kering">Kering</option>
                                <option value="Normal">Normal</option>
                                <option value="Basah">Basah</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="soil-condition">Kondisi Tanah</label>
                            <select id="soil-condition" name="soilCondition" required>
                                <option value="">Pilih Kondisi Tanah</option>
                                <option value="Tidak Subur">Tidak Subur</option>
                                <option value="Subur">Subur</option>
                                <option value="Sangat Subur">Sangat Subur</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="rainfall-intensity">Curah Hujan</label>
                            <select id="rainfall-intensity" name="rainfallIntensity" required>
                                <option value="">Pilih Intensitas Curah Hujan</option>
                                <option value="Rendah">Rendah</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Tinggi">Tinggi</option>
                            </select>
                        </div>

                        <button type="submit" id="calculate-button">Hitung Kalkulasi</button>
                    </form>
                </div>
                <div id="result-card-container" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100"></div>
            </div>
            {{-- Table Riwayat Perhitungan --}}
            <div class="container-fluid">
                <h1 class="text-center fw-bold mt-5 mb-5">Riwayat Perhitungan</h1>

                {{-- table --}}
                @if (session('success'))
                <div class="alert alert-success mb-3 fw-bold" style="max-width: 1000px; margin: 0 auto;">
                    {{ session('success') }}
                </div>
                @endif

                <div class="d-flex justify-content-center">
                    <div class="table-responsive" style="max-width: 1000px;">
                        <table class="table mb-5 text-center align-middle shadow p-3 mb-5 bg-body rounded" style="background-color: white; border-radius: 20px;">
                            <thead style="color: #203B1F">
                                <tr>
                                    <th scope="col" style="width: 15%;">Tanggal Penanaman</th>
                                    <th scope="col" style="width: 15%;">Nama Lahan</th>
                                    <th scope="col" style="width: 12%;">Jenis Tanaman</th>
                                    <th scope="col" style="width: 15%;">Prediksi Panen</th>
                                    <th scope="col" style="width: 33%;">Saran</th>
                                    <th scope="col" style="width: 15%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="container-riwayat">

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <!-- Section CTA -->

</div>


<!-- JS Scroll -->
<script>
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');

        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>

<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

<!-- AOS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"
    integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    AOS.refresh();
    AOS.init(); // Inisialisasi AOS
</script>

<!-- Iconify -->
<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
{{-- SCRIPT SWEET ALERT --}}
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const form = this.closest('.delete-form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>


<!-- Kalkulasi JS -->
<script>
    document.getElementById('agriculture-form').addEventListener('submit', async function(event) {
        event.preventDefault();

        // Ambil data dari form
        const data = {
            fieldName: document.getElementById('field-name').value,
            cropType: document.getElementById('crop-type').value,
            plantDate: document.getElementById('plant-date').value,
            fieldMass: parseFloat(document.getElementById('field-mass').value),
            soilMoisture: document.getElementById('soil-moisture').value,
            soilCondition: document.getElementById('soil-condition').value,
            rainfallIntensity: document.getElementById('rainfall-intensity').value,
        };

        // Logika untuk menentukan saran
        let harvestCondition = "Kondisi panen optimal.";

        if (data.soilCondition === "Tidak Subur" && data.soilMoisture === "Kering" && data.rainfallIntensity === "Rendah") {
            harvestCondition = "Kondisi panen kurang baik. Disarankan perbaikan irigasi, penggunaan pupuk organik, dan penerapan metode konservasi air.";
        } else if (data.soilCondition === "Tidak Subur" && data.soilMoisture === "Kering" && data.rainfallIntensity === "Sedang") {
            harvestCondition = "Tanah tidak subur dan kelembapan rendah meskipun curah hujan sedang. Perlu dilakukan pengolahan tanah dan pemberian pupuk.";
        } else if (data.soilCondition === "Tidak Subur" && data.rainfallIntensity === "Tinggi") {
            harvestCondition = "Tanah tidak subur dengan curah hujan tinggi dapat menyebabkan erosi dan hasil panen berkurang. Tingkatkan pemupukan dan gunakan penahan erosi.";
        } else if (data.soilCondition === "Tidak Subur" && data.soilMoisture === "Normal" && data.rainfallIntensity === "Rendah") {
            harvestCondition = "Tanah tidak subur dengan kelembapan normal tetapi curah hujan rendah. Disarankan penggunaan pupuk organik untuk meningkatkan kesuburan tanah, serta irigasi tambahan untuk memastikan tanaman mendapatkan cukup air.";
        } else if (data.soilCondition === "Subur" && data.soilMoisture === "Kering" && data.rainfallIntensity === "Rendah") {
            harvestCondition = "Tanah subur tetapi kekeringan dapat mengurangi hasil panen. Tambahkan irigasi untuk meningkatkan produktivitas.";
        } else if (data.soilCondition === "Subur" && data.soilMoisture === "Normal" && data.rainfallIntensity === "Sedang") {
            harvestCondition = "Kondisi ideal untuk pertumbuhan tanaman. Lanjutkan pemantauan rutin.";
        } else if (data.soilCondition === "Subur" && data.soilMoisture === "Basah" && data.rainfallIntensity === "Tinggi") {
            harvestCondition = "Tanah subur dengan kelembapan tinggi dan curah hujan tinggi. Waspadai risiko genangan air dan banjir.";
        } else if (data.soilCondition === "Sangat Subur" && data.soilMoisture === "Kering" && data.rainfallIntensity === "Rendah") {
            harvestCondition = "Tanah sangat subur tetapi kelembapan rendah. Tambahkan irigasi untuk memanfaatkan potensi hasil maksimal.";
        } else if (data.soilCondition === "Sangat Subur" && data.soilMoisture === "Normal" && data.rainfallIntensity === "Sedang") {
            harvestCondition = "Kondisi panen sangat baik. Potensi hasil maksimal. Pastikan pengendalian hama dilakukan.";
        } else if (data.soilCondition === "Sangat Subur" && data.soilMoisture === "Basah" && data.rainfallIntensity === "Tinggi") {
            harvestCondition = "Tanah sangat subur dengan curah hujan tinggi. Perhatikan risiko kerusakan akibat genangan air.";
        } else if (data.soilMoisture === "Basah" && data.rainfallIntensity === "Tinggi") {
            harvestCondition = "Kondisi lembap dan curah hujan tinggi. Perhatikan risiko banjir yang dapat merusak tanaman.";
        } else if (data.soilMoisture === "Kering" && data.rainfallIntensity === "Rendah") {
            harvestCondition = "Kelembapan tanah rendah dan curah hujan rendah. Tingkatkan irigasi untuk menjaga pertumbuhan tanaman.";
        } else if (data.soilMoisture === "Kering" && data.rainfallIntensity === "Sedang") {
            harvestCondition = "Kelembapan tanah rendah meskipun curah hujan sedang. Perlu irigasi tambahan.";
        } else if (data.soilMoisture === "Normal" && data.rainfallIntensity === "Tinggi") {
            harvestCondition = "Kelembapan tanah normal tetapi curah hujan tinggi. Pastikan drainase berfungsi untuk mencegah genangan.";
        } else if (data.soilCondition === "Tidak Subur" && data.soilMoisture === "Basah") {
            harvestCondition = "Tanah tidak subur dan kelembapan tinggi. Perlu peningkatan kualitas tanah melalui pengapuran atau pupuk.";
        } else if (data.soilCondition === "Sangat Subur" && data.soilMoisture === "Kering") {
            harvestCondition = "Tanah sangat subur tetapi kelembapan rendah. Irigasi diperlukan untuk mendukung pertumbuhan optimal.";
        } else if (data.soilCondition === "Tidak Subur" && data.soilMoisture === "Normal" && data.rainfallIntensity === "Sedang") {
            harvestCondition = "Tanah tidak subur dengan kelembapan normal dan curah hujan sedang. Disarankan untuk meningkatkan kesuburan tanah dengan pupuk organik atau anorganik untuk mendukung pertumbuhan tanaman yang optimal.";
        } else {
            harvestCondition = "Kondisi pertanian tidak sesuai dengan skenario yang direncanakan. Lakukan pemeriksaan dan penyesuaian.";
        }

        // Hitung durasi panen
        const baseDuration = data.cropType === 'Padi' ? 120 : 90;
        let soilFactor = data.soilMoisture === 'Kering' ? 1.2 : data.soilMoisture === 'Normal' ? 1 : 0.8;
        soilFactor *= data.soilCondition === 'Tidak Subur' ? 1.2 : data.soilCondition === 'Sangat Subur' ? 0.8 : 1;
        const rainfallFactor = data.rainfallIntensity === 'Rendah' ? 1.1 : data.rainfallIntensity === 'Tinggi' ? 0.9 : 1;
        const sizeFactor = data.fieldMass < 1 ? 1 : data.fieldMass <= 5 ? 1.1 : 1.2;

        const totalDuration = Math.round(baseDuration * soilFactor * rainfallFactor * sizeFactor);
        const harvestDate = new Date(data.plantDate);
        harvestDate.setDate(harvestDate.getDate() + totalDuration);

        data.harvestDate = harvestDate.toISOString().split('T')[0]; // Tambahkan tanggal panen ke data

        // Pilih gambar berdasarkan jenis tanaman
        let cropImage = '';
        if (data.cropType === 'Padi') {
            cropImage = '/images/jenis/padi.jpg';
        } else if (data.cropType === 'Jagung') {
            cropImage = '/images/jenis/jagung.jpg';
        } else {
            cropImage = '/images/jenis/default.jpg';
        }

        try {
            const accessToken = localStorage.getItem('access_token') || sessionStorage.getItem('access_token');

            const response = await fetch('/api/save-crop', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();
            console.log(result);

            if (result.success) {
                const resultCardContainer = document.getElementById('result-card-container');
                resultCardContainer.innerHTML = `
                        <div class="card hasil">
                            <div class="card-header">
                                <h2>Hasil Kalkulasi</h2>
                            </div>
                            <div class="card-body text-center">
                                <img src="${cropImage}" alt="${data.cropType}" style="width: 100%; max-width: 210px; margin-bottom: 20px; border-radius: 10px;" />
                                <h5 class="fw-bold">${data.cropType}</h5>
                                <p>Perkiraan tanggal panen untuk jenis tanaman <strong>${data.cropType}</strong> dengan luas lahan <strong>${data.fieldMass} hektar</strong>, sebagai berikut:</p>
                                <h3 class="fw-bold">${harvestDate.getDate()}/${harvestDate.getMonth() + 1}/${harvestDate.getFullYear()}</h3>
                            </div>
    
                            <div class="card-footer">
                                <h2>Saran</h2>
                                <p>${harvestCondition}</p>
                            </div>
                        </div>
                    `;

                AOS.refresh();
                resultCardContainer.style.display = 'block';
                setTimeout(() => {
                    resultCardContainer.classList.add('show');
                }, 100);
            } else {
                alert('Gagal menyimpan data.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim data.');
        }
    });
</script>

{{-- script riwayat --}}
<script>
    (async () => {
        const accessToken = localStorage.getItem('access_token') || sessionStorage.getItem('access_token');
        // API call to fetch petani data with Authorization header
        const response = await fetch('/api/riwayat/user', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${accessToken}`, // Add the token to the Authorization header
                'Content-Type': 'application/json', // Set content type to JSON
            }
        });
        const result = await response.json();
        // console.log(result);

        const containerRiwayat = document.getElementById('container-riwayat');

        containerRiwayat.innerHTML = "";

        // Fungsi untuk memformat tanggal ke DD-MM-YYYY
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0'); // Tambahkan 0 jika kurang dari 10
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }

        // Proses data dan format tanggal
        result.data.forEach(riwayat => {
            containerRiwayat.innerHTML += `
        <tr>
            <td> ${formatDate(riwayat.plant_date)} </td>
            <td> ${riwayat.field_name} </td>
            <td> ${riwayat.crop_type} </td>
            <td> ${formatDate(riwayat.harvest_date)} </td>
            <td> ${riwayat.suggestion} </td>
            <td>
                <div class="delete-form">
                    <button type="button" data-id="${riwayat.id}" class="btn btn-danger btn-sm delete-btn">Hapus</button>
                </div>
            </td>
        </tr>
    `;
        });

        // btn hapus riwayat
        const btnDeleteRiwayat = document.querySelectorAll('.delete-btn');

        btnDeleteRiwayat.forEach(btn => {
            btn.addEventListener('click', async (event) => {
                const id = event.currentTarget.dataset.id;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/api/delete-crop/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'Authorization': `Bearer ${accessToken}`, // Pastikan token valid
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                }
                            });

                            if (!response.ok) {
                                // Ambil pesan error dari server jika ada
                                const errorData = await response.json();
                                throw new Error(errorData.messages || 'Gagal menghapus data');
                            }

                            const result = await response.json();

                            // Swal.fire({
                            //     title: 'Berhasil!',
                            //     text: result.messages || 'Data berhasil dihapus.',
                            //     icon: 'success',
                            //     timer: 2000,
                            //     showConfirmButton: false
                            // });

                            window.location.reload();

                        } catch (error) {
                            console.error('Error:', error.message);
                            Swal.fire({
                                title: 'Error!',
                                text: error.message || 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error',
                            });
                        }
                    }
                });
            });
        });



    })();
</script>


@endsection