from collections import Counter
from characters import characters
from questions import questions
import math

class GameLogic:
    def __init__(self):
        self.possible_answers = list(characters.keys())
        self.asked_questions = set()
        self.questions = questions
        self.game_over = False

    def calculate_entropy(self, data_set):
        """Calcule l'entropie d'un ensemble de données (ici, les personnages possibles)."""
        if not data_set:
            return 0
        probability = 1.0 / len(data_set)
        return -probability * math.log2(probability) * len(data_set) if len(data_set) > 0 else 0

    def calculate_information_gain(self, data_set, attribute):
        """Calcule le gain d'information en divisant le data_set sur un attribut."""
        if not data_set:
            return 0

        entropy_before = self.calculate_entropy(data_set)
        entropy_after = 0

        subset_true = [char for char in data_set if characters[char].get(attribute, False)]
        subset_false = [char for char in data_set if not characters[char].get(attribute, False)]

        weight_true = len(subset_true) / len(data_set)
        weight_false = len(subset_false) / len(data_set)

        entropy_after += weight_true * self.calculate_entropy(subset_true)
        entropy_after += weight_false * self.calculate_entropy(subset_false)

        return entropy_before - entropy_after

    def choose_best_question(self):
        """Choisit la question avec le gain d'information le plus élevé."""
        if len(self.possible_answers) <= 1:
            return None

        best_question = None
        max_info_gain = -1

        for q in self.questions:
            attribute = q['cle']
            if attribute in self.asked_questions:
                continue

            info_gain = self.calculate_information_gain(self.possible_answers, attribute)

            if info_gain > max_info_gain:
                max_info_gain = info_gain
                best_question = q

        return best_question

    def process_answer(self, characteristic, answer):
        """Filtre les personnages en fonction de la réponse de l'utilisateur."""
        if answer == "oui":
            self.possible_answers = [p for p in self.possible_answers if characters[p].get(characteristic, False)]
        else:
            self.possible_answers = [p for p in self.possible_answers if not characters[p].get(characteristic, False)]

        self.asked_questions.add(characteristic)

    def get_final_answer(self):
        """Retourne le personnage deviné."""
        return self.possible_answers[0] if len(self.possible_answers) == 1 else None

    def is_game_finished(self):
        """Retourne True si le jeu est terminé."""
        return len(self.possible_answers) == 1