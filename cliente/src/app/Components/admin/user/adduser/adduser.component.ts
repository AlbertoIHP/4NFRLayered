import { Component, OnInit, Inject } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material'
import { EventService } from '../../../../Services/events.service'

import { User } from '../../../../Models/User.model'
import { UserService } from '../../../../Services/user.service'

import { Project } from '../../../../Models/Project.model'
import { ProjectService } from '../../../../Services/project.service'

import { Stakeholder } from '../../../../Models/Stakeholder.model'
import { StakeholderService } from '../../../../Services/stakeholder.service'

import { Goal } from '../../../../Models/Goal.model'
import { GoalService } from '../../../../Services/goal.service'

import { Softgoal } from '../../../../Models/Softgoal.model'
import { SoftgoalService } from '../../../../Services/softgoal.service'

import { SoftgoalNfr } from '../../../../Models/SoftgoalNfr.model'
import { SoftgoalnfrService } from '../../../../Services/softgoalnfr.service'

import { NfrService } from '../../../../Services/nfr.service'

import * as moment from 'moment'



@Component({
  selector: 'app-adduser',
  templateUrl: './adduser.component.html',
  styleUrls: ['./adduser.component.css']
})
export class AdduserComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup
  public newUser: any
  public userService: any
  public totalProfessions: any
  public totalRoles: any
  public totalUsers: any
  public newProject: any
  public goDescription: boolean
  public finish: boolean

  public totalProjects: Project[]
  public totalStakeholders: Stakeholder[]
  public totalGoals: Goal[]
  public totalSoftgoals: Softgoal[]
  public user: User[]

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AdduserComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    public events: EventService,
    private projectService: ProjectService,
    private stakeholderService : StakeholderService,
    private goalService: GoalService,
    private softgoalService: SoftgoalService,
    private nfrService: SoftgoalnfrService,
    private non: NfrService,
    private usersService: UserService
    )
  {
    this.goDescription = true
    this.finish = true
    this.newUser = data.user
    this.userService = data.userService
    this.totalRoles = data.totalRoles
    this.totalUsers = data.totalUsers
    this.totalProfessions = data.totalProfessions

  }

  addUser()
  {
    console.log(this.newUser)
    this.userService.registerUser(this.newUser).subscribe(data => {
      this.events.reportChange()
      this.events.singUp(this.newUser)
      console.log(data);
    })
  }

  onNoClick()
  {
    this.dialogRef.close();
  }

  checkName()
  {



    if(this.newUser.name != '' && this.newUser.email != '' && this.newUser.password != '')
    {

      this.goDescription = false

    }
    else
    {
      this.goDescription = true
    }

      var existingEmail = this.totalUsers.filter( user => user.email === this.newUser.email )
      console.log(existingEmail)
      if(existingEmail.length >= 1)
      {
        alert("Este correo ya se encuentra registrado")
        this.goDescription = true
      }


  }

  checkDescription()
  {
    if(this.newUser.roles_id != '' && this.newUser.professions_id != '' )
    {


      this.finish = false
    }
    else
    {
      this.finish = true
    }
  }

  ngOnInit() {
    this.firstFormGroup = this._formBuilder.group({
      firstCtrl: ['', Validators.required]
    })
    this.secondFormGroup = this._formBuilder.group({
      secondCtrl: ['', Validators.required]
    })
  }

  normalizeData(todo : any)
  {
    return todo.data
  }

}
