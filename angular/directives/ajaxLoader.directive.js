export function ajaxLoaderDirective() {

	return {
		
		restrict : 'E',

		transclude : true,

		template : '<div layout="row" ng-if="showLoader" layout-sm="column" layout-align="space-around">' 
			+ '<md-progress-linear md-mode="indeterminate"></md-progress-linear>'
			+ '</div>',
		scope : {
			showLoader : '=',
		}
	};	

}

	
	