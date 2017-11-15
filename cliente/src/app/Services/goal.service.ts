import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Goal } from '../Models/Goal.model';
import { address } from './address'

@Injectable()
export class GoalService {
  public base: string = address+"/goals";
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

  getGoals(): Observable<Goal[]>
  {
    this.setToken()
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerGoal(goal: Goal)
  {
    this.setToken()
    return this.http.post( this.base, JSON.stringify(goal), this.options).map((res: Response) => res.json());

  }

  getGoal(id) : Observable<Goal>
  {
    this.setToken()
    return this.http.get(this.base+'/'+id, this.options).map((res: Response) => res.json());
  }

  editGoal(goal: Goal, id: number)
  {
    this.setToken()
    return this.http.put(this.base+'/'+id, JSON.stringify(goal), this.options).map((res: Response) => res.json());
  }

  deleteGoal(id)
  {
    this.setToken()
    return this.http.delete(this.base+'/'+id, this.options).map((res: Response) => res.json());
  }


}

