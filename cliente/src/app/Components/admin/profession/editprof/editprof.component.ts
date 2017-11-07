import { Component, OnInit, Inject } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material'

@Component({
  selector: 'app-editprof',
  templateUrl: './editprof.component.html',
  styleUrls: ['./editprof.component.css']
})
export class EditprofComponent implements OnInit {
  public newArea: any
  public areaService: any
  public goDescription: boolean
  public finish: boolean

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<EditprofComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    )
  {
    this.goDescription = true
    this.finish = true
    this.newArea = data.profession
    this.areaService = data.professionService
  }

  editArea()
  {
    this.areaService.editProfession(this.newArea, this.newArea.id).subscribe( data => {
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

  }

}
