from collections import Counter
from characters import characters

class GameLogic:
    def __init__(self):
        self.possible_answers = list(characters.keys())
        self.asked_questions = []
        # Attribut pour stocker les poids des questions
        self.question_priority = {
            "homme": 0.9,
            "humain": 0.8,
            "pouvoirs": 0.7,
            "pillier": 0.6,
            "supérieur": 0.5,
            "cheveux_noir": 0.4,
            "famille": 0.3,
            "adulte": 0.3,
            "arme": 0.2,
            "eau": 0.1,
            "feu": 0.05,
            "serpent": 0.05,
            "masque": 0.05,
            "chef": 0.03,
            "arc-en-ciel": 0.02,
            "poisson": 0.01
        }
        self.game_over = False

    def choose_best_question(self):
        """Choisit la meilleure question pour diviser les personnages restants en deux groupes équilibrés, en tenant compte de la priorité."""
        best_question = None
        best_score = float('inf')

        # Liste des questions possibles (sous forme de tuples)
        questions = [
            ('Est-ce un homme ?', 'homme'),
            ('Est-ce un humain ?', 'humain'),
            ('A-t-il des pouvoirs ?', 'pouvoirs'),
            ('Est-ce un pilier ?', 'pillier'),
            ('Est-il une lune supérieur ?', 'supérieur'),
            ('A-t-il les cheveux noirs ?', 'cheveux_noir'),
            ('A-t-il un frère ou une soeur ?', 'famille'),
            ("Est-ce que c'est un adulte ?", "adulte"),
            ('Utilise-t-il une arme ?', 'arme'),
            ('Maitrise t-il le souffle de l’eau ?', 'eau'),
            ('Maitrise t-il le souffle du feu ?', 'feu'),
            ('A-t-il un serpent ?', 'serpent'),
            ('Porte-t-il un masque ?', 'masque'),
            ('Est-il le chef des démon ?', 'chef'),
            ('A-t-il des yeux dans les tons pastel arc-en-ciel ?', 'arc-en-ciel'),
            ('A-t-il des pouvoirs liés à des vqse et des poissons ?', 'poisson')
        ]

        # Trier les questions en fonction de leur priorité
        sorted_questions = sorted(questions, key=lambda q: self.question_priority[q[1]], reverse=True)

        for question, key in sorted_questions:
            if key in self.asked_questions:
                continue  # Ne pas reposer la même question

            # Compter combien de personnages répondent "oui" ou "non"
            count_yes = sum(1 for p in self.possible_answers if characters[p].get(key, False))
            count_no = len(self.possible_answers) - count_yes
            score = abs(count_yes - count_no)  # Équilibre entre les groupes

            if score < best_score:
                best_score = score
                best_question = (question, key)

        return best_question

    def process_answer(self, characteristic, answer):
        """Filtre les personnages en fonction de la réponse de l'utilisateur."""
        if answer == "oui":
            self.possible_answers = [p for p in self.possible_answers if characters[p].get(characteristic, False)]
        else:
            self.possible_answers = [p for p in self.possible_answers if not characters[p].get(characteristic, False)]

        self.asked_questions.append(characteristic)

    def get_final_answer(self):
        """Retourne le personnage deviné."""
        return self.possible_answers[0] if len(self.possible_answers) == 1 else None

    def is_game_finished(self):
        """Retourne True si le jeu est terminé, c'est-à-dire lorsqu'il reste un seul personnage."""
        return len(self.possible_answers) == 1
