@extends('utama.layouts.main')
@section('head')
    <meta charset="UTF-8">
    <!-- Website Icon -->
    <link rel="Website Icon"type="png" href="{{ asset('images/logotani.png') }}">
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
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@2.1.0/dist/iconify-icon.min.js"></script>
    <!-- FOnt -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Weather -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@iconify/iconify@2.0.0-beta.4/dist/iconify.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/monitoring.css') }}">
@endsection


@section('main')
    <div class="container-fluid">
        <!-- Header -->
        <div class="header">
            <!-- IMAGE HEADER -->
        </div>
        <!-- SECTION 1 -->
        <div class="section1">
            <div class="awal">
                <h1 class="pt-5" style="margin-bottom: 20px;" data-aos="fade-up" data-aos-duration="2000"> Pantau Lahan
                    Pertanian Anda</h1>
                <p data-aos="fade-in" data-aos-duration="3000" data-aos-delay="500">Segera pantau lahan pertanian Anda
                    secara langsung dan maksimalkan hasil panen dengan informasi
                    akurat tentang kondisi tanah, kelembaban, dan cuaca. Ambil kendali penuh atas lahan Anda sekarang
                    untuk pertanian yang lebih mudah dan efisien!</p><br>
                <!-- Search Bar -->
                <div class="input-group mt-4 justify-content-center pb-5" data-aos="fade-in" data-aos-duration="1000"
                    data-aos-delay="200">
                    <input type="text" class="form-control" placeholder="Masukan Kode ID IoT" aria-label="Search">
                    <button class="btn btn-warning" type="button" id="searchButton"><i
                            class="fas fa-search"></i></button>
                </div>

            </div>
        </div>

        <!-- Section 2 -->
        <div class="section2 mb-5" id="section2">
            <!-- Section Info -->
            <div class="info-section text-white text-start pb-4" style="background-color: #203B1F;">
                <div class="container d-flex justify-content-between align-items-center" data-aos="fade-down"
                    data-aos-duration="1500" data-aos-delay="500">
                    <div class="d-flex align-items-center ms-auto" style="margin-top: 20px; margin-right: -70px;">
                        <span class="me-4">Jum'at | Nov 14</span>
                        <span class="me-2">
                            <iconify-icon icon="ph:wind" height="30" class="iconify-icon"></iconify-icon>
                        </span>
                        <span class="me-4 ket"> 3.7 km/h <br>Angin</span>
                        <span class="me-2">
                            <iconify-icon icon="carbon:rain" height="30" class="iconify-icon"></iconify-icon>
                        </span>
                        <span class="me-4 ket">74% <br> Hujan</span>
                        <span class="me-2">
                            <iconify-icon icon="ion:thermometer-outline" height="30" class="iconify-icon">
                            </iconify-icon>
                        </span>
                        <span class="me-4 ket"></i> 6.5 <br> pH</span>
                        <span class="me-2">
                            <iconify-icon icon="hugeicons:droplet" height="30" class="iconify-icon"></iconify-icon>
                            </i>
                        </span>
                        <span class="ket">83% <br> Kelembapan Udara</span>
                    </div>
                </div>
            </div>
            <!-- Monitoringgggg -->
            <div class="row pt-5">
                <!-- Kolom Kiri (Gambar) -->
                <div class="col-md-4 image-container mb-4" data-aos="fade-right" data-aos-duration="2000"
                    data-aos-delay="500">
                    <img src="{{ asset('images/lahan.png') }}" alt="Lapangan Pertanian" class="lahan">
                    <div class="hover-area"></div>
                    <div class="middle">
                        <img src="{{ asset('images/jagung.jpg') }}" alt="Jagung" class="jagung-image">
                        <div class="text">Lahan Jagung</div>
                    </div>
                </div>

                <!-- Kolom Kanan (Chart & Info) -->
                <div class="col-md-8">
                    <div class="row mb-4 d-flex align-items-stretch">
                        <!-- Chart Irigasi -->
                        <div class="col-md-3 d-flex" data-aos="zoom-in" data-aos-duration="2000" data-aos-delay="500">
                            <div class="card p-3 h-100 w-100 d-flex flex-column">
                                <h6 class="card-title text-start">Irigasi</h6>
                                <div id="irigasiChart" class="chart-container" style="width: 100%; height: 150px;"></div>
                                <div class="digital-number-container text-center">
                                    <h6 class="digital-number">5.000  / 8.000L</h6>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Grafik Baru (Kelembapan, Suhu, Curah Hujan) -->
                        <div class="col-md-5 d-flex" data-aos="zoom-in" data-aos-duration="2000" data-aos-delay="500">
                            <div class="card p-3 h-100 w-100 d-flex flex-column">
                                <h6 class="card-title text-start">Kelembaban, Suhu, Curah Hujan</h6>
                                <div id="lineChart" class="chart-container"
                                    style="width: 100%; height: 150px; margin-top: -25px;"></div>
                            </div>
                        </div>

                        <!-- Grafik Nutrisi Pupuk -->
                        <div class="col-md-4 d-flex" data-aos="zoom-in" data-aos-duration="2000" data-aos-delay="500">
                            <div class="card p-3 h-100 w-100 d-flex flex-column">
                                <div style="display: flex; justify-content: start; align-items: center;">
                                    <h6 class="card-title">Nutrisi Pupuk</h6>
                                    <h6 class="text-muted" style="margin-left: 5px;">/hari</h6>
                                </div>
                                <div id="barChart" class="chart-container mb-4"
                                    style="width: 100%; height: 150px; margin-top: -25px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Cuaca -->
                        <h5 class="card-title text-start" data-aos="fade-in" data-aos-duration="2000"
                            data-aos-delay="500">Cuaca</h5>
                        <hr class="ms-2 mt-2" style="max-width: 97.5%;">
                        <div class="col-md-6" data-aos="zoom-in" data-aos-duration="2000" data-aos-delay="200">
                            <div class="card p-3">
                                <div class="row">
                                    <div class="col-md-4 justify-content-center align-items-center">
                                        <div class="weather-info">
                                            <p>
                                                <span class="iconify" data-icon="twemoji:sun" data-inline="false"
                                                style="color: #FFA500; font-size: 50px;"></span>
                                            </p>                                         
                                            <p>25°C</p>
                                            <p class="text-muted">Hari Ini</p>
                                        </div>
                                    </div>
                                    <!-- tips -->
                                    <div class="col-md-8">
                                        <h5 class="card-title text-start">Tips</h5>
                                        <p>
                                            Sirami tanaman Anda secara mendalam dan teratur. Usahakan agar tanah selalu lembab, tetapi tidak basah.
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Cuaca -->
                        <div class="col-md-6" data-aos="zoom-in" data-aos-duration="2000" data-aos-delay="200">
                            <div class="weather-card">
                                <div class="weather-item">
                                    <h4>09.00</h4>
                                    <span class="iconify" data-icon="bx:bxs-cloud" data-inline="false"
                                        style="color: #808080;"></span>
                                    <p>18°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>10.00</h4>
                                    <span class="iconify" data-icon="carbon:windy" data-inline="false"
                                        style="color: #00BFFF;"></span>
                                    <p>20°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>11.00</h4>
                                    <span class="iconify" data-icon="twemoji:sun-behind-cloud"
                                        data-inline="false"></span>
                                    <p>22°</p>
                                </div>
                                <div class="weather-item active">
                                    <h4>12.00</h4>
                                    <span class="iconify" data-icon="twemoji:sun" data-inline="false"
                                        style="color: #FFA500;"></span>
                                    <p class="active-temp">25°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>13.00</h4>
                                    <span class="iconify" data-icon="twemoji:sun" data-inline="false"
                                        style="color: #FFA500;"></span>
                                    <p>26°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>14.00</h4>
                                    <span class="iconify" data-icon="twemoji:sun-behind-cloud"
                                        data-inline="false"></span>
                                    <p>24°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>15.00</h4>
                                    <span class="iconify" data-icon="twemoji:cloud-with-rain"
                                        data-inline="false"></span>
                                    <p>23°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>16.00</h4>
                                    <span class="iconify" data-icon="twemoji:cloud-with-rain"
                                        data-inline="false"></span>
                                    <p>22°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>17.00</h4>
                                    <span class="iconify" data-icon="twemoji:cloud-with-rain"
                                        data-inline="false"></span>
                                    <p>22°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>18.00</h4>
                                    <span class="iconify" data-icon="twemoji:sun-behind-cloud"
                                        data-inline="false"></span>
                                    <p>24°</p>
                                </div>
                                <div class="weather-item ">
                                    <h4>19.00</h4>
                                    <span class="iconify" data-icon="f7:cloud-moon-fill" data-inline="false"></span>
                                    <p>24°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>20.00</h4>
                                    <span class="iconify" data-icon="f7:cloud-moon-fill" data-inline="false"></span>
                                    <p>23°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>21.00</h4>
                                    <span class="iconify" data-icon="f7:cloud-moon-fill" data-inline="false"></span>
                                    <p>22°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>22.00</h4>
                                    <span class="iconify" data-icon="f7:cloud-moon-fill" data-inline="false"></span>
                                    <p>22°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>23.00</h4>
                                    <span class="iconify" data-icon="f7:cloud-moon-fill" data-inline="false"></span>
                                    <p>20°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>00.00</h4>
                                    <span class="iconify" data-icon="twemoji:cloud-with-rain"
                                        data-inline="false"></span>
                                    <p>19°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>01.00</h4>
                                    <span class="iconify" data-icon="twemoji:cloud-with-rain"
                                        data-inline="false"></span>
                                    <p>19°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>02.00</h4>
                                    <span class="iconify" data-icon="f7:cloud-moon-fill" data-inline="false"></span>
                                    <p>17°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>03.00</h4>
                                    <span class="iconify" data-icon="f7:cloud-moon-fill" data-inline="false"></span>
                                    <p>12°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>04.00</h4>
                                    <span class="iconify" data-icon="f7:cloud-moon-fill" data-inline="false"></span>
                                    <p>14°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>05.00</h4>
                                    <span class="iconify" data-icon="f7:cloud-moon-fill" data-inline="false"></span>
                                    <p>15°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>06.00</h4>
                                    <span class="iconify" data-icon="twemoji:sun-behind-cloud"
                                        data-inline="false"></span>
                                    <p>16°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>07.00</h4>
                                    <span class="iconify" data-icon="twemoji:sun-behind-cloud"
                                        data-inline="false"></span>
                                    <p>17°</p>
                                </div>
                                <div class="weather-item">
                                    <h4>08.00</h4>
                                    <span class="iconify" data-icon="twemoji:sun-behind-cloud"
                                        data-inline="false"></span>
                                    <p>17°</p>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Section CTA -->
        <div class="section3 mx-0">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-md-12 text-center">
                        <h2 class="fw-bold">Bicarakan Kebutuhan Pertanian <br>
                            Anda dengan AI
                        </h2>
                        <br>
                        <a href="chatai.html" class="btn btn-lg btn-warning fw-bold">Mulai Chat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- JS Scroll -->
    <script>
        window.addEventListener('scroll', function () {
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

    <!-- ApexCharts JS -->
    <script>
        // Pie Chart for Irigasi
        var optionsIrigasi = {
            series: [5000, 3000],
            chart: {
                width: 240,
                type: 'pie',
            },
            labels: ['Air Terpakai', 'Sisa Air'],
            legend: {
                show: false,
            },
            colors: ['#355B3E', '#F7C35F'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 150
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var irigasiChart = new ApexCharts(document.querySelector("#irigasiChart"), optionsIrigasi);
        irigasiChart.render();

        // Line Chart (Kelembapan, Suhu, Curah Hujan)
        var optionsLine = {
            chart: {
                type: 'line',
                height: 223,
                width: '100%',
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Kelembapan',
                data: [45, 55, 30, 60, 70, 50, 40]
            }, {
                name: 'Suhu',
                data: [30, 40, 25, 45, 55, 35, 30]
            }, {
                name: 'Curah Hujan',
                data: [20, 30, 10, 35, 40, 30, 20]
            }],
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            colors: ['#22B07D', '#FEB019', '#4B4B4B'],
            xaxis: {
                categories: ['Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Ming', 'Sen'],
                labels: {
                    style: {
                        fontSize: '10px',
                        colors: '#3E3E3E',
                        fontFamily: 'Montserrat'

                    }
                }
            },
            yaxis: {
                min: 0,
                max: 90,
                tickAmount: 6,
                labels: {
                    style: {
                        fontSize: '10px',
                        colors: '#3E3E3E',
                        fontFamily: 'Montserrat'

                    }
                }
            },
            grid: {
                borderColor: '#E0E0E0',
                strokeDashArray: 3
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function (val) {
                        return val + "°C";
                    }
                },
            },
            legend: {
                fontSize: '10px',
                fontFamily: 'Montserrat',
                labels: {
                    colors: '#3E3E3E'
                }
            }
        };
        var lineChart = new ApexCharts(document.querySelector("#lineChart"), optionsLine);
        lineChart.render();

        // Bar Chart for Nutrisi Pupuk
        var optionsBar = {
            chart: {
                type: 'bar',
                height: 223,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: '',
                data: [60, 90, 45]
            }],
            xaxis: {
                categories: ['Nitrogen', 'Fosfor', 'Kalium'],
                labels: {
                    style: {
                        fontSize: '12px',
                        colors: ['#3E3E3E']
                    }
                }
            },
            yaxis: {
                min: 0,
                max: 90,
                tickAmount: 5,
                labels: {
                    formatter: function (val) {
                        return val + "g";
                    },
                    style: {
                        fontSize: '10px',
                        colors: ['#3E3E3E']
                    }
                }
            },
            grid: {
                borderColor: '#E0E0E0',
                strokeDashArray: 3
            },
            colors: ['#F7C35F', '#355B3E', '#8B4513'],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    dataLabels: {
                        position: 'top'
                    },
                    distributed: true
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val + "g";
                },
                style: {
                    fontSize: '12px',
                    colors: ['#FFFFFF']
                }
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function (val, opts) {
                        var label = opts.w.globals.labels[opts.dataPointIndex];
                        return label + ": " + val + "g"; // Label dengan satuan
                    }
                }
            }
        };
        var barChart = new ApexCharts(document.querySelector("#barChart"), optionsBar);
        barChart.render();
    </script>
@endsection