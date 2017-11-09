import { Component, ElementRef, ViewChild, Inject, OnInit, OnChanges } from '@angular/core'

import { Profession } from '../../../Models/Profession.model'
import { ProfessionService } from '../../../Services/profession.service'

import { User } from '../../../Models/User.model'
import { UserService } from '../../../Services/user.service'

import { Role } from '../../../Models/Role.model'
import { RoleService } from '../../../Services/role.service'


import { EventService } from '../../../Services/events.service'



import { AdduserComponent } from './adduser/adduser.component'
import { EdituserComponent } from './edituser/edituser.component'


//Datatable
import {DataSource} from '@angular/cdk/collections';
import {MatPaginator} from '@angular/material';
import {BehaviorSubject} from 'rxjs/BehaviorSubject';
import {Observable} from 'rxjs/Observable';
import 'rxjs/add/operator/startWith';
import 'rxjs/add/observable/merge';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/debounceTime';
import 'rxjs/add/operator/distinctUntilChanged';
import 'rxjs/add/observable/fromEvent';
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material';

import { ExampleDatabase, dataTable, buscadorPorNombre } from '../../constants/constants';


@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css']
})
export class UserComponent implements OnInit, OnChanges {
  public totalUsers: User[]
  public totalRoles: Role[]
  public totalProfessions: Profession[]

  //DATATABLE
  @ViewChild(MatPaginator) paginator: MatPaginator
  @ViewChild('filter') filter: ElementRef
  public sourceDatatable: dataTable | null
  public sourcePorNombre: buscadorPorNombre | null
  public bdEstructura

  displayedColumns = ['Acciones', 'Nombre', 'Correo', 'Profesion', 'Rol']
  public searchByName: boolean;
  public checkEvent: any


  constructor(
    public dialog: MatDialog,
    public professionService: ProfessionService,
    public userService: UserService,
    public roleService: RoleService,
    public events: EventService
    )
  {

    this.checkEvent = this.events.openUser.subscribe( data => {
      this.openAddModal()
    })

    this.events.projectHasClicked.subscribe( data => {
      this.checkEvent.unsubscribe()
    })

    this.events.editProjectHasClicked.subscribe( data => {
        this.checkEvent.unsubscribe()
    })


    this.events.hasChanged.subscribe( data => {
      this.getProfessions()
    })
    this.searchByName = false
    this.totalProfessions = []
    this.totalRoles = []
    this.totalUsers = []

    this.getProfessions()

  }


  getProfessions()
  {
    this.professionService.getProfessions().subscribe( data => {
      this.totalProfessions = this.normalizeData(data)
      this.getRoles()
    })
  }

  getRoles()
  {
    this.roleService.getRoles().subscribe( data => {
      this.totalRoles = this.normalizeData(data)
      this.getUsers()
    })
  }

  getUsers()
  {
    this.userService.getUsers().subscribe( data => {
      this.totalUsers = this.normalizeData(data)
      this.idToString()
    })
  }

  idToString()
  {
    for( let x = 0 ; x < this.totalUsers.length ; x ++ )
    {

      var currentRole = this.totalRoles.filter( role => role.id === parseInt(this.totalUsers[x].roles_id) )
      var currentProfession = this.totalProfessions.filter( profession => profession.id === parseInt(this.totalUsers[x].professions_id) )

      this.totalUsers[x].roles_id = currentRole[0].name
      this.totalUsers[x].professions_id = currentProfession[0].name

    }

      //Datatables
      this.bdEstructura = new ExampleDatabase(this.totalUsers );
      this.sourceDatatable = new dataTable(this.bdEstructura, this.paginator);
      this.sourcePorNombre = new buscadorPorNombre(this.bdEstructura, 'user');
      Observable.fromEvent(this.filter.nativeElement, 'keyup')
          .debounceTime(150)
          .distinctUntilChanged()
          .subscribe(() => {
            if (!this.sourcePorNombre) { return; }
            this.sourcePorNombre.filter = this.filter.nativeElement.value;
          });

  }

  openAddModal()
  {
    let dialogRef = this.dialog.open(AdduserComponent, {
      width: '1000px',
      data:
      {
       user: new User(),
       userService: this.userService,
       totalProfessions: this.totalProfessions,
       totalUsers: this.totalUsers,
       totalRoles: this.totalRoles

      }
    });

    dialogRef.afterClosed().subscribe(result => {

    });
  }




  openEditModal(pro)
  {
    let proAux = JSON.parse(JSON.stringify(pro))

    let dialogRef = this.dialog.open(EdituserComponent, {
      width: '1000px',
      data:
      {
       user: proAux,
       userService: this.userService,
       totalProfessions: this.totalProfessions,
       totalUsers: this.totalUsers,
       totalRoles: this.totalRoles
      }
    });

    dialogRef.afterClosed().subscribe(result => {

    });
  }


  deleteUser(pro)
  {
    this.userService.deleteUser(pro.id).subscribe( data => {
      this.events.reportChange()
      this.getProfessions()
    })
  }

  normalizeData(todo : any)
  {
    return todo.data
  }

  changeSearch()
  {
    this.searchByName = !this.searchByName
  }

  ngOnInit() {
    console.log("Hola me inicie soy usuario")
  }

  ngOnChanges()
  {
    console.log("algo cambiops")

  }

}
