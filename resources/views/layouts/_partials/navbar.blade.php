<!-- BEGIN: Header-->
<nav id="navbar" class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div id="navbar-mobile" class="navbar-collapse">
                <div class="mr-auto float-left d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-none mr-auto">
                            <a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs">
                                <i class="ficon fal fa-bars"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav left-list">
                        <li class="nav-item">
                            <a class="nav-link">
                                <i class="fal fa-paper-plane"></i>
                                <span class="ml-2">What’s New</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="merchant-select" v-cloak>
                        <b-dropdown size="md" variant="primary" text="{{ Auth::user()->merchant ? Auth::user()->merchant->name : 'Select Account' }}">
                            @foreach(Auth::user()->merchantsList() as $index => $merchant)
                                <b-dropdown-item 
                                    href="{{ route('merchant.switch', $merchant->id) }}"
                                    {{ Auth::user()->merchant && Auth::user()->merchant->id == $merchant->id ? 'active' : '' }}>
                                    {{ $merchant->name }}
                                </b-dropdown-item>
                            @endforeach
                            <b-dropdown-divider></b-dropdown-divider>
                            <b-dropdown-item v-b-modal.create-account>Create Account</b-dropdown-item>
                        </b-dropdown>
                    </li>

                    <!-- Start: Notification  -->
                    <li class="dropdown dropdown-notification nav-item">
                        <a href="#" data-toggle="dropdown" class="nav-link nav-link-label" aria-expanded="false">
                            <i class="ficon fal fa-bell"></i>
                            <span class="badge badge-pill badge-primary badge-up">5</span>
                        </a> 
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header m-0 p-2">
                                    <h3 class="white">5 New</h3>
                                    <span class="grey darken-2">App Notifications</span>
                                </div>
                            </li>
                            <li class="scrollable-container media-list">
                                <a href="javascript:void(0)" class="d-flex justify-content-between">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-plus-square font-medium-5 primary"></i></div>
                                        <div class="media-body">
                                            <h6 class="primary media-heading">You have new order!</h6>
                                            <small class="notification-text"> Are your going to meet me tonight?</small>
                                        </div>
                                        <small><time datetime="2015-06-11T18:29:20+08:00" class="media-meta">9 hours ago</time></small>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="d-flex justify-content-between">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-download-cloud font-medium-5 success"></i></div>
                                        <div class="media-body">
                                            <h6 class="success media-heading red darken-1">99% Server load</h6>
                                            <small class="notification-text">You got new order of goods.</small>
                                        </div>
                                        <small><time datetime="2015-06-11T18:29:20+08:00" class="media-meta">5 hour ago</time></small>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="d-flex justify-content-between">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-alert-triangle font-medium-5 danger"></i></div>
                                        <div class="media-body">
                                            <h6 class="danger media-heading yellow darken-3">Warning notifixation</h6>
                                            <small class="notification-text">Server have 99% CPU usage.</small>
                                        </div>
                                        <small><time datetime="2015-06-11T18:29:20+08:00" class="media-meta">Today</time></small>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="d-flex justify-content-between">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-check-circle font-medium-5 info"></i></div>
                                        <div class="media-body">
                                            <h6 class="info media-heading">Complete the task</h6>
                                            <small class="notification-text">Cake sesame snaps cupcake</small>
                                        </div>
                                        <small><time datetime="2015-06-11T18:29:20+08:00" class="media-meta">Last week</time></small>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="d-flex justify-content-between">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-left"><i class="feather icon-file font-medium-5 warning"></i></div>
                                        <div class="media-body">
                                            <h6 class="warning media-heading">Generate monthly report</h6>
                                            <small class="notification-text">Chocolate cake oat cake tiramisu marzipan</small>
                                        </div>
                                        <small><time datetime="2015-06-11T18:29:20+08:00" class="media-meta">Last month</time></small>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-menu-footer">
                                <a href="javascript:void(0)" class="dropdown-item py-3 text-center">
                                Read all notifications
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End: Notification  -->

                    <li class="dropdown dropdown-user nav-item">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link" aria-expanded="false">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name text-bold-600">{{ Auth::user()->name }}</span>
                                <span class="user-status">{{ Auth::user()->merchant ? Auth::user()->merchant->name : '' }}</span>
                            </div>
                            <span>
                                <span class="avatar">{{ Auth::user()->name[0] }}</span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('account.settings') }}" class="dropdown-item">
                                <i class="fal fa-user-alt"></i> Account
                            </a>
                            @if(Auth::user()->merchant && Auth::user()->merchant->stripe_id)
                                <form method="POST" action="{{ route('stripe.portal') }}" class="w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-100">
                                        <i class="fal fa-receipt"></i> Billing
                                    </button>
                                </form>                            
                            @else
                                <a href="{{ url('/upgrade') }}" class="dropdown-item">
                                    <i class="fal fa-crown"></i> Upgrade
                                </a>
                            @endif
                            <a href="#" class="dropdown-item">
                                <i class="fal fa-life-ring"></i> Support
                            </a> 
                            <div class="dropdown-divider"></div>
                            <a href="{{ url('/logout') }}" class="dropdown-item">
                                <i class="fal fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <b-modal id="create-account" title="Create Account" hide-footer v-cloak>
        <form action="{{ route('merchant.create') }}" method="POST">
            @csrf
            <div>
                <label class="mb-1">Company Name</label>
                <input type="text" class="form-control" name="name" placeholder="Company name" required="">
            </div>
            <div class="mt-4">
                <label class="mb-1">Website</label>
                <input type="text" class="form-control" name="website" placeholder="Website" required="">
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-md my-2">Create</button>
            </div>
        </form>
    </b-modal>
</nav>

