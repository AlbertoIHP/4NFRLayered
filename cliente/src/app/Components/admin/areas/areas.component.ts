import { Component, ElementRef, ViewChild, Inject, OnInit } from '@angular/core'

import { Area } from '../../../Models/Area.model'
import { AreaService } from '../../../Services/area.service'

import { AddareComponent } from './addare/addare.component'
import { EditareComponent } from './editare/editare.component'

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





@Component({
  selector: 'app-areas',
  templateUrl: './areas.component.html',
  styleUrls: ['./areas.component.css']
})
export class AreasComponent implements OnInit {
  public totalAreas: Area[]

  //DATATABLE
  @ViewChild(MatPaginator) paginator: MatPaginator
  @ViewChild('filter') filter: ElementRef
  public sourceDatatable: dataTable | null
  public sourcePorNombre: buscadorPorNombre | null
  public bdEstructura

  displayedColumns = ['Acciones', 'Nombre', 'Descripcion']
  public searchByName: boolean;


  constructor(
    public dialog: MatDialog,
    public areaService: AreaService
    )
  {
    this.searchByName = false
    this.totalAreas = []
    this.getAreas()

  }

  getAreas()
  {
    this.areaService.getAreas().subscribe( data => {
      this.totalAreas = this.normalizeData(data)

      //Datatables
      this.bdEstructura = new ExampleDatabase(this.totalAreas );
      this.sourceDatatable = new dataTable(this.bdEstructura, this.paginator);
      this.sourcePorNombre = new buscadorPorNombre(this.bdEstructura, 'area');
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
    let dialogRef = this.dialog.open(AddareComponent, {
      width: '1000px',
      data:
      {
       area: new Area(),
       areaService: this.areaService
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getAreas();
    });
  }


  openEditModal(area)
  {
    let areaAux = JSON.parse(JSON.stringify(area))

    let dialogRef = this.dialog.open(EditareComponent, {
      width: '1000px',
      data:
      {
       area: areaAux,
       areaService: this.areaService
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getAreas();
    });
  }


  deleteArea(area)
  {
    this.areaService.deleteArea(area.id).subscribe( data => {
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

  ngOnInit() {
  }

}
