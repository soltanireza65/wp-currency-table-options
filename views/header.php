<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.

  $demo    = get_option( 'csf_demo_mode', false );
  $text    = ( ! empty( $demo ) ) ? 'غیر فعال سازی' : 'فعال سازی';
  $status  = ( ! empty( $demo ) ) ? 'deactivate' : 'activate';
  $class   = ( ! empty( $demo ) ) ? ' csf-warning-primary' : '';
  $section = ( ! empty( $_GET[ 'section' ] ) ) ? sanitize_text_field( wp_unslash( $_GET[ 'section' ] ) ) : 'about';
  $links   = array(
    'about'           => 'درباره',
    'quickstart'      => 'شروع سریع',
    'documentation'   => 'مستندات افزونه',
    'free-vs-premium' => 'مقایسه نسخه رایگان و پرمیوم',
    'support'         => 'پشتیبانی',
    'relnotes'        => 'یادداشت های انتشار',
  );

?>
<div class="csf-welcome csf-welcome-wrap">

  <h1>به فریمورک قدرتمند کُداستار خوش آمدید <?php echo esc_attr( CSF::$version ); ?></h1>

  <p class="csf-about-text">یک چارچوب قدرتمند و گزینه ساده و سبک وردپرس برای ایجاد پنل تنظیمات حرفه ای برای قالب ها و افزونه ها</p>

  <p class="csf-demo-button"><a href="<?php echo esc_url( add_query_arg( array( 'csf-demo' => $status ) ) ); ?>" class="button button-primary<?php echo esc_attr( $class ); ?>"><?php echo esc_attr( $text ); ?> Demo</a></p>

  <div class="csf-logo">
    <div class="csf--effects"><i></i><i></i><i></i><i></i></div>
    <div class="csf--wp-logos">
      <div class="csf--wp-logo"></div>
      <div class="csf--wp-plugin-logo"></div>
    </div>
    <div class="csf--text">فریمورک کُداستار</div>
    <div class="csf--text csf--version">v<?php echo esc_attr( CSF::$version ); ?></div>
  </div>

  <h2 class="nav-tab-wrapper wp-clearfix">
    <?php

      foreach ( $links as $key => $link ) {

        if ( CSF::$premium && $key === 'free-vs-premium' ) { continue; }

        $activate = ( $section === $key ) ? ' nav-tab-active' : '';

        echo '<a href="'. esc_url( add_query_arg( array( 'page' => 'csf-welcome', 'section' => $key ), admin_url( 'tools.php' ) ) ) .'" class="nav-tab'. esc_attr( $activate ) .'">'. esc_attr( $link ) .'</a>';

      }

    ?>
  </h2>
