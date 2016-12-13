class DashboardController{

	constructor( API, ToastService ){
		'ngInject';

		this.API = API;
		this.ToastService = ToastService;		
	}

	$onInit(){

		this.query = {
			order: 'created_at',
			limit: 10,
			page: 1,
			type: 'all'
		};	
    
		this.getAnnouncements();
	}

	getAnnouncements(){

		this.showLoader = true;

		this.API.all('/announcements/list').post(this.query).then(function( response ){
		
			this.showLoader = false;
			this.showLoader = false;

			this.mainDataList = response.data;
			// console.log(this.mainDataList);
			
		}.bind(this));
	}
  
	paginateDataList( page ){
		// console.log(this);
	}

}

export const DashboardComponent = {
	templateUrl : './views/app/components/dashboard/dashboard.component.html',
	controller : DashboardController,
	controllerAs : 'dashboardCtrl',
	bindings : {}
}