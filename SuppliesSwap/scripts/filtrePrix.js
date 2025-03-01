const rangeInput = document.getElementById('max-prix');
    const valeurPrix = document.getElementById('valeur-prix');
    const resultatsContainer = document.getElementById('resultats');
    const listeComplete = document.getElementById('liste-complete');

    rangeInput.addEventListener('input', function () {
        valeurPrix.textContent = rangeInput.value;
        mettreAJourProduits(rangeInput.value);
    });

    function mettreAJourProduits(maxPrix) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `?max=${maxPrix}`, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const produits = JSON.parse(xhr.responseText);
                
                listeComplete.style.display = 'none';

                resultatsContainer.innerHTML = '';

                produits.forEach(produit => {
                    const article = document.createElement('div');
                    article.className = 'article';
                    article.innerHTML = `
                        <a href="produit.php?produit=${produit.id}">
                            <img src="images/${produit.image}" alt="${produit.nom}" class="article-photo">
                        </a>
                        <div class="article-info">
                            <span class="article-title">${produit.nom}</span>
                            <div class="article-details">
                                <span class="article-etat">${produit.etat}</span>
                                <span class="article-prix">${produit.prix}€</span>
                            </div>
                        </div>
                    `;
                    resultatsContainer.appendChild(article);
                });
            } else {
                console.error('Erreur lors de la récupération des produits.');
            }
        };

        xhr.send();
    }