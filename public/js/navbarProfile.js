
    document.addEventListener('DOMContentLoaded', function() {
        function checkScreenWidth() {
            const navbarNav = document.getElementById('navbarNav');
            // Check if screen width is below 991px
            if (window.innerWidth < 991) {
                // Create new list item for Profile
                if (!document.getElementById('profile-link')) {
                    const li = document.createElement('li');
                    li.classList.add('nav-item');
                    
                    // Periksa apakah URL saat ini adalah /profil
                    const isProfilePage = window.location.pathname === '/profil';
                    li.innerHTML = `<a class="nav-link ${isProfilePage ? 'active' : ''}" href="/profil" id="profile-link">Profile</a>`;
                    
                    // Tambahkan elemen ke navbar
                    document.querySelector('.navbar-nav').appendChild(li);
                }
                
            } else {
                // Remove the Profile link if screen width is 991px or above
                const profileLink = document.getElementById('profile-link');
                if (profileLink) {
                    profileLink.parentNode.removeChild(profileLink);
                }
            }
        }

        // Call the function initially to check screen size
        checkScreenWidth();

        // Add event listener to check screen size on window resize
        window.addEventListener('resize', checkScreenWidth);
    });

