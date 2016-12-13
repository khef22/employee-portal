class ProfileController {
    constructor(API, $state, $mdToast) {
        'ngInject';

        this.API = API;
        this.$state = $state;
        this.$mdToast = $mdToast;
    }

    $onInit(){

        this.employee = {};
        this.fieldEditable = false;
        this.loaded = false;
        this.saving = false;

        this.loadField();
    }

    loadField() {
        this.API.one('profile').get().then(
            function(response) {
                this.employee = response;
                this.loaded = true;
            }.bind(this)
        );

    }

    saveProfile() {
        this.saving = true;
        this.API.all('profile/save').post(this.employee).then(function(){
            this.saving = false;
            this.fieldEditable = false;
            this.$mdToast.show(this.$mdToast.simple().textContent('Saved!'));
        }.bind(this));
    }
}

export const ProfileComponent = {
    templateUrl: './views/app/components/profile/profile.component.html',
    controller: ProfileController,
    controllerAs: 'vm',
    bindings: {}
}
