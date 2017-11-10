export class EngineViewModel {
  public projectStakeholders: any
  public projectGoals: any
  public projectSoftgoals: any
  public projectNfrs: any
  public allNfrs: any
  public nfrsPerGoal: any
  public goalsPerNfr: any

  public matrixForMax: any


  constructor (stakes: any, goals: any, soft: any, nfrs: any, allnfrs: any)
  {
    this.projectStakeholders = stakes
    this.projectGoals = goals
    this.projectSoftgoals = soft
    this.projectNfrs = nfrs
    this.allNfrs = allnfrs
    this.filterNfrs()
    this.generateMatrix()
    this.captureGoalsPerNfr()
  }


  captureGoalsPerNfr()
  {

    let finalArray: any = []

    for( let i = 0 ; i < this.allNfrs.length ; i ++ )
    {
      finalArray.push({nfr: this.allNfrs[i].name, goals: []})

      for (let j = 0 ; j < this.nfrsPerGoal.length ; j ++ )
      {

        for(let nfr of this.nfrsPerGoal[j].nfrs)
        {

          if(nfr != '-')
          {
            if( nfr.id === this.allNfrs[i].id )
            {
              finalArray[i].goals.push(this.nfrsPerGoal[j].goal)
            }
          }


        }



      }
    }

    console.log(finalArray)
    this.goalsPerNfr = finalArray

  }


  generateMatrix()
  {
    let helper: any = []

    for ( let j = 0 ; j < this.projectGoals.length ; j ++ )
    {


      helper.push({ goal: this.projectGoals[j].name, nfrs: [] })



        let currentSoftgoal = this.projectSoftgoals.filter( soft => this.projectGoals[j].id === parseInt( soft.goals_id ) )

        let nfrDelGoal = []

        //Este bloque, lo que permite es capturar todos los NFR del GOAL, pasando por cada soft, y capturando sus NFR

        for ( let soft of currentSoftgoal)
        {
          let currentNfrs = this.projectNfrs.filter( nfr => parseInt(nfr.softgoals_id) === soft.id )


          for(let nfr of currentNfrs)
          {
            let nfrName = this.allNfrs.filter( non => non.id === parseInt(nfr.nfrs_id))

            nfrDelGoal.push(nfrName[0])
          }
        }


        //Aqui finalmente tenemos todos los NFR del GOAL

        for( let nfr of this.allNfrs )
        {
          let toPushed: any = '-'

          for ( let goalNfr of nfrDelGoal )
          {
            if ( goalNfr.id === nfr.id )
            {
              toPushed = goalNfr
              break
            }

          }
           helper[j].nfrs.push(toPushed)

        }


    }


    this.nfrsPerGoal = helper

  }


  filterNfrs()
  {
    let auxNfr: any = []

    for ( let j = 0 ; j < this.projectNfrs.length ; j ++ )
    {
      for( let i = 0 ; i < this.allNfrs.length ; i ++ )
      {

        if( parseInt(this.projectNfrs[j].nfrs_id) === this.allNfrs[i].id )
        {
          let check = auxNfr.filter( nfr => nfr.id === this.allNfrs[i].id )

          if(!(check.length >= 1))
          {
            auxNfr.push(this.allNfrs[i])
          }

        }

      }
    }

    this.allNfrs = auxNfr

  }


  getMaxRepeated()
  {

  }

  getMinRepeated()
  {

  }

}
