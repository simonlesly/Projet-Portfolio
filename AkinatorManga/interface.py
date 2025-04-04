import tkinter as tk
from tkinter import messagebox
from PIL import Image, ImageTk  # Importer Pillow pour gérer les images
from game import GameLogic  # Importer la logique du jeu


class GameApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Jeu de Devinette Manga")

        # Changer la taille de la fenêtre
        self.root.geometry("1200x800")

        # Initialiser la logique du jeu
        self.game_logic = GameLogic()
        self.create_home_page()

    def create_home_page(self):
        """Page d'accueil avec explication des règles et un bouton 'Start'."""
        self.clear_screen()

        # Charger et ajuster l'image de fond
        self.background_image = Image.open("images/glycine_forest.jpg")
        self.background_image = self.background_image.resize((self.root.winfo_screenwidth(), self.root.winfo_screenheight()), Image.Resampling.LANCZOS)
        self.background_image = ImageTk.PhotoImage(self.background_image)
        self.background_label = tk.Label(self.root, image=self.background_image)
        self.background_label.place(relwidth=1, relheight=1)

        title_label = tk.Label(self.root, text="Bienvenue dans le jeu Akinator centré sur : Demon Slayer !", font=("Old Japanese.otf", 30), bg="white", relief="solid", bd=2)
        title_label.pack(pady=50)

        rules_label = tk.Label(self.root, text="L'Akinator va deviner à quel personnage de Demon Slayer tu penses", font=("Old Japanese.otf", 18), bg="white")
        rules_label.pack(pady=20)
        
        fonc_label = tk.Label(self.root, text="Répond aux questions par 'oui' ou 'non'.", font=("Old Japanese.otf", 18), bg="white")
        fonc_label.pack(pady=20)

        start_button = tk.Button(self.root, text="Commencer", font=("Old Japanese.otf", 18), command=self.start_game, bd=2, fg="black", bg="white", activebackground="black", activeforeground="white", width=10, height=2, borderwidth=3, relief="solid")
        start_button.pack(pady=50)

    def start_game(self):
        """Démarre le jeu en créant les éléments nécessaires."""
        self.clear_screen()
        self.game_logic = GameLogic()  # Réinitialiser la logique du jeu
        self.create_game_widgets()
        self.display_next_question()

    def clear_screen(self):
        """Efface les éléments de l'écran actuel."""
        for widget in self.root.winfo_children():
            widget.destroy()

    def create_game_widgets(self):
        """Création des éléments de l'interface pour le jeu."""
        self.background_image = Image.open("images/glycine_forest.jpg")
        self.background_image = self.background_image.resize((self.root.winfo_screenwidth(), self.root.winfo_screenheight()), Image.Resampling.LANCZOS)
        self.background_image = ImageTk.PhotoImage(self.background_image)
        self.background_label = tk.Label(self.root, image=self.background_image)
        self.background_label.place(relwidth=1, relheight=1)

        self.question_label = tk.Label(self.root, text="", font=("Old Japanese.otf", 18), width=50, height=5, bg="white", relief="solid", borderwidth=3)
        self.question_label.pack(pady=30)

        button_frame = tk.Frame(self.root, bg="white")
        button_frame.pack(pady=30)

        # Définition des boutons Oui et Non avec dimensions égales au bouton Commencer
        button_config = {"font": ("Old Japanese.otf", 16), "bd": 2, "fg": "black", "bg": "white","activebackground":"black", "activeforeground":"white", "width": 10, "height": 2, "borderwidth": 3, "relief": "solid"}
                                                           
        self.yes_button = tk.Button(button_frame, text="Oui", command=self.handle_yes, **button_config)
        self.yes_button.pack(side="left", padx=40)

        self.no_button = tk.Button(button_frame, text="Non", command=self.handle_no, **button_config)
        self.no_button.pack(side="right", padx=40)

    def display_next_question(self):
        """Affiche la meilleure question choisie dynamiquement."""
        if self.game_logic.is_game_finished():
            self.end_game()
        else:
            next_question = self.game_logic.choose_best_question()
            if next_question:
                self.question_label.config(text=next_question[0])
            else:
                self.end_game()


    def handle_yes(self):
        """Lorsque l'utilisateur clique sur 'Oui'."""
        characteristic = self.game_logic.get_next_question()
        if characteristic:
            self.game_logic.process_answer(characteristic[1], "oui")
            self.display_next_question()

    def handle_no(self):
        """Lorsque l'utilisateur clique sur 'Non'."""
        characteristic = self.game_logic.get_next_question()
        if characteristic:
            self.game_logic.process_answer(characteristic[1], "non")
            self.display_next_question()

    def end_game(self):
        """Lorsque le jeu est terminé et qu'un personnage a été trouvé."""
        character = self.game_logic.get_final_answer()

        if character:
            self.question_label.config(text=f"J'ai deviné ! C'est {character}!")
            try:
                self.character_image = Image.open(f"images/{character}.png")  # Assurez-vous d'avoir une image pour chaque personnage
                self.character_image = self.character_image.resize((300, 300), Image.Resampling.LANCZOS)
                self.character_image = ImageTk.PhotoImage(self.character_image)
                image_label = tk.Label(self.root, image=self.character_image)
                image_label.pack(pady=20)
            except FileNotFoundError:
                messagebox.showerror("Erreur", "L'image du personnage n'a pas été trouvée.")
        else:
            self.question_label.config(text="Je n'ai pas réussi à deviner le personnage auquel tu pensais.")

        # Ajouter un bouton pour recommencer ou revenir à l'accueil
        self.ask_to_restart()

    def ask_to_restart(self):
        """Demander à l'utilisateur s'il veut recommencer ou revenir à l'accueil."""
        restart_frame = tk.Frame(self.root, bg="white")
        restart_frame.pack(pady=20)

        restart_button = tk.Button(restart_frame, text="Recommencer", font=("Old Japanese.otf", 16), command=self.start_game, relief="solid", bd=5, fg="black", bg="white", width=10, height=2, borderwidth=3)
        restart_button.pack(side="left", padx=40)

        home_button = tk.Button(restart_frame, text="Accueil", font=("Old Japanese.otf", 16), command=self.create_home_page, relief="solid", bd=5, fg="black", bg="white", width=10, height=2, borderwidth=3)
        home_button.pack(side="right", padx=40)


if __name__ == "__main__":
    root = tk.Tk()
    app = GameApp(root)
    root.mainloop()