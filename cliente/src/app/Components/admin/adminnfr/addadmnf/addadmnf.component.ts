import { Component, OnInit, Inject } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material'

@Component({
  selector: 'app-addadmnf',
  templateUrl: './addadmnf.component.html',
  styleUrls: ['./addadmnf.component.css']
})
export class AddadmnfComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup
  public newNfr: any
  public totalCategories: any
  public nfrService: any
  public goCategory: boolean
  public finish: boolean

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddadmnfComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    )
  {
    this.goCategory = true
    this.finish = true
    this.newNfr = data.nfr
    this.totalCategories = data.totalCategories
    this.nfrService = data.nfrService
  }

  ngOnInit() {
    this.firstFormGroup = this._formBuilder.group({
      firstCtrl: ['', Validators.required]
    })
    this.secondFormGroup = this._formBuilder.group({
      secondCtrl: ['', Validators.required]
    })
  }

  addNfr()
  {
    this.nfrService.registerNfr(this.newNfr).subscribe( data => {
      this.onNoClick()
    })
  }

  checkCategory()
  {
    if(this.newNfr.name != '' && this.newNfr.description != '')
    {
      this.goCategory = false
    }
    else
    {
      this.goCategory = true
    }
  }

  checkFinish()
  {
    if(this.newNfr.name != '' && this.newNfr.description != '' && this.newNfr.categories_id != '')
    {
      this.finish = false
    }
    else
    {
      this.finish = true
    }
  }

  onNoClick()
  {
    this.dialogRef.close();
  }

}
