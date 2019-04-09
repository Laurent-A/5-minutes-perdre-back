# Dictionnaire de données

## Entités

### User
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant|
|username|VARCHAR(30)|NOT NULL|Nom de l'utilisateur|
|password|VARCHAR(100)|NOT NULL|Mot de passe utilisateur|
|email|VARCHAR(75)|NOT NULL|Email de l'utilisateur|
|role|Entity|-|Statut de l'utilisateur|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|Date de création|
|updated_at|TIMESTAMP|NULL|Date de modification|


### Game
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant|
|name|VARCHAR(30)|NOT NULL|Nom du jeu|
|url|VARCHAR(100)|NOT NULL|Url du jeu|
|help|Entity|-|Règles du jeu|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|Date de création|
|updated_at|TIMESTAMP|NULL|Date de modification|


### Quizz
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant|
|title|VARCHAR(30)|NOT NULL|Nom du quizz|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|Date de création|
|updated_at|TIMESTAMP|NULL|Date de modification|


### Wiki
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant|
|name|VARCHAR(30)|NOT NULL|Nom de la fiche wiki|
|body|TEXT|NOT NULL|Contenu de la fiche|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|Date de création|
|updated_at|TIMESTAMP|NULL|Date de modification|


### Question
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant|
|title|VARCHAR(75)|NOT NULL|Titre de la question|
|text|VARCHAR(255)|NOT NULL|Question|
|quizz|Entity|-|Quizz auquel appartient la question|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|Date de création|
|updated_at|TIMESTAMP|NULL|Date de modification|


### Answer
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant|
|text|VARCHAR(200)|NOT NULL|Réponse|
|question|Entity|-|Question a laquelle la réponse est rattachée|
|correct|BOOLEEAN|NOT NULL|Indique si la réponse est correcte ou non|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|Date de création|
|updated_at|TIMESTAMP|NULL|Date de modification|


### Tag
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant|
|name|VARCHAR(30)|NOT NULL|Nom de la catégorie|
|favorite|BOOLEEAN|NOT NULL|Indique si la catégorie a été rajouter aux favoris de l'utilisateur ou non|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|Date de création|
|updated_at|TIMESTAMP|NULL|Date de modification|


### Game-Score
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant|
|score|INT|NULL|Score de la partie|
|user|Entity|-|Utilisateur qui a réalisé le score|
|game|Entity|-|Jeu sur lequel le score a été réalisé|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|Date de création|
|updated_at|TIMESTAMP|NULL|Date de modification|


### Quizz-Score
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant|
|score|INT|NULL|Score de la partie|
|user|Entity|-|Utilisateur qui a réalisé le score|
|quizz|Entity|-|Quizz sur lequel le score a été réalisé|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|Date de création|
|updated_at|TIMESTAMP|NULL|Date de modification|


### Role
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant|
|name|VARCHAR(30)|NOT NULL|Affichage du role pour les admins|
|code|VARCHAR(30)|NOT NULL|Code du role pour l'authentification|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|Date de création|
|updated_at|TIMESTAMP|NULL|Date de modification|


### Help
|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant|
|name|VARCHAR(30)|NOT NULL|Nom de l'aide|
|body|TEXT|NOT NULL|Contenu de l'aide|
|game|Entity|NULL|Jeu auquel appartient l'aide|
|created_at|TIMESTAMP|NOT NULL, DEFAULT CURRENT_TIMESTAMP|Date de création|
|updated_at|TIMESTAMP|NULL|Date de modification|
