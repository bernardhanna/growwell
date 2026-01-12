<?php
// Get ACF fields
$heading = get_sub_field('heading');
$heading_tag = get_sub_field('heading_tag');
$heading_color = get_sub_field('heading_color');
$content = get_sub_field('content');
$image = get_sub_field('image');
$image_alt = get_post_meta($image, '_wp_attachment_image_alt', true) ?: 'Featured image';
$button = get_sub_field('button');
$reverse_layout = get_sub_field('reverse_layout');
$background_color = get_sub_field('background_color');

// Generate unique section ID
$section_id = 'image-text-' . uniqid();

// Build padding classes
$padding_classes = [];
if (have_rows('padding_settings')) {
    while (have_rows('padding_settings')) {
        the_row();
        $screen_size = get_sub_field('screen_size');
        $padding_top = get_sub_field('padding_top');
        $padding_bottom = get_sub_field('padding_bottom');

        if ($padding_top) {
            $padding_classes[] = "{$screen_size}:pt-[{$padding_top}rem]";
        }
        if ($padding_bottom) {
            $padding_classes[] = "{$screen_size}:pb-[{$padding_bottom}rem]";
        }
    }
}

// Default padding if none set
if (empty($padding_classes)) {
    $padding_classes = ['pt-24', 'pb-0', 'max-md:pt-16', 'max-sm:pt-10'];
}
?>

<section
    id="<?php echo esc_attr($section_id); ?>"
    class="relative flex overflow-hidden"
    style="background-color: <?php echo esc_attr($background_color ?: '#ffffff'); ?>;"
    role="region"
    aria-labelledby="<?php echo esc_attr($section_id); ?>-heading"
>
    <div class="flex flex-col  items-end w-full mx-auto max-w-[1000px] <?php echo esc_attr(implode(' ', $padding_classes)); ?>  max-lg:px-5">
        <div class="flex gap-12 justify-between items-center w-full <?php echo $reverse_layout ? 'max-md:flex-col-reverse max-md:gap-8 max-sm:gap-6 flex-row-reverse' : 'max-md:flex-col max-sm:gap-6'; ?>">

            <!-- Text Content Section -->
            <div class="flex flex-col shrink-0 gap-4 items-start lg:w-[448px] max-md:w-full max-md:max-w-[600px]">

                <?php if (!empty($heading)): ?>
                <header class="flex flex-col items-start w-full">
                    <<?php echo esc_attr($heading_tag ?: 'h2'); ?>
                        id="<?php echo esc_attr($section_id); ?>-heading"
                        class="w-full text-4xl font-bold leading-[2.625rem] tracking-[-0.045rem]"
                        style="color: <?php echo esc_attr($heading_color ?: '#f87171'); ?>;"
                    >
                        <?php echo esc_html($heading); ?>
                    </<?php echo esc_attr($heading_tag ?: 'h2'); ?>>
                </header>
                <?php endif; ?>

                <?php if (!empty($content)): ?>
                <div class="w-full text-lg font-normal leading-7 text-[#21282E] wp_editor">
                    <?php echo wp_kses_post($content); ?>
                </div>
                <?php endif; ?>

                <?php if ($button && is_array($button) && !empty($button['url']) && !empty($button['title'])): ?>
                <div class="flex flex-col gap-2 items-start pt-2" role="group" aria-label="Call to action">
                    <a
                        href="<?php echo esc_url($button['url']); ?>"
                        class="box-border flex gap-2 justify-center items-center px-6 py-4 bg-amber-400 rounded cursor-pointer h-[52px] max-sm:px-5 max-sm:py-3 max-sm:w-full max-sm:h-12 w-fit whitespace-nowrap btn transition-all duration-300 hover:bg-amber-500 focus:bg-amber-500"
                        target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
                        aria-label="<?php echo esc_attr($button['title']); ?>"
                        <?php if (($button['target'] ?? '') === '_blank'): ?>
                            rel="noopener noreferrer"
                            aria-describedby="<?php echo esc_attr($section_id); ?>-external-link"
                        <?php endif; ?>
                    >
                        <span class="text-base font-semibold leading-6 text-zinc-800 max-sm:text-base max-sm:leading-6">
                            <?php echo esc_html($button['title']); ?>
                        </span>
                    </a>

                    <?php if (($button['target'] ?? '') === '_blank'): ?>
                        <span id="<?php echo esc_attr($section_id); ?>-external-link" class="sr-only">
                            Opens in a new window
                        </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>

            <!-- Image Section -->
            <?php if ($image): ?>
            <figure class="object-cover overflow-hidden shrink-0 h-96 rounded-none w-[544px] max-md:w-full max-md:h-auto max-md:aspect-[544/384] max-md:max-w-[600px] max-sm:rounded-none rounded-bl-[4rem]">
                <?php
                echo wp_get_attachment_image($image, 'full', false, [
                    'alt' => esc_attr($image_alt),
                    'class' => 'object-cover w-full h-full rounded-bl-[4rem]',
                    'loading' => 'lazy',
                    'decoding' => 'async'
                ]);
                ?>
            </figure>
            <?php endif; ?>

        </div>
    </div>
</section>
