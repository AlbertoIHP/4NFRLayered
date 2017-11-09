import { Component, OnInit } from '@angular/core';
import { EventService } from '../../../../Services/events.service'
@Component({
  selector: 'app-nfr',
  templateUrl: './nfr.component.html',
  styleUrls: ['./nfr.component.css']
})
export class NfrComponent implements OnInit {

  constructor(private events: EventService)
  {
    this.events.openNon.subscribe( data => {
      this.openAddModal()
    } )
  }

  ngOnInit() {
  }

  openAddModal()
  {
    console.log("Soy nfr debo abrirme")
  }


}
