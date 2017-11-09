import { Component, Inject, OnInit } from '@angular/core';
import {MatDialog, MatDialogRef, MAT_DIALOG_DATA} from '@angular/material';

import { RoleService } from '../../../../Services/role.service';
import { Role } from '../../../../Models/Role.model';



import { FunctionalityService } from '../../../../Services/functionality.service';
import { Functionality } from '../../../../Models/Functionality.model';


import { PermiseService } from '../../../../Services/permise.service';
import { Permise } from '../../../../Models/Permise.model';

import { EventService } from '../../../../Services/events.service'


@Component({
  selector: 'app-editrole',
  templateUrl: './editrole.component.html',
  styleUrls: ['./editrole.component.css']
})
export class EditroleComponent implements OnInit {
  public role: any;
  public totalModulos: Functionality[]
  public totalPM: Permise[]

  constructor(
    public dialogRef: MatDialogRef<EditroleComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    public servicioRole: RoleService,
    public servicioModulo: FunctionalityService,
    public servicioPM: PermiseService,
    private events: EventService
    )

  {

    this.totalPM = []
    this.role = data.role

   this.servicioModulo.getFunctionalities().subscribe( data => {
      var todo: any = data
      todo = todo.data

      this.totalModulos = todo

      this.servicioPM.getPermises().subscribe(data => {
        var todo: any = data
        todo = todo.data

        console.log(todo)
        console.log(this.role.id)

        this.totalPM = todo.filter( permiso => parseInt(permiso.roles_id) === this.role.id )




        for( let i = 0 ; i < this.totalPM.length ; i ++ )
        {
          var a: any = this.totalModulos.filter( modulo => modulo.id === parseInt(this.totalPM[i].functionalities_id) )

          a = a[0]

          this.totalPM[i].functionalities_id = a.name

          console.log(this.totalPM[i])

          this.totalPM[i].write === '0' ? this.totalPM[i].write = false : this.totalPM[i].write = true
          this.totalPM[i].erase === '0' ? this.totalPM[i].erase = false : this.totalPM[i].erase = true
          this.totalPM[i].update === '0' ? this.totalPM[i].update = false : this.totalPM[i].update = true
          this.totalPM[i].view === '0' ? this.totalPM[i].view =  false: this.totalPM[i].view = true

        }
        console.log(this.totalPM)

      })
    })


  }

  onNoClick()
  {
    this.dialogRef.close();
  }

  editarRole()
  {

    this.servicioRole.editRole(this.role, this.role.id).subscribe( data => {

      for( let j = 0 ; j < this.totalPM.length ; j ++ )
      {

        var module = this.totalModulos.filter( modulo => modulo.name === this.totalPM[j].functionalities_id)

        this.totalPM[j].functionalities_id = module[0].id.toString()


          this.totalPM[j].write === true ? this.totalPM[j].write ='1' : this.totalPM[j].write = '0'
          this.totalPM[j].erase === true ? this.totalPM[j].erase ='1' : this.totalPM[j].erase = '0'
          this.totalPM[j].update === true ? this.totalPM[j].update ='1' : this.totalPM[j].update = '0'
          this.totalPM[j].view === true ? this.totalPM[j].view = '1': this.totalPM[j].view = '0'


        console.log(this.totalPM[j])

        this.servicioPM.editPermise(this.totalPM[j], this.totalPM[j].id).subscribe(data => {
          console.log(data)
        })



      }


      this.events.reportChange()
      this.dialogRef.close();



    });
  }




  ngOnInit() {
  }

}
