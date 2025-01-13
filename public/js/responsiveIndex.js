    window.addEventListener("resize", updateBootstrapClasses);
    window.addEventListener("DOMContentLoaded", updateBootstrapClasses); // Jalankan saat halaman dimuat

    function updateBootstrapClasses() {
        const formSign = document.querySelector("#formSign");
        const gambarSign = document.querySelector("#gambarSign");

        if (window.innerWidth > 1400) {
            // Jika layar lebih dari 1400px
            formSign.classList.remove("col-md-6");
            formSign.classList.add("col-md-4");

            gambarSign.classList.remove("col-md-6");
            gambarSign.classList.add("col-md-8");
        } else {
            // Jika layar 1400px atau kurang
            formSign.classList.remove("col-md-4");
            formSign.classList.add("col-md-6");

            gambarSign.classList.remove("col-md-8");
            gambarSign.classList.add("col-md-6");
        }
    }
