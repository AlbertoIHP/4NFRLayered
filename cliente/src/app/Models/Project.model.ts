export class Project {
  public id: number
  public name: string
  public description: string
  public time: string
  public date: string
  public users_id: string
  public areas_id: string
  public deadline: string

  constructor ()
  {
    this.id = 0
    this.name = ''
    this.description = ''
    this.time = ''
    this.date = ''
    this.users_id = ''
    this.areas_id = ''
    this.deadline = ''
  }
}
