<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('ML') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Maju Lancar') }}</a>
        </div>
        <ul class="nav">
            <li @if ($pageSlug == 'profile') class="active " @endif>
                <a href="{{ route('instructor.profile') }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('Profile') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('instructor.dashboard') }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'schedules') class="active " @endif>
                <a href="{{ route('instructor.schedules') }}">
                    <i class="tim-icons icon-bell-55"></i>
                    <p>{{ __('Schedules') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
