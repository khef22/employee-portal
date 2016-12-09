class UpdateProfileFormController {
    constructor(API, ToastService, $state) {
        'ngInject';

        this.API = API;
        this.$state = $state;
        this.ToastService = ToastService;
    }

    $onInit(){
<<<<<<< Updated upstream
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
=======
        this.employee = {
            title: 'Developer',
            email: 'ipsum@lorem.com',
            firstName: '',
            lastName: '',
            company: 'Google',
            address: '1600 Amphitheatre Pkwy',
            city: 'Mountain View',
            state: 'CA',
            biography: 'Loves kittens, snowboarding, and can type at 130 WPM.\n\nAnd rumor has it she bouldered up Castle Craig!',
            postalCode: '94043'
        };

        this.states = ('AL AK AZ AR CA CO CT DE FL GA HI ID IL IN IA KS KY LA ME MD MA MI MN MS ' +
            'MO MT NE NV NH NJ NM NY NC ND OH OK OR PA RI SC SD TN TX UT VT VA WA WV WI ' +
            'WY').split(' ').map(function(state) {
                return {abbrev: state};
              })
>>>>>>> Stashed changes
    }
}

export const UpdateProfileFormComponent = {
    templateUrl: './views/app/components/update-profile-form/update-profile-form.component.html',
    controller: UpdateProfileFormController,
    controllerAs: 'vm',
    bindings: {}
}
