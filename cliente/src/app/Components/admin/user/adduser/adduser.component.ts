import { Component, OnInit, Inject } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material'
import { EventService } from '../../../../Services/events.service'

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

  public goDescription: boolean
  public finish: boolean

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AdduserComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    public events: EventService
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

}
