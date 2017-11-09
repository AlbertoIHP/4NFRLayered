import { Component, OnInit, Inject, ViewChild } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { MatDatepicker, MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material'
import * as moment from 'moment'
import { EventService } from '../../../../../Services/events.service'


@Component({
  selector: 'app-editgoal',
  templateUrl: './editgoal.component.html',
  styleUrls: ['./editgoal.component.css']
})
export class EditgoalComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup
  private isntGeneralInfo: boolean
  private isntSigthInfo: boolean

  private newGoal: any
  private totalRelevances: any
  private goalService: any
  private totalStakeholders: any


  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<EditgoalComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
    ){

    this.isntSigthInfo = true
    this.isntGeneralInfo = true
    this.newGoal = data.goal
    this.totalRelevances = data.relevances
    this.totalStakeholders = data.stakeholders
    this.goalService = data.goalService
    this.newGoal.date = moment().format('l')
    this.newGoal.time = moment().format('LT')
  }

  onNoClick()
  {
    this.dialogRef.close();
  }

  checkGeneralInfo()
  {
    if( this.newGoal.name != '' && this.newGoal.description != '' )
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
    if( this.newGoal.relevances_id != ''  && this.newGoal.stakeholders_id != '')
    {
      this.isntSigthInfo = false
    }
    else
    {
      this.isntSigthInfo = true
    }
  }


  editGoal()
  {

    this.goalService.editGoal(this.newGoal, this.newGoal.id).subscribe( data => {
      this.events.reportChange()
      this.onNoClick()
    })
  }
  ngOnInit() {
  }

}
