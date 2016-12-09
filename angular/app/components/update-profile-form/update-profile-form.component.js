class UpdateProfileFormController {
    constructor(API, ToastService, $state) {
        'ngInject';

        this.API = API;
        this.$state = $state;
        this.ToastService = ToastService;
    }

    $onInit(){

        this.employee = {};
        this.fieldEditable = false;
        this.loaded = false;
        this.options = {
            'supervisors' : [],
            'employee_statuses' : []
        };

        this.loadPage();
    }

    loadField() {
        this.API.all('profile/field').get('').then(
            function(response) {
                this.employee = response;
                this.employee.datestart = new Date(this.employee.datepickerstart);
                if(this.employee.datepickerfinish)
                {
                    this.employee.datefinish = new Date(this.employee.datepickerfinish);
                }
                this.loaded = true;
            }.bind(this)
        );

    }

    loadPage() {
        this.API.all('profile').get('').then(
            function(response) {
                this.options = response;
                this.loadField();
            }.bind(this)
        );
    }

    toggleEdit() {
        this.fieldEditable = !this.fieldEditable;
    }

    saveProfile() {
        this.API.all('profile/save').post(this.employee);
    }
}

export const UpdateProfileFormComponent = {
    templateUrl: './views/app/components/update-profile-form/update-profile-form.component.html',
    controller: UpdateProfileFormController,
    controllerAs: 'vm',
    bindings: {}
}
