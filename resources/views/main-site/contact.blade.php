@extends('layouts.main-site')

@push('styles')
    
     <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="/assets/css/plugins/owl-carousel/owl.carousel.css">
     <link rel="stylesheet" href="/assets/css/plugins/magnific-popup/magnific-popup.css">

     <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/plugins/nouislider/nouislider.css">
    <link rel="stylesheet" href="/assets/css/skins/skin-demo-8.css">
    <link rel="stylesheet" href="/assets/css/demos/demo-8.css">  

    <style>
        .opening-hours-table {
            border-collapse: collapse;
            width: 100%;
        }
        .opening-hours-table td {
            padding: 4px 0;
            border: none !important;
        }
        .opening-hours-table .day {
            font-weight: 600;
            width: 120px;
            color: #333;
            white-space: nowrap; /* Prevent text wrapping */
            vertical-align: top; /* Align to top */
            padding-right: 15px; /* Add space between days and hours */
        }
        .opening-hours-table .time {
            color: #666;
            vertical-align: top; /* Align to top */
        }
    </style>
@endpush

@push('scripts')
   
    <!-- Google Map -->
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDc3LRykbLB-y8MuomRUIY0qH5S6xgBLX4"></script>

    <!-- Plugins JS File -->
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/jquery.hoverIntent.min.js"></script>
    <script src="/assets/js/jquery.waypoints.min.js"></script>
    <script src="/assets/js/superfish.min.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/js/wNumb.js"></script>
    <script src="/assets/js/bootstrap-input-spinner.js"></script>
    <script src="/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/assets/js/nouislider.min.js"></script>
    <!-- Main JS File -->
    <script src="/assets/js/main.js"></script>
@endpush


@section('title', 'Contact')

 

@section('content')
        <main class="main">
        	<div class="page-header text-center" style="background-image: url('/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Contact<span>Us</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                    <!-- Contact Information Cards -->
                    <div class="row d-flex align-items-stretch mb-5">
                        <div class="col-xl-4 col-md-6 d-flex">
                            <div class="contact-box text-center flex-fill">
                                <div class="contact-icon mb-3">
                                    <i class="icon-location-pin"></i>
                                </div>
                                <h3>Address</h3>
                                @forelse($addresses as $address)
                                    <p>{{ $address->full_address }}</p>
                                @empty
                                    <p>No addresses available.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 d-flex">
                            <div class="contact-box text-center flex-fill">
                                <div class="contact-icon mb-3">
                                    <i class="icon-envelope"></i>
                                </div>
                                <h3>Email Address</h3>
                                <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-12 d-flex">
                            <div class="contact-box text-center flex-fill">
                                <div class="contact-icon mb-3">
                                    <i class="icon-phone"></i>
                                </div>
                                <h3>Phone</h3>
                                @forelse($phoneNumbers as $phoneNumber)
                                    <p>{{ $phoneNumber->phone_number }}</p>
                                @empty
                                    <p>No phone numbers available.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Opening Hours and Map -->
                    <div class="row">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <div class="contact-box">
                                <h3 class="mb-3">Opening Hours</h3>
                                <hr>

								@php
									// Group consecutive days with the same hours
									$groupedHours = [];
									$currentGroup = null;
									
									// Define day order for proper sorting
									$dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
									
									// Sort working hours by day order
									$sortedHours = $workingHours->sortBy(function($hour) use ($dayOrder) {
										return array_search($hour->day_of_week, $dayOrder);
									});
									
									foreach($sortedHours as $hour) {
										$isOpen = !$hour->is_closed;
										$timeString = $isOpen ? 
											\Carbon\Carbon::parse($hour->opens_at)->format('H:i') . ' – ' . \Carbon\Carbon::parse($hour->closes_at)->format('H:i') : 
											'Closed';
										
										if ($currentGroup === null || $currentGroup['time'] !== $timeString) {
											// Start new group
											if ($currentGroup !== null) {
												$groupedHours[] = $currentGroup;
											}
											$currentGroup = [
												'start_day' => $hour->day_of_week,
												'end_day' => $hour->day_of_week,
												'time' => $timeString,
												'is_closed' => $hour->is_closed
											];
										} else {
											// Extend current group
											$currentGroup['end_day'] = $hour->day_of_week;
										}
									}
									
									// Add the last group
									if ($currentGroup !== null) {
										$groupedHours[] = $currentGroup;
									}
								@endphp

                                <table class="table table-sm opening-hours-table">
                                    <tbody>
                                        @forelse($groupedHours as $group)
                                            <tr>
                                                <td class="day">
                                                    @if($group['start_day'] === $group['end_day'])
                                                        {{ $group['start_day'] }}
                                                    @else
                                                        {{ $group['start_day'] }} – {{ $group['end_day'] }}
                                                    @endif
                                                </td>
                                                <td class="time">{{ $group['time'] }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2">No working hours available.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="contact-box">
                                <h3 class="mb-3">Find Us</h3>
                                <hr>
                                <div class="map">
                                    @if($firstCompanyAddress)
                                    <iframe 
                                        src="https://maps.google.com/maps?q={{ urlencode($firstCompanyAddress->full_address) }}&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                                        width="100%" 
                                        style="border:0; height:380px;" 
                                        allowfullscreen="" 
                                        loading="lazy">
                                    </iframe>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

 
@endsection



 