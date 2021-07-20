@extends('layouts.app')

@section('content')
    <div id="billing-home-page" :class="{'loading' : loading}" v-cloak>
        <b-overlay rounded="sm">
            <div class="billing-home-wrapper">
                <div class="row">
                    <div class="col-lg-9 right-view">
                        <div class="card">
                            <div class="card-body">
                                <strong>Billing History</strong>
                                <b-table
                                    id="table-transactions"
                                    :items="transactions"
                                    :fields="fields"
                                    striped
                                    small
                                    primary-key="Date"
                                ></b-table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 left-view">
                        <div class="card">
                            <div class="card-body">
                                <strong>Plan Tier</strong>
                                <div class="plan-detail">
                                    <div><i class="fal fa-cubes"></i></div>
                                    <div>
                                        <p>Pro Plan | $249/mo</p>
                                        <p>Renew May 09, 2021</p>
                                    </div>
                                </div>
                                <div>
                                    <b-form-group>
                                        <a class="btn btn-success btn-block text-bold-600" href="{{ route('upgrade') }}">
                                            Upgrade Plan
                                        </a>
                                    </b-form-group>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </b-overlay>
    </div>
@endsection

@section('scripts')
    <script>
        var page = new Vue({
            el: '#billing-home-page',
            data: {
                transactions: [],
                saving: false,
                loading: true,

                fields: [
                    { key: 'date', sortable: true },
                    { key: 'amount', sortable: true },
                    { key: 'description', sortable: false },
                    { key: 'invoice', sortable: false }
                ]
            },
            created: function() {
                this.loading = false;
                this.initData();
            },
            methods: {
                initData() {
                    this.transactions = [
                        { date: '3/11/2019', amount: 393, description: 'Moose', invoice: '' },
                        { date: '3/11/2019', amount: 383, description: 'Moose' },
                        { date: '3/11/2019', amount: 383, description: 'Moose' },
                        { date: '3/11/2019', amount: 383, description: 'Moose' },
                        { date: '3/11/2019', amount: 383, description: 'Moose' },
                        { date: '3/11/2019', amount: 383, description: 'Moose' },
                        { date: '3/11/2019', amount: 383, description: 'Moose' },
                        { date: '3/11/2019', amount: 383, description: 'Moose' },
                        { date: '3/11/2019', amount: 383, description: 'Moose' },
                        { date: '3/11/2019', amount: 383, description: 'Moose' },
                        { date: '3/11/2019', amount: 383, description: 'Moose' },
                        { date: '3/11/2019', amount: 383, description: 'Moose' },
                        { date: '3/11/2019', amount: 938, description: 'Moose' }
                    ];
                }
            }
        })
    </script>
@endsection
