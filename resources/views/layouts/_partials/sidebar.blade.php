<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand mt-2" href="{{ route('dashboard') }}">
                    <!-- <i class="fal fa-crown"></i> -->
                    <h2 class="brand-text mb-0 pl-0">{{ config('app.name') }}</h2>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fal fa-home"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item has-sub">
                <a href="#">
                    <i class="fal fa-mouse-pointer"></i>
                    <span class="menu-title">On-site</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="{{ route('home') }}">
                            <i></i><span class="menu-item">Widget</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}">
                            <i></i><span class="menu-item">Emails</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('home') }}">
                    <i class="fal fa-envelope-open-text"></i>
                    <span class="menu-title">Notifications</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('home') }}">
                    <i class="fal fa-users"></i>
                    <span class="menu-title">Members</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('home') }}">
                    <i class="fal fa-chart-bar"></i>
                    <span class="menu-title">Reports</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('account/integrations') ? 'active' : '' }}">
                <a href="{{ route('integrations.index') }}">
                    <i class="fal fa-wrench"></i>
                    <span class="menu-title">Integrations</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('account/settings') ? 'active' : '' }}">
                <a href="{{ route('account.settings') }}">
                    <i class="fal fa-cog"></i>
                    <span class="menu-title">Settings</span>
                </a>
            </li>
        </ul>
        @if(Auth::user()->merchant)
            <ul class="mt-auto px-4">
                <li class="mb-2">
                    Plan: {{ Auth::user()->merchant->plan ? Auth::user()->merchant->plan->name : 'Free' }}
                </li>
                @if( !(Auth::user()->merchant->plan && Auth::user()->merchant->plan->growth_order == 3) )
                    <li class="upgrade-button mb-2">
                        <a class="btn btn-success btn-block text-bold-600" href="{{ route('upgrade') }}">
                            Upgrade
                        </a>
                    </li>
                @endif
            </ul>
        @endif
    </div>
</div>
<!-- END: Main Menu-->

