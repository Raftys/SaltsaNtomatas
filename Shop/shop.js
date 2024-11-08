document.addEventListener('DOMContentLoaded', function () {
    fetch('../Shop/fetch_products.php')
        .then(response => response.json())
        .then(data => {
            const itemList = document.querySelector('.item-list');
            if (data.length > 0) {
                data.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.classList.add('item');
                    itemDiv.setAttribute("product_id",item.id);
                    let offerHTML = '';
                    if (item.offer != null) {
                        offerHTML = `<p id="product-offer" class="product-offer">${item.offer}</p>`;
                    }
                    itemDiv.innerHTML = `
                        <img src="${item.image}" alt="">
                        <div class="item-text">
                            <h2 style="color: ${item.offer != null ? 'red' : 'initial'}">${item.name}</h2>
                            ${offerHTML}
                            <p>${item.description}</p>
                            <p>Τιμή: ${parseFloat(item.price).toFixed(2)}€</p>                       
                        </div>
                        <button class="buy-button" >Προσθήκη</button>
                    `;
                    itemList.appendChild(itemDiv);

                    itemDiv.addEventListener('click', function () {
                        const productId = this.getAttribute('product_id'); // Get product ID from clicked item
                        window.location.href = `Product/product.html?product_id=${productId}`;
                    });
                    const buyButton = itemDiv.querySelector('.buy-button');
                    buyButton.addEventListener('click', function (event) {
                        event.stopPropagation(); // Prevent the itemDiv click event from firing
                        addItems(item.id,item.name,item.price,item.image,item.offer,1);
                        loadItemName(item.id).then(itemName => {
                            if (itemName) { // Ensure itemName is valid
                                showNotification(`Το προϊόν ${itemName} έχει προστεθεί στο καλάθι σας.`,"notification");
                            } else {
                                showNotification("Προϊόν δεν βρέθηκε.","notification"); // Fallback message if item name is not retrieved
                            }
                        });
                    });
                });
            } else {
                itemList.innerHTML = '<p>No items found.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching items:', error);
        });
});
