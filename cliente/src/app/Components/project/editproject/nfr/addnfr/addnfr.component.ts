import { Component, OnInit, Inject, ViewChild } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { MatDatepicker, MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material'
import * as moment from 'moment'
import { EventService } from '../../../../../Services/events.service'

import { CategoryService } from '../../../../../Services/category.service'

@Component({
  selector: 'app-addnfr',
  templateUrl: './addnfr.component.html',
  styleUrls: ['./addnfr.component.css']
})
export class AddnfrComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup
  private isntGeneralInfo: boolean
  private isntSigthInfo: boolean

  private newSoftgoalnfr: any
  private totalSoftgoals: any
  private totalNfrs: any
  private softgoalnfrService: any
  public totalCategories: any
  private nfrDetail: any

  public auxAllNfrs: any
  private position = 'above';
  private infoCategoria = "¿Qué es un NFR? Un Non Functional Requirements, está altamente relacionado con el concepto de calidad de software y en medida que estos se cumplan se podrán realizar métricas para analizarlos. Estos NFR se dividen en distintas categorías, las que pueden ser seleccionadas. Por ejemplo: Fiabilidad";
  private infoNFR = "Al seleccionar uno de los NFR de la lista, se mostrará una pequeña descripción de esta";
  private infoSoft = "¿Por qué elegir un subgoal? Los subgoals están altamente relacionados con los requerimientos no funcionales, y son una descomposición en detalle del Goal. Por ejemplo: Agendar el uso de quincho tiene la posibilidad de agregar otros servicios para su utilización";

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddnfrComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService,
    private categoryService: CategoryService
    ){

    this.totalCategories = []

    this.categoryService.getCategories().subscribe( data => {
      var todo: any = data
      this.totalCategories = todo.data
    })

    this.newSoftgoalnfr = data.softgoalnfr
    this.totalNfrs = data.totalNfrs
    this.totalSoftgoals = data.totalSoftgoals
    this.softgoalnfrService = data.softgoalnfrService

    this.isntSigthInfo = true
    this.isntGeneralInfo = true
    this.newSoftgoalnfr.date = moment().format('l')
    this.newSoftgoalnfr.time = moment().format('LT')

    this.auxAllNfrs = this.totalNfrs

  }

  changeCategory(category)
  {
    this.totalNfrs = this.auxAllNfrs.filter( nfr => parseInt(nfr.categories_id) === category.id)
  }

  selectedNfr(nfr)
  {
    this.nfrDetail = nfr.description
  }

  onNoClick()
  {
    this.dialogRef.close();
  }

  checkGeneralInfo()
  {
    if( this.newSoftgoalnfr.nfrs_id != '' )
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
    if( this.newSoftgoalnfr.softgoals_id != '' )
    {
      this.isntSigthInfo = false
    }
    else
    {
      this.isntSigthInfo = true
    }
  }


  addSoftgoalnfr()
  {


    this.softgoalnfrService.registerSoftgoalNfr(this.newSoftgoalnfr).subscribe( data => {
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
