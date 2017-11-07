import { Component, ElementRef, ViewChild, Inject, OnInit } from '@angular/core'

import { Relevance } from '../../../Models/Relevance.model'
import { RelevanceService } from '../../../Services/relevance.service'

import { AddrelComponent } from './addrel/addrel.component'
import { EditrelComponent } from './editrel/editrel.component'

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
  selector: 'app-relevance',
  templateUrl: './relevance.component.html',
  styleUrls: ['./relevance.component.css']
})
export class RelevanceComponent implements OnInit {
  public totalRelevances: Relevance[]

  //DATATABLE
  @ViewChild(MatPaginator) paginator: MatPaginator
  @ViewChild('filter') filter: ElementRef
  public sourceDatatable: dataTable | null
  public sourcePorNombre: buscadorPorNombre | null
  public bdEstructura

  displayedColumns = ['Acciones', 'Nombre', 'Descripcion', 'Peso']
  public searchByName: boolean;


  constructor(
    public dialog: MatDialog,
    public relevanceService: RelevanceService
    )
  {
    this.searchByName = false
    this.totalRelevances = []
    this.getRelevances()
  }

  getRelevances()
  {
    this.relevanceService.getRelevances().subscribe( data => {
      this.totalRelevances = this.normalizeData(data)

      //Datatables
      this.bdEstructura = new ExampleDatabase(this.totalRelevances );
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
    let dialogRef = this.dialog.open(AddrelComponent, {
      width: '1000px',
      data:
      {
       relevance: new Relevance(),
       relevanceService: this.relevanceService
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getRelevances();
    });
  }




  openEditModal(pro)
  {
    let proAux = JSON.parse(JSON.stringify(pro))

    let dialogRef = this.dialog.open(EditrelComponent, {
      width: '1000px',
      data:
      {
       relevance: proAux,
       relevanceService: this.relevanceService
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getRelevances();
    });
  }


  deleteRelevance(pro)
  {
    this.relevanceService.deleteRelevance(pro.id).subscribe( data => {
      this.getRelevances()
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
