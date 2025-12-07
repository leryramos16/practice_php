<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mini Game Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Game Store</h2>

    <div class="row" id="gamesList">
        <!-- Games will be dynamically added here -->
    </div>

    <hr>
    <h3>Cart</h3>
    <ul id="cartList" class="list-group"></ul>
</div>

<script>


// Sample games (in real app, you can fetch from API)
const games = [
    {id: 1, name: "Cyber Adventure", price: 50},
    {id: 2, name: "Pixel Quest", price: 30},
    {id: 3, name: "Speed Racer", price: 20},
];

function renderGames() {
    const container = document.getElementById("gamesList");
    container.innerHTML = "";
    games.forEach(game => {
        const div = document.createElement("div");
        div.className = "col-md-4 mb-3";
        div.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">${game.name}</h5>
                    <p class="card-text">Price: $${game.price}</p>
                    <button class="btn btn-primary" onclick="addToCart(${game.id})">Add to Cart</button>
                </div>
            </div>
        `;
        container.appendChild(div);
    });
}

function addToCart(gameId) {
    const data = { user_id: 1, game_id: gameId, quantity: 1 };
    fetch(`${ROOT}/api/addToCart`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
        alert(res.message);
        if(res.status === "success") fetchCart();
    });
}

function fetchCart() {
    fetch(`${ROOT}/api/cart?user_id=1`)
        .then(res => res.json())
        .then(res => {
            const cartList = document.getElementById("cartList");
            cartList.innerHTML = "";
            res.cart.forEach(item => {
                const li = document.createElement("li");
                li.className = "list-group-item d-flex justify-content-between align-items-center";
                li.innerHTML = `
                    ${item.name} x ${item.quantity} - $${item.price * item.quantity}
                    <button class="btn btn-sm btn-danger" onclick="removeFromCart(${item.game_id})">Remove</button>
                `;
                cartList.appendChild(li);
            });
        });
}

function removeFromCart(gameId) {
    const data = { user_id: 1, game_id: gameId };
    fetch(`${ROOT}/api/removeFromCart`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
        alert(res.message);
        fetchCart();
    });
}

// Initial render
renderGames();
fetchCart();
</script>
</body>
</html>
