

function toggleMenu(elem){
  const nav = document.querySelector(".nav");
  const icon = elem.querySelector("i");
  nav.classList.toggle("close_in");
  icon.classList.toggle("fa-bars");
  icon.classList.toggle("fa-times");

}

$('.responses_content').slick({
  dots: true,
  arrows: false,
  autoplay: true
});