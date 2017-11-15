//Modulos
import { HttpModule } from '@angular/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatNativeDateModule, MatDatepickerModule, MatListModule, MatStepperModule, MatCardModule, MatGridListModule, MatButtonToggleModule, MatTabsModule, MatInputModule , MatSelectModule, MatDialogModule, MatPaginatorModule, MatTableModule, MatButtonModule, MatCheckboxModule, MatSidenavModule, MatToolbarModule, MatMenuModule, MatIconModule, MatTooltipModule } from '@angular/material';
import { ChartsModule } from 'ng2-charts';

//Componentes
import { AppComponent } from './app.component';
import { ProjectComponent } from './Components/project/project.component';
import { EditprojectComponent } from './Components/project/editproject/editproject.component';
import { StakeholderComponent } from './Components/project/editproject/stakeholder/stakeholder.component';
import { GoalComponent } from './Components/project/editproject/goal/goal.component';
import { SoftgoalComponent } from './Components/project/editproject/softgoal/softgoal.component';
import { NfrComponent } from './Components/project/editproject/nfr/nfr.component';
import { AdminComponent } from './Components/admin/admin.component';
import { RoleComponent } from './Components/admin/role/role.component';
import { FunctionalityComponent } from './Components/admin/functionality/functionality.component';
import { AreasComponent } from './Components/admin/areas/areas.component';
import { ProfessionComponent } from './Components/admin/profession/profession.component';
import { RelevanceComponent } from './Components/admin/relevance/relevance.component';
import { CategoriesComponent } from './Components/admin/categories/categories.component';
import { AdminnfrComponent } from './Components/admin/adminnfr/adminnfr.component';
import { ViewprojectComponent } from './Components/project/viewproject/viewproject.component';
import { MappingComponent } from './Components/project/viewproject/mapping/mapping.component';
import { GoalcostComponent } from './Components/project/viewproject/goalcost/goalcost.component';
import { NfrrelevantComponent } from './Components/project/viewproject/nfrrelevant/nfrrelevant.component';
import { LoginComponent } from './Components/login/login.component';
import { UserComponent } from './Components/admin/user/user.component';
import { SharedComponent } from './Components/shared/shared.component';

import { AddstakeComponent } from './Components/project/editproject/stakeholder/addstake/addstake.component';
import { EditstakeComponent } from './Components/project/editproject/stakeholder/editstake/editstake.component';
import { AddsoftComponent } from './Components/project/editproject/softgoal/addsoft/addsoft.component';
import { EditsoftComponent } from './Components/project/editproject/softgoal/editsoft/editsoft.component';
import { AddnfrComponent } from './Components/project/editproject/nfr/addnfr/addnfr.component';
import { EditnfrComponent } from './Components/project/editproject/nfr/editnfr/editnfr.component';
import { AddgoalComponent } from './Components/project/editproject/goal/addgoal/addgoal.component';
import { EditgoalComponent } from './Components/project/editproject/goal/editgoal/editgoal.component';
import { AddroleComponent } from './Components/admin/role/addrole/addrole.component';
import { EditroleComponent } from './Components/admin/role/editrole/editrole.component';
import { AddrelComponent } from './Components/admin/relevance/addrel/addrel.component';
import { EditrelComponent } from './Components/admin/relevance/editrel/editrel.component';
import { AddprofComponent } from './Components/admin/profession/addprof/addprof.component';
import { EditprofComponent } from './Components/admin/profession/editprof/editprof.component';
import { AddfuncComponent } from './Components/admin/functionality/addfunc/addfunc.component';
import { EditfuncComponent } from './Components/admin/functionality/editfunc/editfunc.component';
import { AddcategComponent } from './Components/admin/categories/addcateg/addcateg.component';
import { EditcategComponent } from './Components/admin/categories/editcateg/editcateg.component';
import { AddareComponent } from './Components/admin/areas/addare/addare.component';
import { EditareComponent } from './Components/admin/areas/editare/editare.component';
import { AddadmnfComponent } from './Components/admin/adminnfr/addadmnf/addadmnf.component';
import { EditadmnfComponent } from './Components/admin/adminnfr/editadmnf/editadmnf.component';
import { AdduserComponent } from './Components/admin/user/adduser/adduser.component';
import { EdituserComponent } from './Components/admin/user/edituser/edituser.component';
import { AddprojectComponent } from './Components/project/addproject/addproject.component';
import { AddmateComponent } from './Components/project/addmate/addmate.component';










//Servicios
import { AuthenticationService } from './Services/authentication.service';
import { EventService } from './Services/events.service';
import { AreaService } from './Services/area.service';
import { CategoryService } from './Services/category.service';
import { FunctionalityService } from './Services/functionality.service';
import { GoalService } from './Services/goal.service';
import { NfrService } from './Services/nfr.service';
import { PermiseService } from './Services/permise.service';
import { ProfessionService } from './Services/profession.service';
import { ProjectService } from './Services/project.service';
import { RelevanceService } from './Services/relevance.service';
import { RoleService } from './Services/role.service';
import { SoftgoalService } from './Services/softgoal.service';
import { SoftgoalnfrService } from './Services/softgoalnfr.service';
import { StakeholderService } from './Services/stakeholder.service';
import { UserService } from './Services/user.service';
import { SharedService } from './Services/shared.service';
import { routing, appRoutingProviders } from './Routes/router.module';
import { CollaboratorsComponent } from './Components/project/editproject/collaborators/collaborators.component';



@NgModule({
  declarations: [
    AppComponent,
    ProjectComponent,
    EditprojectComponent,
    StakeholderComponent,
    GoalComponent,
    SoftgoalComponent,
    NfrComponent,
    AdminComponent,
    RoleComponent,
    FunctionalityComponent,
    AreasComponent,
    ProfessionComponent,
    RelevanceComponent,
    CategoriesComponent,
    AdminnfrComponent,
    ViewprojectComponent,
    MappingComponent,
    GoalcostComponent,
    NfrrelevantComponent,
    AddstakeComponent,
    EditstakeComponent,
    AddsoftComponent,
    EditsoftComponent,
    AddnfrComponent,
    EditnfrComponent,
    AddgoalComponent,
    EditgoalComponent,
    AddroleComponent,
    EditroleComponent,
    AddrelComponent,
    EditrelComponent,
    AddprofComponent,
    EditprofComponent,
    AddfuncComponent,
    EditfuncComponent,
    AddcategComponent,
    EditcategComponent,
    AddareComponent,
    EditareComponent,
    AddadmnfComponent,
    EditadmnfComponent,
    LoginComponent,
    UserComponent,
    AdduserComponent,
    EdituserComponent,
    AddprojectComponent,
    SharedComponent,
    AddmateComponent,
    CollaboratorsComponent
  ],

    entryComponents:
  [
    AddstakeComponent,
    EditstakeComponent,
    AddsoftComponent,
    EditsoftComponent,
    AddnfrComponent,
    EditnfrComponent,
    AddgoalComponent,
    EditgoalComponent,
    AddroleComponent,
    EditroleComponent,
    AddrelComponent,
    EditrelComponent,
    AddprofComponent,
    EditprofComponent,
    AddfuncComponent,
    EditfuncComponent,
    AddcategComponent,
    EditcategComponent,
    AddareComponent,
    EditareComponent,
    AddadmnfComponent,
    EditadmnfComponent,
    AdduserComponent,
    EdituserComponent,
    AddprojectComponent,
    AddmateComponent
  ],

  imports: [
    BrowserModule,
    routing,
    FormsModule,
    ReactiveFormsModule,
    HttpModule,
    BrowserAnimationsModule,
    MatButtonModule,
    MatCheckboxModule,
    MatSidenavModule,
    MatToolbarModule,
    MatMenuModule,
    MatIconModule,
    MatTableModule,
    MatPaginatorModule,
    MatDialogModule,
    MatInputModule,
    MatSelectModule,
    MatTabsModule,
    MatButtonToggleModule,
    MatGridListModule,
    MatCardModule,
    MatStepperModule,
    MatListModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatTooltipModule,
    ChartsModule
  ],
  providers: [
    AuthenticationService,
    EventService,
    appRoutingProviders,
    AreaService,
    CategoryService,
    FunctionalityService,
    GoalService,
    NfrService,
    PermiseService,
    ProfessionService,
    ProjectService,
    RelevanceService,
    RoleService,
    SoftgoalService,
    SoftgoalnfrService,
    StakeholderService,
    UserService,
    SharedService

  ],
  bootstrap: [AppComponent]
})


export class AppModule { }
