from characters import characters
from questions import questions

class GameLogic:
    def __init__(self):
        self.possible_answers = list(characters.keys())
        self.asked_questions = []  # Liste des questions déjà posées
        self.current_question_index = 0  # Indice de la question actuelle

    def get_next_question(self):
        if self.current_question_index < len(questions):
            return questions[self.current_question_index]
        return None

    def process_answer(self, characteristic, answer):
        # Réduit la liste des personnages en fonction de la réponse
        if answer == "oui":
            self.possible_answers = [p for p in self.possible_answers if characters[p].get(characteristic, False)]
        else:
            self.possible_answers = [p for p in self.possible_answers if not characters[p].get(characteristic, False)]

        self.current_question_index += 1  # Passe à la question suivante

    def is_game_finished(self):
        return len(self.possible_answers) == 1

    def get_final_answer(self):
        if len(self.possible_answers) == 1:
            return self.possible_answers[0]
        return None
