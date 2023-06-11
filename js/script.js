document.addEventListener("DOMContentLoaded", () => {
  const dropdownMenu = document.querySelector(".dropdown-menu");
  const drowDownArrow = document.querySelector(".dropdown-arrow");

  drowDownArrow.addEventListener("click", () => {
    dropdownMenu.classList.toggle("show");
    console.log("pressed");
  });

  document.addEventListener("click", (event) => {
    if (
      !event.target.closest(".dropdown-menu") &&
      !event.target.closest(".small-img")
    ) {
      dropdownMenu.classList.remove("show");
    }
  });
});
