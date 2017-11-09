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
  selector: 'app-addrole',
  templateUrl: './addrole.component.html',
  styleUrls: ['./addrole.component.css']
})
export class AddroleComponent implements OnInit {
  public nuevoRole: any;


  public totalModulos: Functionality[]
  public totalPM: Permise[]

  constructor(
    public dialogRef: MatDialogRef<AddroleComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    public servicioRole: RoleService,
    public servicioModulo: FunctionalityService,
    public servicioPM: PermiseService,
    private events: EventService
    )
  {
    this.totalModulos = []
    this.totalPM = []

    this.servicioModulo.getFunctionalities().subscribe( data => {
      var todo: any = data
      todo = todo.data

      this.totalModulos = todo


      for ( let j = 0 ; j < this.totalModulos.length ; j ++)
      {
        var a: Permise = new Permise()

        a.functionalities_id = this.totalModulos[j].name

        this.totalPM.push(a)

        console.log(a)
      }


    })




    this.nuevoRole = new Role();
  }


  onNoClick()
  {
    this.dialogRef.close();
  }

  agregarRole()
  {


    this.servicioRole.registerRole(this.nuevoRole).subscribe(data => {

      this.servicioRole.getRoles().subscribe(data => {
        var todo: any = data
        todo = todo.data

        var current = todo.filter( role => role.name === this.nuevoRole.name)

        console.log(current[0].id)

        for ( let j = 0 ; j < this.totalPM.length ; j ++ )
        {


          this.totalPM[j].roles_id = current[0].id


          var module = this.totalModulos.filter( modulo => modulo.name === this.totalPM[j].functionalities_id)


          this.totalPM[j].functionalities_id = module[0].id.toString()


          this.totalPM[j].write === true ? this.totalPM[j].write =1 : this.totalPM[j].write = 0
          this.totalPM[j].erase === true ? this.totalPM[j].erase =1 : this.totalPM[j].erase = 0
          this.totalPM[j].update === true ? this.totalPM[j].update =1 : this.totalPM[j].update = 0
          this.totalPM[j].view === true ? this.totalPM[j].view = 1: this.totalPM[j].view = 0




          console.log(this.totalPM[j])


          this.servicioPM.registerPermise(this.totalPM[j]).subscribe(data => {
            console.log(data)
          })


        }
        this.events.reportChange()

      })

      this.dialogRef.close();
    });



  }






escribir(permiso)
{
  permiso.write = !permiso.write
  console.log(permiso)
}


leer(permiso)
{
  permiso.view = !permiso.view
  console.log(permiso)
}


editar(permiso)
{
  permiso.update = !permiso.update
  console.log(permiso)
}


borrar(permiso)
{
  permiso.erase = !permiso.erase
  console.log(permiso)
}

  ngOnInit() {
  }

}
