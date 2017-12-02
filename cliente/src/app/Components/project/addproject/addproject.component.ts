import { Component, OnInit, Inject, ViewChild } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { MatDatepicker, MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material'
import * as moment from 'moment'

@Component({
  selector: 'app-addproject',
  templateUrl: './addproject.component.html',
  styleUrls: ['./addproject.component.css']
})
export class AddprojectComponent implements OnInit {
  @ViewChild(MatDatepicker) datepicker: MatDatepicker<Date>;
  firstFormGroup: FormGroup
  secondFormGroup: FormGroup
  private newProject: any
  private totalAreas: any
  private projectService
  private isntGeneralInfo: boolean
  private isntSigthInfo: boolean
  private userInfo: any
  private position = 'above';
  private infoNombre = "¿Para qué sirve el nombre del proyecto? El nombre del proyecto es importante para que el usuario sea capaz de    identificar lo que está modelando. Se recomienda que sea descriptivo, para que en caso de tener muchos proyectos sea fácil de ubicar desde el panel de administración de proyectos. Por ejemplo: Sistema de administración de edificios";
  private infoDescripcion = "¿Cuál es la función de describir el proyecto? La descripción del proyecto permite tener una visión general del proyecto desde el panel de administración de proyectos ya que es más extenso que el nombre del proyecto. Por ejemplo: Este proyecto está orientado a realizar un software que permita realizar la administración uno o más edificios de manera sencilla para el usuario";
  private infoArea = "¿Qué es el área del proyecto? El área del proyecto es la sección en que el proyecto es clasificado, permite tener un orden con respecto al tipo de proyecto que se llevará acabo. Por ejemplo: Área administrativa";
  private infoFecha = "¿Qué es la fecha de término del proyecto? Esta es la fecha estimada en que se terminará el proyecto, permite que el usuario tenga claro el rango de tiempo que tiene el proyecto. Por ejemplo: 10 de Marzo del 2018";

  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddprojectComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    )
  {
    this.isntSigthInfo = true
    this.isntGeneralInfo = true

    this.newProject = data.project
    this.totalAreas = data.areas
    this.projectService = data.projectService

    this.userInfo = JSON.parse(localStorage.getItem('userInfo'))
    this.newProject.users_id = this.userInfo.id.toString()
    this.newProject.date = moment().format('l')
    this.newProject.time = moment().format('LT')


  }

  onNoClick()
  {
    this.dialogRef.close();
  }

  checkGeneralInfo()
  {
    if( this.newProject.name != '' && this.newProject.description != '' )
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
    if( this.newProject.areas_id != 0 && this.newProject.deadline != '' )
    {
      this.isntSigthInfo = false
    }
    else
    {
      this.isntSigthInfo = true
    }
  }


  addProject()
  {
    console.log(this.newProject.deadline)
    var splitted = this.newProject.deadline.toString().split(" ")
    var month = splitted[1]
    var day = splitted[2]
    var year = splitted[3]
    var newDate = month+"/"+day+"/"+year
    this.newProject.deadline = newDate

    this.projectService.registerProject(this.newProject).subscribe( data => {
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
