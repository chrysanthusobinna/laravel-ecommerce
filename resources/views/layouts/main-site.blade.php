<!DOCTYPE html>
<html lang="en">


 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('site.name') }} - @yield('title')</title>
    <meta name="keywords" content="eCommerce, online shopping, {{ config('site.name') }}">
    <meta name="description" content="{{ config('site.name') }} - Your trusted online shopping destination">
    <meta name="author" content="{{ config('site.name') }}">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/icons/favicon-16x16.png">
    <link rel="manifest" href="/assets/images/icons/site.webmanifest">
    <link rel="mask-icon" href="/assets/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="/assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="/assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
   
    @stack('styles')
</head>

<body>
    <div class="page-wrapper">
        <header class="header">
            <div class="header-bottom sticky-header">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>
                        
                        <a href="{{ route('home') }}" class="logo">
                            <img src="/assets/images/logo.png" alt="Molla Logo" >
                        </a>
                    </div>
                    <div class="header-center">
                        <nav class="main-nav">
                            <ul class="menu sf-arrows">

                                {{-- Home --}}
                                <li class="{{ Request::routeIs('home') ? 'active' : '' }}">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>

                                {{-- Product --}}
                     

                                {{-- Product --}}   
                                <li class="{{ Request::is('product-list*') ? 'active' : '' }}">
                                    <a href="{{ route('product.list') }}" class="sf-with-ul">Shop</a>

                                    <ul style="display: none;">
                                        @foreach ($categories as $category)
                                            <li><a href="{{ route('product.list', $category->id) }}">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>




                                {{-- About --}}
                                <li class="{{ Request::routeIs('about') ? 'active' : '' }}">
                                    <a href="{{ route('about') }}">About</a>
                                </li>

                                {{-- Contact --}}
                                <li class="{{ Request::routeIs('contact') ? 'active' : '' }}">
                                    <a href="{{ route('contact') }}">Contact</a>
                                </li>

                            </ul>
                        </nav>
                    </div>


                    <div class="header-right">
                        <div class="header-search">
                            <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                            <form action="{{ route('product.list') }}" method="get">
                                <div class="header-search-wrapper">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="q" id="q" placeholder="Search in..." required>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->

                        <!-- <a href="wishlist.html" class="wishlist-link">
                            <i class="icon-heart-o"></i>
                            <span class="wishlist-count">3</span>
                        </a> -->
 
                        @php
                            $user = Auth::user();
                            $showCart = !$user || $user->role === 'customer'; // show for guest or customer
                        @endphp

                        @if ($showCart)
                        <div class="dropdown cart-dropdown">
                            <a href="{{ route('customer.cart') }}" class="dropdown-toggle {{ Request::routeIs('cart') ? 'active' : '' }}" role="button"  >
                                <i class="icon-shopping-cart"></i>
                                <span class="cart-count" id="cart_count" >{{ $customer_total_cart_items ?? 0 }}</span>
                             </a>
 
                        </div> 
                        @endif

                        <div class="dropdown cart-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-user"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                @guest
                                    <div class="dropdown-cart-action">
                                        <a href="{{ route('auth.login') }}" class="btn btn-primary">Login</a>
                                        <a href="{{ route('customer.account.create') }}" class="btn btn-outline-primary-2"><span>Register</span><i class="icon-long-arrow-right"></i></a>
                                    </div>
                                @else
                                    <div class="dropdown-cart-products">
                                        <div class="product">
                                            <div class="product-cart-details">
                                                <h4 class="product-title">
                                                    <a href="#">My Account</a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-cart-action">
                                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'global_admin')
                                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Dashboard</a>
                                        @elseif (Auth::user()->role === 'customer')
                                            <a href="{{ route('customer.account') }}" class="btn btn-primary">My Account</a>
                                        @endif
                                        <a href="{{ route('auth.logout') }}" class="btn btn-primary">Logout</a>
                                    </div>
                                @endguest
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .cart-dropdown -->

                        
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-bottom -->
        </header><!-- End .header -->

        @yield('content')

        <footer class="footer footer-2">
            <div class="footer-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <div class="widget widget-about">
                                <img src="/assets/images/logo-footer.png" class="footer-logo" alt="Footer Logo">
                                <p>At {{ config('site.name') }}, we offer quality products and exceptional service. Shop online for convenient pickup or delivery, and enjoy a seamless shopping experience from the comfort of your home.</p>
                                <div class="social-icons">
                                    @foreach($socialMediaHandles as $handle)
                                        @if($handle->social_media === 'facebook')
                                            <a href="{{ "https://www.facebook.com/" . $handle->handle }}" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                                        @elseif($handle->social_media === 'instagram')
                                            <a href="{{ "https://www.instagram.com/" . $handle->handle }}" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                                        @elseif($handle->social_media === 'youtube')
                                            <a href="{{ "https://www.youtube.com/" .$handle->handle }}" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
                                        @elseif($handle->social_media === 'tiktok')
                                            <a href="{{ "https://www.tiktok.com/@" . $handle->handle }}" class="social-icon" target="_blank" title="Tiktok"><i class="icon-pinterest"></i></a>
                                        @endif
                                    @endforeach
                                </div>
                            </div><!-- End .widget about-widget -->
                        </div><!-- End .col-sm-12 col-lg-3 -->

                        <div class="col-sm-4 col-lg-2">
                            <div class="widget">
                                <h4 class="widget-title">Links</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <li><a href="{{ route('product.list') }}">Products</a></li>
                                    <li><a href="{{ route('about') }}">About us</a></li>
                                    <li><a href="{{ route('contact') }}">Contact us</a></li>
                                    @if($whatsAppNumber)
                                        <li><a href="https://wa.me/{{ $whatsAppNumber->phone_number }}" target="_blank">Chat on WhatsApp</a></li>
                                    @endif
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-4 col-lg-3 -->

                        <div class="col-sm-4 col-lg-2">
                            <div class="widget">
                                <h4 class="widget-title">Categories</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    @php
                                        $randomCategories = $categories->shuffle()->take(4);
                                    @endphp
                                    @foreach($randomCategories as $category)
                                        <li><a href="{{ route('product.list', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-4 col-lg-3 -->

                        <div class="col-sm-4 col-lg-2">
                            <div class="widget">
                                <h4 class="widget-title">My Account</h4><!-- End .widget-title -->

                                <ul class="widget-list">
 
                                    @guest
                                        <li><a href="{{ route('auth.login') }}">Login</a></li>
                                        <li><a href="{{ route('customer.account.create') }}">Register</a></li>
                                    @else
                                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'global_admin')
                                            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                        @elseif (Auth::user()->role === 'customer')
                                            <li><a href="{{ route('customer.account') }}">My Account</a></li>
                                            @endif
                                            <li><a href="{{ route('auth.logout') }}">Logout</a></li>
                                    @endauth


                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-64 col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-middle -->

            <div class="footer-bottom">
                <div class="container">
                    <p class="footer-copyright">Copyright {{ date('Y') }} {{ config('site.name') }}. All Rights Reserved.</p><!-- End .footer-copyright -->
                    <ul class="footer-menu">
                        <li><a href="{{ route('terms.conditions') }}">Terms Of Use</a></li>
                        <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                    </ul><!-- End .footer-menu -->

        
                </div><!-- End .container -->
            </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form action="{{ route('product.list') }}" method="get" class="mobile-search">
                <label for="mobile-search" class="sr-only">Search</label>
                <input type="search" class="form-control" name="q" id="mobile-search" placeholder="Search in..." required>
                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            </form>
            
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li class="{{ Request::routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    
                    <li class="{{ Request::is('product-list*') ? 'active' : '' }}">
                        <a href="{{ route('product.list') }}">Shop</a>
                        <ul>
                            @foreach ($categories as $category)
                                <li><a href="{{ route('product.list', $category->id) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    
                    <li class="{{ Request::routeIs('about') ? 'active' : '' }}">
                        <a href="{{ route('about') }}">About</a>
                    </li>
                    
                    <li class="{{ Request::routeIs('contact') ? 'active' : '' }}">
                        <a href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </nav><!-- End .mobile-nav -->

            <div class="social-icons">
                @foreach($socialMediaHandles as $handle)
                    @if($handle->social_media === 'facebook')
                        <a href="{{ "https://www.facebook.com/" . $handle->handle }}" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                    @elseif($handle->social_media === 'instagram')
                        <a href="{{ "https://www.instagram.com/" . $handle->handle }}" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                    @elseif($handle->social_media === 'youtube')
                        <a href="{{ "https://www.youtube.com/" .$handle->handle }}" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
                    @elseif($handle->social_media === 'tiktok')
                        <a href="{{ "https://www.tiktok.com/@" . $handle->handle }}" class="social-icon" target="_blank" title="Tiktok"><i class="icon-pinterest"></i></a>
                    @endif
                @endforeach
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->


 
    @stack('scripts')

 </html>