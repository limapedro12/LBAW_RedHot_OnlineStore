try{
document.addEventListener('DOMContentLoaded', function () {
    const promoCodeForm = document.getElementById('promoCodeForm');

    promoCodeForm.addEventListener('submit', function (event) {
        event.preventDefault();
        console.log('Form submitted!');

        const promoCodeInput = document.getElementById('promotionCode');
        const promoCode = promoCodeInput.value;

        console.log('Promo code:', promoCode);

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch('/promo_codes/check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ promotionCode: promoCode })
        })
        .then(response => response.json())
        .then(data => {
            const promoCodeResult = document.getElementById('promoCodeResult');
        
            if (data.valid) {
                // Update the page content based on the response
                // For example, update a total value or show a success message
                promoCodeResult.textContent = 'Promo code aplicado com successo!';
                const total = document.getElementById('totalPrice');
                total.textContent = Math.round(((parseFloat(total.textContent) - (parseFloat(total.textContent) * parseFloat(data.data.desconto))) + Number.EPSILON) * 100) / 100;

                const checkoutLink = document.getElementById('checkoutLink');

                checkoutLink.href = 'cart/checkout?promocode=' + data.data.codigo;

                const divPromoCodeForm = document.getElementById('promoCodeFormDiv');
                divPromoCodeForm.classList.add('d-none');

                const promoCodeActive = document.getElementById('promoCodeActive');
                promoCodeActive.textContent = data.data.codigo;

                const promoCodeDiscount = document.getElementById('promoCodeDiscount');
                promoCodeDiscount.textContent = data.data.desconto * 100 + '%';

                const promoCodeRemove = document.getElementById('promoCodeApplied');
                promoCodeRemove.classList.remove('d-none');


            } else {
                // Handle invalid or expired promo code
                promoCodeResult.textContent = data.message;
            }
        })
        
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
} catch (e) {}

try {
document.addEventListener('DOMContentLoaded', function () {
    const promoCodeRemove = document.getElementById('promoCodeRemove');

    promoCodeRemove.addEventListener('click', function (event) {
        event.preventDefault();
        console.log('Form submitted!');

        const promoCodeInput = document.getElementById('promotionCode');
        const promoCode = promoCodeInput.value;

        console.log('Promo code:', promoCode);

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch('/promo_codes/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ promotionCode: promoCode })
        })
        .then(response => response.json())
        .then(data => {
            const promoCodeResult = document.getElementById('promoCodeResult');
        
            if (data.valid) {
                // Update the page content based on the response
                // For example, update a total value or show a success message
                promoCodeResult.textContent = 'Promo code removido com sucesso!';

                const divPromoCodeForm = document.getElementById('promoCodeFormDiv');
                divPromoCodeForm.classList.remove('d-none');

                promoCodeInput.value = '';

                const checkoutLink = document.getElementById('checkoutLink');

                checkoutLink.href = 'cart/checkout';

                const originalPrice = document.getElementById('totalPriceWithOutPromoCode');

                const total = document.getElementById('totalPrice');
                total.textContent = originalPrice.textContent;


                const promoCodeActive = document.getElementById('promoCodeActive');
                promoCodeActive.textContent = '';

                const promoCodeDiscount = document.getElementById('promoCodeDiscount');
                promoCodeDiscount.textContent = '';

                const promoCodeRemove = document.getElementById('promoCodeApplied');
                promoCodeRemove.classList.add('d-none');


            } else {
                // Handle invalid or expired promo code
                promoCodeResult.textContent = data.message;
            }

        }

        )

        .catch(error => {
            console.error('Error:', error);
        });

    });

});
} catch (e) {}


