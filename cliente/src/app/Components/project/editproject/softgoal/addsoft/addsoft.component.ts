import { Component, OnInit, Inject, ViewChild } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { MatDatepicker, MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material'
import * as moment from 'moment'
import { EventService } from '../../../../../Services/events.service'


@Component({
  selector: 'app-addsoft',
  templateUrl: './addsoft.component.html',
  styleUrls: ['./addsoft.component.css']
})
export class AddsoftComponent implements OnInit {
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup
  private isntGeneralInfo: boolean
  private isntSigthInfo: boolean

  public newSoftgoal: any
  public totalRelevances: any
  public totalGoals: any
  public softgoalService: any
  private position = 'above';
  private infoNombre = "¿Qué es un subgoal? Un subgoal es es una característica específica que se puede desprender de un goal en particular. Por ejemplo: Goal: Agendar uso de quincho. Sofgoal: Agendar uso de quincho y ofrecer servicios adicionales";
  private infoDescripcion = "¿Para que describir un subgoal? Sirve para ser más específico con respecto al subgoal escrito ya que mediante su nombre hay información que quedará fuera. Por ejemplo: Agendar el uso de quincho tiene la posibilidad de agregar otros servicios para su utilización, por ejemplo, servicio de aseo posterior a su uso";
  private infoGoal = "¿Por qué seleccionar un Goal? Cada subgoal está relacionado directamente con un goal, puesto que un sofgoal es una especificación de un goal más genérico. Por ejemplo: Agendar uso de quincho";
  private infoRelevancia = "¿Qué es la relevancia de un subgoal? Permite saber lo importante que es para el sistema de software este softgoal. Por ejemplo: Relevante";

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddsoftComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    private events: EventService
    ){
    this.newSoftgoal = data.softgoal
    this.totalRelevances = data.totalRelevances
    this.totalGoals = data.totalGoals
    this.softgoalService = data.softgoalService


    this.isntSigthInfo = true
    this.isntGeneralInfo = true
    this.newSoftgoal.date = moment().format('l')
    this.newSoftgoal.time = moment().format('LT')




  }

  onNoClick()
  {
    this.dialogRef.close();
  }

  checkGeneralInfo()
  {
    if( this.newSoftgoal.name != '' && this.newSoftgoal.description != '' )
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
    if( this.newSoftgoal.relevances_id != ''  && this.newSoftgoal.goals_id != '')
    {
      this.isntSigthInfo = false
    }
    else
    {
      this.isntSigthInfo = true
    }
  }


  addSoftgoal()
  {

    console.log(this.newSoftgoal)

    this.softgoalService.registerSoftgoal(this.newSoftgoal).subscribe( data => {
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
