
import { Router } from '@angular/router';
import { EventService } from './Services/events.service'
import { Component, ElementRef, ViewChild, Inject, OnInit } from '@angular/core'

import { Profession } from './Models/Profession.model'
import { ProfessionService } from './Services/profession.service'

import { User } from './Models/User.model'
import { UserService } from './Services/user.service'

import { Role } from './Models/Role.model'
import { RoleService } from './Services/role.service'

import { AdduserComponent } from './Components/admin/user/adduser/adduser.component'

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  public isLogeado = false

  constructor(  public router: Router, public events : EventService)
  {


    if( localStorage.getItem('currentUser') )
    {
      this.isLogeado = true
    }


    this.events.isSingIn.subscribe( data => {
      this.isLogeado = true
    } )

    this.events.isSingOut.subscribe( data => {
      this.isLogeado = false
    })

  }

  goProject()
  {
    this.router.navigate([''])
    this.events.clickProject()
  }

  goAdmin()
  {
    this.events.clickAdmin()
    this.router.navigate(['admin'])
  }

  singOut()
  {
    localStorage.clear()
    this.events.singOut()
    this.router.navigate(['login'])
  }
}
