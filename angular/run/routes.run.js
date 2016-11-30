export function RoutesRun($state, $auth, $transitions) {
    'ngInject';

    let requiresAuthCriteria = {
        to: ($state) => $state.data && $state.data.auth
    };

    let redirectToLogin = () => {
        'ngInject';
		console.log($auth);
        if (!$auth.isAuthenticated()) {
            return $state.target('app.login', undefined, {location: true});
        }
    };

    $transitions.onBefore(requiresAuthCriteria, redirectToLogin, {priority:10});

}