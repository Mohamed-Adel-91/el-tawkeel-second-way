<?php

return [
    'mode'                  => 'utf-8',
    'format'                => 'A4',
    'default_font' => 'dubai',
    'direction' => 'rtl',
    'tempDir' => storage_path('app/pdf-temp'),
    'font_path' => storage_path('fonts/'),
    'font_data' => [
        'dubai' => [
            'R' => 'Dubai-Regular.ttf',
            'B' => 'Dubai-Bold.ttf',
            'useOTL'     => 0xFF,
            'useKashida' => 75,
        ],
        // 'noto' => [
        //     'R' => 'NotoNaskhArabic-Regular.ttf',
        //     'B' => 'NotoNaskhArabic-Bold.ttf',
        //     'useOTL' => 0xFF,
        //     'useKashida' => 75,
        // ],
    ],
    'autoScriptToLang' => true,
    'autoLangToFont'   => true,
    'author'                => '',
    'subject'               => '',
    'keywords'              => '',
    'creator'               => 'Laravel Pdf',
    'display_mode'          => 'fullpage',
    'pdf_a'                 => false,
    'pdf_a_auto'            => false,
    'icc_profile_path'      => ''
];
