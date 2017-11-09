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

import { SoftgoalNfr } from '../../../../Models/SoftgoalNfr.model'
import { SoftgoalnfrService } from '../../../../Services/softgoalnfr.service'

import { Nfr } from '../../../../Models/Nfr.model'
import { NfrService } from '../../../../Services/nfr.service'

import { AddnfrComponent } from './addnfr/addnfr.component'
import { EditnfrComponent } from './editnfr/editnfr.component'


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
  selector: 'app-nfr',
  templateUrl: './nfr.component.html',
  styleUrls: ['./nfr.component.css']
})
export class NfrComponent implements OnInit {
  public totalGoals: Goal[]
  public totalStakeholders: Stakeholder[]
  public totalRelevances: Relevance[]
  public totalSoftgoals: Softgoal[]
  public totalSoftgoalNfr: SoftgoalNfr[]
  public totalNfrs: Nfr[]
  public userInfo: any
  public projectInfo: any

  //DATATABLE
  @ViewChild(MatPaginator) paginator: MatPaginator
  @ViewChild('filter') filter: ElementRef
  public sourceDatatable: dataTable | null
  public sourcePorNombre: buscadorPorNombre | null
  public bdEstructura

  displayedColumns = ['Acciones', 'Nfr', 'Softgoal', 'Fecha']
  public searchByName: boolean;
  public checkEvent: any



  constructor(
    public dialog: MatDialog,
    private events: EventService,
    private goalService: GoalService,
    private stakeholderService: StakeholderService,
    private relevanceService: RelevanceService,
    private softgoalService: SoftgoalService,
    private softgoalnfrService: SoftgoalnfrService,
    private nfrService: NfrService
    )
  {

    this.events.adminHasClicked.subscribe( data => {
        this.checkEvent.unsubscribe()
    })

    this.events.projectHasClicked.subscribe( data => {
        this.checkEvent.unsubscribe()
    })

    this.checkEvent = this.events.openNon.subscribe( data => {
      this.openAddModal()
    } )

    this.events.hasChanged.subscribe( data => {
      this.getStakeholders()
    })

    this.totalNfrs = []
    this.totalGoals = []
    this.totalStakeholders = []
    this.totalRelevances = []
    this.totalSoftgoals = []
    this.totalSoftgoalNfr = []
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

      this.getNfrs()

    })


  }


  getNfrs()
  {
    this.nfrService.getNfrs().subscribe( data => {
      this.totalNfrs = this.normalizeData(data)
      this.getSoftgoalsnfrs()
    })
  }

  getSoftgoalsnfrs()
  {
    this.softgoalnfrService.getSoftgoalNfrs().subscribe( data => {

      this.totalSoftgoalNfr = this.normalizeData(data)
     let auxSoftNfrs: any = []

      for ( let i = 0 ; i < this.totalSoftgoalNfr.length ; i ++ )
      {
        for( let j = 0 ; j < this.totalSoftgoals.length ; j ++ )
        {
          if( parseInt( this.totalSoftgoalNfr[i].softgoals_id ) === this.totalSoftgoals[j].id)
          {
            auxSoftNfrs.push(this.totalSoftgoalNfr[i])
            break
          }
        }
      }

      this.totalSoftgoalNfr = auxSoftNfrs

      this.idToString()

    })
  }

  idToString()
  {
    for ( let j = 0 ; j < this.totalSoftgoalNfr.length ; j ++ )
    {

      var currentSoft = this.totalSoftgoals.filter( softgoal => softgoal.id === parseInt(this.totalSoftgoalNfr[j].softgoals_id))
      var currentNfr = this.totalNfrs.filter( nfr => nfr.id === parseInt(this.totalSoftgoalNfr[j].nfrs_id) )

      this.totalSoftgoalNfr[j].softgoals_id = currentSoft[0].name
      this.totalSoftgoalNfr[j].nfrs_id = currentNfr[0].name


      //Datatables
      this.bdEstructura = new ExampleDatabase(this.totalSoftgoalNfr );
      this.sourceDatatable = new dataTable(this.bdEstructura, this.paginator);
      this.sourcePorNombre = new buscadorPorNombre(this.bdEstructura, 'softgoalnfrs');
      Observable.fromEvent(this.filter.nativeElement, 'keyup')
          .debounceTime(150)
          .distinctUntilChanged()
          .subscribe(() => {
            if (!this.sourcePorNombre) { return; }
            this.sourcePorNombre.filter = this.filter.nativeElement.value;
          });

    }
  }

  openAddModal()
  {
    let dialogRef = this.dialog.open(AddnfrComponent, {
      width: '1000px',
      data:
      {
        softgoalnfr: new SoftgoalNfr(),
        totalSoftgoals: this.totalSoftgoals,
        totalNfrs: this.totalNfrs,
        softgoalnfrService: this.softgoalnfrService
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getStakeholders();
    });
  }









  openEditModal(pro)
  {
    let proAux = JSON.parse(JSON.stringify(pro))

    let dialogRef = this.dialog.open(EditnfrComponent, {
      width: '1000px',
      data:
      {
        softgoalnfr: proAux,
        totalSoftgoals: this.totalSoftgoals,
        totalNfrs: this.totalNfrs,
        softgoalnfrService: this.softgoalnfrService
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getStakeholders();
    });
  }


  deleteSoftgoal(pro)
  {
    this.softgoalService.deleteSoftgoal(pro.id).subscribe( data => {
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
