document
    .getElementById("tombol-keluar")
    .addEventListener("click", function (event) {
        event.preventDefault(); // Mencegah link default

        logout();
    });

function logout() {
    fetch("/logout", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    })
    .then((response) => {
        if (response.ok) {
            window.location.href = "/login"; // Redirect ke halaman utama setelah logout
        } else {
            alert("Logout gagal");
        }
    })
    .catch((error) => {
        console.error("Error:", error);
    });
}
