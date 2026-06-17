PRAGMA foreign_keys = ON;

INSERT OR IGNORE INTO typeMouvementStock (id, libelle) VALUES (1, 'ENTREE');
INSERT OR IGNORE INTO typeMouvementStock (id, libelle) VALUES (2, 'SORTIE');

UPDATE typeMouvementStock SET libelle = 'ENTREE' WHERE id = 1;
UPDATE typeMouvementStock SET libelle = 'SORTIE' WHERE id = 2;

INSERT OR IGNORE INTO mouvementStock (
    id,
    idSource,
    idTypeMouvementStock,
    date
) VALUES (
    1,
    1,
    1,
    '2026-06-17 08:00:00'
);

INSERT OR IGNORE INTO mouvementStockFille (
    id,
    idMouvementStock,
    quantite,
    idProduit
) VALUES
    (1, 1, 10, 1),
    (2, 1, 25, 2),
    (3, 1, 100, 3),
    (4, 1, 50, 4);
