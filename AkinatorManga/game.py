from collections import Counter

class GameLogic:
    def __init__(self):
        self.possible_answers = list(characters.keys())
        self.asked_questions = []

    def choose_best_question(self):
        """Choisit la meilleure question pour diviser les personnages restants en deux groupes équilibrés."""
        best_question = None
        best_score = float('inf')

        for question, key in questions:
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
