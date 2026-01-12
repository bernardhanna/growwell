<?php
$button_bg_color = get_field('back_to_top_settings_button_bg_color', 'option') ?: '#025A70';
$button_hover_bg_color = get_field('back_to_top_settings_button_hover_bg_color', 'option') ?: '#02485A';
?>
<button id="backToTop"
  class="fixed flex items-center justify-center invisible transition duration-300 rounded-full opacity-0 bottom-5 right-5 w-14 h-14">
  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="8" viewBox="0 0 14 8" fill="none">
  <path d="M13 7L7 1L1 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>
</button>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const backToTop = document.getElementById("backToTop");
    window.addEventListener("scroll", function() {
      if (window.scrollY > 200) {
        backToTop.classList.remove("opacity-0", "invisible");
        backToTop.classList.add("opacity-100", "visible");
      } else {
        backToTop.classList.remove("opacity-100", "visible");
        backToTop.classList.add("opacity-0", "invisible");
      }
    });
    backToTop.addEventListener("click", function() {
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    });
  });
</script>