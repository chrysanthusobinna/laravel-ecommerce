 
@extends('layouts.main-site')

@push('styles')
    
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/skins/skin-demo-8.css">
    <link rel="stylesheet" href="/assets/css/demos/demo-8.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">   
 
@endpush

@push('scripts')
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/jquery.hoverIntent.min.js"></script>
    <script src="/assets/js/jquery.waypoints.min.js"></script>
    <script src="/assets/js/superfish.min.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <!-- Main JS File -->
    <script src="/assets/js/main.js"></script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'99423f3a1f5e6391',t:'MTc2MTQwMDg5Nw=='};var a=document.createElement('script');a.src='../../cdn-cgi/challenge-platform/h/b/scripts/jsd/c88755b0cddc/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>


    <script>
        $(document).ready(function() {
            $('.toggle-password').on('click', function() {
                const targetInput = $($(this).data('target'));
                const type = targetInput.attr('type') === 'password' ? 'text' : 'password';
                targetInput.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
        });
    </script>

@endpush


@section('title', 'Create Account')


 


@section('content')

         <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Register</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('/assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="form-tab">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="signin-2" role="tabpanel" aria-labelledby="signin-tab-2">
                                    <div class="text-center">
                                        <h4> Register </h4>
                                    </div>
                                    @include('partials.message-bag')
                                    <form method="post" action="{{ route('customer.account.store') }}">
                                        @csrf

                                        @include('partials.message-bag')

                                        <div class="form-group">
                                            <label for="first_name">First Name *</label>
                                            <input id="first_name" type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="last_name">Last Name *</label>
                                            <input id="last_name" type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="email">Email Address *</label>
                                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="phone_number">Phone Number *</label>
                                            <input id="phone_number" type="tel" name="phone_number" class="form-control" value="{{ old('phone_number') }}" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="password">Password *</label>
                                            <div class="input-group">
                                                <input id="password" type="password" name="password" class="form-control" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style="cursor: pointer;">
                                                        <i class="fas fa-eye toggle-password" data-target="#password"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password *</label>
                                            <div class="input-group">
                                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" style="cursor: pointer;">
                                                        <i class="fas fa-eye toggle-password" data-target="#password_confirmation"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>Create Account</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <a href="{{ route('auth.login') }}" class="forgot-link">Already have an account? Login</a>
                                        </div><!-- End .form-footer -->

                                        <div class="form-choice">
                                            <p class="text-center">Already registered? <a href="{{ route('auth.login') }}">Login here</a></p>
                                        </div>
                                    </form>

                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .container -->
            </div><!-- End .login-page section-bg -->
        </main><!-- End .main -->

 
@endsection
