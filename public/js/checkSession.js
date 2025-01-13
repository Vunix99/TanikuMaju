// Cek apakah SweetAlert2 sudah didefinisikan
if (typeof Swal === 'undefined') {
    // Jika SweetAlert2 belum didefinisikan, buat elemen script untuk memuat CDN SweetAlert2
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
    script.onload = () => {
        // Setelah SweetAlert2 dimuat, eksekusi fungsi yang menggunakan SweetAlert2
        handleTokenValidation();
    };
    document.head.appendChild(script); // Menambahkan script ke <head>
} else {
    // Jika SweetAlert2 sudah ada, langsung jalankan fungsinya
    handleTokenValidation();
}

function handleTokenValidation() {
    // Periksa apakah ada token di sessionStorage atau localStorage
    const check_token = sessionStorage.getItem('access_token') || localStorage.getItem('access_token');

    // Jika sudah memiliki token dan mencoba mengakses halaman '/' atau '/registrasi', arahkan ke '/beranda'
    if (check_token && (window.location.pathname === '/' || window.location.pathname === '/registrasi')) {
        window.location.href = '/beranda';
        return; // Hentikan eksekusi lebih lanjut
    }

    // Jika token tidak ditemukan dan bukan halaman '/' atau '/registrasi', lakukan pengecekan token
    if (!check_token && (window.location.pathname !== '/' && window.location.pathname !== '/registrasi')) {
        Swal.fire({
            icon: 'warning',
            title: 'Token Tidak Ditemukan',
            text: 'Token sesi Anda hilang. Anda akan diarahkan ke halaman login.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#198754', // Mengubah warna tombol
        }).then(() => {
            window.location.href = '/'; // Redirect ke halaman utama setelah SweetAlert ditutup
        });
    } else if (check_token) {
        // Kirim request ke API untuk memverifikasi token
        fetch('/api/check-token', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + check_token // Mengirimkan token yang ditemukan
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid === false) {
                // Jika token tidak valid, hapus token dan alihkan ke halaman utama ('/')
                sessionStorage.removeItem('access_token');
                localStorage.removeItem('access_token');

                // Tampilkan SweetAlert dengan tombol hijau
                Swal.fire({
                    icon: 'error',
                    title: 'Token Kedaluwarsa',
                    text: 'Sesi Anda telah kedaluwarsa. Anda akan diarahkan ke halaman login.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#198754', // Mengubah warna tombol
                }).then(() => {
                    window.location.href = '/'; // Redirect setelah SweetAlert ditutup
                });
            } else if (data.valid === true) {
                // Jika token valid, biarkan pengguna tetap di halaman yang diakses
            }
        })
        .catch(error => console.error('Error checking token:', error));
    }
}
