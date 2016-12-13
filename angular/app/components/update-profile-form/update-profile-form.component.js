class UpdateProfileFormController {
    constructor(API, ToastService, $state, $mdToast) {
        'ngInject';

        this.API = API;
        this.$state = $state;
        this.ToastService = ToastService;
        this.$mdToast = $mdToast;
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
        this.API.one('profile', 'field').get().then(
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
        this.API.one('profile').get().then(
            function(response) {
                this.options = response;
                this.employee.datestart = new Date(this.employee.datepickerstart);
                if(this.employee.datepickerfinish)
                {
                    this.employee.datefinish = new Date(this.employee.datepickerfinish);
                }
                this.loaded = true;
                this.loadField();
            }.bind(this)
        )
    }

    toggleEdit() {
        this.fieldEditable = !this.fieldEditable;
    }

    saveProfile() {
        this.API.all('profile/save').post(this.employee).then(function(){
            this.fieldEditable = false;
            this.$mdToast.show(this.$mdToast.simple().textContent('Saved!'));
        }.bind(this));
    }
}

export const UpdateProfileFormComponent = {
    templateUrl: './views/app/components/update-profile-form/update-profile-form.component.html',
    controller: UpdateProfileFormController,
    controllerAs: 'vm',
    bindings: {}
}
