import { Component, OnInit } from '@angular/core';
import { EventService } from '../../../../Services/events.service'
@Component({
  selector: 'app-softgoal',
  templateUrl: './softgoal.component.html',
  styleUrls: ['./softgoal.component.css']
})
export class SoftgoalComponent implements OnInit {

  constructor(private events: EventService)
  {
    this.events.openSoft.subscribe( data => {
      this.openAddModal()
    })
  }

  ngOnInit() {
  }

  openAddModal()
  {
    console.log("Soy soft debo abrirme")
  }
}
