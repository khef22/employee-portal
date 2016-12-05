class AppSidenavController{
    constructor($sessionStorage){
        'ngInject';

        this.$sessionStorage = $sessionStorage;
    }

    $onInit(){
        this.user = angular.fromJson(this.$sessionStorage.user);
        this.name = this.user.firstname+' '+this.user.lastname;
        this.empID = this.user.employee_id;
    }
}

export const AppSidenavComponent = {
    templateUrl: './views/app/components/app-sidenav/app-sidenav.component.html',
    controller: AppSidenavController,
    controllerAs: 'vm',
    bindings: {}
}
