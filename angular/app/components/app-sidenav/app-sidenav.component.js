class AppSidenavController{
    constructor($sessionStorage, API){
        'ngInject';

        this.$sessionStorage = $sessionStorage;
        this.API = API;
    }

    $onInit(){
        this.user = angular.fromJson(this.$sessionStorage.user);
        this.name = this.user.firstname+' '+this.user.lastname;
        this.empID = this.user.employee_id;
        this.API.all('clock/status').get('').then(
            function(response) {
                this.status = response.data.clockin_type;
            }
        );
    }

    timeLogStatus() {
        this.API.all('clock/status').get('').then(
            function(response) {
                this.status = response.data.clockin_type;
            }
        );
    }

    clockTimeIn() {
        if(this.status >= 4)
        {
            console.log("success");
        }
        this.API.all('clock/in').get('').then(
            function() {

            }
        );
    }

    clockTimeOut() {
        this.API.all('clock/out').get('').then(
            function() {
                
            }
        );
    }

    clockBreak() {
        this.API.all('break/in').get('').then(
            function() {
                
            }
        );
    }
}

export const AppSidenavComponent = {
    templateUrl: './views/app/components/app-sidenav/app-sidenav.component.html',
    controller: AppSidenavController,
    controllerAs: 'vm',
    bindings: {}
}
