class AppSidenavController{
    constructor($sessionStorage, API, $filter){
        'ngInject';

        this.$sessionStorage = $sessionStorage;
        this.$filter = $filter;
        this.API = API;
    }

    $onInit(){
        this.user = angular.fromJson(this.$sessionStorage.user);
        this.name = this.user.firstname+' '+this.user.lastname;
        this.empID = this.user.employee_id;
        this.clockBtnIn = true;
        this.clockBtnOut = true;
        this.clockBtnBreak = true;
        this.clockBtnBreakText = "Break";
        this.timeLogStatus();
    }

    timeLogStatus() {
        this.API.all('clock/status').get('').then(
            function(response) {
                this.status = response;

                this.clockBtnIn = (this.status.clockinTypes.indexOf(1) > -1 && this.status.clockinTypes.indexOf(4) < 0 ) || false;
                this.clockBtnBreak = (this.status.clockinTypes.indexOf(4) > -1 || this.status.clockinTypes.indexOf(3) > -1) || false;
                this.clockBtnBreakText = this.breakInText();

                this.clockBtnOut = (
                        this.status.clockinTypes.indexOf(4) > -1 ||
                        ( this.status.clockinTypes.indexOf(2) > -1 && this.status.clockinTypes.indexOf(3) < 0 )
                    ) || false;
            }.bind(this)
        );
    }

    clockTimeIn() {
        this.API.all('clock/in').get('').then(
            function() {
                this.timeLogStatus();
            }.bind(this),
            function() {
                console.log("You cant Time-in twice or more on the same day.");
            }
        );
    }

    clockTimeOut() {
        this.API.all('clock/out').get('').then(
            function() {
                this.timeLogStatus();
            }.bind(this)
        );
    }

    clockBreak() {
        var url = (this.status.clockinTypes.indexOf(2) > -1) ? 'break/out' : 'break/in';
        this.API.all(url).get('').then(
            function() {
                this.timeLogStatus();
            }.bind(this)
        );
    }

    clockBreakOut() {
        var url = 'break/out';
        this.API.all(url).get('').then(
            function() {
                this.timeLogStatus();
            }.bind(this)
        );
    }

    breakInText() {
        if(this.status.clockinTypes.indexOf(1) < 0 || this.status.clockinTypes.indexOf(3) > -1 ||
            (this.status.clockinTypes.indexOf(1) > -1 && this.status.clockinTypes.indexOf(4) > -1))
        {
            return "Break";
        }

        if(this.status.clockinTypes.indexOf(2) < 0 || this.status.clockinTypes.indexOf(1) < 0 || this.status.clockinTypes.indexOf(4) > -1)
        {
            return "Break";
        }
        else 
        {
            return "End Break";
        }
    }

    statusFilter($type) {
        return this.status.filter(function(clock){ return clock.clockin_type == $type }).length;
    }
}

export const AppSidenavComponent = {
    templateUrl: './views/app/components/app-sidenav/app-sidenav.component.html',
    controller: AppSidenavController,
    controllerAs: 'vm',
    bindings: {}
}
