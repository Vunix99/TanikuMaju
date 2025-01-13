// for tab content js start //
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;

    // Ambil semua elemen dengan class "tabcontent"
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Ambil semua elemen dengan class "tablinks"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Tampilkan tab content yang dipilih jika elemen dengan id cityName ada
    var cityElement = document.getElementById(cityName);
    if (cityElement) {
        cityElement.style.display = "block";
    }

    // Tambahkan class "active" pada tombol yang dipilih jika elemen evt ada
    if (evt && evt.currentTarget) {
        evt.currentTarget.className += " active";
    }
}

// Coba klik elemen dengan id "defaultOpen" jika elemen tersebut ada
var defaultTab = document.getElementById("defaultOpen");
if (defaultTab) {
    defaultTab.click();
}
// for tab content js end //
