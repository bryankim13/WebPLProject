import { Component, OnInit } from '@angular/core';
import { Camera } from '../camera';
import {HttpClient, HttpErrorResponse,HttpParams } from '@angular/common/http';
import { subscribeOn } from 'rxjs';
@Component({
  selector: 'app-wishlist',
  templateUrl: './wishlist.component.html',
  styleUrls: ['./wishlist.component.css']
})
export class WishlistComponent implements OnInit {

  camera: Camera;
  confirmationMsg: string;
  brandNames: Array<string> = ["Sony","Nikon","Fujifilm","Canon","Panasonic","GoPro"];
  wishes: Array<Camera> = [];
  constructor( private http:HttpClient ) { 
    this.camera = new Camera("", "", "",0);
    this.confirmationMsg = "";
  }

  addWish(): void {
    this.confirmationMsg = "Added to your Wishlist!";
  }
  submitForm(data:any): void{
    let cam = new Camera(data.brand,data.model,data.lens,data.megapix);
    this.wishes.push(cam);
  }
  response:any;
  sendWishes():void{
    let json:string = JSON.stringify(this.wishes);
    this.http.post<any>("https://cs4640.cs.virginia.edu/bjk3yf/project/wishes.php", json).subscribe(
      (respData) => { this.response = respData},
      (error) => {console.log("Error: ",error);}
    );
  }
  ngOnInit(): void {
  }
  

}
