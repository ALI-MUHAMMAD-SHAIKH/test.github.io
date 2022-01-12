// Select Elelments \\
const productsEl = document.querySelector("#products");
const cartCountEl = document.querySelector(".cart-count");
const cartItemsEl = document.querySelector(".cart-items");
const totalEl = document.querySelector(".total");

//  GET ALL PRODUCTS \\
let products = "";
let apiUrl = "http://localhost/xpreskart/wp-json/xpr/v1/products"

async function getJson(apiUrl) {
  let response = await fetch(apiUrl);
  let data = await response.json()
  return data;
}
// console.log(getJson(apiUrl));
async function main() {
  products = await getJson(apiUrl)
  // console.log(products);

  // RENDER PRODUCTS \\
  function renderProducts() {
    products.forEach((product) => {
      productsEl.innerHTML += `
            <div class="col-3">
                <div class="card h-100">
                <a href="${product.title}"><img src="${product.fImg}" class="card-img-top" alt="${product.title}">
                <div class="card-body text-center">
                    <h6 class="card-title">${product.title}</h6></a>
                    <p class="card-text">${product.excerpt}</p>
                    <p class="card-text"><strong class="text-muted"><strike>${product.mrp}</strike></strong></p>
                    <p class="card-text"><b>${product.price}</b></p>
                    <button onclick=addToCart("${product.id}") id="cart" class="btn btn-outline-primary btn-sm">Add to Cart</button>
                </div>
                </div>
            </div>
            `;
    });
  }
  renderProducts();
}

main();

// CART ARRAY\\
let cart = JSON.parse(localStorage.getItem('cart')) || [];
// console.log(cart);
updateCart();

// ADD TO CART \\
function addToCart(id) {
  // check if product already exist in cart
  if (cart.some((item) => item.id === parseInt(id))) {
    // console.log(cart[0].title);
    // alert(cart[0].title+" is already in cart");
    changeNumberOfUnits("plus", parseInt(id));
  } else {
    // console.log(id);// cart product id's
    const item = products.find(product => product.id === parseInt(id));

    // console.log(item);
    cart.push({
      ...item,
      qty: 1,
    });
    // console.log(cart);
    localStorage.setItem("cart", JSON.stringify(cart));
  }
  updateCart();
}

// UPDATE CART \\
function updateCart() {
  renderCartItems();
  renderTotal();
  // save cart to local storage
  localStorage.setItem("cart", JSON.stringify(cart));
}

// CALCULATE & RENDER TOTALS
function renderTotal() {
  let totalPrice = 0, totalItems = 0;

  cart.forEach((item) => {
    totalPrice += item.price * item.qty;
    // console.log(item.id);
    totalItems += item.qty;
    //   console.log(totalPrice);
  });
  // cartCount = JSON.parse(localStorage.cart).length || [];
  cartCountEl.innerHTML = totalItems;
  totalEl.innerHTML = `Total (${totalItems} items): ₹ ${totalPrice.toFixed(2)}`;

}

// RENDER CART ITEMS \\
function renderCartItems() {
  let subTotalPrice = 0;
  // HAVERSINE FORMULA \\
  let lat1 = 12.52800929194333;// zeenath lat
  let lon1 = 76.90926001315462;// zeenath lon
  let lat2 = 12.52716041273515;// Haripriya lat
  let lon2 = 76.88366198431865;// Haripriya lon
  const R = 6371e3; // metres
  const φ1 = lat1 * Math.PI / 180; // φ, λ in radians
  const φ2 = lat2 * Math.PI / 180;
  const Δφ = (lat2 - lat1) * Math.PI / 180;
  const Δλ = (lon2 - lon1) * Math.PI / 180;

  const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
  Math.cos(φ1) * Math.cos(φ2) *
  Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  const d1 = R * c; // in metres  
  const d = (d1 / 1000).toPrecision(3); // 2.78 KM
  
  cartItemsEl.innerHTML = ""; // clear cart element
  cart.forEach((item) => {

    subTotalPrice = item.price * item.qty;
    // console.log(subTotalPrice);
    cartItemsEl.innerHTML += `
            <tr>
                <td><img src="${item.fImg}" onclick="removeItemFromCart(${item.id})" class="cartimg-thumb"></td>
                <td>${item.id}</td>
                <td>${item.title}</td>
                <td>
                <div class="row_qty" style="display: block ruby;">
                    <div class="btn minus" onclick="changeNumberOfUnits('minus', ${item.id})">-</div>
                    <div class="number">${item.qty}</div>
                    <div class="btn plus" onclick="changeNumberOfUnits('plus', ${item.id})">+</div>           
                </div>
                </td>
                <td>${item.price}</td>
                <td>${subTotalPrice}</td>
            </tr>
        `;
  });
}
// REMOVE ITEM FROM CART \\
function removeItemFromCart(id) {
  cart = cart.filter((item) => item.id !== parseInt(id));

  updateCart();
}

// CHANGE NUMBER OF QUANTITY \\
function changeNumberOfUnits(action, id) {
  cart = cart.map((item) => {
    let qty = item.qty;

    if (item.id === parseInt(id)) {
      if (action === "minus") {
        qty--;
      } else if (action === "plus") {
        qty++;
      }//else if ( qty === 0) {
      //qty = 1;
      //}
    }

    return {
      ...item,
      qty,
    };
  });

  updateCart();
}