<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WebsiteController@home');
Route::get('/invoice', 'Billing\BillingController@invoice');

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/signup', 'Auth\RegisterController@showRegistrationForm');

Route::group(['middleware' => ['auth.shopify', 'billable']], function() {
	Route::get('/dashboard', 'Settings\DashboardController@index')->name('home_dashboard');
	
	// Billing Routes
	Route::group(['prefix' => 'transactions', 'namespace' => 'Billing'], function() {
		Route::get('/', 'BillingController@index')->name('transactions.index');
		Route::get('/get', 'BillingController@getBillings')->name('transactions.get');
	});

	// Account Routes
	Route::group(['prefix' => 'account', 'namespace' => 'Settings\Account'], function() {
		Route::get('/settings', 'AccountController@index')->name('account.settings');
		Route::get('/settings/get', 'AccountController@get')->name('account.settings.get');
		Route::post('/settings/update', 'AccountController@update')->name('account.settings.update');

		Route::group(['prefix' => 'employees'], function() {
			Route::get('/get', 'AccountController@getEmployees')->name('account.employees.get');
			Route::post('/store', 'AccountController@storeEmployee')->name('account.employee.store');
			Route::post('/update', 'AccountController@updateEmployee')->name('account.employee.update');
			Route::post('/delete', 'AccountController@deleteEmployee')->name('account.employee.delete');
		});
	});

	// Integrations Routes
	Route::group(['prefix' => '/account/integrations', 'namespace' => 'Settings\Integration'], function() {
		Route::get('/', 'IntegrationController@index')->name('integrations.index');
	    Route::get('/get', 'IntegrationController@get')->name('integrations.get');
	    Route::get('/shopify', 'IntegrationController@shopify')->name('integrations.shopify');
	    Route::post('/store/{slug}', 'IntegrationController@store')->name('integrations.store');
	    Route::post('/delete/{slug}', 'IntegrationController@delete')->name('integrations.delete');
	});

	// Merchant Routes
	Route::group(['namespace' => 'Settings\Merchant'], function() {
		Route::get('/upgrade', 'SubscriptionController@upgrade')->name('upgrade');
		Route::group(['prefix' => 'merchant'], function() {
			Route::get('/switch/{id}', 'MerchantController@switch')->name('merchant.switch');
			Route::post('/create', 'MerchantController@create')->name('merchant.create');
			// Subscriptions
	    	Route::post('/subscription/create', 'SubscriptionController@create')->name('merchant.subscription.create');
	    	Route::post('/stripe/portal', 'SubscriptionController@stripePortal')->name('stripe.portal');
		});
	});
});

Route::post('/stripe/webhook','StripeWebhookController@handleWebhook')->name('cashier.webhook');
Route::post('/postmark/webhook','PostmarkWebhookController@handleWebhook');
Route::post('/test/notification','PostmarkWebhookController@testNotification');

Route::get('/login', function () {
    if (Auth::user()) {
        return redirect()->route('home');
    }
    return view('auth.login');
})->name('login');

Route::group(['prefix' => 'app', 'middleware' => ['auth.shopify', 'billable']], function() {

    Route::get('/', 'WebsiteController@home')->name('home');

    Route::get('/dashboard', 'Settings\DashboardController@index')->name('dashboard');

});
