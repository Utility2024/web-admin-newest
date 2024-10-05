const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");
const formImage = document.querySelector(".images-wrapper .image"); // Menambahkan referensi ke elemen gambar yang akan diubah

// Event listener untuk input field
inputs.forEach((inp) => {
  inp.addEventListener("focus", () => {
    inp.classList.add("active");
  });
  inp.addEventListener("blur", () => {
    if (inp.value != "") return;
    inp.classList.remove("active");
  });
});

document.querySelectorAll('.toggle-password').forEach(item => {
  item.addEventListener('click', function () {
      const passwordField = document.querySelector(this.getAttribute('toggle'));
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);

      // Toggle the eye / eye-slash icon
      this.classList.toggle('fa-eye-slash');
  });
});



// Fungsi untuk mengganti gambar dengan efek fade
function changeImage(src) {
  formImage.classList.remove("show"); // Hilangkan gambar saat ini dengan fade-out

  setTimeout(() => {
    formImage.src = src; // Ganti gambar setelah fade-out selesai
    formImage.classList.add("show"); // Tambahkan gambar baru dengan fade-in
  }, 500); // Delay 500ms sesuai durasi transisi CSS
}

// Event listener untuk tombol toggle
toggle_btn.forEach((btn) => {
  btn.addEventListener("click", () => {
    main.classList.toggle("sign-up-mode");

    // Ubah gambar sesuai dengan form yang aktif menggunakan fungsi changeImage
    if (main.classList.contains("sign-up-mode")) {
      changeImage("./images/register.png"); // Gambar untuk form register
    } else {
      changeImage("./images/login.png"); // Gambar untuk form login
    }
  });
});

// Fungsi untuk memindahkan slider teks dan gambar berdasarkan bullet yang diklik
function moveSlider() {
  let index = this.dataset.value;

  let currentImage = document.querySelector(`.img-${index}`);
  images.forEach((img) => img.classList.remove("show"));
  currentImage.classList.add("show");

  const textSlider = document.querySelector(".text-group");
  textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;

  bullets.forEach((bull) => bull.classList.remove("active"));
  this.classList.add("active");
}

// Event listener untuk bullets slider
bullets.forEach((bullet) => {
  bullet.addEventListener("click", moveSlider);
});
