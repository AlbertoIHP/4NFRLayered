import { Component, OnInit, Inject } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material'
import { EventService } from '../../../../Services/events.service'

@Component({
  selector: 'app-editcateg',
  templateUrl: './editcateg.component.html',
  styleUrls: ['./editcateg.component.css']
})
export class EditcategComponent implements OnInit {
  public newCategory: any
  public categoryService: any
  public finish: boolean

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<EditcategComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
    )
  {
    this.finish = true
    this.newCategory = data.category
    this.categoryService = data.categoryService
  }

  onNoClick()
  {
    this.dialogRef.close();
  }

  ngOnInit()
  {
  }

  editCategory()
  {
    this.categoryService.editCategory(this.newCategory, this.newCategory.id).subscribe( data => {
      this.events.reportChange()
      this.onNoClick()
    })
  }

  checkFinish()
  {
    if( this.newCategory.name != '')
    {
      this.finish = false
    }
    else
    {
      this.finish = true
    }
  }

}
