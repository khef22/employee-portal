import {AppPurchaseRequestsComponent} from './app/components/app-purchase-requests/app-purchase-requests.component';
import {AppSidenavComponent} from './app/components/app-sidenav/app-sidenav.component';
import {AppHeaderComponent} from './app/components/app-header/app-header.component';
import {AppRootComponent} from './app/components/app-root/app-root.component';
import {AppShellComponent} from './app/components/app-shell/app-shell.component';
import {ResetPasswordComponent} from './app/components/reset-password/reset-password.component';
import {ForgotPasswordComponent} from './app/components/forgot-password/forgot-password.component';
import {LoginFormComponent} from './app/components/login-form/login-form.component';
import {RegisterFormComponent} from './app/components/register-form/register-form.component';
import {ProfileComponent} from './app/components/profile/profile.component';


//Inject Schedule Request Component
import {ScheduleRequestsComponent} from './app/components/schedule-requests/schedule-requests.component';

//Dashboard/Announcements Component
import {DashboardComponent} from './app/components/dashboard/dashboard.component';

angular.module('app.components')
	.component('appPurchaseRequests', AppPurchaseRequestsComponent)
	.component('appSidenav', AppSidenavComponent)
	.component('appHeader', AppHeaderComponent)
	.component('appRoot', AppRootComponent)
	.component('appShell', AppShellComponent)
	.component('resetPassword', ResetPasswordComponent)
	.component('forgotPassword', ForgotPasswordComponent)
	.component('loginForm', LoginFormComponent)
	.component('registerForm', RegisterFormComponent)
	.component('scheduleRequests', ScheduleRequestsComponent)
	.component('dashboard', DashboardComponent)
	.component('profile', ProfileComponent);