import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Profession } from '../Models/Profession.model';


@Injectable()
export class ProfessionService {
  public base: string = "http://localhost:8000/api/v1/professions/";
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

  getProfessions(): Observable<Profession[]>
  {
    this.setToken()
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerProfession(prof: Profession)
  {
    this.setToken()
    return this.http.post( this.base, JSON.stringify(prof), this.options).map((res: Response) => res.json());

  }

  getProfession(id) : Observable<Profession>
  {
    this.setToken()
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editProfession(prof: Profession, id: number)
  {
    this.setToken()
    return this.http.put(this.base+id, JSON.stringify(prof), this.options).map((res: Response) => res.json());
  }

  deleteProfession(id)
  {
    this.setToken()
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

