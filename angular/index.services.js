import {APIService} from './services/API.service';
import {DialogService} from './services/dialog.service';
import {ToastService} from './services/toast.service';

//Auth Interceptor Service
// import {AuthInterceptorService} from './services/authInterceptor.service';

angular.module('app.services')
	.service('API', APIService)
	.service('DialogService', DialogService)
	.service('ToastService', ToastService);
	// .service('AuthInterceptorService', AuthInterceptorService.AuthInterceptorFactory).config([ '$httpProvider', function($httpProvider) {
	//     $httpProvider.interceptors.push('AuthInterceptorService');	    
 //  	}]);;