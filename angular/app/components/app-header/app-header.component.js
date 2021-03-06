class AppHeaderController{
    constructor($sce,$auth,$state,ToastService){
        'ngInject';

        this.$sce = $sce;
        this.$auth = $auth;
        this.$state = $state;
        this.ToastService = ToastService;
    }

    $onInit(){
        //defer iframe loading
        //let url = 'https://ghbtns.com/github-btn.html?user=jadjoubran&repo=laravel5-angular-material-starter&type=star&count=true&size=large';
        //this.githubWidget = this.$sce.trustAsResourceUrl(url);
    }

    $doCheck(){
        if (this.$auth.isAuthenticated()) {
            this.islogged = true;
        }else{
            this.islogged = false;
        }
    }

    logout(){
        if (this.$auth.isAuthenticated()) {
            this.$auth.logout();
            this.$state.go('app.login');
            this.ToastService.show('You are now logged out.');
        }
    }
}

export const AppHeaderComponent = {
    templateUrl: './views/app/components/app-header/app-header.component.html',
    controller: AppHeaderController,
    controllerAs: 'vm',
    bindings: {}
}
