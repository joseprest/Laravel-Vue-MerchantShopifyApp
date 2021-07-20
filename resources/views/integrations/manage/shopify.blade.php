@extends('layouts.app')

@section('title', 'Manage Integrations')

@section('content')
    <div id="integration-settings" class="m-t-20 mb-3">
        <form :class="{'loading': loading}" v-cloak>
            <div class="border-bottom mb-4 pb-3">
                <div class="mb-3">
                    <a href="{{ route('integrations.index') }}" class="f-s-15">
                        <i class="arrow left blue"></i>
                        <span class="m-l-5">Apps</span>
                    </a>
                </div>
                <div class="flex-center">
                    <h3 class="bold mb-0">
                        <span v-text="app.name"></span>
                    </h3>
                    <span class="ml-auto">
                        <button class="btn btn-success" @click.prevent="saveSetting">Save</button>
                    </span>
                </div>
            </div>
            <div class="border-bottom">
                <div class="row p-t-25 p-b-25">
                    <div class="col-md-5 col-12">
                        <h5 class="bold m-b-15">
                            <span v-text="app.name"></span> Connection
                        </h5>
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="m-b-0">
                                            <label class="light-font m-b-0 mt-2">
                                            <span v-text="app.name"></span> is
                                            <span class="bold" v-if="app.status == 1">Connected</span>
                                            <span class="bold" v-if="app.status == 0">Disabled</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-5 col-12">
                    <h5 class="bold m-b-15">Order Settings</h5>
                    <p class="mb-3">Define how rewards are issued to your customers based on the order's status and
                        totals.
                    </p>
                </div>
                <div class="col-md-7 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label class="light-font m-b-0 mt-2">
                                            Reward customers with points when the order status is set to:
                                        </label>
                                    </div>
                                    <b-form-select v-model="app.order_settings.reward_status"
                                        name="order_settings.reward_status">
                                        <option value="completed">Completed</option>
                                        <option value="shipped">Shipped</option>
                                    </b-form-select>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3">
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label class="light-font m-b-0 mt-2">
                                        Subtract points from customers when the order status is set to:
                                        </label>
                                    </div>
                                    <b-form-select v-model="app.order_settings.subtract_status"
                                        name="order_settings.subtract_status">
                                        <option value="refunded">Refunded</option>
                                        <option value="cancelled">Cancelled</option>
                                    </b-form-select>
                                </div>
                            </div>
                            <div class="row mt-3 mb-2">
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label class="light-font m-b-0 mt-2">
                                        Reward customers with points based on the following order items:
                                        </label>
                                    </div>
                                    <b-form-checkbox class="w-100 mt-3" name="order_settings.shipping"
                                        v-model="app.order_settings.include_shipping"
                                        value="1"
                                        unchecked-value="0">
                                        Include shipping
                                    </b-form-checkbox>
                                    <b-form-checkbox class="w-100 mt-3" name="order_settings.taxes"
                                        v-model="app.order_settings.include_taxes"
                                        value="1"
                                        unchecked-value="0">
                                        Include taxes
                                    </b-form-checkbox>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        var page = new Vue({
            el: '#integration-settings',
            data: {
                saving: false,
                app: {
                    name: 'Shopify',
                    status: 1,
                    order_settings: {
                        reward_status: 'completed',
                        subtract_status: 'refunded',
                        subtotal: "1",
                        include_shipping: "0",
                        include_taxes: "0",
                        include_previous_orders: "1"
                    },
                },
                loading: false,
            },
            created: function () {
                this.getData()
            },
            methods: {
                getData: function () {
                },
                saveSetting() {
                    this.loading = true
                    setTimeout(() => {
                        this.loading = false;
                        (successToast.bind(this))('Settings saved successfully!');
                    }, 1000);
                },
                reinstallWidgetCode: function () {
                }
            }
        });
    </script>
@endsection
