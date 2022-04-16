<?php if (!defined('ABSPATH'))  die;
$site_url = site_url();
$prefix = 'pp_opts';


CSF::createOptions($prefix, [
  'framework_title' => 'تنظیمات سایت',
  'menu_title' => 'تنظیمات سایت',
  'menu_slug' => 'theme_options',
  'menu_icon' => 'dashicons-chart-pie',
  'admin_bar_menu_icon' => 'dashicons-chart-pie',
  'show_in_customizer' => false,
  'show_search' => false,
  'show_reset_all' => true,
  'show_reset_section' => false,
  'footer_text' => '<strong>پیشرو پرداخت</strong>',
  'footer_credit' => 'از اینکه به ما اعتماد کردید، سپاسگذاریم <a href="https://pypracts.ir">PyPracts</a>',
  // 'defaults' => [],
]);


CSF::createSection($prefix, array(
  'id' => 'currencies',
  'title'  => 'تنظیمات ارزها',
  'icon' => 'far fa-money-bill-alt',
  'fields' => [
    [
      'type' => 'notice',
      'style' => 'info',
      'content' => 'برای دریافت نرخ ارزها در فرم از تابع pp_get_currency_options در options_source استفاده کنید.',
    ],
    [
      'type' => 'notice',
      'style' => 'info',
      'content' =>  $site_url . '/wp-json/pp_opts/v1/currencies?code=sana_sell_usd,sana_sell_cad',
    ],

    [
      'id' => 'is_remote',
      'type' => 'switcher',
      'title' => 'بروزرسانی خودکار نرخ ارز ها',
      'default' => true,
    ],
    [
      'id'    => 'reccurence',
      'type'    => 'number',
      'title'   => 'بازه بروزرسانی ارزها (دقیقه)',
      'default' => 50,
      'dependency' => [
        'is_remote', '==', 'true'
      ],
    ],
    [
      'id'          => 'service_provider',
      'type'        => 'select',
      'title'       => 'سرویس دهنده ارز ها',
      'placeholder' => 'انتخاب کنید',
      'options'     => array(
        'tgju'  => 'tgju',
        'parsijoo'  => 'پارسیجو',
      ),
      'default'     => 'tgju',
      'dependency' => [
        'is_remote', '==', 'true'
      ],
    ],
    [
      'id' => 'currencies',
      'type' => 'group',
      'title' => 'نرخ ارزها',
      'fields' => [
        [
          'id' => 'code',
          'type' => 'text',
          'title' => 'کد ارز',
          'default' => 'sana_sell_usd',
        ],
        [
          'id' => 'title',
          'type' => 'text',
          'title' => 'عنوان ارز',
          'default' => 'عنوان ارز',
        ],
        [
          'id' => 'parsijoo_title',
          'type' => 'text',
          'title' => 'عنوان پارسیجو',
          'default' => 'دلار',
        ],
        [
          'id' => 'price',
          'type' => 'number',
          'title' => 'نرخ ارز',
          'default' => 0,
        ],
        [
          'id' => 'profit',
          'type' => 'number',
          'title' => 'کارمزد ارز',
          'default' => 0,
        ],
        [
          'id'      => 'updated_at',
          'type'    => 'text',
          'title'   => 'آخرین بروز رسانی خودکار',
          'help'   => 'آخرین بروز رسانی خودکار',
          'attributes'   => [
            'class'      => 'updated_at',
            'disabled'      => "disabled"
          ],
          'placeholder'   => 'آخرین بروز رسانی خودکار',
          'disabled'   => true,
          // 'default' => 'آخرین بروزرسانی' . (new \DateTime())->format('Y-m-d H:i:s'),
        ],
      ],
      'dependency' => [
        'is_remote', '==', 'true'
      ],
    ],

    [
      'id' => 'token',
      'type' => 'text',
      'title' => 'توکن ارزها',
      'default' => '',
      'dependency' => [
        'is_remote', '==', 'true',
        'service_provider', '==', 'tgju'
      ],
    ],
  ]
));


CSF::createSection($prefix, array(
  'id' => 'crypto_currencies',
  'title'  => 'تنظیمات رمز ارزها',
  'icon'  => 'fas fa-plus-circle',
  'fields' => [
    [
      'type' => 'notice',
      'style' => 'info',
      'content' => 'برای دریافت نرخ ارزها در فرم از تابع <strong>pp_get_currency_options</strong> در <strong>options_source</strong> استفاده کنید.',
    ],
    [
      'type' => 'notice',
      'style' => 'info',
      'content' => 'https://pishropardakht.com/wp-json/pp_opts/v1/currencies?<strong>code=sana_sell_usd</strong>,<strong>sana_sell_cad</strong>',
    ],

    [
      'id' => 'crypto_is_remote',
      'type' => 'switcher',
      'default' => true,
      'title' => 'بروزرسانی خودکار نرخ رمز ارز ها',
    ],
    [
      'id'    => 'crypto_reccurence',
      'type'    => 'number',
      'title'   => 'بازه بروزرسانی رمز ارزها (دقیقه)',
      'default' => 50,
      'dependency' => [
        'crypto_is_remote', '==', 'true'
      ],
    ],
    [
      'id'          => 'crypto_service_provider',
      'type'        => 'select',
      'title'       => 'سرویس دهنده ارز ها',
      'placeholder' => 'انتخاب کنید',
      'options'     => array(
        'tgju'  => 'tgju',
        'parsijoo'  => 'پارسیجو',
      ),
      'default'     => 'option-2',
      'dependency' => [
        'crypto_is_remote', '==', 'true'
      ],
    ],
    [
      'id' => 'crypto_currencies',
      'type' => 'group',
      'title' => 'نرخ رمز ارزها',
      'fields' => [
        [
          'id' => 'uniq_id',
          'type' => 'text',
          'title' => 'currency_uniq_id',
          'default' => 'crypto-bitcedi-buy',
        ],
        [
          'id' => 'code',
          'type' => 'text',
          'title' => 'کد رمز ارز',
          'default' => 'crypto-bitcedi',
        ],
        [
          'id' => 'title',
          'type' => 'text',
          'title' => 'عنوان رمز ارز',
          'default' => 'عنوان رمز ارز',
        ],
        [
          'id' => 'price',
          'type' => 'number',
          'title' => 'نرخ رمز ارز',
          'default' => 0,
        ],
        [
          'id' => 'profit',
          'type' => 'number',
          'title' => 'کارمزد رمز ارز',
          'default' => 0,
        ],
        [
          'id'      => 'updated_at',
          'type'    => 'text',
          'title'   => 'آخرین بروز رسانی خودکار',
          'help'   => 'آخرین بروز رسانی خودکار',
          'attributes'   => [
            'class'      => 'updated_at',
            'disabled'      => "disabled"
          ],
          'placeholder'   => 'آخرین بروز رسانی خودکار',
          'disabled'   => true,
        ],
      ],
      'dependency' => [
        'crypto_is_remote', '==', 'true'
      ],
    ],
    [
      'id' => 'crypto_token',
      'type' => 'text',
      'title' => 'توکن ارزها',
      'default' => '',
      'dependency' => [
        'crypto_is_remote', '==', 'true',
        'crypto_service_provider', '==', 'tgju'
      ],
    ],

  ]
));
