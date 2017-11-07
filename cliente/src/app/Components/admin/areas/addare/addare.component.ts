import { Component, OnInit, Inject } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material'

@Component({
  selector: 'app-addare',
  templateUrl: './addare.component.html',
  styleUrls: ['./addare.component.css']
})
export class AddareComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup
  public newArea: any
  public areaService: any
  public goDescription: boolean
  public finish: boolean

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddareComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    )
  {
    this.goDescription = true
    this.finish = true
    this.newArea = data.area
    this.areaService = data.areaService
  }

  addArea()
  {
    this.areaService.registerArea(this.newArea).subscribe( data => {
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
