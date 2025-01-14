@extends('utama.layouts.main')
@section('head')
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
<!-- ICon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@2.1.0/dist/iconify-icon.min.js"></script>
<!-- FOnt -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
<!-- JS Typing -->
<script src="https://unpkg.com/typeit@8.7.1/dist/index.umd.js"></script>
<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/chatai.css') }}">
@endsection

@section('main')


<!-- Container -->
<div class="container-fluid konten">
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <h1 class="fw-bold" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="200">
                Optimalkan <br>
                Pertanian Anda <br>
                dengan Bantuan AI
            </h1>
            <h3 style="color: #869DAD;" class="mt-4" data-aos="fade-in" data-aos-duration="2500"
                data-aos-delay="550">Akses chat AI Sekarang Juga - Mulai Chat!</h3>
        </div>
    </div>

    <!-- Section for Logos -->
    <div class="logo-section py-4" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="1000">
        <div class="container">
            <div class="marquee">
                <div class="row justify-content-center align-items-center marquee-content">
                    <div class="col text-center">
                        <img src="{{ asset('images/humana.png') }}" alt="Humana" class="logo-img">
                    </div>
                    <div class="col text-center">
                        <img src="{{ asset('images/anthem.png') }}" alt="Anthem" class="logo-img">
                    </div>
                    <div class="col text-center">
                        <img src="{{ asset('images/healthcare.png') }}" alt="UnitedHealthcare" class="logo-img">
                    </div>
                    <div class="col text-center">
                        <img src="{{ asset('images/aetna.png') }}" alt="Aetna" class="logo-img">
                    </div>
                    <div class="col text-center">
                        <img src="{{ asset('images/cigna.png') }}" alt="Cigna" class="logo-img">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section1">
        <!-- Chat Container -->
        <div class="chat-container"></div>

        <!-- Animation Chat Opening -->
        <div id="animationChatOpening" class="answer-container" data-aos="fade-up" data-aos-duration="900" data-aos-delay="950">
            <div class="icon-container">
                <span class="iconify" data-icon="mdi:sparkles"></span>
            </div>
            <div class="answer-box-opening">
                <p id="multipleStringsOpening"></p>
            </div>
        </div>

        <!-- Input and Send Button -->
        <div class="chat-input-container" data-aos="fade-up" data-aos-duration="800" data-aos-delay="800">
            <textarea id="inputAi" type="text" class="chat-input" placeholder="Masukan Pertanyaan Anda"></textarea>
            <div class="send-button" id="sendButton">
                <iconify-icon icon="tabler:send" style="color: white" height="22"></iconify-icon>
            </div>
        </div>

        <p id="powered" style="font-size: 16px; color:white; justify-content:center; align-items:center; display:flex; margin-bottom:0px;" data-aos="fade-up" data-aos-duration="900" data-aos-delay="950">AI Powered by</p>
        <img id="imagePowered" src="{{ asset('images/gemini.svg') }}" style="width: 84px; height:auto; justify-content:center; align-items:center; display:flex; margin: 0 auto 48px auto;" data-aos="fade-up" data-aos-duration="900" data-aos-delay="950">
    </div>

</div>


<script>
 document.getElementById('sendButton').addEventListener('click', function() {
    const inputBox = document.getElementById('inputAi');
    const inputValue = inputBox.value.trim();

    // Function to set the default height based on screen size
    function setDefaultHeight() {
        const screenWidth = window.innerWidth;

        // Set the default height based on screen width
        if (screenWidth <= 600) {
            inputBox.style.height = '44px'; // For screens with max-width 600px
        } else if (screenWidth > 600 && screenWidth <= 768) {
            inputBox.style.height = '50px'; // For screens with 601px to 768px width
        } else {
            inputBox.style.height = '54px'; // For screens with min-width 769px
        }
    }

    // Call the function to set the height based on screen size
    setDefaultHeight();

    // Pastikan input tidak kosong
    if (inputValue !== '') {
        const chatContainer = document.querySelector('.chat-container');

        // Tambahkan elemen pertanyaan
        const questionChat = document.createElement('div');
        questionChat.classList.add('question-container');
        questionChat.innerHTML = `
            <div class="question-box">
                <p>${inputValue}</p>
            </div>
        `;
        chatContainer.appendChild(questionChat);

        // Hapus elemen animationChatOpening jika ada
        const animationChatOpening = document.getElementById('animationChatOpening');
        if (animationChatOpening) animationChatOpening.remove();

        // Display typing effect (SiTani sedang mengetik...)
        const typingEffect = document.createElement('div');
        typingEffect.classList.add('typing-effect');
        typingEffect.innerHTML = `
            <div class="typing-text" style="margin-left:64px;">
                <p>SiTani sedang mengetik<span id="typingDots">.</span></p>
            </div>
        `;
        chatContainer.appendChild(typingEffect);

        // Start typing animation
        startTypingEffect();

        // Menghapus nilai input
        inputBox.value = '';

        // Reset the height to default after sending
        setDefaultHeight();

        // Ambil token akses
        let access_token = localStorage.getItem('access_token') || sessionStorage.getItem('access_token');

        // Pastikan token akses ada
        if (access_token) {
            // Panggil API
            fetch('/api/gemini/generate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${access_token}`
                    },
                    body: JSON.stringify({
                        text: inputValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        const responseText = data.data.candidates[0].content.parts[0].text;
                        const formattedText = formatResponseText(responseText);

                        // Remove typing effect and display answer
                        typingEffect.remove();

                        // Add the answer with typing effect
                        const answerChat = document.createElement('div');
                        answerChat.classList.add('answer-container');
                        answerChat.innerHTML = `
                            <div class="icon-container">
                                <span class="iconify" data-icon="mdi:sparkles"></span>
                            </div>
                            <div class="answer-box-opening">
                                <p class="answerText"></p> <!-- Use a class instead of id -->
                            </div>
                        `;
                        chatContainer.appendChild(answerChat);

                        // Start the typing effect for the answer text
                        const answerTextElement = answerChat.querySelector('.answerText');
                        typeLetterByLetter(formattedText, answerTextElement);
                    } else {
                        alert('Terjadi kesalahan: ' + data.status);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghubungi API');
                });
        } else {
            alert('Token akses tidak ditemukan');
        }

        // Scroll ke bawah hanya jika posisi scroll saat ini ada di paling bawah
        const isAtBottom = chatContainer.scrollHeight - chatContainer.scrollTop === chatContainer.clientHeight;
        if (isAtBottom) {
            chatContainer.scrollTop = chatContainer.scrollHeight; // Scroll to the bottom after adding the question
        }
    } else {
        alert('Input tidak boleh kosong.');
    }
});


    let isAutoScrolling = true;

    // Function to type the formatted response text letter by letter, handling HTML tags properly
    function typeLetterByLetter(text, element) {
        let index = 0;
        const speed = 5; // Set speed of typing effect to 50ms between each letter
        let formattedText = ''; // To accumulate the formatted text
        let tagBuffer = ''; // Temporary buffer to accumulate HTML tags
        let isInsideTag = false; // Flag to check if we're inside an HTML tag

        const chatContainer = document.querySelector('.chat-container');
        const isAtBottom = chatContainer.scrollHeight - chatContainer.scrollTop === chatContainer.clientHeight;

        // Clear previous content before starting
        element.innerHTML = '';

        // Function to type each letter
        function type() {
            if (index < text.length) {
                const char = text.charAt(index);

                if (char === '<') {
                    isInsideTag = true;
                    tagBuffer = '<'; // Start capturing the tag
                    index++;
                } else if (isInsideTag) {
                    tagBuffer += char;
                    if (char === '>') {
                        isInsideTag = false; // End of tag
                        formattedText += tagBuffer; // Add tag to the formattedText
                        tagBuffer = ''; // Reset the tag buffer
                        index++;
                    } else {
                        index++;
                    }
                } else {
                    formattedText += char;
                    index++;
                }

                // Update the innerHTML with the accumulated text
                element.innerHTML = formattedText;

                // Only scroll if the user hasn't scrolled up manually
                if (isAutoScrolling) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }

                // Continue the typing effect
                setTimeout(type, speed); // Delay between each letter (50ms)
            } else {
                // After typing is finished, ensure scroll to bottom if not already there
                if (isAutoScrolling) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            }
        }

        // Start typing
        type();
    }

    // Listen for scroll events to check if the user has manually scrolled
    const chatContainer = document.querySelector('.chat-container');
    chatContainer.addEventListener('scroll', () => {
        const isAtBottom = chatContainer.scrollHeight - chatContainer.scrollTop === chatContainer.clientHeight;
        isAutoScrolling = isAtBottom; // Stop auto-scrolling if the user scrolls up
    });


    // Function to format the response text (same as your existing function)
    function formatResponseText(text) {
        return text
            .replace(/\n/g, '<br>') // Mengganti \n dengan <br>
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>') // Mengganti **teks** dengan <strong>teks</strong>
            .replace(/\*(.*?)\*/g, '<em>$1</em>'); // Mengganti *teks* dengan <em>teks</em>
    }


    // Function to scroll the chat container to the bottom
    function scrollToBottom() {
        const chatContainer = document.querySelector('.chat-container');
        chatContainer.scrollTop = chatContainer.scrollHeight; // Scroll to the bottom
    }


    // Function that will call formatResponseText and then use typeLetterByLetter to show the formatted text
    function showFormattedTextWithTypingEffect(text, element) {
        // First, format the text using the formatResponseText function
        const formattedText = formatResponseText(text);

        // Then, pass the formatted text to the typeLetterByLetter function to display it letter by letter
        typeLetterByLetter(formattedText, element);
    }



    // Fungsi untuk memulai efek mengetik
    let typingInterval;

    function startTypingEffect() {
        const typingDots = document.getElementById('typingDots');
        let dotCount = 1;

        // Speed up the animation by reducing the interval to 300ms
        typingInterval = setInterval(() => {
            // Cycle between 1, 2, and 3 dots
            typingDots.innerText = '.'.repeat(dotCount);
            dotCount = dotCount % 3 + 1; // Loop through 1 to 3 dots
        }, 300); // Interval reduced to 300ms for faster animation
    }

    // Fungsi untuk menghentikan efek mengetik
    function stopTypingEffect() {
        clearInterval(typingInterval);
        const typingDots = document.getElementById('typingDots');
        typingDots.innerText = ''; // Reset dots to nothing
    }
</script>

<!--Responsive Input Box-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputBox = document.getElementById('inputAi');

        // Function to get the appropriate default height based on screen width
        function getDefaultHeight() {
            const screenWidth = window.innerWidth;

            // Set the default height based on screen width
            if (screenWidth <= 600) {
                return '44px'; // For screens with max-width 600px
            } else if (screenWidth > 600 && screenWidth <= 768) {
                return '50px'; // For screens with 601px to 768px width
            } else {
                return '54px'; // For screens with min-width 769px
            }
        }

        // Set default height when the page loads based on screen size
        inputBox.style.height = getDefaultHeight();

        // Function to adjust input box height as the user types
        inputBox.addEventListener('input', function() {
            // Reset height to auto for resizing
            inputBox.style.height = 'auto';

            // Set the height to scrollHeight (content height) but limit it to max-height (240px)
            inputBox.style.height = `${Math.min(inputBox.scrollHeight, 240)}px`;

            // Toggle scroll based on height
            if (inputBox.scrollHeight > 44) {
                inputBox.style.overflowY = 'auto'; // Enable scroll
            } else {
                inputBox.style.overflowY = 'hidden'; // Disable scroll
            }

            // If input is empty, set height to the default height based on screen size
            if (inputBox.value.trim() === '') {
                inputBox.style.height = getDefaultHeight(); // Set default height based on screen size
                inputBox.style.overflowY = 'hidden'; // Disable scrolling if empty
            }
        });

        // Ensure the height is reset on page resize (in case the user resizes the screen)
        window.addEventListener('resize', function() {
            if (inputBox.value.trim() === '') {
                inputBox.style.height = getDefaultHeight();
            }
        });
    });
</script>

<!-- Typing Opening -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Menyembunyikan elemen #questionChat dan #answerChat saat halaman dimuat


        // Menambahkan pengamatan pada elemen dengan kelas .answer-box
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    new TypeIt("#multipleStringsOpening", {
                        strings: ["Halo Pak Tani! SiTani di sini.",
                            "Butuh solusi untuk ladang pertanian Anda? Silakan tanyakan di sini!"
                        ],
                        speed: 50,
                        waitUntilVisible: true,
                    }).go();

                    // Hentikan pengamatan setelah animasi dimulai
                    observer.unobserve(entry.target);
                }
            });
        });

        // Mulai pengamatan terhadap elemen yang ada pada halaman
        observer.observe(document.querySelector('.answer-box-opening')); // Pastikan selector benar
    });
</script>

<!--Hapus Animasi Chat Input dan opening saat udah berjalan di awal-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi AOS
        AOS.init();

        // Daftar elemen yang menggunakan animasi AOS
        const elementsWithAOS = [
            document.querySelector('#animationChatOpening'),
            document.querySelector('.chat-input-container'),
            document.querySelector('#powered'),
            document.querySelector('#imagePowered'),

        ];

        // Loop melalui setiap elemen untuk mendeteksi akhir animasi
        elementsWithAOS.forEach((element) => {
            if (element) {
                element.addEventListener(
                    'transitionend',
                    function() {
                        // Hapus atribut data-aos setelah animasi pertama selesai
                        element.removeAttribute('data-aos');
                        element.removeAttribute('data-aos-duration');
                        element.removeAttribute('data-aos-delay');
                    }, {
                        once: true
                    } // Pastikan hanya terjadi sekali
                );
            }
        });
    });
</script>

<!-- Script.JS -->
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
<!-- Iconify -->
<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
@endsection