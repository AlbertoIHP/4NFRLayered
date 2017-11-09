import { Component, OnInit, Inject } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material'
import { EventService } from '../../../../Services/events.service'


@Component({
  selector: 'app-editadmnf',
  templateUrl: './editadmnf.component.html',
  styleUrls: ['./editadmnf.component.css']
})
export class EditadmnfComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup
  public newNfr: any
  public totalCategories: any
  public nfrService: any
  public goCategory: boolean
  public finish: boolean

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<EditadmnfComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
    )
  {
    this.goCategory = true
    this.finish = true
    this.newNfr = data.nfr
    this.totalCategories = data.totalCategories
    this.nfrService = data.nfrService
  }

  ngOnInit()
  {
    this.firstFormGroup = this._formBuilder.group({
      firstCtrl: ['', Validators.required]
    })
    this.secondFormGroup = this._formBuilder.group({
      secondCtrl: ['', Validators.required]
    })
  }

  editNfr()
  {
    this.nfrService.editNfr(this.newNfr, this.newNfr.id).subscribe( data => {
      this.events.reportChange()
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
