@extends('layouts.base')

@section('body')
<body style="background-color: #09171f; color: #e2e8f0; padding-top: 0;">
    <script>
        if (localStorage.getItem('darkModeEnabled')) { localStorage.removeItem('darkModeEnabled'); }
    </script>

    {{-- Admin Sidebar --}}
    @include('admin.sidebar')

    {{-- Main Content Wrapper --}}
    <div class="main-content-wrapper" style="min-height: 100vh; padding: 0;">
        @include('layouts.partials.flash-messages', ['topOffset' => '16px'])
        <main style="padding: 0;">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('scripts')
</body>
@endsection
