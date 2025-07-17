# Mailbox Module
Module Dolibarr pour récupérer les mails via IMAP et les enregistrer dans la base et en .eml.

## Installation
- Copier le dossier `mailboxmodule` dans `htdocs/custom/`
- Importer `install.sql` dans la base de données
- Activer le module depuis l'interface Dolibarr

## Configuration
- Modifier `scripts/fetch_emails.php` pour renseigner vos identifiants IMAP
