@extends('layouts.main-site')

@push('styles')
     <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="/assets/css/plugins/owl-carousel/owl.carousel.css">
     <link rel="stylesheet" href="/assets/css/plugins/magnific-popup/magnific-popup.css">
     <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/plugins/nouislider/nouislider.css">
    <link rel="stylesheet" href="/assets/css/skins/skin-demo-8.css">
    <link rel="stylesheet" href="/assets/css/demos/demo-8.css">   

    <!-- Page styles -->
    <style>
      /* choice cards */
      .choice-grid{display:grid;gap:12px}
      .option-card{
        border:1px solid #e9ecef; border-radius:12px; padding:14px 16px; cursor:pointer;
        transition:transform .15s ease, box-shadow .15s ease, border-color .15s ease, background .15s ease;
        background:#fff; position:relative;
      }
      .option-card:hover{ transform:translateY(-1px); box-shadow:0 10px 24px rgba(0,0,0,.06) }
      .option-card.active{
        border-color:#ff3b53; background:linear-gradient(0deg, rgba(255,59,83,.07), rgba(255,59,83,.07)), #fff;
        box-shadow:0 10px 26px rgba(255,59,83,.12);
      }
      .option-title{font-weight:800; margin:0}
      .option-sub{color:#6c757d; margin:2px 0 0 0; font-size:.925rem}
      .checkmark{
        position:absolute; right:12px; top:12px; width:24px; height:24px; border-radius:50%;
        border:2px solid #dee2e6; display:flex; align-items:center; justify-content:center; font-size:14px; color:#fff;
        background:#fff;
      }
      .option-card.active .checkmark{ border-color:#ff3b53; background:#ff3b53 }
      .focus-ring:focus{ outline:3px solid rgba(13,110,253,.35); outline-offset:2px; }
    </style>
@endpush

@push('scripts')
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

    <!-- Card interaction -->
    <script>
      (function() {
        function activateCard(card){
          document.querySelectorAll('.option-card').forEach(c=>{
            c.classList.remove('active');
            c.setAttribute('aria-pressed','false');
            const cm = c.querySelector('.checkmark'); if(cm) cm.innerHTML='';
          });
          card.classList.add('active');
          card.setAttribute('aria-pressed','true');
          const cm = card.querySelector('.checkmark'); if(cm) cm.innerHTML='&#10003;';
          document.getElementById('methodField').value = card.getAttribute('data-value');
        }
        document.addEventListener('DOMContentLoaded', function() {
          document.querySelectorAll('.option-card').forEach(card=>{
            card.addEventListener('click', ()=> activateCard(card));
            card.addEventListener('keydown', (e)=>{
              if(e.key === 'Enter' || e.key === ' ') { e.preventDefault(); activateCard(card); }
            });
          });
        });
      })();
    </script>
 
@endpush

@section('title', 'Choose Delivery Method')
 

@section('content')

<main class="main">
  

    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('product.list') }}">Order</a></li>
                <li class="breadcrumb-item active" aria-current="page">Choose Delivery Method</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <form method="POST" action="{{ route('customer.checkout.fulfilment.post') }}">
                            @csrf
                            
                            <h4 class="mb-4">Choose Delivery Method</h4>
                            <hr>
                            @include('partials.message-bag')

                            @php
                              $selected = old('method', 'pickup');
                            @endphp

                            <input type="hidden" name="method" id="methodField" value="{{ $selected }}">

                            <div class="choice-grid mt-2">
                                <div class="option-card focus-ring {{ $selected === 'pickup' ? 'active' : '' }}"
                                     data-value="pickup" tabindex="0" role="button" aria-pressed="{{ $selected === 'pickup' ? 'true' : 'false' }}">
                                    <div class="checkmark">{!! $selected === 'pickup' ? '&#10003;' : '' !!}</div>
                                    <h6 class="option-title">Pick Up from Store</h6>
                                    <p class="option-sub">Collect your order at any of our available pickup locations.</p>
                                </div>

                                <div class="option-card focus-ring {{ $selected === 'delivery' ? 'active' : '' }}"
                                     data-value="delivery" tabindex="0" role="button" aria-pressed="{{ $selected === 'delivery' ? 'true' : 'false' }}">
                                    <div class="checkmark">{!! $selected === 'delivery' ? '&#10003;' : '' !!}</div>
                                    <h6 class="option-title">Deliver to My Address</h6>
                                    <p class="option-sub">Have your order delivered to your saved or new address.</p>
                                </div>
                            </div>

                            <div class="form-group col-md-12 mt-4 p-0">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('customer.checkout.details') }}" class="btn btn-outline-primary-2">
                                        <i class="icon-long-arrow-left"></i>
                                        <span>Back</span>
                                    </a>
                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span>Continue</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!-- End .col-lg-6 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

@endsection
