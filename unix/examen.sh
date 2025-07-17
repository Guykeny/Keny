#!/bin/bash

# Fonction pour créer des dossiers
create_folders() {
    read -p "Nombre de dossiers à créer (n) : " n
    read -p "Emplacement : " location
    read -p "Modèle : " model

    for i in $(seq 1 $n); do
        mkdir -p "$location/$model$i"
    done

    echo "Dossiers créés avec succès."
}

# Fonction pour effectuer un calcul à partir d'un fichier
calculate_from_file() {
    read -p "Nom du fichier : " filename

    if [ -f "$filename" ]; then
        a=$(grep -o 'a=[0-9]*' "$filename" | sed 's/a=//')
        b=$(grep -o 'b=[0-9]*' "$filename" | sed 's/b=//')

        if [ -n "$a" ] && [ -n "$b" ]; then
            sum=$((a + b))
            echo "La somme de a et b est : $sum"
        else
            echo "Les valeurs de a et b n'ont pas été trouvées dans le fichier."
        fi
    else
        echo "Le fichier n'existe pas."
    fi
}

# Fonction pour compter les lettres d'un mot
count_letters() {
    read -p "Mot : " word
    len=${#word}

    for ((i=0; i<len; i++)); do
        letter="${word:$i:1}"
        count=$(grep -o "$letter" <<< "$word" | wc -l)
        echo "$letter: $(printf '*%.0s' $(seq 1 $count))"
    done
}

# Menu principal
while true; do
    echo -e "\nMenu :"
    echo "1. Créer des dossiers"
    echo "2. Calcul à partir d'un fichier"
    echo "3. Compter les lettres d'un mot"
    echo "0. Quitter"

    read -p "Votre choix : " choice

    case $choice in
        1) create_folders ;;
        2) calculate_from_file ;;
        3) count_letters ;;
        0) echo "Au revoir !"; exit ;;
        *) echo "Choix invalide. Veuillez choisir à nouveau." ;;
    esac
done
