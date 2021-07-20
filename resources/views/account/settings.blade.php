@extends('layouts.app')

@section('content')
	<div id="settings-page" class="loader" v-cloak>
		<b-overlay :show="loading" spinner-variant="primary" rounded="sm">
	        <div class="content-header row">
	            <div class="content-header-left col-12 mb-2">
	                <div class="row breadcrumbs-top mb-3">
	                    <div class="col-6">
	                        <h2 class="content-header-title mb-0 mt-1">Settings</h2>
	                    </div>
	                    <div class="col-6 text-right">
							<div>
								<button class="btn btn-success btn-md" @click="save" :disabled="saving">
									<b-spinner v-if="saving" class="mr-1" small></b-spinner> Save 
								</button>
							</div>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <div>
				<b-tabs v-model="tab" pills>
					<b-tab title="General Settings">
						<b-card class="mt-3">
							<h6 class="mt-2 mb-3">Account Settings</h6>
							<b-form-group class="mt-3 mb-0" label="Name">
								<b-form-input v-model="form.name" name="name" placeholder="Your name"></b-form-input>
							</b-form-group>
							<b-form-group class="mt-3 mb-0" label="Email Address">
								<b-form-input v-model="form.email" name="email" placeholder="Email"></b-form-input>
							</b-form-group>
							<b-form-group class="mt-3 mb-0" label="Billing Email Address">
								<b-form-input v-model="form.store.billing_email" name="store.billing_email" placeholder="Billing Email Address"></b-form-input>
							</b-form-group>
							<b-form-group class="mt-3 mb-0" label="New Password">
								<b-form-input type="password" v-model="form.password" name="password" placeholder="New Password"></b-form-input>
							</b-form-group>
							<b-form-group class="mt-3 mb-0" label="Confirm Password">
								<b-form-input type="password" v-model="form.password_confirmation" placeholder="Confirm Password"></b-form-input>
							</b-form-group>
						</b-card>
						<b-card class="mb-3">
							<h6 class="mt-2 mb-3">Store Settings</h6>
							<b-form-group class="mt-3 mb-0" label="Store Name">
								<b-form-input v-model="form.store.name" name="store.name" placeholder="Store name"></b-form-input>
							</b-form-group>
							<b-form-group class="mt-3 mb-0" label="Website">
								<b-form-input v-model="form.store.website" name="store.website" placeholder="Website"></b-form-input>
							</b-form-group>
						</b-card>
					</b-tab>
					<b-tab title="Employee Access">
						<b-card class="mt-3">
							<div class="row">
								<div class="col-6">
									<h6 class="mt-2 pt-1 mb-3">Employee Access</h6>
								</div>
								<div class="col-6 text-right">
									<button class="btn btn-primary" @click="addEmployee">Add Employee</button>
								</div>
							</div>
	                        <div class="mt-3">
								<b-input-group>
									<template v-slot:prepend>
										<b-input-group-text>
											<i class="fal fa-search"></i>
										</b-input-group-text>
									</template>
									<b-form-input v-model="employeeSearch" placeholder="Search Employee Name.."></b-form-input>
								</b-input-group>
	                        </div>
	                        <div class="search-enteries" v-if="employees.length">
	                            <div class="search-entry" v-for="employee in filteredEmployees">
	                                <div class="d-flex">
		                                <span class="employee-name">
		                                    <a href="javascript:void(0)" class="text-primary"
		                                       @click="editEmployee(employee)">
		                                        <span v-text="employee.name"></span>
		                                    </a>
		                                </span>
	                                    <span class="ml-auto"
	                                          v-text="employee.role == 'owner' ? 'Full Access' : (employee.role == 'member' ? 'Limited Access' : '')"></span>
	                                </div>
	                                <p class="status mb-0" v-if="employee.created_at">
	                                	Added on <span v-text="employee.created_at"></span>
	                                </p>
	                            </div>
	                        </div>
	                        <div v-else>
	                        	<p class="text-muted mt-3">There are no employees!</p>
	                        </div>
						</b-card>
					</b-tab>
					<b-tab title="Notifications">
						<b-card class="mt-3">
							<h6 class="mt-2 mb-3">Notifications</h6>
							<div class="mb-3">
								<b-form-checkbox v-model="form.notifications.daily_summary" size="lg" switch>
									Daily Summary
								</b-form-checkbox>
							</div>
							<div class="mb-3">
								<b-form-checkbox v-model="form.notifications.weekly_summary" size="lg" switch>
									Weekly Summary
								</b-form-checkbox>
							</div>
						</b-card>
					</b-tab>
				</b-tabs>
	        </div>
	    </b-overlay>
        <!-- Add/Edit Employee Modal -->
        <b-modal id="employee-access" :title="employeeForm.id ? 'Edit Employee' : 'Add Employee'" hide-footer v-cloak>
            <form role="form" @submit.prevent="saveEmployee">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="light-font">Employee Name</label>
                            <input class="form-control" v-model="employeeForm.name" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="light-font">Employee Email</label>
                            <input type="email" class="form-control" v-model="employeeForm.email" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="light-font m-t-5">Access Type:</label>
                    </div>
                    <div class="col-md-9">
                        <b-form-radio-group id="role" v-model="employeeForm.role" required>
                            <b-form-radio value="member" name="role">Limited Access (main menu
                                pages only)
                            </b-form-radio>
                            <b-form-radio value="owner" name="role">Full Access (all pages except
                                billing)
                            </b-form-radio>
                        </b-form-radio-group>
                    </div>
                </div>
                <div class="mt-3 pt-3 pb-1 text-center border-top">
                	<div class="py-2" v-if="employeeFormLoading">
                		<b-spinner variant="primary" class="mr-1"></b-spinner>
                	</div>
                	<div class="pt-1" v-else>
	                	<div v-if="!employeeForm.id">
	                        <button type="submit" class="btn btn-success btn-md" :disbled="employeeFormLoading">
	                        	<b-spinner v-if="employeeFormLoading" class="mr-1" small></b-spinner> Save
	                        </button>
	                	</div>
	                	<div v-else>
	                        <button type="submit" class="btn btn-success btn-md" :disbled="employeeFormLoading">
	                        	<b-spinner v-if="employeeFormLoading" class="mr-1" small></b-spinner> Save
	                        </button>
	                        <button @click.prevent="deleteEmployee"class="btn btn-danger btn-md ml-3" :disbled="employeeFormLoading">
	                        	<b-spinner v-if="employeeFormLoading" class="mr-1" small></b-spinner> Delete
	                        </button>
	                	</div>
                	</div>
                </div>
            </form>
        </b-modal>
	</div>
@endsection

@section('scripts')
    <script>
        var page = new Vue({
            el: '#settings-page',
            data: {
            	tab: 0,
            	form: {
            		name: '',
            		email: '',
            		password: '',
            		password_confirmation: '',
            		store: {
            			name: '',
            			website: '',
            			billing_email: '',
            		},
            		notifications: {
            			daily_summary: 1,
            			weekly_summary: 1,
            		}
            	},
		        employeeSearch: '',
		        employeeForm: {
		        	id: '',
		        	name: '',
		        	email: '',
		        	role: 'member'
		        },
            	employees: [{
            		id: 1,
            		name: 'Ahmed',
            		email: '',
            		role: 'owner',
            		created_at: '08/12/2020'
            	}],
            	employeeFormLoading: false,
            	saving: false,
            	loading: true
            },
            created: function() {
            	this.getData();
            	this.getEmployees();
            },
            methods: {
            	getData: function() {
            		this.loading = false;
                    axios.get("{{ route('account.settings.get') }}").then((response) => {
                        let data = response.data;
                        let merchant = data.merchant;
                        this.form.name = data.user.name;
                        this.form.email = data.user.email;
                        if(merchant) {
                            this.form.store.name = merchant.name;
                            this.form.store.website = merchant.website;
                            this.form.store.billing_email = merchant.billing_email;
                        }
                        this.loading = false;
                    })
            	},
            	save: function() {
            		this.saving = true;
                    axios.post("{{ route('account.settings.update') }}", this.form).then((response) => {
                        this.saving = false;
	            		(successToast.bind(this))();
                    }).catch((error) => {
                    	this.tab = 0;
                    	this.saving = false;
	            		(dangerToast.bind(this))();
                    	showErrors(null, error.response.data.errors)
                    })
            	},
            	getEmployees: function() {
                    axios.get("{{ route('account.employees.get') }}").then((response) => {
                        let data = response.data;
                        this.employees = data.users;
                    })
            	},
            	saveEmployee: function() {
            		this.employeeFormLoading = true;
            		let url = this.employeeForm.id ? "{{ route('account.employee.update') }}" : "{{ route('account.employee.store') }}";
                    axios.post(url, this.employeeForm).then((response) => {
                    	this.getEmployees();
                        this.employeeFormLoading = false;
	            		(successToast.bind(this))(response.data.message);
			            this.$root.$emit('bv::hide::modal', 'employee-access')
                    }).catch((error) => {
                        this.employeeFormLoading = false;
	            		(dangerToast.bind(this))();
                    	showErrors(null, error.response.data.errors)
                    })
				},
				deleteEmployee: function() {
					let _this = this;
            		_this.employeeFormLoading = true;
                    axios.post("{{ route('account.employee.delete') }}", {
                    	id: _this.employeeForm.id
                    }).then((response) => {
                    	_this.getEmployees();
                        _this.employeeFormLoading = false;
	            		(successToast.bind(_this))(response.data.message);
			            _this.$root.$emit('bv::hide::modal', 'employee-access')
                    }).catch((error) => {
                        _this.employeeFormLoading = false;
	            		(dangerToast.bind(_this))();
                    	showErrors(null, error.response.data.errors)
                    })
				},
            	addEmployee: function() {
            		this.employeeForm = {id: '', name: '', email: '', role: 'member'}
		            this.$root.$emit('bv::show::modal', 'employee-access')
            	},
            	editEmployee: function(employee) {
            		this.employeeForm = {...employee}
		            this.$root.$emit('bv::show::modal', 'employee-access')
            	}
            },
            computed: {
				filteredEmployees: function () {
					if(this.employeeSearch) {
						return this.employees.filter(item => item.name.toUpperCase().includes(this.employeeSearch.toUpperCase()) || item.email.toUpperCase().includes(this.employeeSearch.toUpperCase()));
					}
					return this.employees
				}
            }
        });
    </script>
@endsection