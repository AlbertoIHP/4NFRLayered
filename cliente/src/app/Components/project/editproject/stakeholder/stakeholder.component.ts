import { Component, ElementRef, ViewChild, Inject, OnInit } from '@angular/core'

import { EventService } from '../../../../Services/events.service'

import { Stakeholder } from '../../../../Models/Stakeholder.model'
import { StakeholderService } from '../../../../Services/stakeholder.service'

import { Profession } from '../../../../Models/Profession.model'
import { ProfessionService } from '../../../../Services/profession.service'

import { AddstakeComponent } from './addstake/addstake.component'
import { EditstakeComponent } from './editstake/editstake.component'


//Datatable
import {DataSource} from '@angular/cdk/collections';
import {MatPaginator} from '@angular/material';
import {BehaviorSubject} from 'rxjs/BehaviorSubject';
import {Observable} from 'rxjs/Observable';
import 'rxjs/add/operator/startWith';
import 'rxjs/add/observable/merge';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/debounceTime';
import 'rxjs/add/operator/distinctUntilChanged';
import 'rxjs/add/observable/fromEvent';
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material';

import { ExampleDatabase, dataTable, buscadorPorNombre } from '../../../constants/constants';



@Component({
  selector: 'app-stakeholder',
  templateUrl: './stakeholder.component.html',
  styleUrls: ['./stakeholder.component.css']
})
export class StakeholderComponent implements OnInit {
  public totalStakeholders: Stakeholder[]
  public totalProfessions: Profession[]
  public userInfo: any
  public projectInfo: any
  public checkEvent: any



  //DATATABLE
  @ViewChild(MatPaginator) paginator: MatPaginator
  @ViewChild('filter') filter: ElementRef
  public sourceDatatable: dataTable | null
  public sourcePorNombre: buscadorPorNombre | null
  public bdEstructura

  displayedColumns = ['Acciones', 'Nombre', 'Descripcion', 'Funcion', 'Profesion', 'Fecha']
  public searchByName: boolean;


  constructor(
    public dialog: MatDialog,
    private events: EventService,
    private professionService: ProfessionService,
    private stakeholderService: StakeholderService
    )
  {

    this.events.adminHasClicked.subscribe( data => {
        this.checkEvent.unsubscribe()
    })

    this.events.projectHasClicked.subscribe( data => {
        this.checkEvent.unsubscribe()
    })

    this.checkEvent = this.events.openStake.subscribe( data => {
      this.openAddModal()
    })

    this.events.hasChanged.subscribe( data => {
      this.getProfessions()
    })

    this.searchByName = false
    this.totalProfessions = []
    this.totalStakeholders = []
    this.userInfo = JSON.parse(localStorage.getItem('userInfo'))
    this.projectInfo = JSON.parse(localStorage.getItem('currentProject'))

    this.getProfessions()


  }

  getProfessions()
  {
    this.professionService.getProfessions().subscribe( data => {
      this.totalProfessions = this.normalizeData(data)
      this.getStakeholders()
    })
  }

  getStakeholders()
  {
    this.stakeholderService.getStakeholders().subscribe( data => {
      this.totalStakeholders = this.normalizeData(data)
      this.totalStakeholders = this.totalStakeholders.filter( stakeholder => this.projectInfo.id === parseInt(stakeholder.projects_id))
      this.idToString()

    })
  }

  idToString()
  {
    for( let j = 0 ; j < this.totalStakeholders.length ; j ++ )
    {
      var currentProfession = this.totalProfessions.filter( profession => profession.id === parseInt(this.totalStakeholders[j].professions_id))

     this.totalStakeholders[j].professions_id = currentProfession[0].name
     this.totalStakeholders[j].projects_id = this.projectInfo.name


    }

      //Datatables
      this.bdEstructura = new ExampleDatabase(this.totalStakeholders );
      this.sourceDatatable = new dataTable(this.bdEstructura, this.paginator);
      this.sourcePorNombre = new buscadorPorNombre(this.bdEstructura, 'area');
      Observable.fromEvent(this.filter.nativeElement, 'keyup')
          .debounceTime(150)
          .distinctUntilChanged()
          .subscribe(() => {
            if (!this.sourcePorNombre) { return; }
            this.sourcePorNombre.filter = this.filter.nativeElement.value;
          });

  }

  openAddModal()
  {
    let dialogRef = this.dialog.open(AddstakeComponent, {
      width: '1000px',
      data:
      {
       stakeholder: new Stakeholder(),
       stakeholderService: this.stakeholderService,
       professions: this.totalProfessions
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getProfessions();
    });
  }






  openEditModal(pro)
  {
    let proAux = JSON.parse(JSON.stringify(pro))

    let dialogRef = this.dialog.open(EditstakeComponent, {
      width: '1000px',
      data:
      {
       stakeholder: proAux,
       stakeholderService: this.stakeholderService,
       professions: this.totalProfessions
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getProfessions();
    });
  }


  deleteStakeholder(pro)
  {
    this.stakeholderService.deleteStakeholder(pro.id).subscribe( data => {
      this.getProfessions()
    })
  }

  normalizeData(todo : any)
  {
    return todo.data
  }

  changeSearch()
  {
    this.searchByName = !this.searchByName
  }


  ngOnInit() {
  }



}
