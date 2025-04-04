import tkinter as tk
from tkinter import messagebox, simpledialog
from PIL import Image, ImageTk
from game import GameLogic

class GameApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Jeu de Devinette Manga")
        self.root.geometry("1200x800")
        self.root.configure(bg="#f0f0f0")  # Couleur de fond globale
        self.game_logic = GameLogic()
        self.current_question_key = None
        self.font_title = ("Old Japanese.otf", 36)
        self.font_large = ("Old Japanese.otf", 20)
        self.font_medium = ("Old Japanese.otf", 18)
        self.font_small = ("Old Japanese.otf", 16)
        self.primary_color = "#4CAF50"  # Vert primaire
        self.secondary_color = "#e0f7fa" # Bleu clair secondaire
        self.text_color = "#333333"
        self.button_active_bg = "#388E3C"
        self.animation_duration = 200  # Durée de l'animation en ms
        self.current_widgets = [] # Pour suivre les widgets de l'écran actuel
        self.create_home_page()

    def clear_screen(self):
        for widget in self.current_widgets:
            widget.destroy()
        self.current_widgets = []

    def add_widget(self, widget):
        self.current_widgets.append(widget)

    def create_home_page(self):
        self.clear_screen()
        try:
            self.background_image = Image.open("images/glycine_forest.jpg")
            self.background_image = self.background_image.resize((self.root.winfo_screenwidth(), self.root.winfo_screenheight()), Image.Resampling.LANCZOS)
            self.background_photo = ImageTk.PhotoImage(self.background_image)
            self.background_label = tk.Label(self.root, image=self.background_photo)
            self.background_label.place(relwidth=1, relheight=1)
            self.add_widget(self.background_label)
        except FileNotFoundError:
            self.root.config(bg=self.secondary_color) # Fallback background color

        title_label = tk.Label(self.root, text="Bienvenue dans le jeu Akinator\nDemon Slayer !", font=self.font_title, bg="white", fg=self.text_color, relief="raised", bd=4, padx=20, pady=20)
        title_label.pack(pady=80)
        self.add_widget(title_label)

        rules_label = tk.Label(self.root, text="Pensez à un personnage de Demon Slayer.", font=self.font_large, bg=self.secondary_color, fg=self.text_color, pady=10)
        rules_label.pack()
        self.add_widget(rules_label)

        fonc_label = tk.Label(self.root, text="Répondez aux questions par Oui ou Non.", font=self.font_large, bg=self.secondary_color, fg=self.text_color, pady=10)
        fonc_label.pack()
        self.add_widget(fonc_label)

        start_button = tk.Button(self.root, text="Commencer", font=self.font_large, command=self.start_game, bg=self.primary_color, fg="white", activebackground=self.button_active_bg, relief="groove", bd=3, padx=30, pady=15)
        start_button.pack(pady=50)
        self.add_widget(start_button)

    def start_game(self):
        self.clear_screen()
        self.game_logic = GameLogic()
        self.current_question_key = None
        self.create_game_widgets()
        self._fade_in(self.question_frame) # Animation d'apparition

    def create_game_widgets(self):
        try:
            self.background_image = Image.open("images/glycine_forest.jpg")
            self.background_image = self.background_image.resize((self.root.winfo_screenwidth(), self.root.winfo_screenheight()), Image.Resampling.LANCZOS)
            self.background_photo = ImageTk.PhotoImage(self.background_image)
            self.background_label = tk.Label(self.root, image=self.background_photo)
            self.background_label.place(relwidth=1, relheight=1)
            self.add_widget(self.background_label)
        except FileNotFoundError:
            self.root.config(bg=self.secondary_color)

        self.question_frame = tk.Frame(self.root, bg=self.secondary_color, padx=30, pady=30, relief="ridge", bd=2)
        self.question_frame.pack(pady=80, padx=50, fill="x")
        self.add_widget(self.question_frame)
        self.question_frame.alpha = 0  # Niveau d'opacité initial (factice pour l'ancienne méthode)

        self.question_label = tk.Label(self.question_frame, text="", font=self.font_medium, wraplength=800, justify="center", bg=self.secondary_color, fg=self.text_color)
        self.question_label.pack(pady=20)
        self.add_widget(self.question_label)

        button_frame = tk.Frame(self.root, bg=self.secondary_color, pady=20)
        button_frame.pack()
        self.add_widget(button_frame)

        button_config = {"font": self.font_small, "bd": 2, "fg": "white", "bg": self.primary_color, "activebackground": self.button_active_bg, "width": 12, "height": 2, "relief": "raised"}

        self.yes_button = tk.Button(button_frame, text="Oui", command=self.handle_yes, **button_config)
        self.yes_button.pack(side="left", padx=50)
        self.add_widget(self.yes_button)

        self.no_button = tk.Button(button_frame, text="Non", command=self.handle_no, **button_config)
        self.no_button.pack(side="right", padx=50)
        self.add_widget(self.no_button)

        self.display_next_question()

    def display_next_question(self):
        if self.game_logic.is_game_finished():
            self._fade_out(self.question_frame, self.end_game)
        else:
            next_question_data = self.game_logic.choose_best_question()
            if next_question_data:
                self.current_question_key = next_question_data['cle']
                self._fade_out(self.question_label, lambda: self.question_label.config(text=next_question_data['question'], font=self.font_medium), self._fade_in)
            else:
                self._fade_out(self.question_frame, self.end_game)

    def handle_yes(self):
        if self.current_question_key:
            self._disable_buttons()
            self.game_logic.process_answer(self.current_question_key, "oui")
            self.display_next_question()

    def handle_no(self):
        if self.current_question_key:
            self._disable_buttons()
            self.game_logic.process_answer(self.current_question_key, "non")
            self.display_next_question()

    def _disable_buttons(self):
        self.yes_button.config(state="disabled")
        self.no_button.config(state="disabled")

    def _enable_buttons(self):
        self.yes_button.config(state="normal")
        self.no_button.config(state="normal")

    def end_game(self):
        self.clear_screen()
        try:
            self.background_image = Image.open("images/glycine_forest.jpg")
            self.background_image = self.background_image.resize((self.root.winfo_screenwidth(), self.root.winfo_screenheight()), Image.Resampling.LANCZOS)
            self.background_photo = ImageTk.PhotoImage(self.background_image)
            self.background_label = tk.Label(self.root, image=self.background_photo)
            self.background_label.place(relwidth=1, relheight=1)
            self.add_widget(self.background_label)
        except FileNotFoundError:
            self.root.config(bg=self.secondary_color)

        character = self.game_logic.get_final_answer()
        result_text = f"J'ai deviné ! C'est {character}!" if character else "Je n'ai pas réussi à deviner."
        result_label = tk.Label(self.root, text=result_text, font=self.font_large, bg=self.secondary_color, fg=self.text_color, pady=20)
        result_label.pack(pady=50)
        self.add_widget(result_label)

        if character:
            try:
                self.character_image = Image.open(f"images/{character}.png")
                self.character_image = self.character_image.resize((300, 300), Image.Resampling.LANCZOS)
                self.character_photo = ImageTk.PhotoImage(self.character_image)
                image_label = tk.Label(self.root, image=self.character_photo, bg=self.secondary_color)
                image_label.pack(pady=20)
                self.add_widget(image_label)
            except FileNotFoundError:
                messagebox.showerror("Erreur", "L'image du personnage n'a pas été trouvée.")

        self.ask_to_restart()

    def ask_to_restart(self):
        restart_frame = tk.Frame(self.root, bg=self.secondary_color, pady=30)
        restart_frame.pack()
        self.add_widget(restart_frame)

        restart_button = tk.Button(restart_frame, text="Rejouer", font=self.font_medium, command=self.start_game, bg=self.primary_color, fg="white", activebackground=self.button_active_bg, relief="raised", bd=3, padx=20, pady=10)
        restart_button.pack(side="left", padx=50)
        self.add_widget(restart_button)

        home_button = tk.Button(restart_frame, text="Accueil", font=self.font_medium, command=self.create_home_page, bg=self.primary_color, fg="white", activebackground=self.button_active_bg, relief="raised", bd=3, padx=20, pady=10)
        home_button.pack(side="right", padx=50)
        self.add_widget(home_button)

    def _fade_in(self, widget, callback=None):
        widget.winfo_children()
        widget.after(self.animation_duration, callback)
        self._enable_buttons()

    def _fade_out(self, widget, callback=None, next_callback=None):
        widget.after(self.animation_duration, callback)
        if next_callback:
            next_callback(widget)

if __name__ == "__main__":
    root = tk.Tk()
    app = GameApp(root)
    root.mainloop()