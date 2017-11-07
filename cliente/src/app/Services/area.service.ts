import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Area } from '../Models/Area.model';


@Injectable()
export class AreaService {
  public base: string = "http://localhost:8000/api/v1/areas/";
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

  getAreas(): Observable<Area[]>
  {
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerArea(area: Area)
  {
    return this.http.post( this.base, JSON.stringify(area), this.options).map((res: Response) => res.json());

  }

  getArea(id) : Observable<Area>
  {
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editArea(area: Area, id: number)
  {
    return this.http.put(this.base+id, JSON.stringify(area), this.options).map((res: Response) => res.json());
  }

  deleteArea(id) {
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

