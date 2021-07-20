@extends('layouts.app')

@section('content')
	<div id="integrations-page" :class="{'loading': loading}" v-cloak>
		<b-overlay :show="saving" spinner-variant="primary" rounded="sm">
			<div class="integrations-wrapper">
				<div class="row">
					<div class="col-lg-3">
						<div class="left-side">
							<div class="card">
								<div class="card-body">
									<i class="fal fa-cubes"></i>
					                <h3>Integrations Directory</h3>
					                <p class="section-desc">Connect AppName with popular integrations to enhance your experience</p>
					                <div>
										<b-form-group class="mt-4 mb-2">
											<b-form-checkbox-group size="lg" stacked v-model="categories" :options="allCategories" ></b-form-checkbox-group>
										</b-form-group>
					                </div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-9">
						<div class="all-integrations">
							<div class="card">
								<div class="card-header main-card-header">
									Integrations Directory
								</div>
								<div class="card-body main-card-body">
									<h3>All Integrations</h3>
									<div v-if="filteredIntegrations.length">
										<div class="row">
											<div class="col-sm-6 col-12 mb-4 pb-3" v-for="integration in filteredIntegrations">
												<div class="card integration">
													<div class="card-body">
														<span class="badge badge-success" v-if="merchantIntegrations.includes(integration.slug)">
															<i class="fal fa-check-circle mr-1"></i> Installed
														</span>
						                                <span class="logo">
						                                    <img :src="integration.image">
						                                </span>
						                                <span class="content">
							                                <h5 class="title" v-text="integration.name"></h5>
							                                <p class="description" v-text="integration.description"></p>
							                                <span class="button">
							                                	<a class="btn btn-outline-primary" href="{{ route('integrations.shopify') }}" v-if="merchantIntegrations.includes(integration.slug)">
							                                		Manage
							                                	</a>
							                                	<button class="btn btn-primary" @click="addIntegration(integration)" v-else>
							                                		<i class="fal fa-plus mr-1"></i> Add
							                                	</button>
							                                </span>
						                                </span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div v-else>
										<p class="text-muted">
				                            We couldn’t find any results. If your app exists on <a href="https://zapier.com/apps" target="_blank">Zapier</a>, we can connect to it in a few minutes.
				                        </p>
									</div>
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
            el: '#integrations-page',
            data: {
            	categories: [],
            	allCategories: ['eCommerce Platform', 'Loyalty & Rewards', 'Email Marketing', 'Social Media', 'Customer Support', 'On-Site', 'Other'],
            	integrations: [
            		{
            			name: 'Shopify',
            			slug: 'shopify',
            			category: 'eCommerce Platform',
            			description: 'Shopify is an all-in-one eCommerce platform for shops with more than 600k active stores.',
            			image: '{{ url("/images/logos/shopify.png") }}',
            			link: ''
            		},
            		{
            			name: 'Magento',
            			slug: 'magento',
            			category: 'eCommerce Platform',
            			description: 'Magento is one of the largest eCommerce platforms in the world with over $55B in annual transactions.',
            			image: '{{ url("/images/logos/magento.png") }}',
            			link: ''
            		},
            		{
            			name: 'WooCommerce',
            			slug: 'woocommerce',
            			category: 'eCommerce Platform',
            			description: 'WooCommerce is a free plugin for Wordpress that helps you sell anything online.',
            			image: '{{ url("/images/logos/wooCommerce.png") }}',
            			link: ''
            		},
            		{
            			name: 'BigCommerce',
            			slug: 'bigcommerce',
            			category: 'eCommerce Platform',
            			description: ' BigCommerce is a feature rich and easy to use platform to help you grow.',
            			image: '{{ url("/images/logos/bigCommerce.png") }}',
            			link: ''
            		},
            		{
            			name: 'Lootly',
            			slug: 'lootly',
            			category: 'Loyalty & Rewards',
            			description: 'Launch a Loyalty, Referrals, and VIP Program for your store in just a few minutes.',
            			image: '{{ url("/images/logos/lootly.png") }}',
            			link: ''
            		},           		
            	],
            	merchantIntegrations: [],
            	saving: false,
            	loading: true
            },
            created: function() {
            	this.getData();
            },
            methods: {
            	getData: function() {
                    axios.get("{{ route('integrations.get') }}").then((response) => {
                    	let integrations = [];
                        let data = response.data.integrations || [];
                        data.map(function(item) {
                        	integrations.push(item.slug)
                        })
                        this.merchantIntegrations = integrations;
                        this.loading = false;
                    })
            	},
            	addIntegration: function(integration) {
            		this.saving = true;
                    axios.post("{{ route('integrations.store', 'slug') }}".replace('slug', integration.slug))
                    .then((response) => {
                    	this.getData();
                        this.saving = false;
	            		(successToast.bind(this))(integration.name+' integration enabled successfully!');
                    }).catch((error) => {
                    	this.saving = false;
	            		(dangerToast.bind(this))('Cannot connect to integration!');
                    })
            	},
            },
            computed: {
            	filteredIntegrations: function() {
            		if(this.categories.length) {
            			return this.integrations.filter(item => this.categories.includes(item.category));
            		}
            		return this.integrations;
            	}
            }
        });
    </script>
@endsection