import { Component, OnInit, Inject, ViewChild, ViewEncapsulation } from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import { MatDatepicker, MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material'
import * as moment from 'moment'



@Component({
  selector: 'app-addmate',
  templateUrl: './addmate.component.html',
  styleUrls: ['./addmate.component.css'],
  encapsulation: ViewEncapsulation.None
})
export class AddmateComponent implements OnInit {
  private userService: any
  private sharedService: any
  private project: any
  private totalUser: any
  private newShared: any
  private userToFind: any
  private isntCorrect: any
  private currentUser: any
  private userToAdd: any
  private totalShared: any


  constructor(
    private _formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddmateComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
    )
  {
    this.currentUser = JSON.parse(localStorage.getItem('userInfo'))

    this.isntCorrect = true
    this.userToFind = ''

    this.project = data.project
    this.userService = data.userService
    this.sharedService = data.sharedService
    this.newShared = data.shared

    this.userService.getUsers().subscribe( data => {
      this.totalUser = this.normalizeData(data)
    })

    this.sharedService.index().subscribe( data => {
      this.totalShared = this.normalizeData(data)
    })


  }

  normalizeData(todo : any)
  {
    return todo.data
  }



  onNoClick()
  {
    this.dialogRef.close();
  }

  verifyUser()
  {

    this.isntCorrect = true




    if( this.currentUser.email != this.userToFind )
    {

      let aux = this.totalUser.filter( user => user.email === this.userToFind )

      if(aux[0])
      {
        if( aux[0].email === this.userToFind )
        {

          this.userToAdd = aux[0]

          let aux2 = this.totalShared.filter( shared => (parseInt(shared.users_id) === this.userToAdd.id &&  parseInt(shared.projects_id) === this.project.id) )
          console.log(aux2)

          if(!aux2[0])
          {
            this.isntCorrect = false
          }

          if(aux2[0])
          {
            alert("Este usuario ya ha sido invitado")
          }

        }

      }



    }


    if( this.currentUser.email === this.userToFind )
    {
      alert("¡ No puedes invitarte a ti mismo !")
    }
  }

  addMate()
  {
    this.newShared.users_id = this.userToAdd.id.toString()
    this.newShared.projects_id = this.project.id.toString()
    console.log(this.newShared)

    this.sharedService.store(this.newShared).subscribe( data => {
      console.log(data)
      this.onNoClick()
    })
  }

  ngOnInit() {
  }

}
