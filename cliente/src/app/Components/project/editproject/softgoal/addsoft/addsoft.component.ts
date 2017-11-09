import { Component, OnInit, Inject, ViewChild } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { MatDatepicker, MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material'
import * as moment from 'moment'
import { EventService } from '../../../../../Services/events.service'


@Component({
  selector: 'app-addsoft',
  templateUrl: './addsoft.component.html',
  styleUrls: ['./addsoft.component.css']
})
export class AddsoftComponent implements OnInit {
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
    public dialogRef: MatDialogRef<AddsoftComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
    ){
    this.newSoftgoal = data.softgoal
    this.totalRelevances = data.totalRelevances
    this.totalGoals = data.totalGoals
    this.softgoalService = data.softgoalService


    this.isntSigthInfo = true
    this.isntGeneralInfo = true
    this.newSoftgoal.date = moment().format('l')
    this.newSoftgoal.time = moment().format('LT')




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


  addSoftgoal()
  {

    console.log(this.newSoftgoal)

    this.softgoalService.registerSoftgoal(this.newSoftgoal).subscribe( data => {
      this.events.reportChange()
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
