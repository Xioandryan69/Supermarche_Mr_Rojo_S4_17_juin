PRAGMA foreign_keys = ON;

CREATE TABLE categorie (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

CREATE TABLE produit (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    designation TEXT NOT NULL,
    id_categorie INTEGER,
    FOREIGN KEY (id_categorie) REFERENCES categorie (id)
);

CREATE TABLE HistoriquePrix (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_produit INTEGER,
    prix REAL NOT NULL,
    dateDebut DATE NOT NULL,
    dateFin DATE,
    FOREIGN KEY (id_produit) REFERENCES produit (id)
);

CREATE TABLE typeMouvementStock (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

CREATE TABLE source (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

CREATE TABLE mouvementStock (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idSource INTEGER,
    date DATE NOT NULL,
    FOREIGN KEY (idSource) REFERENCES source (id)
);

CREATE TABLE mouvementStockFille (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idMouvementStock INTEGER,
    quantite INTEGER NOT NULL,
    idProduit INTEGER,
    FOREIGN KEY (idMouvementStock) REFERENCES mouvementStock (id),
    FOREIGN KEY (idProduit) REFERENCES produit (id)
);

CREATE TABLE caisse (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    designation TEXT NOT NULL,
    idSource INTEGER,
    FOREIGN KEY (idSource) REFERENCES source (id)
);

CREATE TABLE achatMere (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idCaisse INTEGER,
    date DATE NOT NULL,
    FOREIGN KEY (idCaisse) REFERENCES caisse (id)
);

CREATE TABLE achatFille (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idAchatMere INTEGER,
    idProduit INTEGER,
    quantite INTEGER NOT NULL,
    FOREIGN KEY (idAchatMere) REFERENCES achatMere (id),
    FOREIGN KEY (idProduit) REFERENCES produit (id)
);

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    password TEXT NOT NULL
);