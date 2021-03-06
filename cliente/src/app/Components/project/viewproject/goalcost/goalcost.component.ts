import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-goalcost',
  templateUrl: './goalcost.component.html',
  styleUrls: ['./goalcost.component.css']
})
export class GoalcostComponent implements OnInit {

  public engine: any
  // Doughnut
  public goals:string[]
  public data:number[]
  public detail: any
  public type:string = 'polarArea';

  constructor()
  {
    this.engine = JSON.parse(localStorage.getItem('engine'))
    this.goals = []
    this.data = []

    let maxCost = -10000
    let costStake: any


    for ( let stake of this.engine.nfrsPerGoal )
    {
      let aux = stake.nfrs.filter( nfr => nfr != '-')

      if( aux.length > maxCost )
      {
        maxCost = aux.length
        costStake = stake
      }

      this.goals.push(stake.goal)
      this.data.push(aux.length)
    }

    try {
        this.detail = "El goal mas costoso es '"+costStake.goal+"' con "+maxCost+" NFR"
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
