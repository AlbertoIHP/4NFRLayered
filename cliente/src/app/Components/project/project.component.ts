

import { Router, ActivatedRoute } from '@angular/router';

import { Component, ElementRef, ViewChild, Inject, OnInit, OnChanges } from '@angular/core'

import { Area } from '../../Models/Area.model'
import { AreaService } from '../../Services/area.service'

import { Project } from '../../Models/Project.model'
import { ProjectService } from '../../Services/project.service'



import { EventService } from '../../Services/events.service'

import { AddprojectComponent } from './addproject/addproject.component'


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



@Component({
  selector: 'app-project',
  templateUrl: './project.component.html',
  styleUrls: ['./project.component.css']
})
export class ProjectComponent implements OnInit {
  public totalProjects: Project[]
  public totalAreas: Area[]


  //DATATABLE
  @ViewChild(MatPaginator) paginator: MatPaginator
  @ViewChild('filter') filter: ElementRef
  public sourceDatatable: dataTable | null
  public sourcePorNombre: buscadorPorNombre | null
  public bdEstructura

  displayedColumns = ['Acciones', 'Nombre', 'Descripcion', 'Area', 'Creacion', 'Deadline']
  public searchByName: boolean;
  public userInfo


  constructor(
    public dialog: MatDialog,
    private router: Router,
    private projectService: ProjectService,
    private areaService: AreaService)
  {

    if(localStorage.getItem('currentUser'))
    {
      this.searchByName = false
      this.totalAreas = []
      this.totalProjects = []
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
    localStorage.setItem('currentProject', project)
    this.router.navigate(['edit'])
  }


  goView(project)
  {
    localStorage.setItem('currentProject', project)
    this.router.navigate(['view'])
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
