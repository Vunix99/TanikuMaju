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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<!-- FOnt -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/forum.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
@endsection

@section('main')
<div class="container-fluid mt-5">
    <div class="row section1">
        <div class="col-md-4">
            <aside class="sidebar">
                <div class="forum-button" id="forumButton">
                    <span><a href="/diskusi">Forum Diskusi</a></span>
                    <i class="fa-solid fa-chevron-down icon2" id="icon"></i>
                </div>
                <ul class="forum-list" style="margin-left: 15px;" id="forumList">
                    <li class="active"><a href="#">Teknik Budidaya dan Panen</a></li>
                    <li><a href="#">Pupuk dan Nutrisi</a></li>
                    <li><a href="#">Irigasi dan Pengelolaan Air</a></li>
                    <li><a href="#">Masalah Hama dan Penyakit Tanaman</a></li>
                    <li><a href="#">Kondisi Tanah dan Perbaikan Kesuburan</a></li>
                </ul>
            </aside>
        </div>

        <div class="chat-container">
            <header class="chat-header">
                <h2>Teknik Budidaya dan Panen</h2>
            </header>
            <div class="chat-messages" id="chatMessages">
                <!-- Messages will be dynamically loaded here -->
            </div>

            <div class="chat-input">
                <button class="add-button" id="add-button">+</button>
                <textarea type="text" placeholder="Type a message" id="isi_komentar"></textarea>
                <button id="btn-send" class="send-button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="4B2204" d="M4 18.5v-5.154L9.846 12L4 10.654V5.5L19.423 12z" />
                    </svg></button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
    function initializeChat() {
        const forumButton = document.getElementById('forumButton');
        const forumList = document.getElementById('forumList');
        const icon = document.getElementById('icon');
        const chatId = window.location.pathname.split('/').pop();
        const accessToken = localStorage.getItem('access_token') || sessionStorage.getItem('access_token');
        const messagesContainer = document.querySelector('.chat-messages');
        const sendButton = document.getElementById('btn-send');
        const commentInput = document.getElementById('isi_komentar');
        const addButton = document.getElementById('add-button'); // Tombol untuk upload gambar
        const textarea = document.querySelector('.chat-input textarea');

        // File chooser element (disembunyikan)
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.accept = 'image/*';
        fileInput.style.display = 'none';
        document.body.appendChild(fileInput);

        addButton.addEventListener('click', () => {
            fileInput.click(); // Buka file chooser
        });

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (!file) return; // Tidak ada file dipilih

            if (!file.type.startsWith('image/')) {
                alert('Hanya file gambar yang diperbolehkan.');
                return;
            }

            const reader = new FileReader();
            reader.onload = function() {
                const base64Image = reader.result.split(',')[1]; // Ambil Base64 string
                sendImageMessage(base64Image); // Kirim pesan dengan gambar
            };
            reader.readAsDataURL(file); // Encode gambar ke Base64
        });

        function sendImageMessage(base64Image) {
            const isiKomentar = commentInput.value.trim();

            fetch('/api/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${accessToken}`
                    },
                    body: JSON.stringify({
                        id_diskusi: chatId,
                        foto: base64Image
                    })
                })
                .then(response => response.ok ? response.json() : Promise.reject('Error sending message'))
                .then(() => {
                    commentInput.value = ''; // Clear input field
                    fileInput.value = ''; // Reset file input
                    fetchMessages(); // Refresh messages immediately after sending
                })
                .catch(error => {
                    console.error('Error sending chat message with image:', error);
                });
        }

        textarea.addEventListener('input', function() {
            this.style.height = '40px'; // Reset height for automatic resizing
            this.style.height = `${this.scrollHeight}px`; // Adjust height based on content

            // Max height set to 240px
            if (this.scrollHeight > 240) {
                this.style.height = '240px';
            }
        });

        if (!accessToken) {
            console.error('No access token found');
            return;
        }

        forumButton.addEventListener('click', function() {
            forumList.classList.toggle('hidden');
            icon.classList.toggle('rotate');
        });

        document.addEventListener("DOMContentLoaded", function() {
            const forumList = document.getElementById("forumList");

            // Fetch discussions from the API
            fetch("/api/diskusi")
                .then(response => response.json()) // Parse the response as JSON
                .then(data => {
                    // Clear any existing list items (if any)
                    forumList.innerHTML = '';

                    // Loop through the response data and add the forum items
                    data.forEach(function(diskusi) {
                        let forumItem = `<li><a href="/diskusi/chat/${diskusi.id_diskusi}">${diskusi.topik}</a></li>`;
                        forumList.insertAdjacentHTML('beforeend', forumItem); // Append the new forum item
                    });
                })
                .catch(error => {
                    console.error("Error fetching discussions:", error);
                    // Optionally handle the error, like showing a fallback message in the list
                    forumList.innerHTML = '<li>Error loading forum discussions. Please try again later.</li>';
                });
        });


        const apiUrl = `/api/chat/${chatId}`;

        // Function to fetch and display chat messages
        function fetchMessages() {
            fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        // Handle the case where the response is not OK (e.g., 404 error)
                        return Promise.reject('Error fetching chat');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.kosong === true) {
                        // Clear existing messages and show "Pesan Masih Kosong"
                        messagesContainer.innerHTML = '';
                        const emptyMessage = document.createElement('p');
                        emptyMessage.textContent = 'Pesan Masih Kosong';
                        emptyMessage.classList.add('empty-message');
                        emptyMessage.style.textAlign = 'center';
                        emptyMessage.style.fontSize = '18px';
                        emptyMessage.style.color = 'gray';

                        // Center the message vertically and horizontally
                        emptyMessage.style.position = 'absolute';
                        emptyMessage.style.top = '50%';
                        emptyMessage.style.left = '50%';
                        emptyMessage.style.transform = 'translate(-50%, -50%)';

                        messagesContainer.style.position = 'relative'; // Ensure the parent is relative for absolute positioning
                        messagesContainer.appendChild(emptyMessage);

                        console.log("Pesan Masih Kosong");

                    } else if (data.message === "Komentar ditemukan") {
                        // Clear existing messages
                        messagesContainer.innerHTML = '';
                        let groupedMessages = {};
                        data.data.forEach(comment => {
                            const commentDate = new Date(comment.tanggal_komentar);
                            const commentDateString = commentDate.toLocaleDateString('id-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });

                            if (!groupedMessages[commentDateString]) {
                                groupedMessages[commentDateString] = [];
                            }
                            groupedMessages[commentDateString].push(comment);
                        });

                        const sortedDates = Object.keys(groupedMessages).sort((a, b) => new Date(a) - new Date(b));
                        const today = new Date();
                        const yesterday = new Date(today);
                        yesterday.setDate(today.getDate() - 1);

                        const formatDate = (date) => {
                            return date.toLocaleDateString('id-ID', {
                                day: 'numeric',
                                month: 'long'
                            });
                        };

                        sortedDates.forEach(dateString => {
                            const messagesWrapper = document.createElement('div');
                            messagesWrapper.classList.add('messages-wrapper');

                            const date = new Date(dateString);
                            let dateLabelText = formatDate(date);

                            if (date.toDateString() === today.toDateString()) {
                                dateLabelText = 'Hari Ini';
                            } else if (date.toDateString() === yesterday.toDateString()) {
                                dateLabelText = 'Kemarin';
                            }

                            const dateLabel = document.createElement('p');
                            dateLabel.textContent = dateLabelText;
                            dateLabel.classList.add('date-label');
                            dateLabel.style.color = 'white';
                            dateLabel.style.textAlign = 'center';

                            messagesWrapper.appendChild(dateLabel);

                            groupedMessages[dateString].forEach(comment => {
                                const messageDiv = document.createElement('div');
                                const messageContentDiv = document.createElement('div');
                                const userImage = document.createElement('img');
                                const messageText = document.createElement('p');
                                const messageTime = document.createElement('span');
                                const userName = document.createElement('p');

                                userImage.src = comment.id_petani !== accessToken ? 'user1.jpg' : 'user3.jpg';
                                userImage.style.marginLeft = '10px';

                                if (comment.isi_komentar) {
                                    messageText.innerHTML = comment.isi_komentar.replace(/\n/g, '<br>');
                                } else {
                                    messageText.innerHTML = '';
                                }

                                // Split the 'tanggal_komentar' and get the time part
                                const messageTimeText = new Date(comment.tanggal_komentar).toLocaleTimeString('en-GB', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

                                // Set the formatted time (24-hour format) for message time
                                messageTime.textContent = messageTimeText;
                                messageTime.classList.add('time');

                                // Create message div
                                messageDiv.classList.add('message');

                                messageContentDiv.classList.add('message-content');

                                userImage.src = comment.foto_profil || 'default-avatar.jpg'; // Set the profile picture

                                // Set the message time to only show hours and minutes in 24-hour format
                                messageTime.textContent = new Date(comment.tanggal_komentar).toLocaleTimeString('en-GB', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });


                                if (comment.isMe) {
                                    messageDiv.classList.add('sent');
                                    messageContentDiv.appendChild(messageText);
                                    messageContentDiv.appendChild(messageTime);
                                    messageDiv.appendChild(messageContentDiv);
                                    messageDiv.appendChild(userImage);
                                } else {
                                    messageDiv.classList.add('received');

                                    const nameLabel = document.createElement('p');
                                    nameLabel.textContent = comment.nama_petani || `${comment.nama_petani}`;
                                    nameLabel.classList.add('nama_petani');
                                    nameLabel.style.color = 'darkgreen';

                                    messageContentDiv.appendChild(nameLabel);
                                    messageContentDiv.appendChild(messageText);
                                    messageContentDiv.appendChild(messageTime);

                                    messageDiv.appendChild(userImage);
                                    messageDiv.appendChild(messageContentDiv);
                                }

                                // Handle the photo from the comment
                                if (comment.foto && comment.foto !== null) {
                                    const imageUrl = '/storage/' + comment.foto;

                                    const link = document.createElement('a');
                                    link.href = imageUrl;
                                    link.setAttribute('data-lightbox', 'gallery');
                                    link.setAttribute('data-title', 'Klik di mana saja untuk menutup');

                                    const imageContainer = document.createElement('div');
                                    imageContainer.style.position = 'relative';
                                    imageContainer.style.width = '100%'; // Responsif terhadap lebar parent
                                    imageContainer.style.maxWidth = '300px'; // Batas maksimal ukuran
                                    imageContainer.style.aspectRatio = '1'; // Memastikan 1:1 (modern browser support)
                                    imageContainer.style.borderRadius = '8px';
                                    imageContainer.style.overflow = 'hidden';
                                    imageContainer.style.transition = 'all 1.6s ease';

                                    const image = document.createElement('img');
                                    image.src = imageUrl;
                                    image.style.width = '100%'; // Menyesuaikan lebar container
                                    image.style.height = '100%'; // Menyesuaikan tinggi container
                                    image.style.objectFit = 'cover'; // Menjaga rasio aspek dan fokus isi gambar
                                    image.style.borderRadius = '8px';

                                    const hoverDiv = document.createElement('div');
                                    hoverDiv.style.position = 'absolute';
                                    hoverDiv.style.top = '0';
                                    hoverDiv.style.left = '0';
                                    hoverDiv.style.width = '100%';
                                    hoverDiv.style.height = '100%';
                                    hoverDiv.style.display = 'flex';
                                    hoverDiv.style.alignItems = 'center';
                                    hoverDiv.style.justifyContent = 'center';
                                    hoverDiv.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                                    hoverDiv.style.opacity = '0';
                                    hoverDiv.style.transition = 'opacity 0.6s ease';

                                    const fullscreenIcon = document.createElement('i');
                                    fullscreenIcon.className = 'fa fa-expand';
                                    fullscreenIcon.style.color = 'white';
                                    fullscreenIcon.style.fontSize = '30px';
                                    fullscreenIcon.style.cursor = 'pointer';

                                    hoverDiv.appendChild(fullscreenIcon);

                                    imageContainer.addEventListener('mouseenter', function() {
                                        hoverDiv.style.opacity = '1';
                                    });

                                    imageContainer.addEventListener('mouseleave', function() {
                                        hoverDiv.style.opacity = '0';
                                    });

                                    imageContainer.appendChild(image);
                                    imageContainer.appendChild(hoverDiv);

                                    link.appendChild(imageContainer);

                                    const downloadDiv = document.createElement('div');
                                    downloadDiv.style.position = 'absolute';
                                    downloadDiv.style.top = '10px';
                                    downloadDiv.style.right = '10px';
                                    downloadDiv.style.zIndex = '10';

                                    const downloadButton = document.createElement('button');
                                    downloadButton.innerHTML = '<i class="fa fa-download"></i>';
                                    downloadButton.style.backgroundColor = 'rgba(0, 0, 0, 0.6)';
                                    downloadButton.style.color = 'white';
                                    downloadButton.style.border = 'none';
                                    downloadButton.style.borderRadius = '50%';
                                    downloadButton.style.padding = '0';
                                    downloadButton.style.width = '48px';
                                    downloadButton.style.height = '48px';
                                    downloadButton.style.cursor = 'pointer';
                                    downloadButton.style.marginRight = '8px';
                                    downloadButton.style.marginTop = '4px';
                                    downloadButton.style.fontSize = '24px';
                                    downloadButton.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';

                                    downloadButton.addEventListener('click', function() {
                                        const link = document.createElement('a');
                                        link.href = imageUrl;
                                        link.download = 'image.png';
                                        link.click();
                                    });

                                    downloadDiv.appendChild(downloadButton);
                                    messageContentDiv.style.position = 'relative';
                                    messageContentDiv.appendChild(downloadDiv);

                                    messageContentDiv.insertBefore(link, messageTime);
                                }


                                // Append the message div to the wrapper
                                messagesWrapper.appendChild(messageDiv);
                            });

                            messagesContainer.appendChild(messagesWrapper);
                        });

                        scrollToBottom();
                    } else {
                        console.log("Tidak ada komentar ditemukan");
                    }
                })
                .catch(error => {
                    console.error('Error fetching chat data:', error);
                });
        }



        // Function to scroll to the bottom
        function scrollToBottom() {
            // Scroll to the bottom of the messages container
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // MutationObserver to watch for new messages and auto-scroll
        const observer = new MutationObserver(scrollToBottom);
        observer.observe(messagesContainer, {
            childList: true, // Watch for added/removed child elements
            subtree: true // Watch within the entire container
        });

        // Wait until the DOM is fully loaded and the messages are fetched
        document.addEventListener('DOMContentLoaded', () => {
            fetchMessages(); // Fetch and display the chat messages when page is loaded
        });





        // Function to send chat message
        sendButton.addEventListener('click', () => {
            const isiKomentar = commentInput.value.trim();
            if (!isiKomentar) {
                return; // Avoid sending empty messages
            }

            fetch('/api/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${accessToken}`
                    },
                    body: JSON.stringify({
                        id_diskusi: chatId,
                        isi_komentar: isiKomentar
                    })
                })
                .then(response => response.ok ? response.json() : Promise.reject('Error sending message'))
                .then(() => {
                    commentInput.value = ''; // Clear input field
                    commentInput.style.height = '40px'; // Reset textarea height to 40px
                    fetchMessages(); // Refresh messages immediately after sending
                })
                .catch(error => {
                    console.error('Error sending chat message:', error);
                });
        });

    }

    // Initialize the chat when the page is loaded
    initializeChat();
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