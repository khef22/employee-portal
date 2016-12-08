export function RoutesConfig($stateProvider, $urlRouterProvider, $locationProvider) {
	'ngInject';

	let getView = (viewName) => {
		return `./views/app/pages/${viewName}/${viewName}.page.html`;
	};

	$urlRouterProvider.otherwise('/');
	
	/* $locationProvider.html5Mode({
		enabled: true,
		requireBase: false
	}); */

    /*
        data: {auth: true} would require JWT auth
        However you can't apply it to the abstract state
        or landing state because you'll enter a redirect loop
    */

	$stateProvider
		.state('app', {
			abstract: true,
            data: {},
			views: {
				sidenav: {
					templateUrl: getView('sidenav')
				},
				header: {
					templateUrl: getView('header')
				},
				footer: {
					templateUrl: getView('footer')
				},
				main: {}
			}
		})
		.state('app2', {
			abstract: true,
            data: {},
			views: {
				main: {}
			}
		})
		.state('app.main', {
			data: {auth: true},
            url: '/',
            views: {
                'main@': {
                    templateUrl: getView('main')
                }
            }
        })
        .state('app.purchaserequests', {
			data: {auth: true},
            url: '/purchase-requests',
            views: {
                'main@': {
                    templateUrl: getView('purchase-requests')
                }
            }
        })
        .state('app2.login', {
			url: '/login',
			views: {
				'main@': {
					templateUrl: getView('login')
				}
			}
		})
        .state('app.register', {
            url: '/register',
            views: {
                'main@': {
                    templateUrl: getView('register')
                }
            }
        })
        .state('app.forgot_password', {
            url: '/forgot-password',
            views: {
                'main@': {
                    templateUrl: getView('forgot-password')
                }
            }
        })
        .state('app.reset_password', {
            url: '/reset-password/:email/:token',
            views: {
                'main@': {
                    templateUrl: getView('reset-password')
                }
            }
        });
}
