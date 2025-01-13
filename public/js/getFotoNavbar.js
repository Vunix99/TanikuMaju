  // Assuming you have already stored the token in localStorage
  let token = localStorage.getItem('access_token') || sessionStorage.getItem('access_token');

  // Check if token exists
  if (token) {
    // Send request to the petani profile API
    fetch('/api/petani/profil', { // Use relative URL for API
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`, // Send token in Authorization header
        },
      })
      .then(response => response.json())
      .then(data => {

        if (data && data.data) {
          // Get the profile data from the response
          const petani = data.data;

          // Check if foto_profil exists in the response and update the image URL
          if (petani.foto_profil) {
            let newFotoUrl;

            // Check if the foto_profil is the default profile image
            if (petani.foto_profil === "images/profile.png") {
              newFotoUrl = "/images/profile.png"; // Default profile image
            } else {
              newFotoUrl = `/storage/${petani.foto_profil}`; // Assuming your storage URL structure
            }

            // Update the profile photo element (adjust selector based on your HTML)
            const fotoProfilElement = document.getElementById('fotoProfil');
            if (fotoProfilElement) {
              fotoProfilElement.src = newFotoUrl; // Set the new image URL to the img element
            }
          }

          // Optionally, update other profile fields
          const namaPetaniElement = document.getElementById('namaPetani');
          if (namaPetaniElement) {
            namaPetaniElement.textContent = petani.nama_petani; // Set the name
          }

          const nomorWaElement = document.getElementById('nomorWa');
          if (nomorWaElement) {
            nomorWaElement.textContent = petani.nomor_wa; // Set the WA number
          }
        } else {
          console.error('Gagal mendapatkan data profil');
        }
      })
      .catch(error => {
        console.error('Terjadi kesalahan:', error);
      });
  } else {
    console.log('Token tidak ditemukan');
  }