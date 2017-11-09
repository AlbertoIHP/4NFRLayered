import { Component, OnInit, Inject, ViewChild } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { MatDatepicker, MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material'
import * as moment from 'moment'
import { EventService } from '../../../../../Services/events.service'

@Component({
  selector: 'app-editsoft',
  templateUrl: './editsoft.component.html',
  styleUrls: ['./editsoft.component.css']
})
export class EditsoftComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup
  private isntGeneralInfo: boolean
  private isntSigthInfo: boolean

  public newSoftgoal: any
  public totalRelevances: any
  public totalGoals: any
  public softgoalService: any

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<EditsoftComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
    ){
    this.newSoftgoal = data.softgoal
    this.totalRelevances = data.totalRelevances
    this.totalGoals = data.totalGoals
    this.softgoalService = data.softgoalService


    this.isntSigthInfo = true
    this.isntGeneralInfo = true




  }

  onNoClick()
  {
    this.dialogRef.close();
  }

  checkGeneralInfo()
  {
    if( this.newSoftgoal.name != '' && this.newSoftgoal.description != '' )
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
    if( this.newSoftgoal.relevances_id != ''  && this.newSoftgoal.goals_id != '')
    {
      this.isntSigthInfo = false
    }
    else
    {
      this.isntSigthInfo = true
    }
  }


  editSoftgoal()
  {


    this.softgoalService.editSoftgoal(this.newSoftgoal, this.newSoftgoal.id).subscribe( data => {
      this.events.reportChange()
      this.onNoClick()
    })
  }

  ngOnInit() {
  }

}
