
@extends('layouts.admin')

@push('styles')
    <!-- base:css -->
    <link rel="stylesheet" href="/admin_resources/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="/admin_resources/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/admin_resources/css/vertical-layout-light/style.css">
    
@endpush

@push('scripts')
 
<script src="/admin_resources/vendors/js/vendor.bundle.base.js"></script>
<script src="/admin_resources/js/off-canvas.js"></script>
<script src="/admin_resources/js/hoverable-collapse.js"></script>
<script src="/admin_resources/js/template.js"></script>
<script src="/admin_resources/js/settings.js"></script>
<script src="/admin_resources/js/todolist.js"></script>
<!-- plugin js for this page -->
<script src="/admin_resources/vendors/progressbar.js/progressbar.min.js"></script>
<script src="/admin_resources/vendors/chart.js/Chart.min.js"></script>
<!-- Custom js for this page-->
<script src="/admin_resources/js/dashboard.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 
@endpush


@section('title', 'Admin - Business Settings')


@section('content')

<div class="main-panel">
    <div class="content-wrapper">
 
      @include('partials.message-bag')

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Business Settings</span>
            </div>
            <form action="{{ route('business-settings.save') }}" method="POST" style="display: contents;">
                @csrf

                {{-- Hidden actual symbol that will be saved (set from selected country server-side anyway) --}}
                <input type="hidden" id="currency_symbol" name="currency_symbol">

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            {{-- Country Selection --}}
                            <tr>
                                <td><strong>Country</strong></td>
                                <td>
                                    <select required class="form-control" id="country_id" name="country_id">
                                        <option value="" disabled {{ empty($site_settings?->country) ? 'selected' : '' }}>
                                            Select a country
                                        </option>

                                        @foreach ($countries as $country)
                                            <option
                                                value="{{ $country->id }}"
                                                data-currency-symbol="{{ $country->currency_symbol }}"
                                                data-currency-code="{{ $country->currency_code }}"
                                                {{ $site_settings?->country === $country->name ? 'selected' : '' }}
                                            >
                                                {{ $country->name }} ({{ $country->currency_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                            {{-- Currency Details (display only) --}}
                            <tr>
                                <td><strong>Currency Symbol</strong></td>
                                <td>
                                    <input
                                        value="{!! $site_settings->currency_symbol ?? '' !!}"
                                        type="text"
                                        id="decoded_symbol"
                                        class="form-control"
                                        placeholder="Currency Symbol"
                                        readonly
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Currency Code</strong></td>
                                <td>
                                    <input
                                        value="{{ $site_settings->currency_code ?? '' }}"
                                        type="text"
                                        id="currency_code"
                                        class="form-control"
                                        placeholder="Currency Code"
                                        readonly
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <!-- content-wrapper ends -->
    @include('partials.admin.footer')
</div>
<!-- main-panel ends -->
@endsection

<script>
    (function() {
        function updateCurrencyFields() {
            const select = document.getElementById('country_id');
            const option = select.options[select.selectedIndex];

            if (!option) return;

            const symbol = option.getAttribute('data-currency-symbol') || '';
            const code   = option.getAttribute('data-currency-code') || '';

            document.getElementById('decoded_symbol').value = symbol;
            document.getElementById('currency_code').value  = code;

             const hiddenSymbol = document.getElementById('currency_symbol');
            if (hiddenSymbol) hiddenSymbol.value = symbol;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('country_id');
            if (!select) return;

            select.addEventListener('change', updateCurrencyFields);

             updateCurrencyFields();
        });
    })();
</script>