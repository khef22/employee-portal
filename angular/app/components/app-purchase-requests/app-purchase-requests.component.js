class AppPurchaseRequestsController{
    constructor(API){
        'ngInject';

        this.API = API;
    }

    $onInit(){
        this.query = {
            order: 'id',
            limit: 10,
            page: 1
        }; 

        this.getList('waiting-for-approval');
        self = this;
    }

    getList(status){
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

    paginateDataList(page, limit){
        self.query.page = page;
        self.getList('waiting-for-approval');
    }
}

export const AppPurchaseRequestsComponent = {
    templateUrl: './views/app/components/app-purchase-requests/app-purchase-requests.component.html',
    controller: AppPurchaseRequestsController,
    controllerAs: 'purchaseRequestsCtrl',
    bindings: {}
}
