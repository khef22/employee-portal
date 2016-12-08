class UpdateProfileFormController {
    constructor(API, ToastService, $state) {
        'ngInject';

        this.API = API;
        this.$state = $state;
        this.ToastService = ToastService;
    }

    $onInit(){
        this.employee = {};

        this.firstLoad();
    }

    firstLoad() {
        this.API.all('profile').get('').then(
            function(response) {
                this.employee = response;
                this.employee.datepickerstart = new Date(this.employee.datestart);
                this.employee.datepickerfinish = this.employee.datefinish ? new Date(this.employee.datefinish) : "";
            }.bind(this)
        );
    }
}

export const UpdateProfileFormComponent = {
    templateUrl: './views/app/components/update-profile-form/update-profile-form.component.html',
    controller: UpdateProfileFormController,
    controllerAs: 'vm',
    bindings: {}
}
