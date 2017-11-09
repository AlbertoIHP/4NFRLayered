import { Component, OnInit, Inject } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material'
import { EventService } from '../../../../Services/events.service'

@Component({
  selector: 'app-edituser',
  templateUrl: './edituser.component.html',
  styleUrls: ['./edituser.component.css']
})
export class EdituserComponent implements OnInit {
  public newUser: any
  public userService: any
  public totalProfessions: any
  public totalRoles: any
  public totalUsers: any

  public goDescription: boolean
  public finish: boolean

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<EdituserComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
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
    this.userService.editUser(this.newUser,this.newUser.id).subscribe(data => {
      this.events.reportChange()
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
  }

}
