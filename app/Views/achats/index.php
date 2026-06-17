<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Panier Achat</title>

    <style>
        table {
            width: 60%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        button {
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h2>Panier d'achat</h2>

    <!-- AJOUT PRODUIT -->
    <label>Produit :</label>
    <select id="produit">
            <?php foreach ($produits as $produit): ?>
            <option value="<?= $produit['id'] ?>" data-name="<?= $produit['designation'] ?>"
                data-price="<?= $produit['prix'] ?>">
                    <?= esc($produit['designation']) ?>
            </option>
            <?php endforeach; ?>
    </select>

    <label>Quantité :</label>
    <input type="number" id="quantite" min="1" value="1">

    <button type="button" id="btnAjouter" onclick="ajouterPanier()">Ajouter</button>
    <p id="stockInfo"></p>

    <hr>

    <form method="post" action="<?= site_url('achat/valider') ?>">

        <table id="tablePanier">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Sous-total</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody></tbody>

            <tfoot>
                <tr>
                    <td colspan="3"><b>Total</b></td>
                    <td colspan="2"><b id="total">0 Ar</b></td>
                </tr>
            </tfoot>
        </table>

        <!-- champs cachés -->
        <div id="inputsHidden"></div>

        <br>

        <button type="submit">Valider l'achat</button>

    </form>

    <script>
        let panier = [];
        const verifierStockUrl = "<?= site_url('achat/verifier-stock') ?>";

        document.getElementById('produit').addEventListener('change', verifierStockProduit);
        document.getElementById('quantite').addEventListener('input', verifierStockProduit);
        document.addEventListener('DOMContentLoaded', verifierStockProduit);

        function quantiteDansPanier(idProduit) {
            return panier
                .filter(item => item.id === idProduit)
                .reduce((total, item) => total + item.qty, 0);
        }

        async function verifierStockProduit() {
            let select = document.getElementById('produit');
            let quantiteInput = document.getElementById('quantite');
            let stockInfo = document.getElementById('stockInfo');
            let btnAjouter = document.getElementById('btnAjouter');

            let id = select.value;
            let qty = parseInt(quantiteInput.value) || 0;
            let nombre = qty + quantiteDansPanier(id);

            let formData = new FormData();
            formData.append('idproduit', id);
            formData.append('nombre', nombre);

            try {
                let response = await fetch(verifierStockUrl, {
                    method: 'POST',
                    body: formData
                });
                let data = await response.json();

                quantiteInput.max = data.stock;
                stockInfo.innerText = `Stock disponible : ${data.stock}`;

                if (!data.disponible) {
                    stockInfo.innerText += ' - quantité insuffisante';
                }

                btnAjouter.disabled = !data.disponible || qty <= 0;

                return data;
            } catch (error) {
                stockInfo.innerText = 'Impossible de vérifier le stock';
                btnAjouter.disabled = true;
                return {
                    stock: 0,
                    disponible: false
                };
            }
        }

        async function ajouterPanier() {
            let verification = await verifierStockProduit();

            if (!verification.disponible) {
                alert('Stock insuffisant pour ce produit');
                return;
            }

            let select = document.getElementById('produit');

            let id = select.value;
            let name = select.options[select.selectedIndex].dataset.name;
            let price = parseFloat(select.options[select.selectedIndex].dataset.price);

            let qty = parseInt(document.getElementById('quantite').value);

            if (!qty || qty <= 0) return;

            panier.push({
                id: id,
                name: name,
                qty: qty,
                price: price
            });

            renderPanier();
            verifierStockProduit();
        }

        function renderPanier() {
            let tbody = document.querySelector("#tablePanier tbody");
            let inputs = document.getElementById("inputsHidden");
            let totalEl = document.getElementById("total");

            tbody.innerHTML = "";
            inputs.innerHTML = "";

            let total = 0;

            panier.forEach((item, index) => {

                let subtotal = item.qty * item.price;
                total += subtotal;

                tbody.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>${item.qty}</td>
                <td>${item.price} Ar</td>
                <td>${subtotal} Ar</td>
                <td>
                    <button type="button" onclick="supprimer(${index})">X</button>
                </td>
            </tr>
        `;

                inputs.innerHTML += `
            <input type="hidden" name="panier[${index}][id]" value="${item.id}">
            <input type="hidden" name="panier[${index}][qty]" value="${item.qty}">
            <input type="hidden" name="panier[${index}][price]" value="${item.price}">
        `;
            });

            totalEl.innerText = total + " Ar";
        }

        function supprimer(index) {
            panier.splice(index, 1);
            renderPanier();
            verifierStockProduit();
        }
    </script>

</body>

</html>
