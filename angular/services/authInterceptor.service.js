export class AuthInterceptorService {
	construct ( $q, $rootScope, $sessionStorage, $auth, $state, ToastService ) {

		this.$q = $q;		
		this.$rootScope = $rootScope;
		this.$sessionStorage = $sessionStorage;
		this.$auth = $auth;
		this.$state = $state;

	}

	// Override responseError			
	responseError( response ){

		if ( (response.status === 401 || response.status === 403 || response.status == 500) && !this.$auth.isAuthenticated() ) {   

          	this.$auth.logout();
            this.$state.go('app2.login');
            this.ToastService.show('You are now logged out.');

            this.$auth.unlink('google');

         	if ( $rootScope.$state.current ) { 
	            this.$sessionStorage.refresh_redirect_state = JSON.stringify(this.$rootScope.$state.current);
	        } 

        }

        return this.$q.reject(response);
	}

	static AuthInterceptorFactory( $q, $rootScope, $sessionStorage, $auth, $state, ToastService ){
		return new AuthInterceptorService( $q, $rootScope, $sessionStorage, $auth, $state, ToastService );
	}

}

//Auth Interceptor Service Inject Dependencies
AuthInterceptorService.AuthInterceptorFactory.$inject = [ '$q', '$rootScope', '$sessionStorage', '$auth', '$state', 'ToastService' ];
