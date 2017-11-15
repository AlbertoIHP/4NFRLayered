import { Component, ElementRef, ViewChild, Inject, OnInit } from '@angular/core'

import { Category } from '../../../Models/Category.model'
import { CategoryService } from '../../../Services/category.service'

import { AddcategComponent } from './addcateg/addcateg.component'
import { EditcategComponent } from './editcateg/editcateg.component'

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

import { ExampleDatabase, dataTable, buscadorPorNombre } from '../../constants/constants';


import { EventService } from '../../../Services/events.service'


@Component({
  selector: 'app-categories',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.css']
})
export class CategoriesComponent implements OnInit {
  public totalCategories: Category[]

  //DATATABLE
  @ViewChild(MatPaginator) paginator: MatPaginator
  @ViewChild('filter') filter: ElementRef
  public sourceDatatable: dataTable | null
  public sourcePorNombre: buscadorPorNombre | null
  public bdEstructura
  public checkEvent: any

  displayedColumns = ['Acciones', 'Nombre']
  public searchByName: boolean;

  constructor(
    public dialog: MatDialog,
    public categoryService: CategoryService,
    public events: EventService
    )
  {    this.events.sharedHasClicked.subscribe( data => {
        this.checkEvent.unsubscribe()
    })

    this.events.projectHasClicked.subscribe( data => {
      this.checkEvent.unsubscribe()
    })

    this.events.editProjectHasClicked.subscribe( data => {
        this.checkEvent.unsubscribe()
    })

    this.checkEvent = this.events.openCategory.subscribe( data => {
      this.openAddModal()
    })

    this.events.hasChanged.subscribe( data => {
      this.getCategories()
    })

    this.searchByName = false
    this.totalCategories = []
    this.getCategories()
  }

  getCategories()
  {
    this.categoryService.getCategories().subscribe( data => {
      this.totalCategories = this.normalizeData(data)

      //Datatables
      this.bdEstructura = new ExampleDatabase(this.totalCategories );
      this.sourceDatatable = new dataTable(this.bdEstructura, this.paginator);
      this.sourcePorNombre = new buscadorPorNombre(this.bdEstructura, 'categories');
      Observable.fromEvent(this.filter.nativeElement, 'keyup')
          .debounceTime(150)
          .distinctUntilChanged()
          .subscribe(() => {
            if (!this.sourcePorNombre) { return; }
            this.sourcePorNombre.filter = this.filter.nativeElement.value;
          });
    })
  }


  openAddModal()
  {
    let dialogRef = this.dialog.open(AddcategComponent, {
      width: '1000px',
      data:
      {
       category: new Category(),
       categoryService: this.categoryService
      }
    });

    dialogRef.afterClosed().subscribe(result => {

    });
  }



  openEditModal(area)
  {
    let areaAux = JSON.parse(JSON.stringify(area))

    let dialogRef = this.dialog.open(EditcategComponent, {
      width: '1000px',
      data:
      {
       category: areaAux,
       categoryService: this.categoryService
      }
    });

    dialogRef.afterClosed().subscribe(result => {

    });
  }


  deleteCategory(area)
  {
    this.categoryService.deleteCategory(area.id).subscribe( data => {
      this.events.reportChange()
      this.getCategories()
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
