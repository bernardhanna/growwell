<?php
// File: inc/enqueue-fonts.php

/**
 * Enqueue Google Fonts (Lato and Poppins)
 */
function matrix_starter_enqueue_fonts() {
  wp_enqueue_style(
    'google-blinker',
    'https://fonts.googleapis.com/css2?family=Blinker:wght@100;200;300;400;600;700;800;900&display=swap',
    [],
    null
  );
}
add_action('wp_enqueue_scripts', 'matrix_starter_enqueue_fonts');