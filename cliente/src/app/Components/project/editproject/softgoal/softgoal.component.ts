import { Component, ElementRef, ViewChild, Inject, OnInit } from '@angular/core'

import { EventService } from '../../../../Services/events.service'

import { Stakeholder } from '../../../../Models/Stakeholder.model'
import { StakeholderService } from '../../../../Services/stakeholder.service'

import { Goal } from '../../../../Models/Goal.model'
import { GoalService } from '../../../../Services/goal.service'

import { Relevance } from '../../../../Models/Relevance.model'
import { RelevanceService } from '../../../../Services/relevance.service'

import { Softgoal } from '../../../../Models/Softgoal.model'
import { SoftgoalService } from '../../../../Services/softgoal.service'

import { AddsoftComponent } from './addsoft/addsoft.component'
import { EditsoftComponent } from './editsoft/editsoft.component'


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
  selector: 'app-softgoal',
  templateUrl: './softgoal.component.html',
  styleUrls: ['./softgoal.component.css']
})
export class SoftgoalComponent implements OnInit {
  public totalGoals: Goal[]
  public totalStakeholders: Stakeholder[]
  public totalRelevances: Relevance[]
  public totalSoftgoals: Softgoal[]
  public userInfo: any
  public projectInfo: any
  public checkEvent: any



  //DATATABLE
  @ViewChild(MatPaginator) paginator: MatPaginator
  @ViewChild('filter') filter: ElementRef
  public sourceDatatable: dataTable | null
  public sourcePorNombre: buscadorPorNombre | null
  public bdEstructura

  displayedColumns = ['Acciones', 'Nombre', 'Descripcion', 'Goal', 'Relevancia', 'Fecha']
  public searchByName: boolean;



  constructor(
    public dialog: MatDialog,
    private events: EventService,
    private goalService: GoalService,
    private stakeholderService: StakeholderService,
    private relevanceService: RelevanceService,
    private softgoalService: SoftgoalService
    )
  {
    this.events.sharedHasClicked.subscribe( data => {
        this.checkEvent.unsubscribe()
    })

    this.events.adminHasClicked.subscribe( data => {
        this.checkEvent.unsubscribe()
    })

    this.events.projectHasClicked.subscribe( data => {
        this.checkEvent.unsubscribe()
    })


    this.checkEvent = this.events.openSoft.subscribe( data => {
      this.openAddModal()
    })

    this.events.hasChanged.subscribe( data => {
      this.getStakeholders()
    })

    this.totalGoals = []
    this.totalStakeholders = []
    this.totalRelevances = []
    this.totalSoftgoals = []
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

      this.getSoftgoals()

    })
  }

  getSoftgoals()
  {

    this.softgoalService.getSoftgoals().subscribe(data => {
      this.totalSoftgoals = this.normalizeData(data)
      let auxSoftgoals: any = []

      for ( let i = 0 ; i < this.totalSoftgoals.length ; i ++ )
      {
        for( let j = 0 ; j < this.totalGoals.length ; j ++ )
        {
          if( parseInt( this.totalSoftgoals[i].goals_id ) === this.totalGoals[j].id)
          {
            auxSoftgoals.push(this.totalSoftgoals[i])
            break
          }
        }
      }

      this.totalSoftgoals = auxSoftgoals

      this.idToString()

    })


  }

  idToString()
  {
    for ( let j = 0 ; j < this.totalSoftgoals.length ; j ++ )
    {

      var currentGoal = this.totalGoals.filter( goal => goal.id === parseInt(this.totalSoftgoals[j].goals_id) )
      var currentRelevance = this.totalRelevances.filter( relevance => relevance.id === parseInt(this.totalSoftgoals[j].relevances_id) )
      this.totalSoftgoals[j].goals_id = currentGoal[0].name
      this.totalSoftgoals[j].relevances_id = currentRelevance[0].name
    }

      //Datatables
      this.bdEstructura = new ExampleDatabase(this.totalSoftgoals );
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
    let dialogRef = this.dialog.open(AddsoftComponent, {
      width: '1000px',
      data:
      {
        softgoal: new Softgoal(),
        totalStakeholders: this.totalStakeholders,
        totalGoals: this.totalGoals,
        totalRelevances: this.totalRelevances,
        softgoalService: this.softgoalService
      }
    });


  }



  stringToId(softgoal)
  {
    var currentGoal = this.totalGoals.filter( goal => goal.name === softgoal.goals_id)
    var currentRelevance = this.totalRelevances.filter( relevance => relevance.name === softgoal.relevances_id)
    softgoal.goals_id = currentGoal[0].id.toString()
    softgoal.relevances_id = currentRelevance[0].id.toString()


    return softgoal
  }




  openEditModal(pro)
  {
    let proAux = JSON.parse(JSON.stringify(pro))

    proAux = this.stringToId(proAux)

    let dialogRef = this.dialog.open(EditsoftComponent, {
      width: '1000px',
      data:
      {
        softgoal: proAux,
        totalStakeholders: this.totalStakeholders,
        totalGoals: this.totalGoals,
        totalRelevances: this.totalRelevances,
        softgoalService: this.softgoalService
      }
    });

  }


  deleteSoftgoal(pro)
  {
    this.softgoalService.deleteSoftgoal(pro.id).subscribe( data => {
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
