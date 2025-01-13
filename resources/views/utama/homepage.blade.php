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
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<style>
  .truncate-content {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    /* Change this value to control how many lines you want to display */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }


  /* Truncate title to 2 lines */
  .truncate-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    /* Limit to 2 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    max-height: 3em;
    /* Adjust based on the line height */
    line-height: 1.5em;
    /* Adjust line height */
  }
</style>
@endsection

@section('main')
<div class="container-fluid">
  <!-- Header -->
  <div class="header">
    <div class="header-content">
      <h1 class="fw-bold" style="color: #F7C35F; position: relative;" data-aos="fade-right" data-aos-duration="2000">
        Bersama Petan<span class="relative-i" id="spanImage">i
          <img src="{{ asset('images/image5.svg') }}" class="image-above-i" data-aos="fade-up" data-aos-duration="1500">
        </span>,
      </h1>
      <h1 class="fw-bold" data-aos="fade-right" data-aos-duration="2000">Membangun Pertanian yang Lestari</h1>
      <p data-aos="fade-right" data-aos-duration="2000">Dengan teknologi pertanian modern, kami mendukung petani dalam
        mengelola lahan secara efisien, meningkatkan hasil panen, dan menjaga keberlanjutan.</p>
      <a href="#cardHeader" class="btn btn-warning pelajari" data-aos="fade-in" data-aos-duration="1500"
        data-aos-delay="1500">Pelajari Disini</a>
    </div>
  </div>

  <!-- Cards Section-->
  <div class="container bottom-card" id="cardHeader" data-aos="fade-up" data-aos-duration="1500">
    <div class="row text-center">
      <div class="col-md-4">
        <div class="card p-3" data-aos="zoom-in" data-aos-duration="1000">
          <div class="icon">
            <img src="{{ asset('images/pantautani.svg') }}" alt="">
          </div>
          <h5>Kalkulator Tani</h5>
          <p>Optimalkan hasil panen Anda dengan fitur Kalkulasi Tani, solusi cerdas untuk menghitung perkiraan waktu panen dengan mudah dan akurat!</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3" data-aos="zoom-in" data-aos-duration="2000">
          <div class="icon">
            <img src="{{ asset('images/carbon_rain.svg') }}" alt="">
          </div>
          <h5>Cuaca</h5>
          <p>Dapatkan prediksi cuaca real-time dan laporan prakiraan cuaca jangka panjang untuk mengoptimalkan jadwal
            pertanian Anda.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3" data-aos="zoom-in" data-aos-duration="3000">
          <div class="icon">
            <img src="{{ asset('images/chat.svg') }}" alt="">
          </div>
          <h5>Forum Diskusi</h5>
          <p>Diskusikan tantangan pertanian anda bersama komunitas petani. Dapatkan solusi dari mereka yang memiliki pengalaman serupa.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Artikel -->
  <!-- Artikel -->
  <div class="section1">
    <!-- Swiper -->
    <div class="swiper">
      <div class="swiper-wrapper" id="artikelContainer">
        <!-- Artikel akan dimasukkan secara dinamis di sini -->
      </div>
      <!-- Pagination -->
      <div class="swiper-pagination"></div>
    </div>
  </div>


  <!-- Section 2 -->
  <div class="section2">
    <div class="row justify-content-center align-items-center mx-0"
      style="background-image: url('/images/bgpantau.png');">
      <div class="col-md-8 flex-column">
        <div class="contentdua">
          <div class="isi" data-aos="fade-right" data-aos-duration="1500">
            <h1 class="fw-bold">Pantau Lahan Pertanian</h1>
            <br>
            <p>
              Dapatkan akses ke data lahan pertanian terkini yang dirancang untuk meningkatkan hasil panen Anda. Pantau
              kelembaban tanah, prediksi cuaca, dan deteksi hama dalam satu platform. Jadikan setiap keputusan pertanian
              lebih tepat dan efektif dengan teknologi canggih kami.
            </p>
          </div>
          <br>
          <a href="monitoring.html" class="btn btn-warning fw-bold" data-aos="fade-in" data-aos-duration="2000" data-aos-delay="100">Selanjutnya</a>
        </div>
      </div>
      <div class="col-md-4 d-none d-md-flex align-items-center flex-column" data-aos="fade-left"
        data-aos-duration="1500" data-aos-delay="200">
        <img src="{{ asset('images/pantau.jpg') }}" class="w-75 d-block"
          style="transform: scale(1.41); object-fit: cover; object-position: center;">
      </div>
    </div>
  </div>

  <!-- Section 3 -->
  <div class="section3 justify-content-center" id="section3">
    <div class="weather-card" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="200">
      <div class="time-section">
        <h1 class="fw-bold" id="clock"></h1>
        <div class="date-location">
          <h5 class="fw-bold" id="date"></h5>
          <h5><i class="fas fa-map-marker-alt"></i> <span id="location"></span></h5>
        </div>
      </div>
      <div class="temperature-section">
        <h1 class="fw-bold" id="temperature"></h1>
        <h5 id="weather-description"></h5>
        <h5 id="feels-like"></h5>
      </div>
    </div>
  </div>

</div>

<!-- Initialize Swiper -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!--JS OPEN WEATHER-->
<script>
  // API Key dari OpenWeather    
 const apiKey = "{{ $apiKey }}";

  function fetchWeather() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const lat = position.coords.latitude;
          const lon = position.coords.longitude;

          // URL API OpenWeather
          const apiUrl = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&appid=${apiKey}`;

          fetch(apiUrl)
            .then((response) => {
              if (!response.ok) {
                throw new Error(`Kesalahan HTTP! status: ${response.status}`);
              }
              return response.json();
            })
            .then((data) => {
              console.log('Data Cuaca:', data);

              // Menampilkan detail cuaca
              document.getElementById('clock').innerText = new Date().toLocaleTimeString('id-ID');
              document.querySelector('.date-location h5').innerText = formatDate(new Date());
              document.querySelector('.date-location h5:last-child').innerHTML = `<i class="fas fa-map-marker-alt"></i> ${data.name}`;
              document.querySelector('.temperature-section h1').innerText = `${data.main.temp}°C`;

              // Terjemahkan deskripsi cuaca dan pilih icon cuaca
              const weatherDescription = translateWeatherDescription(data.weather[0].description);
              const icon = `https://openweathermap.org/img/wn/${data.weather[0].icon}.png`;

              document.querySelector('.temperature-section h5').innerText = weatherDescription;
              document.querySelector('.temperature-section h5:last-child').innerText = `Terasa seperti ${data.main.feels_like}°C`;
              document.querySelector('.weather-icon img').src = icon;
            })
            .catch((error) => {
              console.error('Kesalahan saat mengambil data cuaca:', error);
            });
        },
        (error) => {
          console.error('Kesalahan saat mendapatkan geolokasi:', error);
        }
      );
    } else {
      console.error('Geolokasi tidak didukung oleh browser ini.');
    }
  }

  // Fungsi untuk menerjemahkan deskripsi cuaca
  function translateWeatherDescription(description) {
    const translations = {
      "clear sky": "Langit cerah",
      "few clouds": "Beberapa awan",
      "scattered clouds": "Awan tersebar",
      "broken clouds": "Awan pecah",
      "shower rain": "Hujan ringan",
      "rain": "Hujan",
      "thunderstorm": "Badai petir",
      "snow": "Salju",
      "mist": "Kabut",
      "smoke": "Asap",
      "haze": "Kabut tipis",
      "dust": "Debu",
      "fog": "Kabut tebal",
      "sand": "Pasir",
      "ash": "Abu",
      "squall": "Angin kencang",
      "tornado": "Tornado",
      // Weather condition codes
      "thunderstorm with light rain": "Badai petir dengan hujan ringan",
      "thunderstorm with rain": "Badai petir dengan hujan",
      "thunderstorm with heavy rain": "Badai petir dengan hujan deras",
      "light thunderstorm": "Badai petir ringan",
      "thunderstorm": "Badai petir",
      "heavy thunderstorm": "Badai petir hebat",
      "ragged thunderstorm": "Badai petir tak teratur",
      "thunderstorm with light drizzle": "Badai petir dengan gerimis ringan",
      "thunderstorm with drizzle": "Badai petir dengan gerimis",
      "thunderstorm with heavy drizzle": "Badai petir dengan gerimis deras",
      "light intensity drizzle": "Gerimis ringan",
      "drizzle": "Gerimis",
      "heavy intensity drizzle": "Gerimis deras",
      "light intensity drizzle rain": "Hujan gerimis ringan",
      "drizzle rain": "Hujan gerimis",
      "heavy intensity drizzle rain": "Hujan gerimis deras",
      "shower rain and drizzle": "Hujan ringan dan gerimis",
      "heavy shower rain and drizzle": "Hujan deras dan gerimis",
      "shower drizzle": "Gerimis hujan",
      "light rain": "Hujan ringan",
      "moderate rain": "Hujan sedang",
      "heavy intensity rain": "Hujan deras",
      "very heavy rain": "Hujan sangat deras",
      "extreme rain": "Hujan ekstrem",
      "freezing rain": "Hujan beku",
      "light intensity shower rain": "Hujan ringan",
      "shower rain": "Hujan ringan",
      "heavy intensity shower rain": "Hujan deras",
      "ragged shower rain": "Hujan tidak teratur",
      "light snow": "Salju ringan",
      "snow": "Salju",
      "heavy snow": "Salju lebat",
      "sleet": "Salju campur hujan",
      "light shower sleet": "Hujan salju ringan",
      "shower sleet": "Hujan salju",
      "light rain and snow": "Hujan dan salju ringan",
      "rain and snow": "Hujan dan salju",
      "light shower snow": "Salju ringan",
      "shower snow": "Salju",
      "heavy shower snow": "Salju lebat",
      "mist": "Kabut",
      "smoke": "Asap",
      "haze": "Kabut tipis",
      "dust": "Debu",
      "fog": "Kabut tebal",
      "sand": "Pasir",
      "ash": "Abu",
      "squall": "Angin kencang",
      "tornado": "Tornado",
      "clea skyr": "Langit Cerah",
      "few clouds": "Beberapa Awan",
      "scattered clouds": "Awan Tersebar",
      "broken clouds": "Awan Rusak",
      "overcast clouds": "Awan Mendung"

    };

    return translations[description.toLowerCase()] || description.charAt(0).toUpperCase() + description.slice(1);
  }

  // Fungsi format tanggal
  function formatDate(date) {
    const options = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    };
    return new Date(date).toLocaleDateString('id-ID', options);
  }

  // Inisialisasi pengambilan cuaca
  document.addEventListener('DOMContentLoaded', fetchWeather);
</script>



<!-- Script.JS -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const artikelContainer = document.getElementById("artikelContainer");

    // Fetch data artikel dari API
    fetch("/api/artikel", {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        }
      })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Gagal mengambil data artikel");
        }
        return response.json();
      })
      .then((data) => {
        // Pastikan data ada
        if (data.length === 0) {
          artikelContainer.innerHTML = "<p>Tidak ada artikel yang tersedia.</p>";
          return;
        }

        // Generate artikel HTML
        data.forEach((artikel, index) => {
          const delay = 100 + index * 100; // Tambahkan delay animasi berdasarkan indeks

          // Process the content by removing all HTML tags
          let isiArtikel = artikel.isi;

          // Create a new temporary div to process the HTML
          const tempDiv = document.createElement('div');
          tempDiv.innerHTML = isiArtikel;

          // Remove all HTML tags and keep only the plain text
          const plainText = tempDiv.textContent || tempDiv.innerText;

          // Check if the text length exceeds a threshold (e.g., 200 characters)
          const truncatedText = plainText.length > 200 ? plainText.substring(0, 200) + '...' : plainText;

          // Wrap the truncated text in a <p> tag with class 'truncate-content'
          const artikelHTML = `
                <div class="swiper-slide" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="${delay}">
                    <div class="card custom-card">
                        <img src="${artikel.gambar}" class="card-img-top zoom" alt="${artikel.judul}">
                        <div class="card-body">
                            <h5 class="card-title truncate-title">${artikel.judul}</h5>
                            <div class="card-text">
                                <p class="truncate-content">${truncatedText}</p>
                            </div>
                        </div>
                        <div class="card-footer ms-auto">
                            <a href="/artikel/detail/?id=${artikel.id}" class="btn">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `;
          artikelContainer.insertAdjacentHTML("beforeend", artikelHTML);
        });

        var swiper = new Swiper('.swiper', {
          slidesPerView: 3, // Default 3 cards per slide
          spaceBetween: 30,
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
          },
          breakpoints: {
            // When the screen width is 1280px or above, show 4 cards per slide
            1280: {
              slidesPerView: 4,
            },
            // When the screen width is between 768px and 1280px, show 3 cards per slide
            768: {
              slidesPerView: 3,
            },
            // When the screen width is between 480px and 768px, show 2 cards per slide
            480: {
              slidesPerView: 2,
            },
            // When the screen width is 480px or less, show 1 card per slide
            0: {
              slidesPerView: 1,
            },
          },
        });


        // Add margin to the swiper pagination dots
        const swiperPagination = document.querySelector('.swiper-pagination');
        if (swiperPagination) {
          swiperPagination.style.marginTop = '10px'; // Add 10px top margin
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        artikelContainer.innerHTML = "<p>Terjadi kesalahan saat memuat artikel.</p>";
      });
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

<!-- Script Clock -->
<script>
  function randomTime() {
    const randomHour = Math.floor(Math.random() * 24);
    const randomMinute = Math.floor(Math.random() * 60);

    const formattedHour = randomHour < 10 ? '0' + randomHour : randomHour;
    const formattedMinute = randomMinute < 10 ? '0' + randomMinute : randomMinute;

    return `${formattedHour}:${formattedMinute}`;
  }

  function getCurrentTime() {
    const now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();
    hours = hours < 10 ? '0' + hours : hours;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    return `${hours}:${minutes}`;
  }

  function startRandomAnimation() {
    const clock = document.getElementById("clock");
    let randomInterval = setInterval(() => {
      clock.innerHTML = randomTime();
    }, 100);
    setTimeout(() => {
      clearInterval(randomInterval);
      clock.innerHTML = getCurrentTime();
      startRealClock();
    }, 2000);
  }

  function startRealClock() {
    const clock = document.getElementById("clock");

    function updateClock() {
      clock.innerHTML = getCurrentTime();
    }
    setInterval(updateClock, 60000);
  }

  function observeSection() {
    const section3 = document.getElementById("section3");
    const observerCallback = (entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          startRandomAnimation();
          observer.unobserve(section3);
        }
      });
    };
    const observerOptions = {
      root: null,
      threshold: 0.5
    };
    const observer = new IntersectionObserver(observerCallback, observerOptions);
    observer.observe(section3);
  }
  document.addEventListener("DOMContentLoaded", observeSection);
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