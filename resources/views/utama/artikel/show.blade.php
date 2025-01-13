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
<!-- Icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<!-- Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
  rel="stylesheet">
<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/detailArtikel.css') }}">
<style>
  .image-container {
    position: relative;
    display: inline-block;
    width: 100%;
    height: auto;
  }

  .image-container img {
    display: block;
    width: 100%;
    height: auto;
  }

  .image-container .overlay {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* Warna hitam transparan */
    z-index: 1;
  }

  .article-image {
    z-index: 0;
    /* Pastikan gambar berada di belakang overlay */
  }
</style>
@endsection

@section('main')
<!-- Main Content Section -->


<section class="main-content">
  <div class="image-container" data-aos="fade-down" data-aos-duration="1500" data-aos-delay="200" >
    <img src="" alt="" data-aos="fade-down" data-aos-duration="1500" data-aos-delay="200" style="height: 700px;" class="article-image">
    <div class="overlay"></div>
  </div>
  <h1 data-aos="fade-up" data-aos-duration="2000" data-aos-delay="200"></h1>
  <time datetime=""></time>
</section>

<section class="related-articles">
  <h3>Artikel Lainnya</h3>
  <div class="article-card-container" data-aos="fade-up" data-aos-duration="1000">
    <!-- Kontainer ini akan diisi dengan artikel secara dinamis -->
  </div>
</section>


<!-- JS Scroll -->

<!--Isi Artikel Utama-->
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


<script>
  // Function to fetch and display related articles
  async function fetchRelatedArticles() {
    try {
      // Ambil id artikel saat ini dari query parameter
      const urlParams = new URLSearchParams(window.location.search);
      const articleId = urlParams.get('id'); // Ambil parameter 'id' dari URL

      // Tentukan limit artikel yang akan diambil dan id artikel yang akan dikecualikan
      const limit = 3;
      const exclude = articleId;

      // Panggil API untuk mendapatkan artikel terkait
      const response = await fetch(`/api/artikel?limit=${limit}&exclude=${exclude}`);

      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }

      const articles = await response.json(); // Parse JSON response

      // Pilih elemen container untuk artikel terkait
      const articleContainer = document.querySelector('.article-card-container');

      // Kosongkan kontainer sebelum merender ulang
      articleContainer.innerHTML = '';

      // Loop untuk membuat kartu artikel dinamis
      articles.forEach(article => {
        const articleCard = document.createElement('div');
        articleCard.className = 'article-card';

        // Cek apakah deskripsi ada, jika tidak ada tampilkan pesan default
        const description = article.isi ? article.isi.substring(0, 100) : 'Deskripsi tidak tersedia';

        // Menambahkan tanggal dinamis (bisa diambil dari artikel jika ada, atau menggunakan tanggal saat ini)
        const currentDate = new Date();
        const formattedDate = currentDate.toLocaleDateString('id-ID', {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });

        articleCard.innerHTML = `
          <div class="card-body" style="cursor: pointer;">
            <img src="${article.gambar}" class="img zoom" alt="${article.judul}">
            <div class="card-content">
              <h3 style="font-weight: bold; margin-bottom:12px;">${article.judul}</h3>
              <p class="fw-bold" style="color: #69340E; margin-bottom:0px;">${formattedDate}</p> <!-- Menambahkan tanggal dinamis -->
              <p style="font-size:14px; color: #8E8E8E; margin-bottom: 12px;">${description}...</p>
            </div>
            <div class="button-class" style="width:auto; margin-top:48px;">
              <a href="/artikel/detail?id=${article.id}" class="arrow-button">
                <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        `;

        // Tambahkan event listener untuk redirect saat card-body diklik
        articleCard.querySelector('.card-body').addEventListener('click', function() {
          window.location.href = `/artikel/detail?id=${article.id}`;
        });

        // Tambahkan kartu artikel ke kontainer
        articleContainer.appendChild(articleCard);
      });

    } catch (error) {
      console.error('Error fetching related articles:', error);
    }
  }

  // Panggil fungsi untuk menampilkan artikel terkait
  fetchRelatedArticles();
</script>







<script>
  // Function to get the ID from URL parameters
  function getArticleIdFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('id'); // Get the 'id' parameter
  }

  // Function to fetch and display article data
  async function fetchArticleById() {
    const id = getArticleIdFromUrl(); // Get ID from URL
    if (!id) {
      console.error('Article ID not found in the URL!');
      return;
    }

    try {
      const response = await fetch(`/api/artikel/${id}`);
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }

      const article = await response.json();

      // Select the main content section
      const mainContent = document.querySelector('.main-content');

      // Set the image
      const imgElement = mainContent.querySelector('.article-image');
      imgElement.src = `${article.gambar}`;
      imgElement.alt = article.judul;

      // Set the title
      const titleElement = mainContent.querySelector('h1');
      titleElement.textContent = article.judul;

      // Set the date
      const timeElement = mainContent.querySelector('time');
      const formattedDate = new Date(article.tanggal).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
      });
      timeElement.textContent = formattedDate;
      timeElement.setAttribute('datetime', article.tanggal);

      // Append content dynamically with styling
      const contentElement = document.createElement('div');
      const screenWidth = window.innerWidth;
      // Atur margin berdasarkan lebar layar
      if (screenWidth <= 480) {
        // Untuk layar kecil (smartphone)
        contentElement.style.marginLeft = '20px';
        contentElement.style.marginRight = '20px';
      } else if (screenWidth <= 768) {
        // Untuk layar sedang (tablet)
        contentElement.style.marginLeft = '40px';
        contentElement.style.marginRight = '40px';
      } else {
        // Untuk layar besar (desktop)
        contentElement.style.marginLeft = '85px';
        contentElement.style.marginRight = '85px';
      }
      contentElement.innerHTML = article.isi;

      mainContent.appendChild(contentElement);

    } catch (error) {
      console.error('Error fetching article data:', error);
    }
  }

  // Call the function to fetch and display the article
  fetchArticleById();
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
  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<!-- AOS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"
  integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  AOS.init();
</script>
@endsection