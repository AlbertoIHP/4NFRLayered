export class Goal {
  public id: number
  public name: string
  public description: string
  public stakeholders_id: string
  public relevances_id: string
  public date: string
  public time: string

  constructor ()
  {
    this.id = 0
    this.name = ''
    this.description = ''
    this.date = ''
    this.time = ''
    this.stakeholders_id = ''
    this.relevances_id = ''


  }
}
