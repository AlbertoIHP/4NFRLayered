import { NgModule }             from '@angular/core';
import { RouterModule, Routes } from '@angular/router';


import { SharedComponent } from '../Components/shared/shared.component'
import { ProjectComponent } from '../Components/project/project.component'
import { EditprojectComponent } from '../Components/project/editproject/editproject.component'
import { ViewprojectComponent } from '../Components/project/viewproject/viewproject.component'
import { AdminComponent } from '../Components/admin/admin.component'
import { LoginComponent } from '../Components/login/login.component'

const routes: Routes =
[
   { path: '',  component: ProjectComponent },
   { path: 'edit',  component: EditprojectComponent },
   { path: 'view',  component: ViewprojectComponent },
   { path: 'admin',  component: AdminComponent },
   { path: 'login',  component: LoginComponent },
   { path: 'shared',  component: SharedComponent }
];

export const appRoutingProviders: any[] = [

];

export const routing = RouterModule.forRoot(routes);

