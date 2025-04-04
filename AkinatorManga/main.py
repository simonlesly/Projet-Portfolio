# main.py

from interface import GameApp
import tkinter as tk

def main():
    # Créer une instance de la fenêtre Tkinter et démarrer l'application
    root = tk.Tk()  # Crée la fenêtre principale
    app = GameApp(root)  # Lance l'application de jeu avec l'interface graphique
    root.mainloop()  # Lance la boucle principale de Tkinter pour gérer l'interface

if __name__ == "__main__":
    main()