import { Component, OnInit } from '@angular/core';
import { EventService } from '../../../../Services/events.service'

@Component({
  selector: 'app-stakeholder',
  templateUrl: './stakeholder.component.html',
  styleUrls: ['./stakeholder.component.css']
})
export class StakeholderComponent implements OnInit {

  constructor(private events: EventService)
  {
    this.events.openStake.subscribe( data => {
      this.openAddModal()
    })
  }

  ngOnInit() {
  }

  openAddModal()
  {
    console.log("Soy stake debo abrirme")
  }

}
