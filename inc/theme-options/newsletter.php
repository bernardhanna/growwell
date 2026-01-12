<?php
use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Newsletter – Theme Options
 * Location: Options Page
 */
$newsletter_opts = new FieldsBuilder('newsletter_options', [
  'label' => 'Newsletter',
]);

$newsletter_opts
  // CONTENT
  ->addImage('icon', [
    'label'         => 'Icon',
    'return_format' => 'url',
    'preview_size'  => 'thumbnail',
    'default_value' => 'https://api.builder.io/api/v1/image/assets/f35586c581c84ecf82b6de32c55ed39e/301e89f03d7d97e1d3092c1ed127110fe05e8512?placeholderIfAbsent=true',
  ])
  ->addText('heading', [
    'label'         => 'Main Heading',
    'default_value' => 'Get early access to the resources',
  ])
  ->addSelect('heading_tag', [
    'label'         => 'Heading Tag',
    'choices'       => ['h1'=>'H1','h2'=>'H2','h3'=>'H3','h4'=>'H4','h5'=>'H5','h6'=>'H6'],
    'default_value' => 'h2',
  ])
  ->addText('description', [
    'label'         => 'Description Text',
    'default_value' => 'Are you a teacher or work with children with SEN?',
  ])

  // === NEW: how the form is provided (built-in / shortcode / HTML) ===
  ->addSelect('form_mode', [
    'label'         => 'Form Mode',
    'instructions'  => 'Use built-in Brevo signup, or embed your own form via shortcode or raw HTML.',
    'choices'       => [
      'brevo'     => 'Built-in newsletter (Brevo)',
      'shortcode' => 'Shortcode (Gravity Forms / CF7 / WPForms / etc.)',
      'html'      => 'Raw HTML (WYSIWYG)',
    ],
    'default_value' => 'brevo',
    'ui'           => 1,
  ])
  ->addText('form_shortcode', [
    'label'            => 'Form Shortcode',
    'instructions'     => 'Paste a shortcode like [gravityform id="1" title="false"]',
    'conditional_logic'=> [[['field' => 'form_mode', 'operator' => '==', 'value' => 'shortcode']]],
  ])
  ->addWysiwyg('form_html', [
    'label'            => 'Form HTML',
    'instructions'     => 'Paste raw HTML for a custom form.',
    'media_upload'     => 0,
    'delay'            => 0,
    'conditional_logic'=> [[['field' => 'form_mode', 'operator' => '==', 'value' => 'html']]],
    'wrapper'          => ['class' => 'wp_editor'],
  ])

  // Built-in newsletter bits (used when form_mode = brevo)
  ->addTrueFalse('newsletter_enabled', [
    'label'         => 'Enable Built-in Newsletter',
    'ui'            => 1,
    'default_value' => 1,
  ])
  ->addText('brevo_list_ids', [
    'label'            => 'Brevo List IDs',
    'instructions'     => 'Comma-separated list IDs for Brevo newsletter subscription',
    'conditional_logic'=> [[['field' => 'newsletter_enabled', 'operator' => '==', 'value' => 1]]],
  ])
  ->addText('success_message', [
    'label'            => 'Success Message',
    'default_value'    => 'Thanks! You\'ve been subscribed to our newsletter.',
    'conditional_logic'=> [[['field' => 'newsletter_enabled', 'operator' => '==', 'value' => 1]]],
  ])
  ->addText('error_message', [
    'label'            => 'Error Message',
    'default_value'    => 'Sorry, something went wrong. Please try again.',
    'conditional_logic'=> [[['field' => 'newsletter_enabled', 'operator' => '==', 'value' => 1]]],
  ])

  // DESIGN
  ->addColorPicker('background_color', [
    'label'         => 'Background Color',
    'default_value' => '#fbbf24',
  ])
  ->addColorPicker('text_color', [
    'label'         => 'Text Color',
    'default_value' => '#27272a',
  ])
  ->addColorPicker('button_bg_color', [
    'label'         => 'Button Background Color',
    'default_value' => '#312e81',
  ])
  ->addColorPicker('button_text_color', [
    'label'         => 'Button Text Color',
    'default_value' => '#ffffff',
  ])

  // LAYOUT (padding controls)
  ->addRepeater('padding_settings', [
    'label'         => 'Padding Settings',
    'instructions'  => 'Customize padding for different screen sizes.',
    'button_label'  => 'Add Padding',
  ])
    ->addSelect('screen_size', [
      'label'   => 'Screen Size',
      'choices' => [
        'xxs'=>'xxs','xs'=>'xs','mob'=>'mob','sm'=>'sm','md'=>'md','lg'=>'lg','xl'=>'xl','xxl'=>'xxl','ultrawide'=>'ultrawide',
      ],
    ])
    ->addNumber('padding_top', [
      'label' => 'Padding Top',
      'min' => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem',
    ])
    ->addNumber('padding_bottom', [
      'label' => 'Padding Bottom',
      'min' => 0, 'max' => 20, 'step' => 0.1, 'append' => 'rem',
    ])
  ->endRepeater();

return $newsletter_opts;

