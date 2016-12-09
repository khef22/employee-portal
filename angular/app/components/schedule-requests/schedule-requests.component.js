class ScheduleRequestsController{

	constructor( API, ToastService, $state, $mdDialog ) {
		'ngInject';

		this.API = API;
		this.ToastService = ToastService;
		this.state = $state;
		this.$mdDialog = $mdDialog;
		this.ToastService = ToastService;
	}

	$onInit() {
		
		this.query = {
		    order: 'date_filed',
		    limit: 10,
		    page: 1
		};		

		this.fetchDataList();
	}

	fetchDataList(){

		this.showLoader = true;

		this.API.all('/requests/schedule/list').post(this.query).then(function( response ){
		
			this.showLoader = false;
			this.mainDataList = response.data;
			
		}.bind(this));
	}

	paginateDataList(){

		// console.info(this.mainDataList);

		// this.API.all(this.mainDataList.next_page_url).post(this.query).then(function( response ){
		// 	this.mainDataList = response.data;
		// });

	}


	logRequest(ev){

		this.$mdDialog.show({
	      
	      	controller: ScheduleRequestsDialogController,

	      	controllerAs : 'vmDialog',	      

	      	templateUrl: './views/app/components/schedule-requests/form-dialog.html',
	      	
	      	parent: angular.element(document.body),
	      	
	      	targetEvent: ev,
	      	
	      	clickOutsideToClose:false,	

	      	fullscreen : true,      	

	    });

	}
}

class ScheduleRequestsDialogController{

	constructor( $scope, $mdDialog, ToastService, API ){
		'ngInject';

		this.$scope = $scope;

		this.$mdDialog = $mdDialog;

		this.record = {};

		this.time_hours = [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ];

		this.time_minutes = [ '00', '15', '30', '45' ];

		this.time_am_pm = [ 'am', 'pm' ];	

		this.currentDate = new Date();

		this.currentDateTimeZone = this.currentDate.toTimeString().substr(9,6);

		this.ToastService = ToastService;

		this.API = API;		

		this.timezones = [
			"(GMT-12:00) International Date Line West",
			"(GMT-11:00) Midway Island, Samoa",
			"(GMT-10:00) Hawaii",
			"(GMT-09:00) Alaska",
			"(GMT-08:00) Pacific Time (US & Canada)",
			"(GMT-08:00) Tijuana, Baja California",
			"(GMT-07:00) Mountain Time (US & Canada)",
			"(GMT-07:00) Arizona",
			"(GMT-07:00) Chihuahua, La Paz, Mazatlan",
			"(GMT-06:00) Central Time (US & Canada)",
			"(GMT-06:00) Central America",
			"(GMT-06:00) Guadalajara, Mexico City, Monterrey",
			"(GMT-06:00) Saskatchewan",
			"(GMT-05:00) Eastern Time (US & Canada)",
			"(GMT-05:00) Bogota, Lima, Quito, Rio Branco",
			"(GMT-05:00) Indiana (East)",
			"(GMT-04:00) Atlantic Time (Canada)",
			"(GMT-04:00) Caracas, La Paz",
			"(GMT-04:00) Manaus",
			"(GMT-04:00) Santiago",
			"(GMT-03:30) Newfoundland",
			"(GMT-03:00) Brasilia",
			"(GMT-03:00) Buenos Aires, Georgetown",
			"(GMT-03:00) Greenland",
			"(GMT-03:00) Montevideo",
			"(GMT-02:00) Mid-Atlantic",
			"(GMT-01:00) Cape Verde Is",
			"(GMT-01:00) Azores",
			"(GMT+00:00) Casablanca, Monrovia, Reykjavik",
			"(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London",
			"(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna",
			"(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague",
			"(GMT+01:00) Brussels, Copenhagen, Madrid, Paris",
			"(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb",
			"(GMT+01:00) West Central Africa",
			"(GMT+02:00) Amman",
			"(GMT+02:00) Athens, Bucharest, Istanbul",
			"(GMT+02:00) Beirut",
			"(GMT+02:00) Cairo",
			"(GMT+02:00) Harare, Pretoria",
			"(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius",
			"(GMT+02:00) Jerusalem",
			"(GMT+02:00) Minsk",
			"(GMT+02:00) Windhoek",
			"(GMT+03:00) Kuwait, Riyadh, Baghdad",
			"(GMT+03:00) Nairobi",
			"(GMT+03:00) Tbilisi",
			"(GMT+03:30) Tehran",
			"(GMT+04:00) Abu Dhabi, Muscat",
			"(GMT+04:00) Baku",
			"(GMT+04:00) Moscow, St. Petersburg, Volgograd",
			"(GMT+04:00) Yerevan",
			"(GMT+04:30) Kabul",
			"(GMT+05:00) Yekaterinburg",
			"(GMT+05:00) Islamabad, Karachi, Tashkent",
			"(GMT+05:30) Sri Jayawardenapura",
			"(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi",
			"(GMT+05:45) Kathmandu",
			"(GMT+06:00) Almaty, Novosibirsk",
			"(GMT+06:00) Astana, Dhaka",
			"(GMT+06:30) Yangon (Rangoon)",
			"(GMT+07:00) Bangkok, Hanoi, Jakarta",
			"(GMT+07:00) Krasnoyarsk",
			"(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi",
			"(GMT+08:00) Kuala Lumpur, Singapore",
			"(GMT+08:00) Irkutsk, Ulaan Bataar",
			"(GMT+08:00) Perth",
			"(GMT+08:00) Taipei",
			"(GMT+09:00) Osaka, Sapporo, Tokyo",
			"(GMT+09:00) Seoul",
			"(GMT+09:00) Yakutsk",
			"(GMT+09:30) Adelaide",
			"(GMT+09:30) Darwin",
			"(GMT+10:00) Brisbane",
			"(GMT+10:00) Canberra, Melbourne, Sydney",
			"(GMT+10:00) Hobart",
			"(GMT+10:00) Guam, Port Moresby",
			"(GMT+10:00) Vladivostok",
			"(GMT+11:00) Magadan, Solomon Is., New Caledonia",
			"(GMT+12:00) Auckland, Wellington",
			"(GMT+12:00) Fiji, Kamchatka, Marshall Is.",
			"(GMT+13:00) Nuku",
		];   

		this.minDate = new Date();	

	}

	onlyZylunDays( date ){		
		return date.getDay() !== 0;		
	}


	$onInit(){
		console.info("Schedule Request Dialog is loaded.");
	}

	hideDialog(){
		this.$mdDialog.hide();
	}

	cancelDialog(){
		this.$mdDialog.cancel();
	}

	submitDialog(){		

		this.API.all('/requests/schedule/add').post(this.record).then(function( response ){
			if ( response.status ) {
    			this.ToastService.show('New Log Request successfully submitted.');
			}
		}.bind(this),function( xhr ){
			this.ToastService.error(xhr.statusText);
		}.bind(this));

	}

}


export const ScheduleRequestsComponent = {
	templateUrl : './views/app/components/schedule-requests/schedule-requests.component.html',
	controller : ScheduleRequestsController,
	controllerAs : 'scheduleRequestsCtrl',
	bindings : {}
}