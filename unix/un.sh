#!/bin/bash

echo -n "Donnez un mot : "
read mot

if [[ -z $mot ]]; then
    echo "Le mot est vide."
    exit 1
fi

nb=1  # Initialiser le compteur à 1 car le premier caractère est déjà une occurrence

for ((i = 1; i < ${#mot}; i++)); do
    if [[ "${mot:i:1}" == "${mot:i-1:1}" ]]; then
        nb=$((nb + 1))
    else
        echo -n "${mot:i-1:1}"
        for ((j = 1; j <= nb; j++)); do
            echo -n "*"
        done
        nb=1  # Réinitialiser le compteur pour la nouvelle lettre
    fi
done

# Afficher le résultat pour la dernière lettre
echo -n "${mot: -1}"
for ((j = 1; j <= nb; j++)); do
    echo -n "*"
done

echo  # Aller à la ligne après l'affichage du résultat
