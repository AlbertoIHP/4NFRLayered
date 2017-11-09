import { EventService } from '../../Services/events.service'

import { Component, ElementRef, ViewChild, Inject, OnInit } from '@angular/core'

import { Profession } from '../../Models/Profession.model'
import { ProfessionService } from '../../Services/profession.service'

import { User } from '../../Models/User.model'
import { UserService } from '../../Services/user.service'

import { Role } from '../../Models/Role.model'
import { RoleService } from '../../Services/role.service'

import { AuthenticationService } from '../../Services/authentication.service'

import { AdduserComponent } from '../admin/user/adduser/adduser.component'

import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material';

import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  private user: any
  private password: any
  private totalUsers: User[]
  private totalRoles: Role[]
  private totalProfessions: Profession[]
  private arentFully = true

  constructor(
    public router: Router,
    private dialog: MatDialog,
    private professionService: ProfessionService,
    private userService: UserService,
    private roleService: RoleService,
    private events: EventService,
    private auth: AuthenticationService)
  {

    this.events.isSingOut.subscribe( data => {
      this.user = ''
      this.password = ''
    })

    this.events.isSingUp.subscribe( newUser => {
      this.user = newUser.email
      this.password = newUser.password
    } )

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
    })
  }

  normalizeData(todo : any)
  {
    return todo.data
  }

  ngOnInit() {
  }

  login()
  {
    this.auth.login(this.user, this.password).subscribe(data => {
      this.userService.getUsers().subscribe(data => {
        this.totalUsers = this.normalizeData(data)

        var currentUser = this.totalUsers.filter( user => user.email === this.user)

        localStorage.setItem('userInfo', JSON.stringify(currentUser[0]) )
      this.events.singIn()
      this.router.navigate([''])

      })



    })

  }

  singUp()
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

  checkData()
  {
    if(this.user != '' && this.password != '')
    {
      this.arentFully = false
    }
    else
    {
      this.arentFully = true
    }
  }

}
