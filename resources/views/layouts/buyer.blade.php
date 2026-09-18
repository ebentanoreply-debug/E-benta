@extends('layouts.base')

@section('body')
@php
    $savedCount = auth()->check() && auth()->user()->isBuyer() ? auth()->user()->savedListings()->count() : 0;
    $unreadMsgCount = auth()->check() ? auth()->user()->unreadMessagesCount() : 0;
    $globalDeviceTypes = \App\Models\DeviceType::orderBy('name')->get();
    $activeListingCount = \App\Models\Listing::where('status', 'available')->count();
@endphp
<body class="has-commerce-header" style="background-color: #f8fafc; color: #0f172a;">
    <script>
        if (localStorage.getItem('darkModeEnabled')) { localStorage.removeItem('darkModeEnabled'); }
    </script>

    @include('layouts.partials.commerce-header')
    @include('layouts.partials.flash-messages', ['topOffset' => '135px'])

    <main>
        @yield('content')
    </main>

    @include('layouts.partials.eco-footer')
    @include('layouts.partials.mobile-bottom-nav')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @include('layouts.partials.notification-script')
    @yield('scripts')
</body>
@endsection
