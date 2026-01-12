<?php
// Get ACF fields
$heading = get_sub_field('heading');
$heading_tag = get_sub_field('heading_tag');
$subheading = get_sub_field('subheading');
$content = get_sub_field('content');
$image = get_sub_field('image');
$image_alt = get_post_meta($image, '_wp_attachment_image_alt', true) ?: 'Content image';
$button = get_sub_field('button');
$reverse_layout = get_sub_field('reverse_layout');
$show_decorative_shape = get_sub_field('show_decorative_shape');

// Design options
$background_color = get_sub_field('background_color') ?: '#dbeafe';
$heading_color = get_sub_field('heading_color') ?: '#0d9488';
$subheading_color = get_sub_field('subheading_color') ?: '#312e81';
$content_color = get_sub_field('content_color') ?: '#27272a';
$button_bg_color = get_sub_field('button_bg_color') ?: '#fbbf24';
$button_text_color = get_sub_field('button_text_color') ?: '#27272a';

// Padding settings
$padding_classes = [];
if (have_rows('padding_settings')) {
    while (have_rows('padding_settings')) {
        the_row();
        $screen_size = get_sub_field('screen_size');
        $padding_top = get_sub_field('padding_top');
        $padding_bottom = get_sub_field('padding_bottom');
        $padding_classes[] = "{$screen_size}:pt-[{$padding_top}rem]";
        $padding_classes[] = "{$screen_size}:pb-[{$padding_bottom}rem]";
    }
}

// Generate unique ID for this section
$section_id = 'content-block-' . wp_generate_uuid4();
?>

<section
    id="<?php echo esc_attr($section_id); ?>"
    class="relative flex overflow-hidden <?php echo esc_attr(implode(' ', $padding_classes)); ?>"
    style="background-color: <?php echo esc_attr($background_color); ?>;"
    role="region"
    aria-labelledby="<?php echo esc_attr($section_id); ?>-heading"
>
    <?php if ($show_decorative_shape): ?>
        <div class="absolute left-0 bottom-0 pointer-events-none" aria-hidden="true">
            <svg
                width="341"
                height="506"
                viewBox="0 0 341 506"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                class="w-[341px] h-[506px]"
                role="presentation"
            >
                <path
                    d="M228.946 482.501C192.382 516.232 140.64 539.789 79.3039 550.707C33.4712 558.717 -1.52046 557.139 -2.98304 557.008C-12.6622 556.439 -20.2973 548.516 -20.2497 538.77L-22.2229 143.07C-22.3728 111.659 -17.1415 80.1833 -5.22555 51.0522C6.3762 22.7672 24.0899 -3.11081 48.5824 6.39634C97.5225 25.5315 -29.0142 214.261 50.7146 214.848C130.444 215.436 237.74 35.2399 291.699 54.1759C345.658 73.1119 348.477 120.641 317.971 175.05C287.511 229.338 111.665 274.887 93.5923 338.725C75.5196 402.564 206.379 312.806 265.784 359.619C325.234 406.311 229.112 482.425 229.112 482.425L228.946 482.501Z"
                    fill="#99D7F2"
                />
            </svg>
        </div>
    <?php endif; ?>

    <div class="flex flex-col items-center w-full mx-auto max-w-[1000px] lg:py-24 pt-5 pb-5 max-lg:px-5">
        <div class="flex relative gap-12 items-center w-full max-w-[1088px] z-[1] <?php echo $reverse_layout ? 'flex-col md:flex-row-reverse' : 'flex-col md:flex-row'; ?> max-md:gap-8 max-md:items-start max-sm:gap-6">

            <div class="flex relative flex-col shrink-0 gap-4 items-start w-full md:w-[448px] max-md:w-full">
                <?php if (!empty($heading)): ?>
                    <header class="flex relative flex-col items-start self-stretch">
                        <<?php echo esc_attr($heading_tag); ?>
                            id="<?php echo esc_attr($section_id); ?>-heading"
                            class="relative text-[#008A80] text-4xl font-bold leading-[2.625rem] tracking-[-0.045rem]"
                            style="color: <?php echo esc_attr($heading_color); ?>;"
                        >
                            <?php echo esc_html($heading); ?>
                        </<?php echo esc_attr($heading_tag); ?>>
                    </header>
                <?php endif; ?>

                <?php if (!empty($subheading)): ?>
                    <div
                        class="relative self-stretch text-xl font-semibold leading-8 max-sm:text-lg max-sm:leading-7"
                        style="color: <?php echo esc_attr($subheading_color); ?>;"
                    >
                        <?php echo esc_html($subheading); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($content)): ?>
                    <div
                        class="w-full text-lg font-normal leading-7 text-[#21282E] wp_editor relative"
                        style="color: <?php echo esc_attr($content_color); ?>;"
                    >
                        <?php echo wp_kses_post($content); ?>
                    </div>
                <?php endif; ?>

                <?php if ($button && is_array($button) && isset($button['url'], $button['title'])): ?>
                    <div class="flex relative flex-col gap-2 items-start pt-2">
                        <a
                            href="<?php echo esc_url($button['url']); ?>"
                            class="flex relative gap-2 justify-center items-center px-6 py-4 rounded cursor-pointer border-none h-[52px] max-sm:px-5 max-sm:py-3 max-sm:w-full max-sm:h-12 w-fit whitespace-nowrap btn transition-all duration-300 hover:opacity-90 focus:ring-2 focus:ring-offset-2"
                            style="background-color: <?php echo esc_attr($button_bg_color); ?>; color: <?php echo esc_attr($button_text_color); ?>; --tw-ring-color: <?php echo esc_attr($button_bg_color); ?>;"
                            target="<?php echo esc_attr($button['target'] ?? '_self'); ?>"
                            aria-label="<?php echo esc_attr($button['title']); ?>"
                        >
                            <span class="relative text-base font-semibold leading-6 max-sm:text-base max-sm:leading-6">
                                <?php echo esc_html($button['title']); ?>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($image): ?>
                <div class="object-cover overflow-hidden relative shrink-0 h-96 rounded-[56px_0_0_0] w-full md:w-[544px] max-md:w-full max-md:h-auto max-md:rounded-[32px_0_0_0] max-sm:w-full max-sm:h-auto max-sm:rounded-[24px_0_0_0]">
                    <?php echo wp_get_attachment_image($image, 'full', false, [
                        'alt' => esc_attr($image_alt),
                        'class' => 'w-full h-full object-cover',
                        'loading' => 'lazy'
                    ]); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
