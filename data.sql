-- Active: 1781676894628@@127.0.0.1@3306
INSERT INTO source (libelle) VALUES ('Tsena A');

-- Catégories
INSERT INTO
    categorie (libelle)
VALUES ('Boissons'),
    ('Alimentation');

-- Produits
INSERT INTO
    produit (designation, id_categorie)
VALUES ('Coca-Cola 1L', 1),
    ('Eau Minérale 1.5L', 1),
    ('Jus d''Orange', 1),
    ('Riz 1kg', 2),
    ('Sucre 1kg', 2);

-- Historique des prix
INSERT INTO
    HistoriquePrix (
        id_produit,
        prix,
        dateDebut,
        dateFin
    )
VALUES (1, 3500, '2026-01-01', NULL);

-- Caisses
INSERT INTO
    caisse (designation, idSource)
VALUES ('Caisse Principale', 1),
    ('Caisse Boutique', 1);

-- Utilisateur
INSERT INTO users (username, password) VALUES ('admin', 'admin123');