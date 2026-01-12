<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

$news_events = new FieldsBuilder('news_events', [
    'label' => 'News & Events Section',
]);

$news_events
    ->addTab('Content', ['label' => 'Content'])
        ->addText('heading', [
            'label' => 'Section Heading',
            'instructions' => 'Enter the main heading.',
            'default_value' => 'News & events',
        ])
        ->addSelect('heading_tag', [
            'label' => 'Heading Tag',
            'choices' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
                'p'  => 'Paragraph',
                'span' => 'Span',
            ],
            'default_value' => 'h2',
        ])
        // Optional category; if empty, show latest 6 posts.
        ->addTaxonomy('category_filter', [
            'label' => 'Category (optional)',
            'taxonomy' => 'category',
            'field_type' => 'select',
            'add_term' => 0,
            'save_terms' => 0,
            'load_terms' => 0,
            'return_format' => 'object', // we’ll read ->slug or ->term_id
            'allow_null' => 1,
        ])

    ->addTab('Layout', ['label' => 'Layout'])
        ->addRepeater('padding_settings', [
            'label' => 'Padding Settings',
            'instructions' => 'Customize padding for different screen sizes.',
            'button_label' => 'Add Screen Size Padding',
            'layout' => 'table',
        ])
            ->addSelect('screen_size', [
                'label' => 'Screen Size',
                'choices' => [
                    'xxs' => 'xxs',
                    'xs' => 'xs',
                    'mob' => 'mob',
                    'sm' => 'sm',
                    'md' => 'md',
                    'lg' => 'lg',
                    'xl' => 'xl',
                    'xxl' => 'xxl',
                    'ultrawide' => 'ultrawide',
                ],
            ])
            ->addNumber('padding_top', [
                'label' => 'Padding Top',
                'min' => 0,
                'max' => 20,
                'step' => 0.1,
                'append' => 'rem',
                'default_value' => 1.25,
            ])
            ->addNumber('padding_bottom', [
                'label' => 'Padding Bottom',
                'min' => 0,
                'max' => 20,
                'step' => 0.1,
                'append' => 'rem',
                'default_value' => 6,
            ])
        ->endRepeater();

return $news_events;
