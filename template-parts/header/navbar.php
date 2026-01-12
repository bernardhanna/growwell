<?php
$logo_id = get_field('logo', 'option') ?: get_theme_mod('custom_logo');
$logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
$logo_alt = $logo_id ? get_post_meta($logo_id, '_wp_attachment_image_alt', true) : get_bloginfo('name');
$logo_position = get_field('logo_position', 'option');
$logo_position_class = ($logo_position === 'center') ? 'justify-center' : 'justify-start';

use Log1x\Navi\Navi;

$primary_navigation = Navi::make()->build('primary');
$secondary_navigation = Navi::make()->build('secondary');
?>
<section
  id="site-nav"
  x-data="{
    isOpen: false,
    activeDropdown: null,
    scrolled: false,
    toggleDropdown(i) {
      this.activeDropdown = (this.activeDropdown === i ? null : i);
    },
    checkWindowSize() {
      if (window.innerWidth > 1084) {
        this.isOpen = false;
        this.activeDropdown = null;
      }
    },
    onScroll() {
      this.scrolled = window.scrollY > 0;
    }
  }"
  x-init="
    onScroll();
    window.addEventListener('resize', checkWindowSize);
    window.addEventListener('scroll', onScroll, { passive: true });
  "
  x-effect="document.body.style.overflow = isOpen ? 'hidden' : ''"
  :class="(scrolled || isOpen) ? 'bg-primary-light shadow-sm' : 'bg-transparent'"
  class="py-4 transition-colors duration-300"
  role="banner"
>
  <nav class="flex justify-between items-center w-full mx-auto max-w-[1168px] px-5 lg:px-0" aria-label="Primary">
    <a href="<?php echo esc_url(home_url('/')); ?>"
       class="flex <?php echo $logo_position_class; ?> focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-amber-500 rounded"
       aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
      <?php if ($logo_url) : ?>
        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>" />
      <?php else : ?>
        <span class="font-semibold"><?php echo esc_html(get_bloginfo('name')); ?></span>
      <?php endif; ?>
    </a>

    <?php if ($primary_navigation->isNotEmpty()) : ?>
      <ul id="primary-menu" class="hidden lg:flex items-center leading-loose gap-9 max-md:gap-6">
        <?php foreach ($primary_navigation->toArray() as $index => $item) :
          $is_active = !empty($item->active);
          $item_id   = 'menu-item-' . $index;
        ?>
          <li class="relative group <?php echo esc_attr($item->classes); ?> <?php echo $is_active ? 'current-item' : ''; ?>">
            <a
              id="<?php echo esc_attr($item_id); ?>"
              href="<?php echo esc_url($item->url); ?>"
              class="
                flex items-center gap-2.5 relative
                text-[#1d2838] lg:text-white
                focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-amber-500 rounded
                lg:after:content-[''] lg:after:absolute lg:after:left-0 lg:after:-bottom-1
                lg:after:h-[2px] lg:after:w-0 lg:group-hover:after:w-full lg:focus-visible:after:w-full
                lg:after:bg-current lg:after:transition-all lg:after:duration-300
                transition-colors duration-200
              "
              :class="(scrolled ? 'text-white' : '')"
              <?php echo $is_active ? 'aria-current="page"' : ''; ?>
            >
              <?php echo esc_html($item->label); ?>
              <?php if ($item->children) : ?>
                <span class="ml-[2px]" aria-hidden="true">
                  <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18" viewBox="0 0 17 18" fill="none">
                    <path d="M4.25 6.875L8.5 11.125L12.75 6.875" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </span>
              <?php endif; ?>
            </a>

            <?php if ($item->children) : ?>
              <!-- Mobile-only submenu toggle button -->
              <button
                type="button"
                class="lg:hidden mt-2 text-sm underline focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-amber-500 rounded"
                @click="toggleDropdown(<?php echo (int) $index; ?>)"
                :aria-expanded="activeDropdown === <?php echo (int) $index; ?> ? 'true' : 'false'"
                :aria-controls="'submenu-<?php echo (int) $index; ?>'"
                aria-haspopup="true"
              >Submenu</button>

              <ul
                id="submenu-<?php echo (int) $index; ?>"
                class="absolute left-0 hidden group-hover:block focus-within:block lg:min-w-[200px] z-50 bg-white shadow border-b-2 border-[#F68D2E]
                       lg:rounded lg:py-2
                       lg:mt-2
                       lg:text-[#1d2838]"
                role="menu"
                aria-labelledby="<?php echo esc_attr($item_id); ?>"
                x-show="activeDropdown === <?php echo (int) $index; ?> || window.innerWidth > 1084"
                x-cloak
              >
                <?php foreach ($item->children as $child) :
                  $child_active = !empty($child->active);
                ?>
                  <li class="group <?php echo esc_attr($child->classes); ?> <?php echo $child_active ? 'current-item' : ''; ?>" role="none">
                    <a
                      role="menuitem"
                      href="<?php echo esc_url($child->url); ?>"
                      class="block px-4 py-2 text-sm font-normal hover:bg-secondary hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-amber-500"
                      <?php echo $child_active ? 'aria-current="page"' : ''; ?>
                    >
                      <?php echo esc_html($child->label); ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php get_template_part('template-parts/header/navbar/mobile'); ?>

    <?php if ($secondary_navigation->isNotEmpty()) : ?>
      <ul class="flex gap-4 px-4 xl:gap-6">
        <?php foreach ($secondary_navigation->toArray() as $item) : ?>
          <li class="relative group <?php echo esc_attr($item->classes); ?>">
            <a href="<?php echo esc_url($item->url); ?>"
               class="text-[#1d2838] lg:text-white hover:opacity-90 transition-opacity duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-amber-500 rounded"
               :class="(scrolled ? 'text-white' : '')"
            >
              <?php echo esc_html($item->label); ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </nav>
</section>
