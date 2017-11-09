import { Component, OnInit, Inject, ViewChild } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { MatDatepicker, MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material'
import * as moment from 'moment'
import { EventService } from '../../../../../Services/events.service'

@Component({
  selector: 'app-editstake',
  templateUrl: './editstake.component.html',
  styleUrls: ['./editstake.component.css']
})
export class EditstakeComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup

  private totalProfessions: any
  private newStakeholder: any
  private stakeholderService: any
  private isntGeneralInfo: boolean
  private isntSigthInfo: boolean

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<EditstakeComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
    )


  {
    this.isntSigthInfo = true
    this.isntGeneralInfo = true
    this.totalProfessions = data.professions
    this.stakeholderService = data.stakeholderService
    this.newStakeholder = data.stakeholder
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


  editStakeholder()
  {
    console.log(this.newStakeholder)

    this.stakeholderService.editStakeholder(this.newStakeholder, this.newStakeholder.id).subscribe( data => {
      this.events.reportChange()
      this.onNoClick()
    })
  }

  ngOnInit() {
  }

}
