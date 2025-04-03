import { Component } from '@angular/core';
import { Panier } from '../../modules/Panier';
import { ManagePaniersService} from '../../service/manage-paniers.service';
import { LigneBoxes } from '../../modules/LigneBoxes';

@Component({
  selector: 'app-panier',
  templateUrl: './panier.component.html',
  styleUrl: './panier.component.css'
})
export class PanierComponent {
  panier : Panier
  calculerTotalCommande: any;
  constructor(private managePaniersService : ManagePaniersService){
    this.panier= this.managePaniersService.getPanier()
  }
// Fonction pour avoir le prix total du Panier
getPrix(){
  let prix=0
  for (const uneLigne of this.panier.listeDeBoxe){
    prix+=uneLigne.boxe.prix * uneLigne.qte
  }
  return prix.toFixed(2)
}

//méthode qui affiche les saveurs des boxes du panier
getSaveur() {
  const listeSaveur: any[] = []; // On crée une liste vide
  // Étape 1 : Parcourir la liste des boxes
  for (let uneBoxe of this.panier.listeDeBoxe) {
    // Étape 2 : Parcourir les saveurs des boxes
    for (let uneSaveur of uneBoxe.boxe.saveurs) {
      // Étape 3 : Vérifier si la saveur n'est pas déjà présente dans la liste
      if (!listeSaveur.includes(uneSaveur)) {
        listeSaveur.push(uneSaveur); // On l'ajoute à la liste des saveurs
      }
    }
  }
  return(listeSaveur)
}

// Fonction pour supprimer une boxe
  supprimer(uneLigne : LigneBoxes){
    this.managePaniersService.deleteBoxe(uneLigne.boxe)
    this.panier = this.managePaniersService.getPanier()
  }
// Fonction pour reduire la quantité de boxe
  reduire(uneLigne : LigneBoxes){
    this.managePaniersService.reducePanier(uneLigne.boxe)
    this.panier = this.managePaniersService.getPanier()
  }
// Fonction pour augmenter la quantité de boxe
  augmenter(uneLigne : LigneBoxes){
    this.managePaniersService.increasePanier(uneLigne.boxe)
    this.panier = this.managePaniersService.getPanier()
  }

  promo1(): number{
    const seuilPromotion = 30; // Définir le seuil de la promotion (35€)
    let boxMoinChere = 0
    // Calculer le total de la commande en parcourant chaque ligne du panier
    let totalCommande = 0;
    for (let uneLigne of this.panier.listeDeBoxe) {
        totalCommande += uneLigne.boxe.prix * uneLigne.qte; // Ajouter le prix de chaque boxe multiplié par sa quantité au total
    }

    // Appliquer la promotion si le total de la commande atteint ou dépasse 30€
    if (totalCommande >= seuilPromotion) {
        // Sélectionner la boxe la moins chère du panier 
        for(let uneBox of this.panier.listeDeBoxe)
         boxMoinChere += Math.min(uneBox.boxe.prix)
        console.log("prix de la boxe la moins chère :",boxMoinChere)
    }
    totalCommande-=boxMoinChere
return(totalCommande)
}



  promo2(): void {
    const seuilPromotion = 35; // Définir le seuil de la promotion (35€)

    // Calculer le total de la commande en parcourant chaque ligne du panier
    let totalCommande = 0;
    for (const uneLigne of this.panier.listeDeBoxe) {
        totalCommande += uneLigne.boxe.prix * uneLigne.qte; // Ajouter le prix de chaque boxe multiplié par sa quantité au total
    }

    // Appliquer la promotion si le total de la commande atteint ou dépasse 35€
    if (totalCommande >= seuilPromotion) {
        // Sélectionner une boxe du panier de manière aléatoire
        const randomIndex = Math.floor(Math.random() * this.panier.listeDeBoxe.length);
        const boxOfferte = this.panier.listeDeBoxe[randomIndex]; // Sélectionner une boxe aléatoire dans le panier

        // Augmenter la quantité de la boxe offerte de 1
        boxOfferte.qte++; // Ajouter une unité à la quantité de la boxe sélectionnée, la rendant ainsi gratuite
    }console.log(totalCommande)
  
  }

  
}
   
  
  
  
  
  
  
  
 

