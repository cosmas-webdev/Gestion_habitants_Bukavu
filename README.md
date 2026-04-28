# 🏙️ Gestion des Habitants de Bukavu

![Version](https://img.shields.io/badge/version-1.0.0-blue)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?logo=javascript&logoColor=black)
![Chart.js](https://img.shields.io/badge/Chart.js-4.x-FF6384?logo=chart.js&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?logo=bootstrap&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green)
![Status](https://img.shields.io/badge/status-active-success)

> 🇫🇷 Système de recensement et de gestion des habitants de la ville de Bukavu, République Démocratique du Congo.
> 🇬🇧 Citizen census and management system for the city of Bukavu, Democratic Republic of Congo.

---

## 📋 **Description**

**Gestion_habitants_Bukavu** est une application web complète permettant de recenser et gérer les habitants de la ville de Bukavu. L'application offre une interface intuitive pour l'identification des citoyens par **Commune** (Ibanda, Kadutu, Bagira), **Quartier** et **Avenue**, avec des graphiques statistiques interactifs et un système de gestion des sessions utilisateurs.

### 🎯 **Objectifs du projet**
- Centraliser les données démographiques de la ville
- Faciliter le recensement et le suivi des habitants
- Fournir des statistiques visuelles pour l'aide à la décision
- Assurer une gestion sécurisée avec authentification

---

## ✨ **Fonctionnalités**

### 🏠 **Gestion des Habitants**
- ✅ Enregistrement complet (nom, prénom, date de naissance, sexe, état civil)
- ✅ Attribution par Commune → Quartier → Avenue
- ✅ Recherche avancée multi-critères
- ✅ Modification et suppression des enregistrements
- ✅ Visualisation détaillée des fiches habitants

### 📊 **Tableau de Bord**
- 📈 Graphiques interactifs avec **Chart.js**
- 📊 Statistiques par commune (population totale, répartition)
- 📋 Liste des derniers habitants enregistrés
- 🔍 Filtres dynamiques par commune et quartier

### 🔐 **Authentification & Sécurité**
- 👤 Système de connexion/déconnexion
- 🔑 Gestion des sessions PHP
- 🛡️ Protection des pages administrateur
- 📝 Journal des actions utilisateurs

### 📄 **Exports & Rapports**
- 📥 Export des données en Excel
- 🖨️ Format d'impression optimisé
- 📊 Rapports statistiques par période

---

## 🛠️ **Technologies Utilisées**

| Catégorie | Technologies |
|-----------|-------------|
| **Backend** | PHP 8.0+ |
| **Base de données** | MySQL 8.0 |
| **Frontend** | HTML5, CSS3, JavaScript ES6+ |
| **Framework CSS** | Bootstrap 5.x |
| **Graphiques** | Chart.js 4.x |
| **Icônes** | Font Awesome 6 |
| **Authentification** | Sessions PHP natives |
| **Export** | PhpSpreadsheet (Excel) |

---

## 📸 **Captures d'écran**

<div align="center">
  <p><em>Ajoutez vos captures d'écran dans un dossier /screenshots</em></p>
  <img src="screenshots/dashboard.png" alt="Dashboard" width="80%">
  <br><br>
  <img src="screenshots/habitants-list.png" alt="Liste des habitants" width="80%">
  <br><br>
  <img src="screenshots/statistiques.png" alt="Statistiques" width="80%">
</div>

---

## 🗄️ **Structure de la Base de Données**

```sql
-- Table des communes
communes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,        -- Ibanda, Kadutu, Bagira
    code VARCHAR(10) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des quartiers
quartiers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    commune_id INT,
    nom VARCHAR(100) NOT NULL,
    FOREIGN KEY (commune_id) REFERENCES communes(id)
);

-- Table des avenues
avenues (
    id INT PRIMARY KEY AUTO_INCREMENT,
    quartier_id INT,
    nom VARCHAR(100) NOT NULL,
    FOREIGN KEY (quartier_id) REFERENCES quartiers(id)
);

-- Table des habitants
habitants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100),
    date_naissance DATE,
    sexe ENUM('M', 'F'),
    etat_civil VARCHAR(50),
    profession VARCHAR(100),
    telephone VARCHAR(20),
    commune_id INT,
    quartier_id INT,
    avenue_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (commune_id) REFERENCES communes(id),
    FOREIGN KEY (quartier_id) REFERENCES quartiers(id),
    FOREIGN KEY (avenue_id) REFERENCES avenues(id)
);

-- Table des utilisateurs
utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'agent', 'lecture') DEFAULT 'agent',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
