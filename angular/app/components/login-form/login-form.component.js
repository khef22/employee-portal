class LoginFormController {
	constructor($auth, ToastService, $state,$sessionStorage) {
		'ngInject';

		this.$auth = $auth;
		this.ToastService = ToastService;
		this.$state = $state;
		this.$sessionStorage = $sessionStorage;
	}

    $onInit(){
        this.username = '';
        this.password = '';

		if(this.$auth.isAuthenticated()){
			this.$state.go('app.main')
		}
    }

	login() {
		let user = {
			username: this.username,
			password: this.password
		};

		this.$auth.login(user)
			.then((response) => {
				this.$auth.setToken(response.data);
				this.getUserInfo(response);
				this.$state.go('app.main');
				this.ToastService.show('Logged in successfully.');
			})
			.catch(this.failedLogin.bind(this));
			
	}

	authenticate(provider){
		this.$auth.authenticate(provider)
			.then((response) => {
				this.$auth.setToken(response.data);
				this.getUserInfo(response);
				this.$state.go('app.main');
				this.ToastService.show('Logged in successfully.');
			})
			.catch(this.failedLogin.bind(this));
	}

	getUserInfo(response){
		response = angular.fromJson(response.data);
		this.$sessionStorage.user = response.data.user;
	}

	failedLogin(response) {
		if (response.status === 422) {
			for (let error in response.data.errors) {
				return this.ToastService.error(response.data.errors[error][0]);
			}
		}
		this.ToastService.error(response.statusText);
	}
}

export const LoginFormComponent = {
	templateUrl: './views/app/components/login-form/login-form.component.html',
	controller: LoginFormController,
	controllerAs: 'vm',
	bindings: {}
}
