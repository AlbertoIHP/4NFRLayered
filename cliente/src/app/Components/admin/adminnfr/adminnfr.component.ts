import { Component, ElementRef, ViewChild, Inject, OnInit } from '@angular/core'

import { Nfr } from '../../../Models/Nfr.model'
import { NfrService } from '../../../Services/nfr.service'

import { Category } from '../../../Models/Category.model'
import { CategoryService } from '../../../Services/category.service'

import { AddadmnfComponent } from './addadmnf/addadmnf.component';
import { EditadmnfComponent } from './editadmnf/editadmnf.component';

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
  selector: 'app-adminnfr',
  templateUrl: './adminnfr.component.html',
  styleUrls: ['./adminnfr.component.css']
})

export class AdminnfrComponent implements OnInit {
  public totalCategories: Category[]
  public totalNfrs: Nfr[]


  //DATATABLE
  @ViewChild(MatPaginator) paginator: MatPaginator
  @ViewChild('filter') filter: ElementRef
  public sourceDatatable: dataTable | null
  public sourcePorNombre: buscadorPorNombre | null
  public bdEstructura

  displayedColumns = ['Acciones', 'Nombre', 'Descripcion', 'Categoria']
  public searchByName: boolean;


  constructor(public dialog: MatDialog,
    public categoryService: CategoryService,
    public nfrService: NfrService,
    public events: EventService
    )
  {
    this.events.openNfr.subscribe( data => {
      this.openAddModal()
    })

    this.searchByName = false
    this.totalNfrs = []
    this.totalCategories = []
    this.getCategories()
  }



  getCategories()
  {
    this.categoryService.getCategories().subscribe( data => {
      this.totalCategories = this.normalizeData(data)
      this.getNfrs()
    })
  }

  getNfrs()
  {
    this.nfrService.getNfrs().subscribe( data => {
      this.totalNfrs = this.normalizeData(data)
      this.idToString()


      //Datatables
      this.bdEstructura = new ExampleDatabase(this.totalNfrs );
      this.sourceDatatable = new dataTable(this.bdEstructura, this.paginator);
      this.sourcePorNombre = new buscadorPorNombre(this.bdEstructura, 'nfr');
      Observable.fromEvent(this.filter.nativeElement, 'keyup')
          .debounceTime(150)
          .distinctUntilChanged()
          .subscribe(() => {
            if (!this.sourcePorNombre) { return; }
            this.sourcePorNombre.filter = this.filter.nativeElement.value;
          });

    })
  }

  idToString()
  {
    for ( let i = 0 ; i < this.totalNfrs.length ; i ++ )
    {
      let idCategory = this.totalNfrs[i].categories_id
      let currentCategory = this.totalCategories.filter( category => category.id === parseInt(idCategory))
      this.totalNfrs[i].categories_id = currentCategory[0].name
    }
  }

  stringToId(nfr: Nfr)
  {
    let nameCategory = nfr.categories_id
    let currentCategory = this.totalCategories.filter( category => category.name === nameCategory)

    nfr.categories_id = currentCategory[0].id.toString()

  }


  normalizeData(todo : any)
  {
    return todo.data
  }

  openAddModal()
  {
    let dialogRef = this.dialog.open(AddadmnfComponent, {
      width: '1000px',
      data:
      {
       nfr: new Nfr(),
       nfrService: this.nfrService,
       totalCategories: this.totalCategories
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getCategories();
    });
  }

  openEditModal(nfr)
  {
    let nfrAux = JSON.parse(JSON.stringify(nfr))

    this.stringToId(nfrAux)

    let dialogRef = this.dialog.open(EditadmnfComponent, {
      width: '1000px',
      data:
      {
       nfr: nfrAux,
       nfrService: this.nfrService,
       totalCategories: this.totalCategories
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.getCategories();
    });
  }

  deleteNfr(nfr)
  {
    this.nfrService.deleteNfr(nfr.id).subscribe(data => {
      this.getCategories()
    })
  }

  changeSearch()
  {
    this.searchByName = !this.searchByName
  }


  ngOnInit()
  {

  }

}
