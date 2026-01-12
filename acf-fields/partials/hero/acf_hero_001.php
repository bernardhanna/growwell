<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$hero_001 = new FieldsBuilder('hero_001', [
    'label' => 'Hero Block',
]);

$hero_001
    ->addTab('Content', ['label' => 'Content'])
    ->addImage('desktop_image', [
        'label' => 'Desktop Background Image',
        'instructions' => 'Upload the background image for desktop and tablet devices (769px and above).',
        'return_format' => 'id',
        'preview_size' => 'medium',
        'required' => 1,
    ])
    ->addImage('mobile_image', [
        'label' => 'Mobile Background Image',
        'instructions' => 'Upload the background image for mobile devices (768px and below). If not provided, desktop image will be used.',
        'return_format' => 'id',
        'preview_size' => 'medium',
        'required' => 0,
    ])
    ->addText('title', [
        'label' => 'Title',
        'instructions' => 'Enter the main heading text for the hero section.',
        'default_value' => 'Welcome to Our Website',
        'required' => 1,
    ])
    ->addSelect('title_tag', [
        'label' => 'Title HTML Tag',
        'instructions' => 'Select the appropriate HTML tag for the title.',
        'choices' => [
            'h1' => 'H1',
            'h2' => 'H2',
            'h3' => 'H3',
            'h4' => 'H4',
            'h5' => 'H5',
            'h6' => 'H6',
            'p' => 'Paragraph',
            'span' => 'Span',
        ],
        'default_value' => 'h1',
        'required' => 1,
    ])
    ->addWysiwyg('description', [
        'label' => 'Description',
        'instructions' => 'Enter the description text that appears below the title.',
        'default_value' => '<p>Discover amazing features and services that will transform your experience.</p>',
        'media_upload' => 0,
        'tabs' => 'visual,text',
        'toolbar' => 'basic',
        'required' => 0,
    ])
    ->addLink('cta_button', [
        'label' => 'Call to Action Button',
        'instructions' => 'Add a call to action button with link, text, and target settings.',
        'return_format' => 'array',
        'required' => 0,
    ])
    ->addText('scroll_url', [
        'label'         => 'Scroll Button URL',
        'instructions'  => 'Anchor or URL the mouse/scroll button should link to (e.g. #image-text-69651b0a08ea7). Leave empty to hide.',
        'default_value' => '',
    ])
    ->addTab('Layout', ['label' => 'Layout'])
    ->addRepeater('padding_settings', [
        'label' => 'Padding Settings',
        'instructions' => 'Customize padding for different screen sizes.',
        'button_label' => 'Add Screen Size Padding',
        'min' => 0,
        'max' => 10,
    ])
    ->addSelect('screen_size', [
        'label' => 'Screen Size',
        'instructions' => 'Select the screen size for this padding setting.',
        'choices' => [
            'xxs' => 'XXS (Extra Extra Small)',
            'xs' => 'XS (Extra Small)',
            'mob' => 'Mobile',
            'sm' => 'SM (Small)',
            'md' => 'MD (Medium)',
            'lg' => 'LG (Large)',
            'xl' => 'XL (Extra Large)',
            'xxl' => 'XXL (Extra Extra Large)',
            'ultrawide' => 'Ultrawide',
        ],
        'required' => 1,
    ])
    ->addNumber('padding_top', [
        'label' => 'Padding Top',
        'instructions' => 'Set the top padding in rem units.',
        'min' => 0,
        'max' => 20,
        'step' => 0.1,
        'append' => 'rem',
        'default_value' => 5,
    ])
    ->addNumber('padding_bottom', [
        'label' => 'Padding Bottom',
        'instructions' => 'Set the bottom padding in rem units.',
        'min' => 0,
        'max' => 20,
        'step' => 0.1,
        'append' => 'rem',
        'default_value' => 5,
    ])
    ->endRepeater();

return $hero_001;
