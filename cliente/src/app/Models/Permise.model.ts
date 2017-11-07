export class Permise {
  public id: number
  public roles_id: string
  public functionalities_id: string
  public write: any
  public erase: any
  public update: any
  public view: any

  constructor ()
  {
    this.id = 0
    this.roles_id = ''
    this.functionalities_id = ''
    this.write = '0'
    this.erase = '0'
    this.update = '0'
    this.view = '0'
  }
}
