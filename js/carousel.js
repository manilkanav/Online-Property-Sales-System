const carouselImages = Array.from(
  document.querySelectorAll(".carousel-image img")
);
let currentImageIndex = 0;

function changeImage(n) {
  currentImageIndex += n;
  if (currentImageIndex >= carouselImages.length) {
    currentImageIndex = 0;
  } else if (currentImageIndex < 0) {
    currentImageIndex = carouselImages.length - 1;
  }

  carouselImages.forEach((image, index) => {
    image.style.display = index === currentImageIndex ? "block" : "none";
  });
}

// Initialize the carousel
changeImage(0);
