

import { Router, ActivatedRoute } from '@angular/router';

import { Component, ElementRef, ViewChild, Inject, OnInit, OnChanges } from '@angular/core'

import { Area } from '../../Models/Area.model'
import { AreaService } from '../../Services/area.service'

import { Project } from '../../Models/Project.model'
import { ProjectService } from '../../Services/project.service'

import * as moment from 'moment'

import { EventService } from '../../Services/events.service'

import { AddprojectComponent } from './addproject/addproject.component'

import { EngineViewModel } from '../../Models/EngineViewModel.model'

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

import { ExampleDatabase, dataTable, buscadorPorNombre } from '../constants/constants';


import { Stakeholder } from '../../Models/Stakeholder.model'
import { StakeholderService } from '../../Services/stakeholder.service'

import { Goal } from '../../Models/Goal.model'
import { GoalService } from '../../Services/goal.service'

import { Softgoal } from '../../Models/Softgoal.model'
import { SoftgoalService } from '../../Services/softgoal.service'

import { SoftgoalNfr } from '../../Models/SoftgoalNfr.model'
import { SoftgoalnfrService } from '../../Services/softgoalnfr.service'

import { NfrService } from '../../Services/nfr.service'

@Component({
  selector: 'app-project',
  templateUrl: './project.component.html',
  styleUrls: ['./project.component.css']
})
export class ProjectComponent implements OnInit {
  public totalProjects: Project[]
  public totalAreas: Area[]
  public newProject: any
  public totalStakeholders: Stakeholder[]
  public totalGoals: Goal[]
  public totalSoftgoals: Softgoal[]


  //DATATABLE
  @ViewChild(MatPaginator) paginator: MatPaginator
  @ViewChild('filter') filter: ElementRef
  public sourceDatatable: dataTable | null
  public sourcePorNombre: buscadorPorNombre | null
  public bdEstructura

  displayedColumns = ['Acciones', 'Nombre', 'Descripcion', 'Area', 'Creacion', 'Deadline']
  public searchByName: boolean;
  public userInfo
  public alive: boolean

  private projectStakeholders: Stakeholder[]
  private projectGoals: Goal[]
  private projectSoftgoals: Softgoal[]
  private projectNfrs: SoftgoalNfr[]

  private auxProject: Project


  constructor(
    public dialog: MatDialog,
    private router: Router,
    private projectService: ProjectService,
    private areaService: AreaService,
    private events: EventService,
    private stakeholderService : StakeholderService,
    private goalService: GoalService,
    private softgoalService: SoftgoalService,
    private nfrService: SoftgoalnfrService,
    private non: NfrService)
  {
    this.alive = true

    this.events.clickProject()

    if(localStorage.getItem('currentUser'))
    {
      this.events.adminHasClicked.subscribe( data => {
        this.alive = false
      })

      this.events.editProjectHasClicked.subscribe( data => {
        this.alive = false
      })

      this.searchByName = false
      this.totalAreas = []
      this.totalProjects = []
      this.totalStakeholders = []
      this.userInfo = JSON.parse(localStorage.getItem('userInfo'))
      this.getAreas()
      

    }
    else
    {
      this.router.navigate(['login'])
    }
  }

  getAreas()
  {
    this.areaService.getAreas().subscribe( data => {
      this.totalAreas = this.normalizeData(data)
      this.getProjects()
    })
  }

  getProjects()
  {
    this.projectService.getProjects().subscribe(data => {
      this.totalProjects = this.normalizeData(data)

      this.totalProjects = this.totalProjects.filter(project => this.userInfo.id === parseInt(project.users_id))
      
      this.idToString()

    })
  }

  idToString()
  {
    for( let j = 0 ; j < this.totalProjects.length ; j ++ )
    {
      var currentArea = this.totalAreas.filter( area => area.id === parseInt(this.totalProjects[j].areas_id))

      this.totalProjects[j].areas_id = currentArea[0].name
    }


      //Datatables
      this.bdEstructura = new ExampleDatabase(this.totalProjects );
      this.sourceDatatable = new dataTable(this.bdEstructura, this.paginator);
      this.sourcePorNombre = new buscadorPorNombre(this.bdEstructura, 'project');
      Observable.fromEvent(this.filter.nativeElement, 'keyup')
          .debounceTime(150)
          .distinctUntilChanged()
          .subscribe(() => {
            if (!this.sourcePorNombre) { return; }
            this.sourcePorNombre.filter = this.filter.nativeElement.value;
          });
  }

  deleteProject(pro)
  {
    this.projectService.deleteProject(pro.id).subscribe( data => {
      this.getAreas()
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



  goEdit(project)
  {
    this.events.clickEditProject()
    localStorage.setItem('currentProject', JSON.stringify(project))
    this.router.navigate(['edit'])
  }


  goView(project)
  {

    this.auxProject = project

    this.stakeholderService.getStakeholders().subscribe( data => {

      this.projectStakeholders = this.normalizeData(data).filter( stakeholder => this.auxProject.id === parseInt(stakeholder.projects_id) )

      this.goalService.getGoals().subscribe( data => {

        this.projectGoals = []

        let aux = this.normalizeData(data)

        for ( let i = 0 ; i < aux.length ; i ++ )
        {
          for( let j = 0 ; j < this.projectStakeholders.length ; j ++ )
          {

            if( parseInt(aux[i].stakeholders_id) === this.projectStakeholders[j].id )
            {
              this.projectGoals.push(aux[i])
              break
            }

          }
        }

        this.softgoalService.getSoftgoals().subscribe( data => {

          let aux = this.normalizeData(data)
          this.projectSoftgoals = []

          for ( let i = 0 ; i < aux.length ; i ++ )
          {
            for( let j = 0 ; j < this.projectGoals.length ; j ++ )
            {

              if( parseInt(aux[i].goals_id) === this.projectGoals[j].id )
              {
                this.projectSoftgoals.push(aux[i])
                break
              }

            }
          }

          this.nfrService.getSoftgoalNfrs().subscribe( data => {
            let aux = this.normalizeData(data)
            this.projectNfrs = []


            for ( let i = 0 ; i < aux.length ; i ++ )
            {
              for( let j = 0 ; j < this.projectSoftgoals.length ; j ++ )
              {

                if( parseInt(aux[i].softgoals_id) === this.projectSoftgoals[j].id )
                {
                  this.projectNfrs.push(aux[i])
                  break
                }

              }
            }


            this.non.getNfrs().subscribe(data => {
              let engine = new EngineViewModel(this.projectStakeholders, this.projectGoals, this.projectSoftgoals, this.projectNfrs, this.normalizeData(data))

              localStorage.setItem('engine', JSON.stringify(engine))

              this.router.navigate(['view'])
            })







          })




        })


      })


    })



  }


  openAddModal()
  {
    let dialogRef = this.dialog.open(AddprojectComponent, {
      width: '1000px',
      data:
      {
        project: new Project(),
        projectService: this.projectService,
        areas: this.totalAreas

      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getAreas();
    });
  }
 
  ngOnInit() {
  }

}
