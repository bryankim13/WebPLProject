import { Component, OnInit } from '@angular/core';
import { Camera } from '../camera';
@Component({
  selector: 'app-wishlist',
  templateUrl: './wishlist.component.html',
  styleUrls: ['./wishlist.component.css']
})
export class WishlistComponent implements OnInit {

  camera: Camera;
  confirmationMsg: string;
  brandNames: Array<string> = ["Sony","Fujifilm","Nikon","Canon","GoPro","Panasonic"];
  wishes: Array<Camera> = [];
  constructor() { 
    this.camera = new Camera("Sony", "A7", "22mm",25);
    this.confirmationMsg = "";
  }

  tog_control = true;
  addWish(): void {
    this.confirmationMsg = "Added to your Wishlist!";
  }
  submitForm(data:any): void{
    let cam = new Camera(data.brand,data.model,data.lens,data.megaPix);
  }
  togIntro(): void {
    this.tog_control = !this.tog_control;
  }
  ngOnInit(): void {
  }
  

}
