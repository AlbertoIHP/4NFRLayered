import { Injectable } from '@angular/core';
import { Http, Headers, RequestOptions, Response } from '@angular/http';
import { Observable } from 'rxjs';
import 'rxjs/add/operator/map';
import { AuthenticationService } from './authentication.service';
import { Category } from '../Models/Category.model';


@Injectable()
export class CategoryService {
  public base: string = "http://localhost:8000/api/v1/categories/";
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

  getCategories(): Observable<Category[]>
  {
    return this.http.get(this.base, this.options).map((res: Response) => res.json());
  }

  registerCategory(category: Category)
  {
    return this.http.post( this.base, JSON.stringify(category), this.options).map((res: Response) => res.json());

  }

  getCategory(id) : Observable<Category>
  {
    return this.http.get(this.base+id, this.options).map((res: Response) => res.json());
  }

  editCategory(category: Category, id: number)
  {
    return this.http.put(this.base+id, JSON.stringify(category), this.options).map((res: Response) => res.json());
  }

  deleteCategory(id) {
    return this.http.delete(this.base+id, this.options).map((res: Response) => res.json());
  }


}

