@if(\Filament\Facades\Filament::auth()->check())
    @if(\Filament\Facades\Filament::auth()->user()->garage == 'SP')
        <img src="{{ asset('/assets/images/logo_SP.png') }}" alt="Logo" class="h-10">
    @endif

    @if(\Filament\Facades\Filament::auth()->user()->garage == 'SBO')
        <img src="{{ asset('/assets/images/logo_SBO.png') }}" alt="Logo" class="h-10">
    @endif
@else
    <img src="{{ asset('/assets/images/spphat-logo-1.png') }}" alt="Logo" class="h-10">
@endif
