export class User {
  public id: number
  public name: string
  public email: string
  public password: string
  public professions_id: string
  public roles_id: string


  constructor ()
  {
    this.id = 0
    this.name = ''
    this.email = ''
    this.password = ''
    this.professions_id = ''
    this.roles_id = ''
  }
}
