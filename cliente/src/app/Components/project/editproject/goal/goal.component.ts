import { Component, ElementRef, ViewChild, Inject, OnInit } from '@angular/core'

import { EventService } from '../../../../Services/events.service'

import { Stakeholder } from '../../../../Models/Stakeholder.model'
import { StakeholderService } from '../../../../Services/stakeholder.service'

import { Goal } from '../../../../Models/Goal.model'
import { GoalService } from '../../../../Services/goal.service'

import { Relevance } from '../../../../Models/Relevance.model'
import { RelevanceService } from '../../../../Services/relevance.service'

import { AddgoalComponent } from './addgoal/addgoal.component'
import { EditgoalComponent } from './editgoal/editgoal.component'


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
  selector: 'app-goal',
  templateUrl: './goal.component.html',
  styleUrls: ['./goal.component.css']
})
export class GoalComponent implements OnInit {
  public totalGoals: Goal[]
  public totalStakeholders: Stakeholder[]
  public totalRelevances: Relevance[]
  public userInfo: any
  public projectInfo: any
  public checkEvent: any

  //DATATABLE
  @ViewChild(MatPaginator) paginator: MatPaginator
  @ViewChild('filter') filter: ElementRef
  public sourceDatatable: dataTable | null
  public sourcePorNombre: buscadorPorNombre | null
  public bdEstructura

  displayedColumns = ['Acciones', 'Nombre', 'Descripcion', 'Stakeholder', 'Relevancia', 'Fecha']
  public searchByName: boolean;

  constructor(
    public dialog: MatDialog,
    private events: EventService,
    private goalService: GoalService,
    private stakeholderService: StakeholderService,
    private relevanceService: RelevanceService
    )
  {

    this.events.adminHasClicked.subscribe( data => {
        this.checkEvent.unsubscribe()
    })

    this.events.projectHasClicked.subscribe( data => {
        this.checkEvent.unsubscribe()
    })

    this.checkEvent = this.events.openGoal.subscribe( data => {
      this.openAddModal()
    })

    this.events.hasChanged.subscribe( data => {
      this.getStakeholders()
    })

    this.totalGoals = []
    this.totalStakeholders = []
    this.totalRelevances = []
    this.userInfo = JSON.parse(localStorage.getItem('userInfo'))
    this.projectInfo = JSON.parse(localStorage.getItem('currentProject'))
    this.searchByName = false

    this.getStakeholders()



  }

  getStakeholders()
  {
    this.stakeholderService.getStakeholders().subscribe(data => {
      this.totalStakeholders = this.normalizeData(data)

      this.totalStakeholders = this.totalStakeholders.filter( stakeholder => parseInt(stakeholder.projects_id) === this.projectInfo.id)

      this.getRelevances()

    })
  }

  getRelevances()
  {
    this.relevanceService.getRelevances().subscribe( data => {
      this.totalRelevances = this.normalizeData(data)
      this.getGoals()
    })
  }


  getGoals()
  {
    this.goalService.getGoals().subscribe( data => {
      this.totalGoals = this.normalizeData(data)
      let auxGoals: any = []

      for ( let i = 0 ; i < this.totalGoals.length ; i ++ )
      {
        for( let j = 0 ; j < this.totalStakeholders.length ; j ++ )
        {
          if( parseInt( this.totalGoals[i].stakeholders_id ) === this.totalStakeholders[j].id)
          {
            auxGoals.push(this.totalGoals[i])
            break
          }
        }
      }

      this.totalGoals = auxGoals

      this.idToString()

    })
  }

  idToString()
  {
    for( let x = 0 ; x < this.totalGoals.length ; x ++ )
    {
      var currentStake = this.totalStakeholders.filter( stake => stake.id  === parseInt(this.totalGoals[x].stakeholders_id) )
      var currentrelevance = this.totalRelevances.filter( relevance => relevance.id === parseInt(this.totalGoals[x].relevances_id) )

      this.totalGoals[x].stakeholders_id = currentStake[0].name
      this.totalGoals[x].relevances_id = currentrelevance[0].name
    }

      //Datatables
      this.bdEstructura = new ExampleDatabase(this.totalGoals );
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
    let dialogRef = this.dialog.open(AddgoalComponent, {
      width: '1000px',
      data:
      {
       goal: new Goal(),
       goalService: this.goalService,
       stakeholders: this.totalStakeholders,
       relevances: this.totalRelevances
      }
    });
  }







  openEditModal(pro)
  {
    let proAux = JSON.parse(JSON.stringify(pro))

    let dialogRef = this.dialog.open(EditgoalComponent, {
      width: '1000px',
      data:
      {
       goal: proAux,
       goalService: this.goalService,
       stakeholders: this.totalStakeholders,
       relevances: this.totalRelevances
      }
    });
  }


  deleteGoal(pro)
  {
    this.goalService.deleteGoal(pro.id).subscribe( data => {
      this.events.reportChange()
      this.getStakeholders()
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
