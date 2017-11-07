import { Component, ElementRef, ViewChild, Inject, OnInit } from '@angular/core'

import { Profession } from '../../../Models/Profession.model'
import { ProfessionService } from '../../../Services/profession.service'

import { AddprofComponent } from './addprof/addprof.component'
import { EditprofComponent } from './editprof/editprof.component'

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
  selector: 'app-profession',
  templateUrl: './profession.component.html',
  styleUrls: ['./profession.component.css']
})
export class ProfessionComponent implements OnInit {
  public totalProfessions: Profession[]


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
    public professionService: ProfessionService
    )
  {
    this.searchByName = false
    this.totalProfessions = []
    this.getProfessions()
  }

  getProfessions()
  {
    this.professionService.getProfessions().subscribe( data => {
      this.totalProfessions = this.normalizeData(data)
      //Datatables
      this.bdEstructura = new ExampleDatabase(this.totalProfessions );
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
    let dialogRef = this.dialog.open(AddprofComponent, {
      width: '1000px',
      data:
      {
       profession: new Profession(),
       professionService: this.professionService
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getProfessions();
    });
  }



  openEditModal(pro)
  {
    let proAux = JSON.parse(JSON.stringify(pro))

    let dialogRef = this.dialog.open(EditprofComponent, {
      width: '1000px',
      data:
      {
       profession: proAux,
       professionService: this.professionService
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getProfessions();
    });
  }


  deleteProfession(pro)
  {
    this.professionService.deleteProfession(pro.id).subscribe( data => {
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
