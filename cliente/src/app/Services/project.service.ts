import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Project } from '../Models/Project.model';
import { address } from './address'

@Injectable()
export class ProjectService {
  public base: string = address+"/projects";
  public options: RequestOptions;
  public headers: Headers;

  constructor(private http: Http, private authenticationService: AuthenticationService)
  {
    this.setToken()
  }

  setToken()
  {
    this.headers = new Headers(
    {
      'Authorization': 'Bearer ' + this.authenticationService.token,
      'Content-Type': 'application/json'
    });

    this.options = new RequestOptions({ headers: this.headers });
  }

  getProjects(): Observable<Project[]>
  {
    this.setToken()
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerProject(proj: Project)
  {
    this.setToken()
    return this.http.post( this.base, JSON.stringify(proj), this.options).map((res: Response) => res.json());

  }

  getProject(id) : Observable<Project>
  {
    this.setToken()
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editProject(proj: Project, id: number)
  {
    this.setToken()
    return this.http.put(this.base+id, JSON.stringify(proj), this.options).map((res: Response) => res.json());
  }

  deleteProject(id)
  {
    this.setToken()
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

