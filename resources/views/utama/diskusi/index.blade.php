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
<link rel="stylesheet" href="{{ asset('css/forum.css') }}">
@endsection

@section('main')
<!-- Main Content -->
<div class="container-fluid mt-5">
    <div class="row section1">
        <div class="col-md-4">
            <aside class="sidebar">
                <div class="forum-button active" id="forumButton">
                    <span><a href="forum.html">Forum Diskusi</a></span>
                    <i class="fa-solid fa-chevron-right icon" id="icon"></i>
                </div>
                <ul class="forum-list hidden" style="margin-left: 15px;" id="forumList">
                    <!-- Dynamic list of forum topics will be inserted here -->
                </ul>
            </aside>
        </div>
        <div class="col-md-8">
            <main class="content">
                <h2>Forum Diskusi Petani: Berbagi Pengalaman dan Solusi Pertanian</h2>
                <p>Temukan jawaban atas tantangan pertanian Anda dengan berdiskusi bersama para petani lainnya.</p>
                <ul class="discussion-list" id="discussionList">
                    <!-- Dynamic list of discussions will be inserted here -->
                </ul>
            </main>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Fetch data from the same API for both forum topics and discussions
    $(document).ready(function() {
        $.ajax({
            url: '/api/diskusi', // Same API endpoint for both forum topics and discussions
            method: 'GET',
            success: function(response) {
                let forumList = $('#forumList');
                let discussionList = $('#discussionList');

                // Populate forum list in the sidebar
                response.forEach(function(diskusi) {
                    let forumItem = `<li><a href="/diskusi/chat/${diskusi.id_diskusi}">${diskusi.topik}</a></li>`;
                    forumList.append(forumItem);
                });

                // Populate discussion list in the main content
                response.forEach(function(diskusi) {
                    let discussionItem = `<li>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                      d="m20.616 19.308l-3.078-3.077H8q-.635 0-1.086-.452t-.452-1.087v-.23H17.23q.666 0 1.14-.475q.475-.475.475-1.14V6h.231q.635 0 1.087.452t.452 1.087zm-16.231-6.19l1.655-1.656h9.19q.27 0 .443-.173t.173-.443v-6.23q0-.27-.173-.443T15.231 4H5q-.27 0-.442.173q-.173.173-.173.443zm-1 2.42V4.617q0-.667.474-1.141Q4.334 3 5 3h10.23q.667 0 1.142.475q.474.474.474 1.14v6.231q0 .667-.474 1.141q-.475.475-1.141.475H6.46zm1-4.692V4z" />
                                            </svg>
                                            <a href="/diskusi/chat/${diskusi.id_diskusi}">${diskusi.topik}</a>
                                          </li>`;
                    discussionList.append(discussionItem);
                });
            },
            error: function(error) {
                console.log('Error fetching data:', error);
            }
        });

        // Toggle sidebar visibility
        const forumButton = document.getElementById('forumButton');
        const forumList = document.getElementById('forumList');
        const icon = document.getElementById('icon');

        forumButton.addEventListener('click', function() {
            forumList.classList.toggle('hidden'); // Toggle show/hide
            icon.classList.toggle('rotate'); // Rotate icon
        });
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