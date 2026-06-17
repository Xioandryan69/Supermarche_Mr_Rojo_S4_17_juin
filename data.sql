PRAGMA foreign_keys = ON;

-- =========================
-- CATEGORIE
-- =========================
INSERT INTO categorie (libelle) VALUES ('Informatique');

INSERT INTO categorie (libelle) VALUES ('Alimentation');

INSERT INTO categorie (libelle) VALUES ('Boisson');

-- =========================
-- PRODUIT
-- =========================
INSERT INTO
    produit (designation, id_categorie)
VALUES ('Ordinateur HP', 1);

INSERT INTO
    produit (designation, id_categorie)
VALUES ('Clavier USB', 1);

INSERT INTO produit (designation, id_categorie) VALUES ('Riz', 2);

INSERT INTO
    produit (designation, id_categorie)
VALUES ('Coca Cola', 3);

-- =========================
-- HISTORIQUE PRIX
-- =========================
INSERT INTO
    HistoriquePrix (
        id_produit,
        prix,
        dateDebut,
        dateFin
    )
VALUES (
        1,
        2500000,
        '2026-01-01',
        NULL
    );

INSERT INTO
    HistoriquePrix (
        id_produit,
        prix,
        dateDebut,
        dateFin
    )
VALUES (2, 50000, '2026-01-01', NULL);

INSERT INTO
    HistoriquePrix (
        id_produit,
        prix,
        dateDebut,
        dateFin
    )
VALUES (3, 3000, '2026-01-01', NULL);

INSERT INTO
    HistoriquePrix (
        id_produit,
        prix,
        dateDebut,
        dateFin
    )
VALUES (4, 2500, '2026-01-01', NULL);

-- =========================
-- SOURCE
-- =========================
INSERT INTO source (libelle) VALUES ('Fournisseur principal');

INSERT INTO source (libelle) VALUES ('Import');

INSERT INTO source (libelle) VALUES ('Local');

-- =========================
-- TYPE MOUVEMENT STOCK
-- =========================
INSERT INTO typeMouvementStock (libelle) VALUES ('ENTREE');

INSERT INTO typeMouvementStock (libelle) VALUES ('SORTIE');

-- =========================
-- MOUVEMENT STOCK INITIAL
-- =========================
INSERT INTO
    mouvementStock (
        idSource,
        idTypeMouvementStock,
        date
    )
VALUES (1, 1, '2026-06-17 08:00:00');

INSERT INTO
    mouvementStockFille (
        idMouvementStock,
        quantite,
        idProduit
    )
VALUES (1, 10, 1),
    (1, 25, 2),
    (1, 100, 3),
    (1, 50, 4);

-- =========================
-- CAISSE
-- =========================
INSERT INTO
    caisse (designation, idSource)
VALUES ('Caisse principale', 1);

INSERT INTO
    caisse (designation, idSource)
VALUES ('Caisse secondaire', 2);

-- =========================
-- USERS
-- =========================
INSERT INTO users (username, password) VALUES ('admin', '123456');

INSERT INTO
    users (username, password)
VALUES ('manager', 'password');
