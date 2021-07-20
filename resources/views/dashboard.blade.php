@extends('layouts.app')

@section('content')
    <div id="dashboard" class="loader" v-cloak>
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12 mb-3">
                        <h2 class="content-header-title float-left mb-0">Dashboard</h2>
                        <!-- <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active">Sub-home</li>
                            </ol>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Description -->
            <section id="description" class="card">
                <div class="card-header">
                    <h4 class="card-title">Dashboard</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="card-text">
                            <p>Dashboard Page</p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="mt-4">
                <h5 class="text-primary mb-4">Permission System</h5>
                <div class="row">
                    <div class="col-md-3">
                        <h6 class="mb-3">Widget (Free Plan)</h6>
                        <p>You can access this feature</p>
                    </div>
                    <div class="col-md-3">
                        <h6 class="mb-3">Nudges ({{ feature_plan('Nudges')->name }} Plan)</h6>
                        @if(has_permission('Nudges'))
                            <p>You can access this feature</p>
                        @else
                            <no-access 
                                title="Nudges" 
                                desc="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua" 
                                plan="{{ feature_plan('Nudges')->name }}"></no-access>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <h6 class="mb-3">Insights ({{ feature_plan('Insights')->name }} Plan)</h6>
                        @if(has_permission('Insights'))
                            <p>You can access this feature</p>
                        @else
                            <no-access 
                                title="Analytics & Insights" 
                                desc="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua" 
                                plan="{{ feature_plan('Insights')->name }}"></no-access>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <h6 class="mb-3">API Access ({{ feature_plan('APIAccess')->name }} Plan)</h6>
                        @if(has_permission('APIAccess'))
                            <p>You can access this feature</p>
                        @else
                            <no-access 
                                title="API Access" 
                                desc="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua" 
                                plan="{{ feature_plan('APIAccess')->name }}"></no-access>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var dashboard = new Vue({
            el: '#dashboard'
        })
    </script>
@endsection