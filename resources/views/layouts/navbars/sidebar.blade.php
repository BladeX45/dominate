<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('ML') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Maju Lancar') }}</a>
        </div>
        <ul class="nav">
            {{-- dashboard --}}
            <li @if ($pageSlug == 'customer.dashboard') class="active " @endif>
                <a href="{{ route('customer.dashboard') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p class="text-dark">{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'profile') class="active " @endif>
                <a href="{{ route('profile.edit') }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p class="text-dark">{{ __('Profile') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'pricing') class="active " @endif>
                <a href="{{ route('pages.pricing') }}">
                    <i class="tim-icons icon-basket-simple"></i>
                    <p class="text-dark">{{ __('Plans') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'transaction') class="active " @endif>
                <a href="{{ route('customer.transactions') }}">
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <p class="text-dark">{{ __('Transaction History') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'schedule') class="active " @endif>
                <a href="{{ route('customer.schedules') }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p class="text-dark">{{ __('Training Schedule') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
