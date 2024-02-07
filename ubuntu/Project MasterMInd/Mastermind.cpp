#include <iostream>
#include <cstdlib>
#include <ctime>

using namespace std;


const int TAILLE_COMBINAISON = 4;


void genererCombinaison(int combinaison[TAILLE_COMBINAISON]) {
    srand(time(0));

    for (int i = 0; i < TAILLE_COMBINAISON; ) {
        int randNum = rand() % 6 + 1;
        bool found = false;
        for (int j = 0; j < i; ++j) {
            if (combinaison[j] == randNum) {
                found = true;
                break;
            }
        }
        if (!found) {
            combinaison[i] = randNum;
            i++;
        }
    }
}

// Compare la combinaison de l'utilisateur avec la combinaison secrète
void comparerCombinaisons(const int utilisateur[TAILLE_COMBINAISON], const int secret[TAILLE_COMBINAISON], int& bienPlace, int& malPlace) {
    bienPlace = 0;
    malPlace = 0;

    for (int i = 0; i < TAILLE_COMBINAISON; ++i) {
        if (utilisateur[i] == secret[i]) {
            bienPlace++;
        } else {
            for (int j = 0; j < TAILLE_COMBINAISON; ++j) {
                if (utilisateur[i] == secret[j]) {
                    malPlace++;
                    break;
                }
            }
        }
    }
}

int main() {
   
    int secret[TAILLE_COMBINAISON];
    int essai[TAILLE_COMBINAISON];
    int bienPlace, malPlace, tentatives = 0;

    cout << "Bienvenue dans le jeu Mastermind!" << endl;
    cout << "Devinez la combinaison de 4 chiffres distincts (chiffres de 1 à 6)." << endl;

    genererCombinaison(secret);

    do {
        cout << "Entrez votre combinaison : ";
        for (int i = 0; i < TAILLE_COMBINAISON; ++i) {
            cin >> essai[i];
        }

        comparerCombinaisons(essai, secret, bienPlace, malPlace);
        tentatives++;

        if (bienPlace == TAILLE_COMBINAISON) {
            cout << "Félicitations! Vous avez trouvé la combinaison en " << tentatives << " tentatives!" << endl;
            break;
        } else {
            cout << bienPlace << " bien placé(s), " << malPlace << " mal placé(s). Essayez encore." << endl;
        }
    } while (tentatives < 10);

    if (tentatives == 10 && bienPlace < TAILLE_COMBINAISON) {
        cout << "Vous avez épuisé vos tentatives! La combinaison était ";
        for (int i = 0; i < TAILLE_COMBINAISON; ++i) {
            cout << secret[i];
        }
        cout << "." << endl;
    }

    return 0;
}
