<?php
/**
 * News & Events Section (Flexi)
 * - Grid layout, MAX 6 posts.
 * - Latest by default; if a category is selected (ACF Taxonomy), show latest from that category.
 * - Category pill shows (except 'uncategorized'); if the slug contains 'event', pill reads "Event".
 * - Each card is a single <a> link to the post (no nested anchors).
 */

$section_id  = 'news-events-' . uniqid();
$heading     = get_sub_field('heading') ?: 'News & events';
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$cat_field   = get_sub_field('category_filter'); // taxonomy field (object or null)

// Padding classes
$padding_classes = ['pt-5', 'pb-5'];
if (have_rows('padding_settings')) {
    $padding_classes = [];
    while (have_rows('padding_settings')) {
        the_row();
        $screen_size    = get_sub_field('screen_size');
        $padding_top    = get_sub_field('padding_top');
        $padding_bottom = get_sub_field('padding_bottom');
        if ($screen_size !== null && $padding_top !== null) {
            $padding_classes[] = esc_attr($screen_size) . ':pt-[' . esc_attr($padding_top) . 'rem]';
        }
        if ($screen_size !== null && $padding_bottom !== null) {
            $padding_classes[] = esc_attr($screen_size) . ':pb-[' . esc_attr($padding_bottom) . 'rem]';
        }
    }
}

// Query: MAX 6
$args = [
    'post_type'           => 'post',
    'posts_per_page'      => 6,
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
];

if (!empty($cat_field) && is_object($cat_field)) {
    if (!empty($cat_field->slug)) {
        $args['category_name'] = sanitize_title($cat_field->slug);
    } elseif (!empty($cat_field->term_id)) {
        $args['cat'] = (int) $cat_field->term_id;
    }
}

$q = new WP_Query($args);

// Collect posts
$items = [];
if ($q->have_posts()) {
    while ($q->have_posts()) {
        $q->the_post();
        $post_id   = get_the_ID();
        $title     = get_the_title($post_id) ?: __('Untitled post', 'your-textdomain');
        $permalink = get_permalink($post_id);
        $image_id  = get_post_thumbnail_id($post_id);

        // Determine primary category
        $cat_obj = null;
        $cats    = get_the_category($post_id);
        if (!empty($cats)) {
            foreach ($cats as $c) {
                if (!empty($c->slug) && $c->slug !== 'uncategorized') {
                    $cat_obj = $c; break;
                }
            }
            if (!$cat_obj) { $cat_obj = $cats[0]; }
        }

        $cat_slug  = $cat_obj->slug  ?? '';
        $cat_name  = $cat_obj->name  ?? '';
        $show_pill = ($cat_slug && $cat_slug !== 'uncategorized');
        $pill_text = (stripos($cat_slug, 'event') !== false) ? 'Event' : $cat_name;

        $items[] = [
            'title'     => $title,
            'image_id'  => $image_id,
            'url'       => $permalink,
            'show_pill' => $show_pill,
            'pill_text' => $pill_text,
        ];
    }
    wp_reset_postdata();
}

// Enforce MAX 6
$items = array_slice($items, 0, 6);

// Alt helper
function _ne_media_alt($attachment_id, $fallback) {
    $alt = '';
    if ($attachment_id) {
        $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
    }
    return $alt ? $alt : $fallback;
}
?>
<section id="<?php echo esc_attr($section_id); ?>" class="relative flex overflow-hidden" role="region" aria-labelledby="<?php echo esc_attr($section_id); ?>-heading">
    <div class="flex flex-col items-center w-full mx-auto max-w-container lg:py-24 max-lg:px-5 <?php echo esc_attr(implode(' ', $padding_classes)); ?>">

        <?php if (!empty($heading)) : ?>
            <<?php echo esc_attr($heading_tag); ?>
                id="<?php echo esc_attr($section_id); ?>-heading"
                class="text-[#3E4883] text-center pb-4 text-3xl font-normal leading-[2.375rem] max-md:max-w-full"
            >
                <?php echo esc_html($heading); ?>
            </<?php echo esc_attr($heading_tag); ?>>
        <?php endif; ?>

        <?php if (!empty($items)) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full mt-6" role="list" aria-label="News and events">
                <?php
                $rendered = 0;
                foreach ($items as $item) :
                    if ($rendered >= 6) { break; }
                    $rendered++;

                    $image_id  = (int) ($item['image_id'] ?? 0);
                    $title     = $item['title'] ?? '';
                    $url       = $item['url'] ?? '';
                    $image_alt = _ne_media_alt($image_id, $title ?: 'News image');

                    $show_pill = !empty($item['show_pill']);
                    $pill_text = !empty($item['pill_text']) ? $item['pill_text'] : '';
                ?>
                <a class="group block w-full relative focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600"
                   href="<?php echo esc_url($url); ?>"
                   aria-label="<?php echo esc_attr('Read article: ' . $title); ?>"
                   role="listitem"
                   target="_self">
                    <div class="relative overflow-hidden rounded-[3.5rem_3.5rem_3.5rem_1rem] w-full">
                        <div class="relative w-full min-h-[280px]">
                            <?php if ($image_id) : ?>
                                <?php echo wp_get_attachment_image($image_id, 'large', false, [
                                    'alt'     => esc_attr($image_alt),
                                    'class'   => 'object-cover absolute inset-0 w-full h-full transition-transform duration-300 group-hover:scale-[1.03]',
                                    'loading' => 'lazy',
                                ]); ?>
                            <?php endif; ?>

                            <?php if ($show_pill && !empty($pill_text)) : ?>
                                <div class="absolute top-0 left-0 z-[1] m-6 inline-flex items-center px-4 py-1 text-sm leading-none bg-white rounded-full shadow">
                                    <span class="whitespace-nowrap"><?php echo esc_html($pill_text); ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Title bar -->
                            <div class="absolute bottom-4 left-4 z-[1]">
                                <div class="inline-flex items-center p-4 text-xl bg-amber-400 rounded-[1rem]">
                                    <span class="text-zinc-800">
                                        <?php echo esc_html($title); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="mt-6 text-center" role="status" aria-live="polite">
                <?php echo esc_html__('No posts found.', 'your-textdomain'); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
