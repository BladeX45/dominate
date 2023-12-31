<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __() }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Menu') }}</a>
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
                        <li @if ($pageSlug == 'Instructors') class="active " @endif>
                            <a href="{{ route('admin.users')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Instructor Management') }}</p>
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
                        <li @if ($pageSlug == 'schedules') class="active " @endif>
                            <a href="{{ route('admin.schedules')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Schedule Management') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li @if ($pageSlug == 'admin.cashFlow') class="active " @endif>
                <a data-toggle="collapse" href="#accounting" aria-expanded="true">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Accounting') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="accounting">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'admin.cashFlow') class="active " @endif>
                            <a href="{{ route('admin.cashflow')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Cash Flow') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'transactions') class="active " @endif>
                            <a href="{{ route('admin.transactions')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Incoming Trnsaction') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'admin.expense') class="active " @endif>
                            <a href="{{ route('admin.expenses')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Outgoing Transaction') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
