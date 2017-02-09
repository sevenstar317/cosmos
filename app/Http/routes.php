<?php

use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;

//logs
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['domain' => 'cosmos.local', 'prefix' => 'chat-advisor'], function () {
	Route::get('/', ['as' => 'agent.home', 'uses' => 'AgentController@agentChat']);
//	Route::get('agent/chat', ['uses' => 'AgentController@agentChat']);
	Route::get('test-chat', ['uses' => 'AgentController@agentChatPartial']);
	Route::get('test-chat-room', ['uses' => 'AgentController@agentChatRoomPartial']);
	Route::get('info', ['uses' => 'AgentController@info']);
	Route::get('info2', ['uses' => 'AgentController@info2']);
	Route::get('info3', ['uses' => 'AgentController@info3']);
	Route::get('info4', ['uses' => 'AgentController@info4']);
	Route::get('info5', ['uses' => 'AgentController@info5']);
	Route::get('sign1/{sign}', ['uses' => 'AgentController@sign1']);
	Route::get('sign2/{sign}', ['uses' => 'AgentController@sign2']);
	Route::get('first-redirect', ['uses' => 'AgentController@firstRedirect']);
	Route::get('end-chat/{agent_id}/{customer_id}', ['uses' => 'AgentController@endChat']);

	//******** Agents auth ***********//

// Authentication Routes...
	Route::get('login', 'AgentsAuth\AuthController@showLoginForm');
	Route::post('login', 'AgentsAuth\AuthController@postLogin');
	Route::get('logout', 'AgentsAuth\AuthController@logout');

// Registration Routes...
	Route::get('register', 'AgentsAuth\AuthController@showRegistrationForm');
	Route::post('register', 'AgentsAuth\AuthController@register');

// Password Reset Routes...
	Route::get('password/reset/{token?}', 'AgentsAuth\PasswordController@showResetForm');
	Route::get('password/email', 'AgentsAuth\PasswordController@getEmail');
	Route::post('password/email', 'AgentsAuth\PasswordController@sendResetLinkEmail');
	Route::post('password/reset', 'AgentsAuth\PasswordController@reset');
});

Route::group(['domain' => 'connect.livecosmos.com'], function () {
	Route::get('/', function () {
		return redirect('chat-advisor/first-redirect');
	});
	Route::group(['prefix' => 'chat-advisor'], function () {
		Route::get('/', ['as' => 'agent.home', 'uses' => 'AgentController@agentChat']);
		Route::get('test-chat', ['uses' => 'AgentController@agentChatPartial']);
		Route::get('info', ['uses' => 'AgentController@info']);
		Route::get('info2', ['uses' => 'AgentController@info2']);
		Route::get('info3', ['uses' => 'AgentController@info3']);
		Route::get('info4', ['uses' => 'AgentController@info4']);
		Route::get('info5', ['uses' => 'AgentController@info5']);
		Route::get('test-chat-room', ['uses' => 'AgentController@agentChatRoomPartial']);
		Route::get('first-redirect', ['uses' => 'AgentController@firstRedirect']);
		Route::get('end-chat/{agent_id}/{customer_id}', ['uses' => 'AgentController@endChat']);
		Route::get('sign1/{sign}', ['uses' => 'AgentController@sign1']);
		Route::get('sign2/{sign}', ['uses' => 'AgentController@sign2']);

		//******** Agents auth ***********//

// Authentication Routes...
		Route::get('login', 'AgentsAuth\AuthController@showLoginForm');
		Route::post('login', 'AgentsAuth\AuthController@postLogin');
		Route::get('logout', 'AgentsAuth\AuthController@logout');

// Registration Routes...
		Route::get('register', 'AgentsAuth\AuthController@showRegistrationForm');
		Route::post('register', 'AgentsAuth\AuthController@register');

// Password Reset Routes...
		Route::get('password/reset/{token?}', 'AgentsAuth\PasswordController@showResetForm');
		Route::get('password/email', 'AgentsAuth\PasswordController@getEmail');
		Route::post('password/email', 'AgentsAuth\PasswordController@sendResetLinkEmail');
		Route::post('password/reset', 'AgentsAuth\PasswordController@reset');
	});
});

Route::group(['prefix' => 'customer-support'], function () {
	Route::get('chat-search', ['as'=>'chat.search','uses' => 'SupportController@chatSearch']);
	Route::post('chat-search', ['as'=>'chat.search','uses' => 'SupportController@chatSearch']);
	Route::get('login', ['as'=>'chat.login','uses' => 'SupportController@fakeLogin']);
	Route::post('login', ['as'=>'chat.login','uses' => 'SupportController@fakeLogin']);
});

Route::resource('main', 'MainController');

Route::get('/', ['as' => 'home', 'uses' => 'MainController@index']);
Route::get('selectSign', ['uses' => 'MainController@selectSign']);
Route::get('step2', ['uses' => 'MainController@step2']);
Route::get('step3', ['uses' => 'MainController@step3']);
Route::get('step4', ['uses' => 'MainController@step4']);
Route::get('step5', ['uses' => 'MainController@step5']);
Route::get('step6', ['uses' => 'MainController@step6']);
Route::get('startNow', ['uses' => 'MainController@startNow']);
Route::post('startNow', ['uses' => 'MainController@startNow']);
Route::get('successPage', ['uses' => 'MainController@successPage']);
Route::post('successPage', ['uses' => 'MainController@successPage']);
Route::get('accessReport', ['uses' => 'MainController@accessReport']);
Route::post('accessReport', ['uses' => 'MainController@accessReport']);
Route::get('readyMap', ['uses' => 'MainController@readyMap']);
Route::get('connectingToSpec', ['as' => 'connectingToSpec', 'uses' => 'MainController@connectingToSpec']);
Route::get('signUpMapComplete', ['as' => 'signUpMapComplete', 'uses' => 'MainController@signUpMapComplete']);
Route::get('checkout', ['uses' => 'MainController@checkout']);
Route::post('checkout', ['uses' => 'MainController@checkout']);
Route::get('dashboardCheckout', ['as' => 'dashboardCheckout', 'uses' => 'MainController@dashboardCheckout']);
Route::post('dashboardCheckout', ['as' => 'dashboardCheckout', 'uses' => 'MainController@dashboardCheckout']);
Route::get('checkout2', ['as' => 'checkout2', 'uses' => 'MainController@checkout2']);
Route::post('checkout2', ['as' => 'checkout2', 'uses' => 'MainController@checkout2']);
Route::get('dashboard/get-cities', ['uses' => 'DashboardController@getCities']);
Route::get('dashboard/get-states', ['uses' => 'DashboardController@getStates']);
Route::get('dashboard/get-cities-auto', ['uses' => 'DashboardController@getCitiesAutocomplete']);

Route::get('dashboard/show-report/{type}', [ 'uses' => 'DashboardController@showReport']);

Route::get('dashboard/initial', ['uses' => 'DashboardController@initial']);
Route::get('dashboard/my-cosmos', ['uses' => 'DashboardController@myCosmos']);

Route::get('dashboard/live-chat', function () {
	if(!Auth::guest()):
		return redirect('dashboard/live-chat/'.Auth::user()->id);
	else:
		return redirect('/');
		endif;
});

Route::get('dashboard/live-chat/{id?}', ['uses' => 'DashboardController@liveChat']);

Route::get('dashboard/activity', ['uses' => 'DashboardController@activity']);
Route::post('dashboard/activity', ['uses' => 'DashboardController@activity']);
Route::get('dashboard/settings', ['uses' => 'DashboardController@settings']);

Route::get('dashboard/romantic-report', ['uses' => 'DashboardController@fillRomantic']);
Route::post('dashboard/romantic-report', ['uses' => 'DashboardController@fillRomantic']);
Route::get('dashboard/new-report/{sku}', ['uses' => 'DashboardController@fillNormal']);
Route::post('dashboard/new-report/{sku}', ['uses' => 'DashboardController@fillNormal']);

Route::get('dashboard/user-update', [ 'uses' => 'DashboardController@update']);
Route::post('dashboard/user-update', [ 'uses' => 'DashboardController@update']);
Route::post('dashboard/settings', ['as' => 'user.update', 'uses' => 'DashboardController@settings']);
Route::post('dashboard/user-change-password', ['as' => 'user.change-password', 'uses' => 'DashboardController@changePassword']);

Route::post('dashboard/edit-payment', ['as' => 'user.edit-payment', 'uses' => 'DashboardController@editPayment']);
Route::post('main/sendContact', ['as' => 'user.contact-support', 'uses' => 'MainController@sendContact']);
Route::post('main/sendContactJoinAdvisor', ['as' => 'user.join-advisor', 'uses' => 'MainController@sendContactJoinAdvisor']);

Route::get('terms', ['uses' => 'HomeController@terms']);

Route::get('privacy', ['uses' => 'HomeController@privacy']);
Route::get('contact', ['uses' => 'HomeController@contact']);
Route::get('join', ['uses' => 'HomeController@joinAsAdvisor']);

Route::post('payment/buyPackage', ['uses' => 'PaymentController@buyPackage']);
Route::post('payment/buyReport', ['uses' => 'PaymentController@buyReport']);
Route::post('payment/quickCheckout', ['uses' => 'PaymentController@quickCheckout']);

Route::get('payment/payForDownloadPdfReport/{id}', ['uses' => 'PaymentController@payForDownloadPdfReport']);
Route::get('payment/payForEmailReport/{id}', ['uses' => 'PaymentController@payForEmailReport']);
Route::get('reports/downloadpdf/{id}', ['uses' => 'ReportsController@downloadPdfReport']);
Route::get('reports/email/{id}', ['uses' => 'ReportsController@emailReport']);
Route::get('reports/view-report/{id}', ['uses' => 'ReportsController@viewReport']);

Route::get('rep', ['uses' => 'ReportsController@getReport']);

Route::get('payment/payForDownloadChat/{id}', ['uses' => 'PaymentController@payForDownloadChat']);
Route::get('payment/payForEmailChat/{id}', ['uses' => 'PaymentController@payForEmailChat']);
Route::get('reports/downloadChat/{id}', ['uses' => 'ReportsController@downloadChat']);
Route::get('reports/emailChat/{id}', ['uses' => 'ReportsController@emailChat']);

Route::get('apitest', ['uses' => 'ReportsController@apiTest']);

Route::auth();
Route::get('register2', function () {

	if ($_SERVER['HTTP_HOST'] == 'trackingcsm.livecosmos.com' || $_SERVER['HTTP_HOST'] == 'm.livecosmos.com') {
		$user = new User();
		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');
		$user->status = 'Pending';
		$user->registration_token = Str::random(16);
		$user->name = "Temp";
		$user->email = "no@email.com" . $user->registration_token;
		$user->real_password = 'q1w2e3r4t5y6';
		$user->password = bcrypt('q1w2e3r4t5y6');
		if ($user->save()) {
			return redirect()->action('MainController@selectSign', ['registration_token' => $user->registration_token]);
		}
	}
	return redirect()->action('Auth\AuthController@showRegistrationForm',['first_name'=>Input::get('first_name'),'last_name'=>Input::get('last_name')]);
});
Route::get('dashboard', function () {
	return redirect()->action('DashboardController@liveChat');
});

//*******************//

Route::get('dashboard/test-chat', ['uses' => 'DashboardController@clientChatPartial']);
Route::get('dashboard/client-rooms', ['uses' => 'DashboardController@clientChatRooms']);
Route::get('dashboard/end-chat/{agent_id}/{customer_id}/{hours}/{minutes}/{seconds}', ['uses' => 'DashboardController@endChat']);

Route::get('sendmessage', 'AgentController@sendMessage');
Route::get('/home', 'HomeController@index');
Route::get('/horoscope', 'HoroscopeController@index');
Route::get('/horoscope/{sign}', 'HoroscopeController@horoscopePage');

