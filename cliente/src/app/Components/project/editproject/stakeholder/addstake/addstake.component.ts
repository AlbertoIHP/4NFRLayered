import { Component, OnInit, Inject, ViewChild } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { MatDatepicker, MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material'
import * as moment from 'moment'
import { EventService } from '../../../../../Services/events.service'

@Component({
  selector: 'app-addstake',
  templateUrl: './addstake.component.html',
  styleUrls: ['./addstake.component.css']
})
export class AddstakeComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup

  private totalProfessions: any
  private newStakeholder: any
  private stakeholderService: any
  private isntGeneralInfo: boolean
  private isntSigthInfo: boolean

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddstakeComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
    )
  {
    this.isntSigthInfo = true
    this.isntGeneralInfo = true
    this.totalProfessions = data.professions
    this.stakeholderService = data.stakeholderService
    this.newStakeholder = data.stakeholder
    this.newStakeholder.date = moment().format('l')
    this.newStakeholder.time = moment().format('LT')
  }
  onNoClick()
  {
    this.dialogRef.close();
  }

  checkGeneralInfo()
  {
    if( this.newStakeholder.name != '' && this.newStakeholder.description != '' )
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
    if( this.newStakeholder.function != 0 && this.newStakeholder.professions_id != '' )
    {
      this.isntSigthInfo = false
    }
    else
    {
      this.isntSigthInfo = true
    }
  }


  addStakeholder()
  {
    console.log(this.newStakeholder)

    this.stakeholderService.registerStakeholder(this.newStakeholder).subscribe( data => {
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
