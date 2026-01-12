<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$content_block_two = new FieldsBuilder('content_block_two', [
    'label' => 'Content Block Two',
]);

$content_block_two
    ->addTab('Content', ['label' => 'Content'])
    ->addText('heading', [
        'label' => 'Heading Text',
        'instructions' => 'Enter the main heading text.',
        'default_value' => 'Any questions? Meet us!',
        'required' => 1,
    ])
    ->addSelect('heading_tag', [
        'label' => 'Heading Tag',
        'instructions' => 'Select the HTML tag for the heading.',
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
        'default_value' => 'h2',
        'required' => 1,
    ])
    ->addText('subheading', [
        'label' => 'Subheading Text',
        'instructions' => 'Enter the subheading text (optional).',
        'default_value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.',
    ])
    ->addWysiwyg('content', [
        'label' => 'Main Content',
        'instructions' => 'Enter the main content text.',
        'default_value' => '<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.</p>',
        'media_upload' => 0,
        'tabs' => 'all',
        'toolbar' => 'full',
    ])
    ->addImage('image', [
        'label' => 'Featured Image',
        'instructions' => 'Upload an image for this content block.',
        'return_format' => 'id',
        'preview_size' => 'medium',
        'library' => 'all',
    ])
    ->addLink('button', [
        'label' => 'Call to Action Button',
        'instructions' => 'Add a button link (optional).',
        'return_format' => 'array',
    ])

    ->addTab('Design', ['label' => 'Design'])
    ->addColorPicker('background_color', [
        'label' => 'Background Color',
        'instructions' => 'Choose the background color for this section.',
        'default_value' => '#dbeafe',
    ])
    ->addColorPicker('heading_color', [
        'label' => 'Heading Color',
        'instructions' => 'Choose the color for the main heading.',
        'default_value' => '#0d9488',
    ])
    ->addColorPicker('subheading_color', [
        'label' => 'Subheading Color',
        'instructions' => 'Choose the color for the subheading.',
        'default_value' => '#312e81',
    ])
    ->addColorPicker('content_color', [
        'label' => 'Content Text Color',
        'instructions' => 'Choose the color for the main content text.',
        'default_value' => '#27272a',
    ])
    ->addColorPicker('button_bg_color', [
        'label' => 'Button Background Color',
        'instructions' => 'Choose the background color for the button.',
        'default_value' => '#fbbf24',
    ])
    ->addColorPicker('button_text_color', [
        'label' => 'Button Text Color',
        'instructions' => 'Choose the text color for the button.',
        'default_value' => '#27272a',
    ])
    ->addTrueFalse('show_decorative_shape', [
        'label' => 'Show Decorative Shape',
        'instructions' => 'Toggle to show/hide the decorative background shape.',
        'default_value' => 1,
        'ui' => 1,
    ])

    ->addTab('Layout', ['label' => 'Layout'])
    ->addTrueFalse('reverse_layout', [
        'label' => 'Reverse Layout',
        'instructions' => 'Toggle to reverse the image and text positions (image on left, text on right).',
        'default_value' => 0,
        'ui' => 1,
    ])
    ->addRepeater('padding_settings', [
        'label' => 'Padding Settings',
        'instructions' => 'Customize padding for different screen sizes.',
        'button_label' => 'Add Screen Size Padding',
        'layout' => 'table',
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
        'default_value' => 6,
    ])
    ->addNumber('padding_bottom', [
        'label' => 'Padding Bottom',
        'instructions' => 'Set the bottom padding in rem units.',
        'min' => 0,
        'max' => 20,
        'step' => 0.1,
        'append' => 'rem',
        'default_value' => 6,
    ])
    ->endRepeater();

return $content_block_two;
