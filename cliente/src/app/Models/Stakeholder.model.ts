export class Stakeholder {
  public id: number
  public name: string
  public description: string
  public function: string
  public projects_id: string
  public professions_id: string
  public date: string
  public time: string

  constructor ()
  {
    this.id = 0
    this.name = ''
    this.description = ''
    this.function = ''
    this.projects_id = ''
    this.professions_id = ''
    this.date = ''
    this.time = ''
  }
}
