import { Component, OnInit, Inject, ViewChild } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { MatDatepicker, MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material'
import * as moment from 'moment'
import { EventService } from '../../../../../Services/events.service'

@Component({
  selector: 'app-addstake',
  templateUrl: './addstake.component.html',
  styleUrls: ['./addstake.component.css']
})
export class AddstakeComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup

  private totalProfessions: any
  private newStakeholder: any
  private stakeholderService: any
  private isntGeneralInfo: boolean
  private isntSigthInfo: boolean
  private position = 'above';
  private infoNombre = "¿Qué es un stakeholder? Un stakeholder es una persona que está interesada en utilizar el sistema, en general son los usuarios que usan el sistema y quienes son afectados por el funcionamiento de este de alguna manera. Por ejemplo: En un sistema de administración de edificios así se deberían ingresar los stakeholders: Conserje, Administrador, …, etc."
  private infoDescripcion = "¿Qué es la descripción de un stakeholder? Describe en forma general lo que hace un determinado stakeholder y cuales son sus características. Por ejemplo: Stakeholder conserje. Descripción: Se encarga de realizar acciones administrativas en el edificio, cuenta con determinados privilegios.";
  private infoFuncion = "¿Qué es la función de un stakeholder? La función de un stakeholder es la función que desempeñará cuando el sistema esté realizada, y permite saber de qué manera lo afectará. Por ejemplo: Stakeholder conserje. Función: Registrar uso de espacios comunes… etc.";
  private infoProfesion = "¿Qué es la profesión de un stakeholder? Es la profesión u oficio que realiza el stakeholder. Por ejemplo: Stakeholder conserje. Profesión: Conserje, Capacitación en Seguridad para Conserje";

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddstakeComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
    )
  {
    this.isntSigthInfo = true
    this.isntGeneralInfo = true
    this.totalProfessions = data.professions
    this.stakeholderService = data.stakeholderService
    this.newStakeholder = data.stakeholder
    this.newStakeholder.date = moment().format('l')
    this.newStakeholder.time = moment().format('LT')
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


  addStakeholder()
  {
    console.log(this.newStakeholder)

    this.stakeholderService.registerStakeholder(this.newStakeholder).subscribe( data => {
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
