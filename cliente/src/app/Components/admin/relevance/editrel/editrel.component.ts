import { Component, OnInit, Inject } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material'
import { EventService } from '../../../../Services/events.service'



@Component({
  selector: 'app-editrel',
  templateUrl: './editrel.component.html',
  styleUrls: ['./editrel.component.css']
})
export class EditrelComponent implements OnInit {
  public newArea: any
  public areaService: any
  public goDescription: boolean
  public finish: boolean

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<EditrelComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
    )
  {
    this.goDescription = true
    this.finish = true
    this.newArea = data.relevance
    this.areaService = data.relevanceService
  }

  editArea()
  {
    this.areaService.editRelevance(this.newArea, this.newArea.id).subscribe( data => {
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
    if(this.newArea.name != '' && this.newArea.description != '')
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
    if(this.newArea.name != '' && this.newArea.description != '' && this.newArea.weigth != '')
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
