import tkinter as tk
import requests

fenetre = tk.Tk()
fenetre.title("Cinéphoria - Incidents")
fenetre.geometry("600x500")
fenetre.configure(bg="black")

titre = tk.Label(
    fenetre,
    text="Déclaration d'incident",
    bg="black",
    fg="#C47938",
    font=("Arial", 22, "bold")
)
titre.pack(pady=20)

label_salle = tk.Label(fenetre, text="Salle :", bg="black", fg="white")
label_salle.pack()

champ_salle = tk.Entry(fenetre, width=40)
champ_salle.pack(pady=5)

label_type = tk.Label(fenetre, text="Type d'incident :", bg="black", fg="white")
label_type.pack()

champ_type = tk.Entry(fenetre, width=40)
champ_type.pack(pady=5)

label_description = tk.Label(fenetre, text="Description :", bg="black", fg="white")
label_description.pack()

champ_description = tk.Entry(fenetre, width=40)
champ_description.pack(pady=5)

def ajouter_incident():
    salle = champ_salle.get()
    type_incident = champ_type.get()
    description = champ_description.get()

    response = requests.post(
        "http://localhost:8888/cine/api/ajouter_incident.php",
        data={
            "salle": salle,
            "type_incident": type_incident,
            "description": description
        }
    )

    resultat = response.json()

    print(resultat["message"])

    incident = f"Salle {salle} - {type_incident} : {description}"

    liste.insert(tk.END, incident)

    champ_salle.delete(0, tk.END)
    champ_type.delete(0, tk.END)
    champ_description.delete(0, tk.END)

    bouton = tk.Button(
        fenetre,
        text="Déclarer l'incident",
        bg="#C47938",
        fg='white',
        command=ajouter_incident
    )
    bouton.pack(pady=10)

liste = tk.Listbox(fenetre, width=30, height=10)
liste.pack(pady=20)


fenetre.mainloop()












