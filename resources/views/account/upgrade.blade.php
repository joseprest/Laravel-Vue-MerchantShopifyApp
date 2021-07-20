@extends('layouts.app')

@section('content')
    <div id="upgrade-page" class="loader" v-cloak>
        <div class="pricing-header">
            <h1>Simple and <span>Transparent</span> pricing</h1> 
            <p>Unlimited Customers &amp; Unlimited Orders</p> 
            <div class="switch-input-wrap">
                <strong class="month" :class="{'active': !yearly}">Monthly</strong>
                <label class="switch">
                    <input type="checkbox" v-model="yearly">
                    <span class="switch-slider round"></span>
                </label>
                <strong class="year" :class="{'active': yearly}">Yearly <span>(Get 2 Months Free)</span></strong>
            </div>
        </div>

        <div class="plans mt-5">
            @foreach($plans as $plan)
                <div class="plan-item">
                    <div class="border"></div>
                    <div class="plan-div">
                        <div class="price-wrap">
                            <div class="upper-subheading package-title">{{ $plan->name }}</div>
                            <div id="essential-secondary-price" class="starting-at-text starting-at start">Starting at</div>
                            <div v-if="yearly">
                                <div id="essential-main-price" class="price-text">${{ $plan->yearly_price }}/yr*</div>
                            </div>
                            <div v-else>
                                <div id="essential-main-price" class="price-text">${{ $plan->price }}/mo*</div>
                            </div>
                            <div class="div-block-164"></div>
                            <div class="body-14 pre-logo-tet">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod dolore aliqua.
                            </div>
                        </div>
                        <div class="body-14 bold">Includes:</div>
                        <ul role="list" class="plan-list">
                            <li class="plan-list-item">{{ $plan->name }} Plan feature 1</li>
                            <li class="plan-list-item">{{ $plan->name }} Plan feature 2</li>
                            <li class="plan-list-item">{{ $plan->name }} Plan feature 3</li>
                            <li class="plan-list-item">{{ $plan->name }} Plan feature 4</li>
                            <li class="plan-list-item">{{ $plan->name }} Plan feature 5</li>
                        </ul>
                        <div class="button-wrapper">
                            @if('IS NOT SHOPIFY')
                                @if($merchant->plan)
                                    @if($merchant->plan->id == $plan->id)
                                        <template v-if="yearly_plan == yearly">
                                            <button class="button current">Current</button>
                                        </template>
                                        <template v-else>
                                            <button class="button" @click="updatePlanModel('{{ json_encode($plan) }}')">
                                                Select Plan
                                            </button>
                                        </template>
                                    @else
                                        <button class="button" @click="updatePlanModel('{{ json_encode($plan) }}')">
                                            Select Plan
                                        </button>
                                    @endif
                                @else
                                    <button class="button" @click="updatePlanModel('{{ json_encode($plan) }}')">
                                        Select Plan
                                    </button>
                                @endif
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <b-modal id="upgrade-modal" class="stripe-modal" static centered hide-header hide-footer>
            <div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="row" style="min-height: 310px;">
                    <div class="col-sm-6 testimonial">
                        <div class="testimonial-wrapper">
                            <span class="img">
                            <img src="{{ url('images/assets/audimods.jpg') }}" height="60">
                            </span>
                            <p class="f-s-15 m-b-15">"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."</p>
                            <p class="credit"><b>John Doe</b> <br> Director of eCommerce</p>
                        </div>
                    </div>
                    <div class="col-sm-6 flex-center">
                        <form id="payment-form" class="payment-form" action="{{ route('merchant.subscription.create') }}" method="post">
                            @csrf
                            <input type="hidden" name="is_yearly" :value="yearly ? 1 : 0"/>
                            <input type="hidden" name="plan" :value="plan.id"/>
                            <p class="">
                                Selected plan: 
                                <span class="font-weight-bold text-dark ml-2 mr-1" v-text="plan.name"></span>
                                <span class="font-weight-bold text-dark">
                                    ($<span v-text="plan.price"></span>/<span v-text="yearly ? 'year' : 'month'"></span>)
                                </span>
                            </p>
                            <div class="payment-form-group card-number">
                                <label>Card number</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="cardNumber" class="form-control"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-form-group mb-2">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <label>Expiration Date</label>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="cardExpiry" class="form-control"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>CVV</label>
                                        <div id="cardCvc" class="form-control"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="card-errors" class="mb-2" role="alert"></div>
                            <button id="card-button" class="btn mt-auto" type="submit" data-secret="{{ $intent->client_secret }}" disabled="">
                                {{ __('Subscribe') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </b-modal>
    </div>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var page = new Vue({
            el: '#upgrade-page',
            data: {
                yearly: {!! $merchant->is_subscription_yearly ? '1' : '0' !!},
                yearly_plan: {!! $merchant->is_subscription_yearly ? '1' : '0' !!},
                plan: {
                    id: '',
                    name: '',
                    price: '',
                },
                subscribed: {!! $merchant->subscribed('default') ? '1' : '0' !!}
            },
            mounted: function() {
                initStripe();
            },
            methods: {
                updatePlanModel: function(planJson) {
                    let plan = JSON.parse(planJson)
                    this.plan.id = plan.id;
                    this.plan.name = plan.name;
                    this.plan.price = this.yearly ? plan.yearly_price : plan.price;
                    if(this.subscribed) {
                        setTimeout(() => {
                            document.getElementById('payment-form').submit();
                        }, 0);
                    } else {
                        this.$root.$emit('bv::show::modal', 'upgrade-modal')
                    }
                },
                closeModal: function() {
                    this.$root.$emit('bv::hide::modal', 'upgrade-modal')
                },
            }            
        });

        function initStripe() {
            // Custom styling can be passed to options when creating an Element.
            var style = {
                base: {
                    color: '#333',
                    lineHeight: '18px',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '15px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#dc3545',
                    iconColor: '#dc3545'
                }
            };

            const stripe = Stripe('{{ config("services.stripe.key") }}', { locale: 'en' }); // Create a Stripe client.
            const elements = stripe.elements(); // Create an instance of Elements.

            const cardNumber = elements.create('cardNumber', { style: style }); // Create an instance of the card Element.
            const cardExpiry = elements.create('cardExpiry', { style: style }); // Create an instance of the card Element.
            const cardCvc = elements.create('cardCvc', { style: style }); // Create an instance of the card Element.

            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;

            cardNumber.mount('#cardNumber');
            cardExpiry.mount('#cardExpiry');
            cardCvc.mount('#cardCvc');

            cardNumber.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    document.getElementById('card-button').setAttribute('disabled', true)
                    displayError.textContent = event.error.message;
                } else {
                    document.getElementById('card-button').removeAttribute('disabled')
                    displayError.textContent = '';
                }
            });

            // Handle form submission.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                stripe
                    .handleCardSetup(clientSecret, cardNumber, {
                        payment_method_data: {
                            //billing_details: { name: cardHolderName.value }
                        }
                    })
                    .then(function(result) {
                        if (result.error) {
                            // Inform the user if there was an error.
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {
                            // Send the token to your server.
                            stripeTokenHandler(result.setupIntent.payment_method);
                        }
                    });
            });

            // Submit the form with the token ID.
            function stripeTokenHandler(paymentMethod) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'paymentMethod');
                hiddenInput.setAttribute('value', paymentMethod);
                form.appendChild(hiddenInput);
                document.getElementById('card-button').setAttribute('disabled', 'disabled')
                // Submit the form
                form.submit();
            }
        }
        @if(session('success'))
            swal("Upgrade Successful", "{{ session('success') }}", "success");
        @endif
        @if(session('error'))
            swal("Whoops", "{{ session('error') }}", "error");
        @endif
    </script>
@endsection