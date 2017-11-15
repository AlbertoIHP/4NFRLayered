import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { EventService } from '../../../../Services/events.service'

import { SharedService } from '../../../../Services/shared.service'
import { UserService } from '../../../../Services/user.service'
import { Shared } from '../../../../Models/Shared.model'


import { AddmateComponent } from '../../addmate/addmate.component'

import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material';
@Component({
  selector: 'app-collaborators',
  templateUrl: './collaborators.component.html',
  styleUrls: ['./collaborators.component.css'],
  encapsulation: ViewEncapsulation.None
})
export class CollaboratorsComponent implements OnInit {
  public collaborators: any
  public currentProject

  constructor(
    public dialog: MatDialog,
    private events: EventService,
    private sharedService: SharedService,
    private userService: UserService
    )
  {

    this.events.openAddMate.subscribe( data => {
      this.openAddModal()
    })


    this.refreshData()

  }

  refreshData()
  {
    this.currentProject = JSON.parse(localStorage.getItem('currentProject'))
    this.collaborators = []

    this.sharedService.index().subscribe( data => {
      var todo: any = data
      todo = todo.data
      this.collaborators = todo.filter( shared => parseInt(shared.projects_id) === this.currentProject.id )

      for( let i = 0 ; i < this.collaborators.length ; i ++ )
      {
        this.userService.getUser(this.collaborators[i].users_id).subscribe( data => {
            console.log(data)
            let aux: any = data
            aux = aux.data

            this.collaborators[i].users_id = aux.email
        })

      }


    })
  }

  deleteMate(collaborator)
  {
    this.sharedService.destroy(collaborator.id).subscribe(data => { console.log(data) })
    this.refreshData()
  }

  openAddModal()
  {
    let dialogRef = this.dialog.open(AddmateComponent, {
      width: '500px',
      data:
      {
        project: this.currentProject,
        userService: this.userService,
        sharedService: this.sharedService,
        shared: new Shared()
      }
    });

    dialogRef.afterClosed().subscribe(result => {

      this.refreshData();
    });
  }

  ngOnInit() {
  }

}
