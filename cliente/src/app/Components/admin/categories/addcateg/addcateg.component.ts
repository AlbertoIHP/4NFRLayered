import { Component, OnInit, Inject } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material'
@Component({
  selector: 'app-addcateg',
  templateUrl: './addcateg.component.html',
  styleUrls: ['./addcateg.component.css']
})
export class AddcategComponent implements OnInit {
  public newCategory: any
  public categoryService: any
  public finish: boolean


  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddcategComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
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

  addCategory()
  {
    this.categoryService.registerCategory(this.newCategory).subscribe( data => {
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
