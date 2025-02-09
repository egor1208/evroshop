document.addEventListener('DOMContentLoaded', function() {
    // Обработчик добавления в корзину
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            fetch('add-to-cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Товар добавлен в корзину!');
                    // Обновление количества товаров в корзине в шапке
                    if (data.cartCount) {
                        document.querySelector('.cart-count').textContent = data.cartCount;
                    }
                } else {
                    alert(data.message || 'Произошла ошибка');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при добавлении товара в корзину');
            });
        });
    });

    // Автоматическая отправка формы при изменении селектов
    document.querySelectorAll('.filter-form select').forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
}); 