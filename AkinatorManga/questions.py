# questions.py

# Liste de questions générales avec leurs poids
questions = [
    {"question": "Est-ce que c'est un homme ?", "cle": "homme", "poids": 0.9},
    {"question": "Est-ce que c'est un humain ?", "cle": "humain", "poids": 0.8},
    {"question": "Est-ce qu'il a des pouvoirs ?", "cle": "pouvoirs", "poids": 0.7},
    {"question": "Est-ce que c'est un pillier ?", "cle": "pillier", "poids": 0.6},
    {"question": "Est-ce que c'est une lune supérieure ?", "cle": "supérieur", "poids": 0.6},
    {"question": "Est-ce qu'il a des cheveux noirs ?", "cle": "cheveux_noir", "poids": 0.5},
    {"question": "Est-ce qu'il a un frère ou une sœur ?", "cle": "famille", "poids": 0.5},
    {"question": "Est-ce que c'est un adulte ?", "cle": "adulte", "poids": 0.5},
    {"question": "Est-ce qu'il utilise une arme ?", "cle": "arme", "poids": 0.4},
    {"question": "Est-ce qu'il maitrise le souffle de l’eau ?", "cle": "eau", "poids": 0.4},
    {"question": "Est-ce qu'il maitrise le souffle du feu ?", "cle": "feu", "poids": 0.4},
    {"question": "Est-ce qu'il a un serpent ?", "cle": "serpent", "poids": 0.3},
    {"question": "Est-ce qu'il porte un masque ?", "cle": "masque", "poids": 0.3},
    {"question": "Est-ce que c'est le chef des démons ?", "cle": "chef", "poids": 0.3},
    {"question": "Est-ce qu'il a des yeux dans les tons pastel arc-en-ciel ?", "cle": "arc-en-ciel", "poids": 0.2},
    {"question": "Est-ce que son pouvoir est lié à des poissons et des pots ?", "cle": "poisson", "poids": 0.2},
    {"question": "Est-ce qu'il a des pouvoirs liés à des araignées ?", "cle": "araignée", "poids": 0.2}
]

# Optionnel : Trier les questions par ordre de poids décroissant
questions.sort(key=lambda q: q["poids"], reverse=True)