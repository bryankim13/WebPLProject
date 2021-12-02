import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';

import { AppComponent } from './app.component';
import { NavbarComponent } from './navbar/navbar.component';
import { WishlistComponent } from './wishlist/wishlist.component';

@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    WishlistComponent
  ],
  imports: [
    BrowserModule,
    FormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
