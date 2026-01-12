<?php
// Read from options (global)
$icon                = get_field('icon', 'option');
$heading             = get_field('heading', 'option') ?: 'Get early access to the resources';
$heading_tag         = get_field('heading_tag', 'option') ?: 'h2';
$description         = get_field('description', 'option') ?: 'Are you a teacher or work with children with SEN?';

$form_mode           = get_field('form_mode', 'option') ?: 'brevo';
$form_shortcode      = get_field('form_shortcode', 'option');
$form_html           = get_field('form_html', 'option');

$email_placeholder   = get_field('email_placeholder', 'option') ?: 'Email';
$name_placeholder    = get_field('name_placeholder', 'option') ?: 'First name';
$submit_text         = get_field('submit_text', 'option') ?: 'Submit';
$privacy_text        = get_field('privacy_text', 'option') ?: 'I agree to the Atollo\'s Privacy Policy & Cookie Policy.';
$privacy_policy_url  = get_field('privacy_policy_url', 'option') ?: '#';
$cookie_policy_url   = get_field('cookie_policy_url', 'option') ?: '#';

$newsletter_enabled  = (bool) get_field('newsletter_enabled', 'option');
$brevo_list_ids      = get_field('brevo_list_ids', 'option') ?: '';
$success_message     = get_field('success_message', 'option') ?: 'Thanks! You\'ve been subscribed to our newsletter.';
$error_message       = get_field('error_message', 'option') ?: 'Sorry, something went wrong. Please try again.';

// Design
$background_color    = get_field('background_color', 'option') ?: '#fbbf24';
$text_color          = get_field('text_color', 'option') ?: '#27272a';
$button_bg_color     = get_field('button_bg_color', 'option') ?: '#312e81';
$button_text_color   = get_field('button_text_color', 'option') ?: '#ffffff';

// Padding classes from repeater
$padding_classes = [];
if (have_rows('padding_settings', 'option')) {
  while (have_rows('padding_settings', 'option')) {
    the_row();
    $screen_size    = get_sub_field('screen_size');
    $pt             = (string) get_sub_field('padding_top');
    $pb             = (string) get_sub_field('padding_bottom');
    if ($screen_size !== '') {
      $padding_classes[] = "{$screen_size}:pt-[{$pt}rem]";
      $padding_classes[] = "{$screen_size}:pb-[{$pb}rem]";
    }
  }
}

// Unique id for a11y
$section_id = 'newsletter-' . esc_attr(wp_generate_uuid4());

// Global CAPTCHA options (already in your Contact Forms options group)
$captcha_provider   = function_exists('get_field') ? (get_field('captcha_provider', 'option') ?: 'none') : 'none';
$recaptcha_site_key = function_exists('get_field') ? get_field('recaptcha_site_key', 'option') : '';
$turnstile_site_key = function_exists('get_field') ? get_field('turnstile_site_key', 'option') : '';

// Enqueue CAPTCHA scripts only if we render built-in form
if ($form_mode === 'brevo') {
  if ($captcha_provider === 'recaptcha_v3' && $recaptcha_site_key) {
    wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js?render=' . $recaptcha_site_key, [], null, true);
  }
  if ($captcha_provider === 'turnstile' && $turnstile_site_key) {
    wp_enqueue_script('cloudflare-turnstile', 'https://challenges.cloudflare.com/turnstile/v0/api.js', [], null, true);
  }
  $brevo_nonce = wp_create_nonce('matrix_brevo_subscribe');
}

// Helper for icon alt (optional; icon is URL here)
$heading_for_alt = wp_strip_all_tags($heading);
?>
<section id="<?php echo esc_attr($section_id); ?>"
  class="relative flex overflow-hidden <?php echo esc_attr(implode(' ', $padding_classes)); ?>"
  style="background-color: <?php echo esc_attr($background_color); ?>; color: <?php echo esc_attr($text_color); ?>;"
  role="region"
  aria-labelledby="newsletter-heading"
>
<svg class="absolute right-0 h-full top-0 z-0" xmlns="http://www.w3.org/2000/svg" width="275" height="196" viewBox="0 0 275 196" fill="none">
<path d="M409.496 45.9507C443.942 98.572 464.706 162.338 469.751 220.677C473.535 264.285 468.684 305.278 455.682 339.196C440.934 377.959 415.415 407.807 382.037 425.25C314.796 460.525 244.353 452.772 178.277 402.864C132.382 368.171 104.438 324.659 101.624 320.202C55.6322 249.846 22.3513 170.866 7.89399 97.8935C-6.56331 24.5338 -1.03275 -36.3247 23.4185 -73.5375C43.9886 -104.742 76.7845 -118.115 115.693 -111.235C158.58 -103.579 195.936 -87.0077 226.5 -62.1992C243.771 -65.591 262.886 -64.0405 283.068 -57.5476C335.463 -40.6855 378.156 -1.92205 409.496 45.9507ZM144.22 294.908C148.586 301.498 172.552 336.773 209.132 364.198C259.199 401.605 309.654 407.516 359.041 381.545C423.663 347.627 423.469 260.7 420.461 224.941C412.698 134.331 358.944 23.4678 274.141 -8.22122C275.597 -5.89542 277.052 -3.56951 278.41 -1.1468C305.967 46.1445 318.774 104.871 314.408 164.373C308.586 243.159 275.014 296.944 230.769 298.203C212.431 298.688 186.039 289.675 164.499 243.838C147.227 207.013 136.942 154.488 137.039 103.321C137.039 69.1118 142.182 5.92742 176.142 -32.7391C177.015 -33.7081 177.889 -34.6773 178.762 -35.6463C158.968 -48.1475 135.196 -57.4506 107.154 -62.4899C87.8457 -65.8817 74.3587 -60.7456 64.8499 -46.2093C48.0639 -20.7224 44.959 29.5732 56.5054 88.2997C69.7983 155.263 100.557 228.139 143.249 293.358C143.346 293.552 143.443 293.649 143.54 293.842C143.54 293.842 143.831 294.327 144.22 294.908Z" fill="#F1607A"/>
</svg>
  <div class="flex flex-col items-center w-full mx-auto max-w-container justify-center lg:h-[12.5rem] z-50 max-lg:px-5">
    <div class="flex overflow-hidden  gap-8 items-start w-full max-md:px-5">

      <!-- Left -->
      <div class="min-w-60 w-[448px] max-md:max-w-full">
        <header class="flex gap-2 items-center text-3xl font-semibold leading-none max-md:max-w-full">
          <?php if (!empty($icon)) : ?>
            <img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($heading_for_alt ?: ''); ?>" class="object-contain shrink-0 w-8 aspect-square" />
          <?php endif; ?>

          <<?php echo esc_attr($heading_tag); ?> id="newsletter-heading" class="my-auto" style="color: <?php echo esc_attr($text_color); ?>;">
            <?php echo esc_html($heading); ?>
          </<?php echo esc_attr($heading_tag); ?>>
        </header>

        <?php if (!empty($description)) : ?>
          <p class="mt-2 text-base leading-none max-md:max-w-full" style="color: <?php echo esc_attr($text_color); ?>;">
            <?php echo esc_html($description); ?>
          </p>
        <?php endif; ?>
      </div>

      <!-- Right (Form) -->
      <div class="flex-1 shrink basis-0 min-w-60 max-md:max-w-full">
        <?php if ($form_mode === 'shortcode' && !empty($form_shortcode)) : ?>

          <?php echo do_shortcode($form_shortcode); ?>

        <?php elseif ($form_mode === 'html' && !empty($form_html)) : ?>

          <?php echo $form_html; // trusted admin HTML ?>

        <?php else : // Built-in Brevo ?>
          <?php if ($newsletter_enabled) : ?>
            <form class="w-full"
              data-brevo-newsletter="1"
              role="form"
              aria-labelledby="newsletter-heading"
              novalidate
            >
              <div class="flex max-lg:flex-col flex-row gap-4 w-full text-base text-gray-600 max-md:max-w-full">
                <!-- Email -->
                <div class="flex-1 shrink whitespace-nowrap basis-12 min-w-60">
                  <label for="newsletter-email" class="sr-only">Email Address (required)</label>
                  <div class="flex-1 w-full">
                    <div class="flex flex-1 justify-between items-center px-4 py-3 bg-white rounded size-full">
                      <input type="email"
                        id="newsletter-email"
                        name="email"
                        placeholder="<?php echo esc_attr($email_placeholder); ?>"
                        required aria-required="true"
                        aria-describedby="email-error"
                        autocomplete="email"
                        class="flex-1 shrink gap-2 my-auto w-full basis-0 bg-transparent border-none outline-none text-gray-600 placeholder-gray-400 focus:ring-0"
                      />
                    </div>
                  </div>
                  <div id="email-error" class="text-red-600 text-xs mt-1 hidden" role="alert" aria-live="polite"></div>
                </div>

                <!-- First name -->
                <div class="flex-1 shrink basis-12 min-w-60">
                  <label for="newsletter-name" class="sr-only">First Name (optional)</label>
                  <div class="flex-1 w-full">
                    <div class="flex flex-1 justify-between items-center px-4 py-3 bg-white rounded size-full">
                      <input type="text"
                        id="newsletter-name"
                        name="name"
                        placeholder="<?php echo esc_attr($name_placeholder); ?>"
                        autocomplete="given-name"
                        class="flex-1 shrink gap-2 my-auto w-full basis-0 bg-transparent border-none outline-none text-gray-600 placeholder-gray-400 focus:ring-0"
                      />
                    </div>
                  </div>
                </div>

                <!-- Submit -->
                <button type="submit"
                  class="btn flex gap-2 justify-center items-center px-6 py-3.5 font-semibold text-white whitespace-nowrap rounded min-h-[52px] w-fit max-md:px-5 hover:opacity-90 transition-opacity duration-200"
                  style="background-color: <?php echo esc_attr($button_bg_color); ?>; color: <?php echo esc_attr($button_text_color); ?>;"
                  aria-describedby="submit-help"
                >
                  <span class="my-auto"><?php echo esc_html($submit_text); ?></span>
                </button>
              </div>

              <!-- Consent -->
              <div class="flex flex-wrap gap-4 items-center mt-4 w-full max-md:max-w-full">
                <div class="flex overflow-hidden flex-col justify-center items-center w-8 rounded min-h-8">
                  <div class="flex gap-2 justify-center items-center w-8 h-8 rounded border border-solid min-h-8" style="border-color: <?php echo esc_attr($text_color); ?>;">
                    <input type="checkbox"
                      id="newsletter-consent"
                      name="consent"
                      required aria-required="true"
                      aria-describedby="consent-error"
                      class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                    />
                  </div>
                </div>

                <label for="newsletter-consent" class="flex-1 shrink my-auto text-sm leading-none basis-0 max-md:max-w-full cursor-pointer" style="color: <?php echo esc_attr($text_color); ?>;">
                  <?php echo esc_html($privacy_text); ?>
                  <a href="<?php echo esc_url($privacy_policy_url); ?>" class="underline hover:opacity-80 focus:opacity-80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" target="_blank" rel="noopener" style="color: <?php echo esc_attr($text_color); ?>;">Privacy Policy</a>
                  &
                  <a href="<?php echo esc_url($cookie_policy_url); ?>" class="underline hover:opacity-80 focus:opacity-80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" target="_blank" rel="noopener" style="color: <?php echo esc_attr($text_color); ?>;">Cookie Policy</a>.
                </label>

                <div id="consent-error" class="text-red-600 text-xs mt-1 hidden w-full" role="alert" aria-live="polite"></div>
              </div>

              <!-- Hidden for Brevo -->
              <input type="hidden" name="list_ids" value="<?php echo esc_attr($brevo_list_ids); ?>" />

              <?php if (!empty($brevo_nonce)) : ?>
                <input type="hidden" name="nonce" value="<?php echo esc_attr($brevo_nonce); ?>" />
              <?php endif; ?>

              <!-- Turnstile visible widget (if selected globally) -->
              <?php if ($captcha_provider === 'turnstile' && $turnstile_site_key): ?>
                <div class="cf-turnstile mt-4" data-sitekey="<?php echo esc_attr($turnstile_site_key); ?>" data-theme="light" data-size="normal"></div>
              <?php endif; ?>

              <div id="submit-help" class="sr-only">Please enter a valid email address and accept the privacy policy to subscribe.</div>
              <div id="form-messages" class="mt-4 hidden" role="alert" aria-live="polite"></div>
            </form>
          <?php else : ?>
            <div class="text-center p-8">
              <p class="text-lg" style="color: <?php echo esc_attr($text_color); ?>;">Newsletter signup is currently disabled.</p>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php if ($form_mode === 'brevo' && $newsletter_enabled) : ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  window.themeFormsCaptchaProvider = '<?php echo esc_js($captcha_provider); ?>';
  <?php if ($captcha_provider === 'recaptcha_v3' && $recaptcha_site_key): ?>
  window.themeFormsRecaptchaV3 = '<?php echo esc_js($recaptcha_site_key); ?>';
  <?php endif; ?>
  <?php if ($captcha_provider === 'turnstile' && $turnstile_site_key): ?>
  window.themeFormsTurnstileSiteKey = '<?php echo esc_js($turnstile_site_key); ?>';
  <?php endif; ?>
  window.matrixBrevoNonce = '<?php echo isset($brevo_nonce) ? esc_js($brevo_nonce) : ''; ?>';
  window.ajaxurl = '<?php echo esc_js(admin_url('admin-ajax.php')); ?>';
});
</script>
<?php endif; ?>
