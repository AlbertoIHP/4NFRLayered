import { Component, OnInit } from '@angular/core';
import { EventService } from '../../../../Services/events.service'

@Component({
  selector: 'app-goal',
  templateUrl: './goal.component.html',
  styleUrls: ['./goal.component.css']
})
export class GoalComponent implements OnInit {

  constructor(private events: EventService)
  {
    this.events.openGoal.subscribe( data => {
      this.openAddModal()
    })
  }

  ngOnInit() {
  }

  openAddModal()
  {
    console.log("Soy goal debo abrirme")
  }


}
