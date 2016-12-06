export function SatellizerConfig($authProvider) {
	'ngInject';

	$authProvider.httpInterceptor = function() {
		return true;
	}

	$authProvider.loginUrl = '/api/auth/login';
	$authProvider.signupUrl = '/api/auth/register';
	$authProvider.tokenRoot = 'data';//compensates success response macro
	$authProvider.google({
		clientId: '324851456685-v9m3hidhmq65fs8v9kjfttjuefhk5hv4.apps.googleusercontent.com',
		url: 'api/auth/google'
    });
    $authProvider.unlinkUrl = '/api/auth/unlink/';

}
