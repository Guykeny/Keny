#!/bin/bash

# Fonction pour la tâche 1
tache1() {
    read -p "Veuillez saisir le chemin du répertoire : " repertoire
    d= find "$repertoire" -type f -name "*.od*" -exec du -h {} \;
    res=$(cut -f1 "$d")
    echo "$(pwd)/$d ($res)"
}

# Fonction pour la tâche 2
tache2() {
    read -p "Veuillez saisir le chemin du fichier : " fichier
    read -p "Veuillez saisir le mot à remplacer : " mot1
    read -p "Veuillez saisir le nouveau mot : " mot2
    count=$(sed -i "" "s/$mot1/$mot2/g" "$fichier" | wc -l)
    echo "Le mot $mot1 a été remplacé par $mot2 $count fois dans le fichier $fichier"
}

# Fonction pour la tâche 3
tache3() {
    read -p "Veuillez saisir le nombre n : " n
    a=0
    b=1
    echo -n "$a $b "
    for ((i=2; i<n; i++)); do
        c=$((a + b))
        echo -n "$c "
        a=$b
        b=$c
    done
    echo
}

# Menu principal
while true; do
    echo "Menu :"
    echo "1. Afficher la taille et le nom des fichiers open document d'un répertoire"
    echo "2. Remplacer un mot dans un fichier"
    echo "3. Afficher les n premiers termes de la suite de Fibonacci"
    echo "0. Quitter"
    read -p "Veuillez saisir votre choix : " choix

    case $choix in
        1) tache1 ;;
        2) tache2 ;;
        3) tache3 ;;
        0) echo "Au revoir !"; exit ;;
        *) echo "Choix invalide, veuillez réessayer." ;;
    esac
done
