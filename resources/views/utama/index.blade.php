@extends('utama.layouts.main')
@section('head')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - KawanTani</title>
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
        <div class="col-md-6 ps-5 pt-5 kiri" id="formSign">
            <div class="form-login">
                <h2 class=" mb-4 fw-bold text-start mt-5">Login</h2>
                <p style="color: #203B1F; font-weight: 400; font-size: 14px;" class="mb-4">Masuk untuk terus memantau lahan pertanian Anda. Dapatkan akses ke fitur dan layanan yang disesuaikan dengan kebutuhan Anda.</p>
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Masukkan Username Anda">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Masukkan Password Anda">
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label" for="rememberMe" style="color: #203B1F; font-size: 14px;">Ingat saya?</label>
                        </div>
                        <div>
                            <a href="#" class="text-decoration-none" style="color: #203B1F; font-size: 14px;">Forgot Password?</a>
                        </div>
                    </div>
                    <!-- Pesan error yang disembunyikan secara default -->
                    <div class="text-center mt-3 error-message d-none">
                        <p class="fw-bold" style="color: red; font-size: 14px;">
                            Username atau password yang Anda masukkan salah. Silakan coba lagi.
                        </p>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-2 fw-bold">Login</button>
                </form>
                <p class="text-center mt-3 mb-2">Belum memiliki akun? <a href="/registrasi" style="font-weight: bold; color:#203B1F; text-decoration: none;">Registrasi disini</a></p>
                <p class="text-center mt-3 mb-5">© 2024, KawanTani.</p>
            </div>
        </div>
        <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center" id="gambarSign">
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

<script>
    // Inisialisasi Lottie Animation
    let lottiePlayer = lottie.loadAnimation({
        container: document.getElementById('lottie'),
        renderer: 'svg',
        loop: true,
        autoplay: false, // Jangan mulai otomatis
        path: '/js/loading-animation.json' // Ganti dengan path JSON animasi loading
    });

    // Event listener untuk menangani form login
    // Event listener for the form submit
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault();

        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        const rememberMe = document.getElementById("rememberMe").checked; // Check if "Ingat saya?" is selected
        const errorMessage = document.querySelector(".error-message");
        const loadingAnimation = document.getElementById("loadingAnimation");

        // Show loading animation
        loadingAnimation.style.visibility = "visible";
        lottiePlayer.play();

        // Send login request to the API
        fetch("/api/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" // CSRF Token for security
                },
                body: JSON.stringify({
                    username: username,
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === "Login success") {
                    const accessToken = data.access_token; // Assuming the API sends the access token

                    // If "Remember Me" is checked, store the token in localStorage
                    if (rememberMe) {
                        localStorage.setItem('access_token', accessToken);
                    } else {
                        // If not checked, store token in sessionStorage for the current session
                        sessionStorage.setItem('access_token', accessToken);
                    }

                    // After 5 seconds, stop animation and redirect to home page
                    setTimeout(function() {
                        lottiePlayer.stop();
                        loadingAnimation.style.visibility = "hidden";
                        window.location.href = "/beranda";
                    }, 2000); // 5 seconds
                } else {
                    // Show error message if login fails
                    setTimeout(function() {
                        lottiePlayer.stop();
                        loadingAnimation.style.visibility = "hidden";
                        errorMessage.classList.remove("d-none");
                    }, 2000); // 5 seconds
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Show error message if an error occurs
                setTimeout(function() {
                    lottiePlayer.stop();
                    loadingAnimation.style.visibility = "hidden";
                    errorMessage.classList.remove("d-none");
                }, 2000); // 5 seconds
            });
    });
</script>
@endsection