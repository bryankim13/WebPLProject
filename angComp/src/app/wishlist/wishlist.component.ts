import { Component, OnInit } from '@angular/core';
import { Camera } from '../camera';
@Component({
  selector: 'app-wishlist',
  templateUrl: './wishlist.component.html',
  styleUrls: ['./wishlist.component.css']
})
export class WishlistComponent implements OnInit {

  camera: Camera;

  constructor() { 
    this.camera = new Camera("Sony", "A7", "22mm",25);
  }

  alert(): void {
    alert("Your entry has been successfully submitted!");
  }

  ngOnInit(): void {
  }

}
