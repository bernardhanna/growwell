<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$image_with_text = new FieldsBuilder('image_with_text', [
    'label' => 'Image with Text',
]);

$image_with_text
    ->addTab('Content', [
        'label' => 'Content',
        'placement' => 'top',
    ])
    ->addText('heading', [
        'label' => 'Heading Text',
        'instructions' => 'Enter the main heading text for this section.',
        'default_value' => 'Empower learners with disabilities by creating inclusive digital materials',
        'required' => 1,
    ])
    ->addSelect('heading_tag', [
        'label' => 'Heading Tag',
        'instructions' => 'Select the appropriate HTML heading tag for SEO and accessibility.',
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
    ->addWysiwyg('content', [
        'label' => 'Content',
        'instructions' => 'Enter the main content text that will appear below the heading.',
        'default_value' => '<p>The industry-led programme is supported through €20m funding from DIGITAL Europe. It will equip European SMEs and companies with a comprehensive knowledge of cybersecurity management, regulatory and technical skills, helping to safeguard European industries from cyber attacks. This pan-European resilience will protect our economic prosperity, and support long-term competitiveness and growth.</p>',
        'media_upload' => 0,
        'tabs' => 'all',
        'toolbar' => 'full',
        'required' => 1,
    ])
    ->addImage('image', [
        'label' => 'Featured Image',
        'instructions' => 'Upload an image that will be displayed alongside the text content.',
        'return_format' => 'id',
        'preview_size' => 'medium',
        'library' => 'all',
        'required' => 1,
    ])
    ->addLink('button', [
        'label' => 'Call to Action Button',
        'instructions' => 'Add a button link with custom text and destination URL.',
        'return_format' => 'array',
        'required' => 0,
    ])

    ->addTab('Design', [
        'label' => 'Design',
        'placement' => 'top',
    ])
    ->addColorPicker('heading_color', [
        'label' => 'Heading Text Color',
        'instructions' => 'Choose the color for the main heading text.',
        'default_value' => '#f87171',
        'enable_opacity' => 0,
    ])
    ->addColorPicker('background_color', [
        'label' => 'Background Color',
        'instructions' => 'Set the background color for this section.',
        'default_value' => '#ffffff',
        'enable_opacity' => 0,
    ])

    ->addTab('Layout', [
        'label' => 'Layout',
        'placement' => 'top',
    ])
    ->addTrueFalse('reverse_layout', [
        'label' => 'Reverse Layout',
        'instructions' => 'Toggle this to switch the positions of the text and image (image on left, text on right).',
        'default_value' => 0,
        'ui' => 1,
        'ui_on_text' => 'Reversed',
        'ui_off_text' => 'Normal',
    ])
    ->addRepeater('padding_settings', [
        'label' => 'Padding Settings',
        'instructions' => 'Customize padding for different screen sizes. Add multiple entries to control padding at different breakpoints.',
        'button_label' => 'Add Screen Size Padding',
        'layout' => 'table',
        'min' => 0,
        'max' => 10,
    ])
        ->addSelect('screen_size', [
            'label' => 'Screen Size',
            'instructions' => 'Select the screen size breakpoint for this padding setting.',
            'choices' => [
                'xxs' => 'Extra Extra Small (xxs)',
                'xs' => 'Extra Small (xs)',
                'mob' => 'Mobile (mob)',
                'sm' => 'Small (sm)',
                'md' => 'Medium (md)',
                'lg' => 'Large (lg)',
                'xl' => 'Extra Large (xl)',
                'xxl' => 'Extra Extra Large (xxl)',
                'ultrawide' => 'Ultra Wide (ultrawide)',
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

return $image_with_text;