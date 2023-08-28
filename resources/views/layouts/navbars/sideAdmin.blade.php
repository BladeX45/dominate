<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('ML') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Maju Lancar') }}</a>
        </div>
        <ul class="nav">
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#managemnt" aria-expanded="true">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Management') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="managemnt">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'admin.users') class="active " @endif>
                            <a href="{{ route('admin.users')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('User Management') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'admin.customers') class="active " @endif>
                            <a href="{{ route('admin.customers')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Customer Management') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'admin.assets') class="active " @endif>
                            <a href="{{ route('admin.assets')  }}">
                                <i class="tim-icons icon-app"></i>
                                <p>{{ __('Asset Management') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'plans') class="active " @endif>
                            <a href="{{ route('admin.plans')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Plan Management') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="{{ route('pages.icons') }}">
                    <i class="tim-icons icon-money-coins"></i>
                    <p>{{ __('Accounting') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
