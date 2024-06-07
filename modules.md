# **SURETES**

## Afficher bouton demarrer realisation (toutes les suretes)
- si phase = formalization et has_recovery = true


## Liste des garanties déjà formalisé (dans recouvrement)
- ajouter query string phase = formalized à la route principale des garanties soit 
/api/guarantees?phase=formalized


## gestion des status (toutes les suretes)

- si phase = formalization alors En cours de formalisation
- si phase = formalized alors Formalisé
- si phase = realization alors En cours de recouvrement
- si phase = realized alors Recouvré


## sureté personnelles

- si le type est contre garantie autonome choisir une garantie autonome en lieu et place de contrat dans le formulaire
    * liste des garanties autonomes: ajouter query string type = autonomous soit
        /api/guarantees?type=autonomous
    * envoyer autonomous_id quand type = autonomous_counter dans le form de creation


## sureté mobilière

- Creation : Afficher le champ type de formalisation pour tout sauf quand type = 'vehicle'
