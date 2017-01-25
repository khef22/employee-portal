export class AuthInterceptorService {

	construct ( $q, $sessionStorage, $auth, $state, ToastService ) {

		this.$q = $q;				
		this.$sessionStorage = $sessionStorage;
		this.$auth = $auth;
		this.$state = $state;
		this.ToastService = ToastService;

	}

	// Override responseError			
	responseError( response ){

		if ( (response.status === 401 || response.status === 403 || response.status == 500) && !this.$auth.isAuthenticated() ) {
			
			this.$auth.logout();
			this.$state.go('app2.login');
			this.ToastService.show('You are now logged out.');

			this.$auth.unlink('google');
		}

		return this.$q.reject(response);
	}

	static AuthInterceptorFactory( $q, $sessionStorage, $auth, $state, ToastService ){
		return new AuthInterceptorService( $q, $sessionStorage, $auth, $state, ToastService );
	}

}

//Auth Interceptor Service Inject Dependencies
AuthInterceptorService.AuthInterceptorFactory.$inject = [ '$q', '$sessionStorage', '$auth', '$state', 'ToastService' ];