import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Goal } from '../Models/Goal.model';


@Injectable()
export class GoalService {
  public base: string = "http://localhost:8000/api/v1/goals/";
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

  getGoals(): Observable<Goal[]>
  {
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerGoal(goal: Goal)
  {
    return this.http.post( this.base, JSON.stringify(goal), this.options).map((res: Response) => res.json());

  }

  getGoal(id) : Observable<Goal>
  {
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editGoal(goal: Goal, id: number)
  {
    return this.http.put(this.base+id, JSON.stringify(goal), this.options).map((res: Response) => res.json());
  }

  deleteGoal(id) {
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

