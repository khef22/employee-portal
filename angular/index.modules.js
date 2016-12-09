angular.module('app', [
    'app.run',
	'app.filters',
	'app.services',
	'app.components',
    'app.directives',
	'app.routes',
	'app.config',
]);

angular.module('app.run', []);
angular.module('app.routes', []);
angular.module('app.filters', []);
angular.module('app.services', []);
angular.module('app.config', []);
angular.module('app.directives', []);
angular.module('app.components', [
<<<<<<< Updated upstream
	'ui.router', 'ngMaterial', 'angular-loading-bar',
	'restangular', 'ngStorage', 'satellizer'
=======
	'ui.router', 'ngMaterial', 'angular-loading-bar', 'md.data.table',
	'ngMessages', 'restangular', 'ngStorage', 'satellizer'
>>>>>>> Stashed changes
]);

