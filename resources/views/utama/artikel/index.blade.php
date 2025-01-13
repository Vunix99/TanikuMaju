@extends('utama.layouts.main')
@section('head')
<meta charset="UTF-8">
<!-- Website Icon -->
<link rel="Website Icon" type="png" href="{{ asset('images/logotani.png') }}">
<!-- AOS CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
  integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Swiper Js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- Icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<!-- Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
  rel="stylesheet">
<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/artikel.css') }}">
@endsection

@section('main')
<div class="container-fluid p-0">
  <!-- Header -->
  <div class="header">
    <div class="header-content">
      <h1 class="fw-bold" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="200">Baca Artikel <br> Terbaru
        Kami</h1>
    </div>
  </div>

  <!-- Article Section -->
  <div class="container my-5">
    <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
      <h2>Artikel TanikuMaju</h2>
      <!-- Search Bar -->
      <div class="input-group mb-3 justify-content-center" data-aos="fade-up" data-aos-duration="2000"
        data-aos-delay="200">
        <input type="text" class="form-control" id="searchInput" placeholder="Masukkan judul artikel" aria-label="Search">
        <button class="btn btn-warning" type="button" id="searchButton"><i class="fas fa-search"></i></button>
      </div>
    </div>
  </div>

  <!-- Swiper Section -->
  <div class="container my-5">
    <div class="row">

      <!-- SWiper -->
      <div class="swiper" data-aos="fade-up" data-aos-duration="1000">
        <div class="swiper-wrapper">
          <!-- Swiper slides akan diisi dengan JS -->
          <div class="swiper-slide">
            <!-- Placeholder untuk konten yang akan diisi lewat JavaScript -->
          </div>
        </div>

        <div class="pembatas"></div>

        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
      </div>

    </div>
  </div>


</div>


<!-- Script -->
<!-- JS Swiper -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const apiUrl = "/api/artikel"; // Ganti dengan endpoint API yang sesuai
  const swiperWrapper = document.querySelector(".swiper-wrapper");
  const searchInput = document.getElementById('searchInput');
  const searchButton = document.getElementById('searchButton');
  let debounceTimeout;

  // Fetch artikel dari API
  fetch(apiUrl)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`API error: ${response.status}`);
      }
      return response.json();
    })
    .then((articles) => {
      if (!Array.isArray(articles) || articles.length === 0) {
        throw new Error("No articles found in API response.");
      }
      renderArticles(articles);
    })
    .catch((error) => {
      console.error("Error fetching articles:", error);
      displayErrorMessage("Failed to load articles. Please try again later.");
    });

  // Fungsi untuk merender artikel
  function renderArticles(articles) {
    swiperWrapper.innerHTML = ""; // Kosongkan konten yang ada

    articles.forEach((article, index) => {
      const slideIndex = Math.floor(index / 6); // Kelompokkan artikel per 6 artikel per slide
      let slide = swiperWrapper.querySelector(`.swiper-slide[data-index="${slideIndex}"]`);

      if (!slide) {
        slide = document.createElement("div");
        slide.classList.add("swiper-slide");
        slide.setAttribute("data-index", slideIndex);
        slide.innerHTML = `<div class="row"></div>`;
        swiperWrapper.appendChild(slide);
      }

      const row = slide.querySelector(".row");

      const articleHtml = `
        <div class="col-md-4 mb-4">
          <a href="/artikel/detail/?id=${article.id}">
            <div class="card">
              <img src="${article.gambar || '/default-image.jpg'}" class="card-img-top zoom" alt="${article.judul || 'Gambar Artikel'}">
              <div class="card-body">
                <p class="fw-bold" style="color: #69340E;">${formatDate(article.tanggal)}</p>
                <h5 class="card-title article-title">${article.judul || 'Judul Artikel'}</h5>
                <p class="card-text">${generateSummary(article.isi) || 'Ringkasan tidak tersedia.'}</p>
              </div>
            </div>
          </a>
        </div>
      `;

      row.insertAdjacentHTML("beforeend", articleHtml);
    });

    initializeSwiper(); // Inisialisasi Swiper setelah artikel di-render
  }

  // Helper untuk format tanggal
  function formatDate(dateStr) {
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(dateStr).toLocaleDateString("id-ID", options);
  }

  // Helper untuk membuat ringkasan dari isi artikel
  function generateSummary(content) {
    const tempDiv = document.createElement("div");
    tempDiv.innerHTML = content;
    const text = tempDiv.textContent || tempDiv.innerText || "";
    return text.length > 100 ? `${text.substring(0, 100)}...` : text;
  }

  // Fungsi untuk menginisialisasi Swiper.js
  function initializeSwiper() {
    new Swiper('.swiper', {
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
        renderBullet: (index, className) => `<span class="${className}">${index + 1}</span>`,
      },
    });
  }

  // Fungsi untuk menampilkan pesan error
  function displayErrorMessage(message) {
    swiperWrapper.innerHTML = `<div class="error-message">${message}</div>`;
  }

  // Fungsi pencarian artikel berdasarkan judul
  function searchArticles() {
    const query = searchInput.value.trim().toLowerCase(); // Ambil nilai input dan ubah menjadi huruf kecil
    const swiperSlides = document.querySelectorAll('.swiper-slide'); // Ambil elemen swiper-slide

    console.log(`Mencari artikel dengan kata kunci: "${query}"`); // Tambahkan log pencarian

    swiperSlides.forEach(slide => {
      const articles = slide.querySelectorAll('.article-title');
      let slideContainsMatch = false; // Lacak apakah slide memiliki kecocokan

      articles.forEach(article => {
        const title = article.textContent.trim().toLowerCase();
        if (title.includes(query)) {
          article.closest('.col-md-4').style.display = ''; // Tampilkan artikel
          slideContainsMatch = true; // Tandai kecocokan ditemukan
        } else {
          article.closest('.col-md-4').style.display = 'none'; // Sembunyikan artikel
        }
      });

      // Tampilkan atau sembunyikan slide berdasarkan kecocokan
      slide.style.display = slideContainsMatch ? '' : 'none';
    });
  }

  // Tambahkan event listener untuk input pencarian dengan debounce
  searchInput.addEventListener('input', () => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(searchArticles, 500);
  });

  // Tambahkan event listener untuk tombol pencarian
  searchButton.addEventListener('click', searchArticles);
});

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