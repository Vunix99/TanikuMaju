@extends('utama.layouts.main')
@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - KawanTani</title>
    <!-- Website Icon -->
    <link rel="Website Icon" type="png" href="{{ asset('images/logotani.png') }}">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- ICon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- FOnt -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        /* CSS for the floating loading animation with background */
        #loadingAnimation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.4);
            /* Semi-transparent black background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            visibility: hidden;
            /* Hidden by default */
        }

        #lottie {
            width: 100px;
            height: 100px;
        }
    </style>
@endsection


@section('main')
    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
        <div class="row w-100 ">
            <div class="col-12 text-start mb-3">
                <img src="{{ asset('images/logoHijau.svg') }}" alt="logo" class="logo ps-5 mt-5">
            </div>
            <div class="col-md-4 ps-5 pt-2 kiri" id="formSign">
                <div class="form-login">
                    <h2 class="mb-4 fw-bold text-start mt-5">Registrasi</h2>
                    <p style="color: #203B1F; font-weight: 400; font-size: 14px;" class="mb-4">
                        Daftar sekarang untuk memulai perjalanan Anda dalam memantau dan mengelola lahan pertanian
                        dengan lebih mudah. Nikmati fitur eksklusif dan layanan yang dirancang khusus untuk mendukung kebutuhan pertanian Anda.
                    </p>
                    <form id="registerForm">
                        <div class="mb-3">
                            <label for="nama_petani" class="form-label fw-bold">Nama Petani</label>
                            <input type="text" class="form-control" id="nama_petani" placeholder="Masukkan Nama Anda" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomor_wa" class="form-label fw-bold">Nomor WhatsApp</label>
                            <input type="text" class="form-control" id="nomor_wa" placeholder="Masukkan Nomor WhatsApp Anda (cth. 081xxxxxx)" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Masukkan Username Anda" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Masukkan Password Anda" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" placeholder="Konfirmasi Password Anda" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 mt-2 fw-bold">Registrasi</button>
                    </form>
                    <p class="text-center mt-3 mb-2">Sudah memiliki akun? <a href="/login" style="font-weight: bold; color:#203B1F; text-decoration: none;">Login disini</a></p>
                    <p class="text-center mt-3 mb-5">© 2024, TanikuMaju.</p>
                </div>
            </div>
            <div id="gambarSign" class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
                <img src="{{ asset('images/login.png') }}" alt="Farmers" class="petani zoom">
            </div>
        </div>
    </div>


    <div id="loadingAnimation">
        <div id="lottie"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.7/lottie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Inisialisasi Lottie Animation
        let lottiePlayer = lottie.loadAnimation({
            container: document.getElementById('lottie'),
            renderer: 'svg',
            loop: true,
            autoplay: false, // Jangan mulai otomatis
            path: '/js/loading-animation.json' // Ganti dengan path JSON animasi loading
        });

        // Event listener untuk form registrasi
        document.getElementById("registerForm").addEventListener("submit", function(event) {
            event.preventDefault();

            const namaPetani = document.getElementById("nama_petani").value;
            const nomorWA = document.getElementById("nomor_wa").value;
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;
            const passwordConfirmation = document.getElementById("password_confirmation").value;
            const loadingAnimation = document.getElementById("loadingAnimation");

            // Tampilkan animasi loading
            loadingAnimation.style.visibility = "visible";
            lottiePlayer.play();

            // Kirim request registrasi ke API
            fetch("/api/register", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}" // CSRF Token untuk keamanan
                    },
                    body: JSON.stringify({
                        nama_petani: namaPetani,
                        nomor_wa: nomorWA,
                        username: username,
                        password: password,
                        password_confirmation: passwordConfirmation
                    })
                })
                .then(response => {
                    // Validasi status respons HTTP
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw {
                                status: response.status,
                                data
                            };
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Tunda Sweet Alert selama 2 detik
                    setTimeout(() => {
                        // Hentikan animasi loading
                        lottiePlayer.stop();
                        loadingAnimation.style.visibility = "hidden";

                        // Tampilkan Sweet Alert sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Registrasi Berhasil',
                            text: data.message,
                            showConfirmButton: true
                        }).then(() => {
                            // Arahkan ke halaman beranda
                            window.location.href = "/";
                        });
                    }, 2000); // Penundaan 2 detik
                })
                .catch(error => {
                    // Tunda Sweet Alert error selama 2 detik
                    setTimeout(() => {
                        // Hentikan animasi loading
                        lottiePlayer.stop();
                        loadingAnimation.style.visibility = "hidden";

                        if (error.data) {
                            // Jika error berasal dari server, tampilkan Sweet Alert error
                            Swal.fire({
                                icon: 'error',
                                title: 'Registrasi Gagal',
                                html: `<strong>${error.data.message}</strong><br>${formatErrors(error.data.errors)}`,
                                showConfirmButton: true
                            });
                        } else {
                            // Jika error berasal dari jaringan atau masalah lainnya
                            Swal.fire({
                                icon: 'error',
                                title: 'Registrasi Gagal',
                                text: 'Terjadi kesalahan. Silakan coba lagi.',
                                showConfirmButton: true
                            });
                        }
                    }, 2000); // Penundaan 2 detik
                });
        });

        // Fungsi untuk memformat error
        function formatErrors(errors) {
            let errorMessages = '';
            for (const [field, messages] of Object.entries(errors)) {
                errorMessages += `<strong>${field}:</strong> ${messages.join('<br>')}<br>`;
            }
            return errorMessages;
        }
    </script>
@endsection