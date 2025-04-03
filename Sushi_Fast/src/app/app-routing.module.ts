import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './component/home/home.component';
import { NosboxesComponent } from './component/nosboxes/nosboxes.component';
import { PanierComponent } from './component/panier/panier.component';
import { DetailsBoxesComponent } from './component/details-boxes/details-boxes.component';

const routes: Routes = [
  {path: '', component: HomeComponent},
  {path: 'nosboxes', component: NosboxesComponent},
  {path: 'panier', component: PanierComponent},
  {path: 'details-boxes/:id', component: DetailsBoxesComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
