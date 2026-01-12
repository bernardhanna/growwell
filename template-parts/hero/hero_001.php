<?php
$desktop_image = get_sub_field('desktop_image');
$mobile_image  = get_sub_field('mobile_image');
$title         = get_sub_field('title');
$title_tag     = get_sub_field('title_tag');
$description   = get_sub_field('description');
$cta_button    = get_sub_field('cta_button');
$scroll_url    = get_sub_field('scroll_url'); // NEW: URL field

$section_id = 'hero_' . uniqid();

$desktop_image_url = $desktop_image ? wp_get_attachment_image_url($desktop_image, 'full') : '';
$mobile_image_url  = $mobile_image  ? wp_get_attachment_image_url($mobile_image,  'full') : '';

// Padding classes
$padding_classes = [];
if (have_rows('padding_settings')) {
    while (have_rows('padding_settings')) {
        the_row();
        $screen_size    = get_sub_field('screen_size');
        $padding_top    = get_sub_field('padding_top');
        $padding_bottom = get_sub_field('padding_bottom');
        $padding_classes[] = "{$screen_size}:pt-[{$padding_top}rem]";
        $padding_classes[] = "{$screen_size}:pb-[{$padding_bottom}rem]";
    }
}
?>

<section
    id="<?php echo esc_attr($section_id); ?>"
    class="relative flex overflow-hidden min-h-[832px] max-sm:min-h-screen <?php echo esc_attr(implode(' ', $padding_classes)); ?>"
    role="banner"
    aria-label="Hero section"
>
<svg class="absolute right-0 top-0" xmlns="http://www.w3.org/2000/svg" width="132" height="96" viewBox="0 0 132 96" fill="none">
<path d="M195.652 64.6478C194.904 65.8674 194.115 67.0754 193.243 68.2599C187.933 75.4794 180.474 81.1083 172.371 84.0963C161.814 88.0009 150.279 87.1137 139.782 81.6011C130.181 76.565 122.149 68.0372 117.195 57.6513C110.665 43.959 104.736 35.7569 66.8114 39.6241C56.0543 40.7449 43.7563 36.691 32.1646 28.2313C20.8698 19.9896 11.5766 8.46778 5.98058 -4.24563C0.0619538 -17.7208 -1.50081 -32.0228 1.4577 -45.6741C4.86466 -61.3896 14.0741 -75.9138 28.7797 -88.7966C45.3447 -103.345 65.475 -111.477 86.9884 -112.288C105.831 -113.004 124.518 -107.772 138.288 -97.9815C147.017 -91.7609 153.377 -83.9738 156.659 -75.4458C160.342 -65.9553 160.155 -55.7692 156.163 -46.0761C148.332 -27.2281 145.862 -14.1988 148.807 -7.33109C151.155 -1.83929 157.757 0.963851 168.338 5.06932C170.479 5.89745 172.691 6.79044 174.987 7.70685C192.277 14.8694 202.032 28.0866 201.736 44.0544C201.601 51.0362 199.442 58.2065 195.61 64.6361L195.652 64.6478Z" fill="#FBAE25"/>
</svg>
    <?php if ($desktop_image_url || $mobile_image_url): ?>
        <style>
            #<?php echo esc_attr($section_id); ?> {
                <?php if ($desktop_image_url): ?>
                background-image: url('<?php echo esc_url($desktop_image_url); ?>');
                <?php endif; ?>
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
            <?php if ($mobile_image_url): ?>
            @media (max-width: 767px) {
                #<?php echo esc_attr($section_id); ?> {
                    background-image: url('<?php echo esc_url($mobile_image_url); ?>');
                }
            }
            <?php endif; ?>
        </style>
    <?php endif; ?>

    <div class="flex flex-col items-start justify-center w-full mx-auto max-w-container pt-20 pb-20 max-lg:px-5 text-center">
        <div class="flex flex-col items-start justify-center max-w-[36rem] mx-auto space-y-6 ">

            <?php if (!empty($title)): ?>
                <<?php echo esc_attr($title_tag); ?>
                    class="text-[3.75rem] font-bold leading-[4rem] tracking-[-0.075rem] text-primary text-left"
                    id="hero-title-<?php echo esc_attr($section_id); ?>"
                >
                    <?php echo esc_html($title); ?>
                </<?php echo esc_attr($title_tag); ?>>
            <?php endif; ?>

            <?php if (!empty($description)): ?>
                <div
                    class="text-2xl font-normal leading-8
 text-white/90 text-left wp_editor"
                    aria-describedby="hero-title-<?php echo esc_attr($section_id); ?>"
                >
                    <?php echo wp_kses_post($description); ?>
                </div>
            <?php endif; ?>

            <?php if ($cta_button && is_array($cta_button) && isset($cta_button['url'], $cta_button['title'])): ?>
                <div class="mt-8">
                    <a
                        href="<?php echo esc_url($cta_button['url']); ?>"
                        class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-primary-dark bg-primary border-2 border-primary rounded-[0.25rem] transition-all duration-300 hover:bg-secondary hover:border-secondary focus:ring-4 focus:ring-primary/50 focus:outline-none w-fit whitespace-nowrap btn h-[3.25rem]"
                        target="<?php echo esc_attr($cta_button['target'] ?? '_self'); ?>"
                        aria-label="<?php echo esc_attr($cta_button['title']); ?>"
                    >
                        <span class="font-semibold"><?php echo esc_html($cta_button['title']); ?></span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="ml-2 transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true">
                            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php if (!empty($scroll_url)) : ?>
    <span class="scroll-btn w-full flex justify-center items-center">
        <a href="<?php echo esc_url($scroll_url); ?>" class="__mPS2id _mPS2id-h" aria-label="Scroll to next section">
            <span class="mouse"><span></span></span>
        </a>
    </span>
    <?php endif; ?>
<svg class="absolute left-0 bottom-0" xmlns="http://www.w3.org/2000/svg" width="153" height="248" viewBox="0 0 153 248" fill="none">
<path d="M100.975 165.921L5.86108 67.5247L-2.46817 74.726C-3.47574 75.601 -28.1275 97.0032 -47.4056 125.539C-82.4689 177.295 -71.5201 210.004 -56.2051 228.378C-45.7935 240.829 -32.1578 247.424 -16.7084 247.492C4.98785 247.559 30.4457 235.041 58.9263 210.206C79.2791 192.506 93.6537 174.94 94.2582 174.199L100.975 165.988V165.921Z" fill="#8875AC"/>
<path d="M39.1105 5.47197C37.6999 3.31829 35.6176 1.63568 33.0651 0.693442C26.8854 -1.52754 20.1683 1.7703 18.086 7.96213L-5.89411 79.8413C-7.97642 86.0331 -4.61786 92.898 1.56189 95.0517C7.74163 97.2726 14.4587 93.9748 16.541 87.783L40.5211 15.9038C41.7302 12.2695 41.1257 8.43328 39.1105 5.47197Z" fill="#8875AC"/>
<path d="M150.951 134.558C147.794 129.712 141.547 127.693 136.173 130.116L80.1525 155.489C74.2415 158.181 71.689 165.248 74.443 171.238C77.197 177.295 84.1828 179.987 90.161 177.295L146.182 151.922C152.093 149.23 154.645 142.163 151.891 136.173C151.623 135.568 151.354 135.029 151.018 134.558H150.951Z" fill="#8875AC"/>
<path d="M78.6757 38.7867C77.7353 37.3061 76.3919 36.0273 74.7798 35.0178C69.1374 31.5854 61.883 33.4025 58.6588 39.0559L22.9909 100.503C19.6995 106.157 21.6474 113.493 27.2898 116.925C32.9322 120.357 40.1867 118.54 43.4109 112.887L79.0788 51.4396C81.4298 47.4014 81.0939 42.4884 78.6757 38.7867Z" fill="#8875AC"/>
<path d="M127.575 79.0336C127.307 78.6971 127.105 78.2932 126.769 77.9567C122.605 72.8417 115.149 72.0341 110.111 76.2069L52.6123 123.992C47.6416 128.164 46.9699 135.635 51.1345 140.817C55.2991 145.932 62.7551 146.74 67.7929 142.567L125.291 94.7824C129.926 90.8788 130.867 84.0813 127.508 79.0336H127.575Z" fill="#8875AC"/>
</svg>
</section>

<style>
@keyframes ani-mouse {
  0% { opacity:1; top:29% }
  15% { opacity:1; top:50% }
  50% { opacity:0; top:50% }
  100% { opacity:0; top:29% }
}
.scroll-btn{display:block;position:absolute;left:0;right:0;text-align:center;bottom:30px}
.scroll-btn>*{display:inline-block;line-height:18px;font-size:13px;font-weight:400;color:#fff;letter-spacing:2px}
.scroll-btn>.active,.scroll-btn>:focus,.scroll-btn>:hover{color:#fff}
.scroll-btn>.active,.scroll-btn>:active,.scroll-btn>:focus,.scroll-btn>:hover{opacity:.8}
.scroll-btn .mouse{position:relative;display:block;width:30px;height:48px;margin:0 auto 20px;box-sizing:border-box;border:3px solid #fff;border-radius:23px}
.scroll-btn .mouse>*{position:absolute;display:block;top:29%;left:50%;width:8px;height:8px;margin:-4px 0 0 -4px;background:#fff;border-radius:50%;animation:2.5s linear infinite ani-mouse}
</style>
