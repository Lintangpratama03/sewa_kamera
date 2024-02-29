document.addEventListener("DOMContentLoaded", function() {
    var currentLocation = window.location.href;

    // Mendapatkan semua elemen <a> di dalam navbar
    var navLinks = document.querySelectorAll("#navbar ul li a");

    // Iterasi melalui setiap elemen <a> dan cek apakah URL sesuai dengan href elemen tersebut
    navLinks.forEach(function(navLink) {
        // Memeriksa apakah href elemen sama dengan URL saat ini
        if (navLink.href === currentLocation) {
            // Menambahkan kelas "active" ke elemen yang sesuai
            navLink.classList.add("active");
        }
    });
});