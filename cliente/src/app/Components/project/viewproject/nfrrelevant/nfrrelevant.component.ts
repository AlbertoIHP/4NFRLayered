import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-nfrrelevant',
  templateUrl: './nfrrelevant.component.html',
  styleUrls: ['./nfrrelevant.component.css']
})
export class NfrrelevantComponent implements OnInit {

  public engine: any
  // Doughnut
  public goals:string[] // = ['Download Sales', 'In-Store Sales', 'Mail-Order Sales'];
  public data:any[]
  public detail: any
  public type:string = 'bar';

  constructor()
  {
    this.engine = JSON.parse(localStorage.getItem('engine'))
    this.goals = []
    this.data = [{data: [], label: 'Cantidad de repeticiones'}]

    let maxCost = -10000
    let costStake: any


    for ( let stake of this.engine.goalsPerNfr )
    {
      let aux = stake.goals

      if( aux.length > maxCost )
      {
        maxCost = aux.length
        costStake = stake
      }

      this.goals.push(stake.nfr)
      this.data[0].data.push(aux.length)
    }

    try {
        this.detail = "El nfr mas relevante es '"+costStake.nfr+"' con "+maxCost+" repeticiones"
    }
    catch(err) {
       this.detail = "No hay registros aun"
    }


  }

  ngOnInit() {
  }



  // events
  public chartClicked(e:any):void {
    console.log(e);
  }

  public chartHovered(e:any):void {
    console.log(e);
  }

}
