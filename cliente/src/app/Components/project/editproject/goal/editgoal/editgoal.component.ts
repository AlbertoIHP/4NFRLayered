import { Component, OnInit, Inject, ViewChild } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { MatDatepicker, MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material'
import * as moment from 'moment'
import { EventService } from '../../../../../Services/events.service'


@Component({
  selector: 'app-editgoal',
  templateUrl: './editgoal.component.html',
  styleUrls: ['./editgoal.component.css']
})
export class EditgoalComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup
  private isntGeneralInfo: boolean
  private isntSigthInfo: boolean

  private newGoal: any
  private totalRelevances: any
  private goalService: any
  private totalStakeholders: any
  private position = 'above';
  private infoNombre = "¿Qué es un goal u objetivo? Es un objetivo que el stakeholder quiere alcanzar al utilizar el software. Por ejemplo: Conserje: Agendar uso de quincho";
  private infoDescripcion = "¿Para qué describir un goal? Permite saber que es lo que hace el goal de manera específica, detallando más de lo que se podría inferir del nombre: Por ejemplo: El conserje tendrá la capacidad de agendar hroas para el quincho dentro del horario preestablecido por el edificio y a las personas que acrediten ser parte de este";
  private infoRelevancia = "¿A que se refiere con relevancia del goal? Es en que medida el goal afectará al software final. Por ejemplo: La relevancia de este goal es relevante";
  private infoStakeholder = "¿Quién es el stakeholder de un goal? Es quien está interasado en el Goal específico Por ejemplo: Goal agendar uso de quincho. El stakeholder de este Goal ese el conserje";

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<EditgoalComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
    ){

    this.isntSigthInfo = true
    this.isntGeneralInfo = true
    this.newGoal = data.goal
    this.totalRelevances = data.relevances
    this.totalStakeholders = data.stakeholders
    this.goalService = data.goalService
    this.newGoal.date = moment().format('l')
    this.newGoal.time = moment().format('LT')
  }

  onNoClick()
  {
    this.dialogRef.close();
  }

  checkGeneralInfo()
  {
    if( this.newGoal.name != '' && this.newGoal.description != '' )
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
    if( this.newGoal.relevances_id != ''  && this.newGoal.stakeholders_id != '')
    {
      this.isntSigthInfo = false
    }
    else
    {
      this.isntSigthInfo = true
    }
  }


  editGoal()
  {

    this.goalService.editGoal(this.newGoal, this.newGoal.id).subscribe( data => {
      this.events.reportChange()
      this.onNoClick()
    })
  }
  ngOnInit() {
  }

}
