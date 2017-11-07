import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Project } from '../Models/Project.model';


@Injectable()
export class ProjectService {
  public base: string = "http://localhost:8000/api/v1/projects/";
  public options: RequestOptions;
  public headers: Headers;

  constructor(private http: Http, private authenticationService: AuthenticationService)
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
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerProject(proj: Project)
  {
    return this.http.post( this.base, JSON.stringify(proj), this.options).map((res: Response) => res.json());

  }

  getProject(id) : Observable<Project>
  {
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editProject(proj: Project, id: number)
  {
    return this.http.put(this.base+id, JSON.stringify(proj), this.options).map((res: Response) => res.json());
  }

  deleteProject(id) {
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

