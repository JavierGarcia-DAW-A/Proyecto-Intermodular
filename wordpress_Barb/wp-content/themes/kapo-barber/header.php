<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.ico">

    <!-- CSS here -->
    <?php wp_head(); ?>
</head>
<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo/loder.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!--? Header Start -->
        <div class="header-area header-transparent pt-20">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-2 col-md-1">
                            <div class="logo">
                                <a href="<?php echo home_url('/'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo/logo.png" alt=""></a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10 col-md-10">
                            <div class="menu-main d-flex align-items-center justify-content-end">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav>
                                        <?php
                                        wp_nav_menu( array(
                                            'theme_location' => 'primary',
                                            'menu_id'        => 'navigation',
                                            'container'      => false,
                                            'menu_class'     => '',
                                            'fallback_cb'    => 'kapo_barber_menu_fallback' // Fallback to custom function
                                        ) );
                                        
                                        function kapo_barber_menu_fallback() {
                                            echo '<ul id="navigation">';
                                            echo '<li class="active"><a href="' . home_url('/') . '">Home</a></li>';
                                            echo '<li><a href="#">About</a></li>';
                                            echo '<li><a href="#">Services</a></li>';
                                            echo '<li><a href="#">Portfolio</a></li>';
                                            echo '<li><a href="#">Blog</a>';
                                            echo '<ul class="submenu">';
                                            echo '<li><a href="#">Blog</a></li>';
                                            echo '<li><a href="#">Blog Details</a></li>';
                                            echo '<li><a href="#">Element</a></li>';
                                            echo '</ul>';
                                            echo '</li>';
                                            echo '<li><a href="#">Contact</a></li>';
                                            echo '</ul>';
                                        }
                                        ?>
                                    </nav>
                                </div>
                                <div class="header-right-btn f-right d-none d-lg-block ml-30">
                                    <a href="#" class="btn header-btn">RESERVE YOUR HAIRCUT</a>
                                </div>
                            </div>
                        </div>   
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
