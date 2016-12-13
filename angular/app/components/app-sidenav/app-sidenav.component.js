class AppSidenavController{
    constructor($sessionStorage, API, $filter, $interval){
        'ngInject';

        this.$sessionStorage = $sessionStorage;
        this.$filter = $filter;
        this.$interval = $interval;
        this.API = API;
    }

    $onInit(){
        this.user = angular.fromJson(this.$sessionStorage.user);
        this.name = this.user.firstname+' '+this.user.lastname;
        this.empID = this.user.employee_id;
        this.clockIsTicking = false;
        this.clockBtnIn = true;
        this.clockBtnOut = true;
        this.clockBtnBreak = true;
        this.clockBtnBreakText = "Break";
        this.status = {
            'break': {'isOnBreak': false, 'time': 0},
            'work': {'isWorking': false, 'time': 0}
        };

        this.timeLogStatus();
    }

    clockTicking() {
        if(this.clockIsTicking)
        {
            return false;
        }

        this.$interval(function() {
            this.clock = Date.now();
        }.bind(this), 1000);
        this.clockIsTicking = true;
    }

    timeLogStatus() {
        this.API.all('clock/status').get('').then(
            function(response) {
                angular.extend(this.status, response);

                this.countupTimer();
                this.clockTicking();

                this.clockBtnIn = (this.status.clockinTypes != 4) || false;
                this.clockBtnBreak = (this.status.clockinTypes == 4) || false;
                this.clockBtnBreakText = this.breakInText();

                this.clockBtnOut = (this.status.clockinTypes == 2 || this.status.clockinTypes == 4) || false;
            }.bind(this)
        );
    }

    countupTimer() {
        if(this.status.break.isOnBreak)
        {
            this.$interval.cancel(this.breakInterval);
            this.breakInterval = this.$interval(function() {
                this.status.break.time += 1;
            }.bind(this), 1000);
        }
        else
        {
            this.$interval.cancel(this.breakInterval);
        }

        if(this.status.work.isWorking)
        {
            this.$interval.cancel(this.workInterval);
            this.workInterval = this.$interval(function() {
                this.status.work.time += 1;
            }.bind(this), 1000);
        }
        else
        {
            this.$interval.cancel(this.workInterval);
        }
    }

    clockTimeIn() {
        this.API.all('clock/in').get('').then(
            function() {
                this.timeLogStatus();
            }.bind(this)
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
        var url = (this.status.clockinTypes == 2) ? 'break/out' : 'break/in';
        this.API.all(url).get('').then(
            function() {
                this.timeLogStatus();
            }.bind(this)
        );
    }

    breakInText() {
        if(this.status.clockinTypes != 2) 
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
