<?php
ob_start();
session_start();

include '../config/config.php';

// Vérification de la présence du paramètre "id" dans l'URL
if (!isset($_GET['id'])) {
    echo "Paramètre 'id' manquant dans l'URL.";
    exit();
}

// Récupération de l'ID de l'article depuis le paramètre GET
$CocktailId = $_GET['id'];

// Récupération du cocktail depuis la base de données
$sql = "SELECT *
        FROM Cocktails_Ingredients, Cocktails, Ingredients, Files
        WHERE Cocktails.id = Cocktails_Ingredients.CocktailID
        AND Ingredients.id = Cocktails_Ingredients.IngredientID
        AND Cocktails_Ingredients.CocktailID = :id
        AND Cocktails.ImageID = Files.id";
$query = $dbh->prepare($sql);
$query->bindParam(":id", $CocktailId, PDO::PARAM_INT);
$query->execute();
$item = $query->fetchAll(PDO::FETCH_ASSOC);

// Vérification si l'article existe
if (count($item) == 0) {
    echo "Cocktail non trouvé.";
    exit();
}

$title = $item[0]['CocktailLibelle'];
$imagePath = $item[0]['Path'];

$rootDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/';
$rootDir = basename(dirname($rootDir));
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

$pricePerItem = 10; //A CHANGER
$totalAmount = $quantity * $pricePerItem;
// Affichage des résultats
?>

<title>Formulaire de commande</title>
<style>
    .item-image {
        width: 200px;
        height: 200px;
        object-fit: cover;
    }

    .order-form {
        max-width: 500px;
        margin: 0 auto;
    }

    .total-amount {
        font-size: 24px;
    }
</style>

<div class="container">
    <div class="order-form">
        <div class="card">
            <img class="card-img-top shadowCook" src="<?php echo DIRECTORY_SEPARATOR . $rootDir . DIRECTORY_SEPARATOR . $imagePath; ?>" alt="Item Image">
            <div class="card-body">
                <h5 class="card-title"><?php echo $title; ?></h5>
                <form id="order-form" method="POST">
                    <div class="form-group">
                        <label for="quantity">Quantité :</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="<?php echo $quantity; ?>">
                    </div>
                    <h5 class="total-amount">Total : $<?php echo $totalAmount; ?></h5>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // ... Votre code JavaScript ici ...
</script>

<?php
$content = ob_get_clean();
include 'layout.php';
?>