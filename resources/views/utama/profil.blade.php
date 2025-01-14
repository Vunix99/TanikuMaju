@extends('utama.layouts.main')
@section('head')
<meta charset="UTF-8">
<!-- Website Icon -->
<link rel="Website Icon" type="png" href="{{ asset('images/logotani.png') }}">
<!-- AOS CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
    integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Sweeper Js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- ICon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<!-- FOnt -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

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
<div class="container-fluid profile" style="margin-bottom: 160px; margin-top:80px;">
    <div class="profile-container" style="position: relative; text-align: center;"> <!-- Center align the content -->
        <img src="{{ asset('images/logotani.png') }}" alt="Profile Picture" class="profile-picture" id="profile-picture">

        <label class="input-label" for="username">Username</label>
        <input type="text" id="username" class="input-field" value="petanisedangsibuk" disabled>

        <label class="input-label" for="namalengkap">Nama Lengkap</label>
        <input type="text" id="namalengkap" class="input-field" value="Petani Satu" enabled>

        <label class="input-label" for="phone">Nomor Telepon</label>
        <input type="text" id="phone" class="input-field" value="08647760129" enabled>

        <div class="tombol" style="display: flex; align-items: center; margin-top:24px;">
            <button type="button" class="btn btn-outline-primary" id="ubahPasswordBtn" data-bs-toggle="modal" data-bs-target="#exampleModal"
                style="background-color: transparent; color: #F7C35F; border-color: #F7C35F; font-weight: 600; height: 100%; width:100%;">Ubah Password</button>

            <button type="button" class="btn btn-primary" id="simpanPerubahanBtn" style="background-color: #F7C35F; color: #203B1F; border-color: transparent; font-weight: 600; height: 100%; width:100%;">Simpan Perubahan</button>
        </div>


        <button type="button" class="btn btn-link" id="logoutBtn"
            style="color: rgb(206, 4, 4); text-decoration: underline; border: none; font-weight: 600; margin-top:24px; height: 100%; width: 100%;">Logout</button>
    </div>
</div>


<!-- MODAL GANTI PASSWORD -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="change-password-form">
                    <div class="mb-3">
                        <label for="password_lama" class="col-form-label"
                            style="font-size: 14px; color: #595959; font-weight: 500;">Password Saat ini</label>
                        <input type="password" class="form-control" id="password_lama">
                    </div>
                    <div class="mb-3">
                        <label for="password_baru" class="col-form-label"
                            style="font-size: 14px; color: #595959; font-weight: 500;">Password Baru</label>
                        <input type="password" class="form-control" id="password_baru">
                    </div>
                    <div class="mb-3">
                        <label for="password_baru_confirmation" class="col-form-label"
                            style="font-size: 14px; color: #595959; font-weight: 500;">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_baru_confirmation">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary"
                    style="background-color: #F7C35F; color: #203B1F; border-color: transparent; font-weight: 600;"
                    id="submit-password-change">Ubah Password</button>
            </div>
        </div>
    </div>
</div>
<div id="loadingAnimation">
    <div id="lottie"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.7/lottie.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!--Script logout-->
<script>
    document.querySelector("#logoutBtn").addEventListener("click", async function() {
        // Ambil token dari localStorage atau sessionStorage
        const token = localStorage.getItem('access_token') || sessionStorage.getItem('access_token');


        // Jika token tidak ada, logout tidak perlu dilakukan
        if (!token) {
            Swal.fire({
                title: 'Gagal!',
                text: 'Token tidak ditemukan. Silakan login ulang.',
                icon: 'error',
                showConfirmButton: false,
                timer: 3000 // Alert stays for 3 seconds
            });
            return;
        }

        startLottieAnimation();

        try {
            // Kirim permintaan logout ke server
            const response = await fetch("/api/logout", {
                method: "POST", // Biasanya, logout menggunakan POST
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + token // Menambahkan token Bearer untuk otentikasi
                }
            });

            const data = await response.json(); // Parsing response JSON

            // Jika loggedOut true, hapus token dan arahkan ke halaman utama
            if (data.loggedOut) {
                // Wait for loading animation to finish before showing success message
                setTimeout(() => {
                    stopLottieAnimation();
                    sessionStorage.removeItem('access_token');
                    localStorage.removeItem('access_token');

                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Logout berhasil. Anda akan diarahkan ke halaman utama.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000 // Alert stays for 3 seconds
                    }).then(() => {
                        window.location.href = "/"; // Arahkan ke halaman utama
                    });
                }, 5000); // Wait for loading animation to finish
            } else {
                throw new Error('Logout gagal. Silakan coba lagi.');
            }
        } catch (error) {
            stopLottieAnimation(); // Stop loading animation in case of error

            console.error("Error:", error);

            Swal.fire({
                title: 'Gagal!',
                text: error.message || 'Terjadi kesalahan saat logout. Silakan coba lagi.',
                icon: 'error',
                showConfirmButton: false,
                timer: 3000 // Alert stays for 3 seconds
            });
        }
    });
</script>



<!--Handle Poto Profil-->
<script>
    let lottiePlayer = lottie.loadAnimation({
        container: document.getElementById('lottie'),
        renderer: 'svg',
        loop: true,
        autoplay: false,
        path: '/js/loading-animation.json'
    });

    const startLottieAnimation = () => {
        const loadingAnimation = document.getElementById('loadingAnimation');
        loadingAnimation.style.visibility = "visible"; // Show the background and animation
        lottiePlayer.play();
    };

    const stopLottieAnimation = () => {
        const loadingAnimation = document.getElementById('loadingAnimation');
        loadingAnimation.style.visibility = "hidden"; // Hide the background and animation
        lottiePlayer.stop();
    };

    const profilePicture = document.getElementById('profile-picture');
    const profilePictureContainer = document.createElement('div');
    profilePictureContainer.style.position = 'relative';
    profilePictureContainer.style.display = 'inline-block';
    profilePictureContainer.style.textAlign = 'center';
    profilePictureContainer.style.margin = '0 auto';
    profilePicture.style.width = '200px';
    profilePicture.style.height = '200px';
    profilePicture.style.borderRadius = '50%';
    profilePicture.style.transition = 'all 0.3s ease';
    profilePicture.parentNode.insertBefore(profilePictureContainer, profilePicture);
    profilePictureContainer.appendChild(profilePicture);

    const overlay = document.createElement('div');
    const editIcon = document.createElement('i');
    overlay.style.position = 'absolute';
    overlay.style.top = '50%';
    overlay.style.left = '50%';
    overlay.style.transform = 'translate(-50%, -50%)';
    overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    overlay.style.opacity = '0';
    overlay.style.transition = 'opacity 0.3s ease, width 0.3s ease, height 0.3s ease';
    overlay.style.display = 'flex';
    overlay.style.justifyContent = 'center';
    overlay.style.alignItems = 'center';
    overlay.style.borderRadius = '50%';

    editIcon.classList.add('fa', 'fa-pencil');
    editIcon.style.color = 'white';
    editIcon.style.fontSize = '30px';
    editIcon.style.cursor = 'pointer';
    overlay.appendChild(editIcon);
    profilePictureContainer.appendChild(overlay);

    const profilePictureSize = profilePicture.offsetWidth;
    overlay.style.width = `${profilePictureSize}px`;
    overlay.style.height = `${profilePictureSize}px`;

    profilePictureContainer.addEventListener('mouseenter', () => {
        overlay.style.opacity = '1';
        overlay.style.width = `${profilePictureSize}px`;
        overlay.style.height = `${profilePictureSize}px`;
    });

    profilePictureContainer.addEventListener('mouseleave', () => {
        overlay.style.opacity = '0';
        overlay.style.width = `${profilePictureSize}px`;
        overlay.style.height = `${profilePictureSize}px`;
    });

    const openFileChooser = () => {
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.accept = 'image/*';
        fileInput.click();

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const base64Image = e.target.result.split(',')[1];
                    handleProfileImageUpload(file, base64Image);
                };
                reader.readAsDataURL(file);
            }
        });
    };

    editIcon.addEventListener('click', openFileChooser);
    overlay.addEventListener('click', openFileChooser);

    const handleProfileImageUpload = async (file, base64Image) => {
        try {
            startLottieAnimation(); // Show the animation and background

            const accessToken = localStorage.getItem('access_token') || sessionStorage.getItem('access_token');
            if (!accessToken) {
                console.error("Access token not found.");
                return;
            }

            const response = await fetch('/api/petani/update', {
                method: 'PATCH',
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    foto_profil: base64Image,
                }),
            });

            const data = await response.json();
            if (data.message === "Profil petani berhasil diperbarui") {
                // Show success alert after loading animation
                setTimeout(() => {
                    stopLottieAnimation();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Profil petani berhasil diperbarui',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 4000 // Alert stays for 4 seconds before refreshing
                    }).then(() => {
                        location.reload(); // Refresh the page after the alert
                    });
                }, 5000); // Wait for loading animation to finish
            } else {
                console.error("Error updating profile image:", data.message);
                // Show error alert after loading animation
                setTimeout(() => {
                    stopLottieAnimation();
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Gagal memperbarui profil petani',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 2500 // Alert stays for 4 seconds before refreshing
                    }).then(() => {
                        location.reload(); // Refresh the page after the alert
                    });
                }, 5000); // Wait for loading animation to finish
            }
        } catch (error) {
            console.error("Error handling profile image upload:", error);
            stopLottieAnimation();
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat mengunggah foto profil.',
                icon: 'error',
                showConfirmButton: false,
                timer: 100000 // Alert stays for 4 seconds before refreshing
            }).then(() => {
                location.reload(); // Refresh the page after the alert
            });
        }
    };
</script>


<!--Script Update Nama petani dan Nomor Wa-->
<script>
    document.querySelector("#simpanPerubahanBtn").addEventListener("click", async function() {
        // Ambil nilai dari input form
        const namaLengkap = document.querySelector("#namalengkap").value;
        const nomorTelepon = document.querySelector("#phone").value;

        // Ambil token dari localStorage atau sessionStorage
        const token = localStorage.getItem('access_token') || sessionStorage.getItem('access_token');
        if (!token) {
            Swal.fire({
                title: 'Gagal!',
                text: 'Token tidak ditemukan. Silakan login ulang.',
                icon: 'error',
                showConfirmButton: false,
                timer: 3000 // Alert stays for 3 seconds
            });
            return;
        }

        // Membuat objek data yang akan dikirim ke server
        const data = {
            nama_petani: namaLengkap,
            nomor_wa: nomorTelepon
        };

        // Start loading animation
        startLottieAnimation();

        try {
            const response = await fetch("/api/petani/update", {
                method: "PATCH", // Menggunakan PATCH
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + token // Menambahkan token Bearer
                },
                body: JSON.stringify(data) // Kirim data sebagai JSON
            });

            const result = await response.json(); // Mengambil respon dari server

            if (result.message) {
                // Wait for loading animation to finish before showing success message
                setTimeout(() => {
                    stopLottieAnimation();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: result.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000 // Alert stays for 3 seconds
                    });
                }, 5000); // Wait for loading animation to finish
            }
        } catch (error) {
            stopLottieAnimation(); // Stop loading animation in case of error
            console.error("Error:", error); // Menampilkan error di console jika ada
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan. Silakan coba lagi.',
                icon: 'error',
                showConfirmButton: false,
                timer: 3000 // Alert stays for 3 seconds
            });
        }
    });
</script>


<!-- Script untuk mengirim ubah password -->
<script>
    document.querySelector("#submit-password-change").addEventListener("click", async function() {
        // Ambil nilai dari input form
        const passwordLama = document.querySelector("#password_lama").value;
        const passwordBaru = document.querySelector("#password_baru").value;
        const passwordBaruKonfirmasi = document.querySelector("#password_baru_confirmation").value;

        // Validasi bahwa password baru dan konfirmasi password cocok
        if (passwordBaru !== passwordBaruKonfirmasi) {
            Swal.fire({
                title: 'Gagal!',
                text: 'Password baru dan konfirmasi password tidak cocok.',
                icon: 'error',
                showConfirmButton: false,
                timer: 3000 // Alert stays for 3 seconds
            });
            return;
        }

        // Ambil token dari localStorage atau sessionStorage
        const token = localStorage.getItem('access_token') || sessionStorage.getItem('access_token');
        if (!token) {
            Swal.fire({
                title: 'Gagal!',
                text: 'Token tidak ditemukan. Silakan login ulang.',
                icon: 'error',
                showConfirmButton: false,
                timer: 3000 // Alert stays for 3 seconds
            });
            return;
        }

        // Membuat objek data yang akan dikirim ke server
        const data = {
            password_lama: passwordLama,
            password_baru: passwordBaru,
            password_baru_confirmation: passwordBaruKonfirmasi
        };

        // Start loading animation
        startLottieAnimation();

        try {
            const response = await fetch("/api/petani/update", {
                method: "PATCH", // Menggunakan PATCH
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + token // Menambahkan token Bearer
                },
                body: JSON.stringify(data) // Kirim data sebagai JSON
            });

            const result = await response.json(); // Mengambil respon dari server

            if (result.message) {
                // Wait for loading animation to finish before showing success message
                setTimeout(() => {
                    stopLottieAnimation();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Password berhasil diubah!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000 // Alert stays for 3 seconds
                    }).then(() => {
                        // Clear the input fields
                        document.querySelector("#password_lama").value = "";
                        document.querySelector("#password_baru").value = "";
                        document.querySelector("#password_baru_confirmation").value = "";

                        // Simulate clicking the "close" button with data-bs-dismiss="modal"
                        const closeButton = document.querySelector('[data-bs-dismiss="modal"]');
                        if (closeButton) {
                            closeButton.click(); // Simulate the click on the close button
                        }
                    });
                }, 5000); // Wait for loading animation to finish
            }
        } catch (error) {
            stopLottieAnimation(); // Stop loading animation in case of error
            console.error("Error:", error); // Menampilkan error di console jika ada
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan. Silakan coba lagi.',
                icon: 'error',
                showConfirmButton: false,
                timer: 3000 // Alert stays for 3 seconds
            });
        }
    });
</script>



<script>
    // Function to fetch and update profile data
    const updateProfileData = async () => {
        try {
            // Get the access_token from localStorage or sessionStorage
            const accessToken = localStorage.getItem('access_token') || sessionStorage.getItem('access_token');

            if (!accessToken) {
                console.error("Access token not found.");
                return;
            }

            // API call to fetch petani data with Authorization header
            const response = await fetch('/api/petani/profil', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${accessToken}`, // Add the token to the Authorization header
                    'Content-Type': 'application/json', // Set content type to JSON
                }
            });

            const data = await response.json();

            if (data.message === "Petani ditemukan") {
                const profileData = data.data;

                // Update username
                document.getElementById('username').value = profileData.username;

                // Update nama lengkap
                document.getElementById('namalengkap').value = profileData.nama_petani;

                // Update phone number (nomor_wa)
                document.getElementById('phone').value = profileData.nomor_wa;

                // Update profile picture
                const profilePicture = document.getElementById('profile-picture');

                // Cek apakah foto profil adalah "images/profile.png"
                if (profileData.foto_profil === "images/profile.png") {
                    profilePicture.src = "/images/profile.png"; // Ganti dengan gambar default
                } else {
                    profilePicture.src = `{{ asset('/storage/${profileData.foto_profil}') }}`; // Gambar profil dari storage
                }
            } else {
                console.error("Profile data not found.");
            }
        } catch (error) {
            console.error("Error fetching profile data:", error);
        }
    };

    // Call the function to update profile data when the page loads
    window.onload = updateProfileData;
</script>


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

<!-- Initialize Swiper -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper', {
        slidesPerView: 3,
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
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
    AOS.init();
</script>
@endsection