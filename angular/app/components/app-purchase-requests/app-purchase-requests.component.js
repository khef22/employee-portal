class AppPurchaseRequestsController{
    constructor(API,$scope){
        'ngInject';

        this.API = API;
        this.$scope = $scope;
    }

    $onInit(){
        this.query = {
            order: 'id',
            limit: 10,
            page: 1,
            status: 'waiting-for-approval'
        }; 

        this.selected = [];
        this.getList();
        self = this;
    }

    getList(){
        this.showLoader = true;
        this.list = "";
        this.API.all('purchaserequest/list').post(this.query).then(
            function(response) {
                this.showLoader = false;
                this.total = response.purcahseRequestsList.total;
                this.list = response.purcahseRequestsList.data;
            }.bind(this)
        );
    }

    paginateDataList(){
        self.getList();
    }
}

export const AppPurchaseRequestsComponent = {
    templateUrl: './views/app/components/app-purchase-requests/app-purchase-requests.component.html',
    controller: AppPurchaseRequestsController,
    controllerAs: 'purchaseRequestsCtrl',
    bindings: {}
}
