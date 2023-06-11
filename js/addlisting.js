document.addEventListener("DOMContentLoaded", () => {
  const fileInput = document.getElementById("images");
  fileInput.addEventListener("change", previewImage);
});

function previewImage() {
  const fileInput = document.getElementById("images");
  const imagePreviewContainer = document.getElementById("image_preview");
  const totalFiles = fileInput.files.length;
  const maxFiles = 5;

  if (totalFiles > maxFiles) {
    alert(`You can only upload up to ${maxFiles} files.`);
    fileInput.value = ""; // Reset the file input
    return;
  }

  imagePreviewContainer.style.display = totalFiles > 0 ? "block" : "none";
  imagePreviewContainer.innerHTML = "";

  Array.from(fileInput.files).forEach((file) => {
    const img = document.createElement("img");
    img.src = URL.createObjectURL(file);
    img.classList.add("preview-image");
    imagePreviewContainer.appendChild(img);
  });
}
