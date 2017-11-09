import { Component, OnInit, Inject, ViewChild } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { MatDatepicker, MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material'
import * as moment from 'moment'

@Component({
  selector: 'app-addproject',
  templateUrl: './addproject.component.html',
  styleUrls: ['./addproject.component.css']
})
export class AddprojectComponent implements OnInit {
  @ViewChild(MatDatepicker) datepicker: MatDatepicker<Date>;
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup
  private newProject: any
  private totalAreas: any
  private projectService
  private isntGeneralInfo: boolean
  private isntSigthInfo: boolean
  private userInfo: any

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddprojectComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    )
  {
    this.isntSigthInfo = true
    this.isntGeneralInfo = true

    this.newProject = data.project
    this.totalAreas = data.areas
    this.projectService = data.projectService

    this.userInfo = JSON.parse(localStorage.getItem('userInfo'))
    this.newProject.users_id = this.userInfo.id.toString()
    this.newProject.date = moment().format('l')
    this.newProject.time = moment().format('LT')


  }

  onNoClick()
  {
    this.dialogRef.close();
  }

  checkGeneralInfo()
  {
    if( this.newProject.name != '' && this.newProject.description != '' )
    {
      this.isntGeneralInfo = false
    }
    else
    {
      this.isntGeneralInfo = true
    }
  }
  checkSigthInfo()
  {
    if( this.newProject.areas_id != 0 && this.newProject.deadline != '' )
    {
      this.isntSigthInfo = false
    }
    else
    {
      this.isntSigthInfo = true
    }
  }


  addProject()
  {
    var splitted = this.newProject.deadline.toString().split(" ")
    var month = splitted[1]
    var day = splitted[2]
    var year = splitted[3]
    var newDate = month+"/"+day+"/"+year
    this.newProject.deadline = newDate

    this.projectService.registerProject(this.newProject).subscribe( data => {
      this.onNoClick()
    })
  }


  ngOnInit()
  {
    this.firstFormGroup = this._formBuilder.group({
      firstCtrl: ['', Validators.required]
    });
    this.secondFormGroup = this._formBuilder.group({
      secondCtrl: ['', Validators.required]
    });
  }

}
