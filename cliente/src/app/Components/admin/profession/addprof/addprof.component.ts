import { Component, OnInit, Inject } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material'
import { EventService } from '../../../../Services/events.service'

@Component({
  selector: 'app-addprof',
  templateUrl: './addprof.component.html',
  styleUrls: ['./addprof.component.css']
})
export class AddprofComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup
  public newArea: any
  public areaService: any
  public goDescription: boolean
  public finish: boolean

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddprofComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
    )
  {
    this.goDescription = true
    this.finish = true
    this.newArea = data.profession
    this.areaService = data.professionService
  }

  addArea()
  {
    this.areaService.registerProfession(this.newArea).subscribe( data => {
      this.events.reportChange()
      this.onNoClick()
    })
  }

  onNoClick()
  {
    this.dialogRef.close();
  }

  checkName()
  {
    if(this.newArea.name != '')
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
    if(this.newArea.name != '' && this.newArea.description != '')
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
