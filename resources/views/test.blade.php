<body>
    <div id="AmazonPayButton"></div>
    <script src="https://static-fe.payments-amazon.com/checkout.js"></script>
    <script type="text/javascript" charset="utf-8">
        amazon.Pay.renderButton('#AmazonPayButton', {
            // set checkout environment
            merchantId: 'A1V2ZW022WI0BY',
            ledgerCurrency: 'JPY',
            sandbox: true,
            // customize the buyer experience
            checkoutLanguage: 'ja_JP',
            productType: 'PayAndShip',
            placement: 'Cart',
            buttonColor: 'Gold',
            // configure Create Checkout Session request
            createCheckoutSessionConfig: {
                payloadJSON: '{"storeId":"amzn1.application-oa2-client.9f751aa7eed74bcaab087e055526b188","webCheckoutDetails":{"checkoutReviewReturnUrl":"https://days.photo/amazon-pay/review"}}', // string generated in step 2
                signature: '04NY+F8jkX/GBVCo2g+GHUXQFSnwaOZoTotu0wMYQhBGIfQYE9xTlwhsXRx37Lv0nQlfbbbwl7S14fo+LToj0Vdxx25fRpI0yyYTomRU8avlHFSqwNfY/DeSzVB/6GwHPIo4uqQ9wU3MnIng312m5EC0aIR9tZW2pr8+VI1ByeM8RHKCkRVmo/JDZB4tHfs1dHz0AEFaqGh3VvFO9+Qd80MMnKaan+iynrsmV92edvhHDLqbmShnzBWQITLupF8H/bMQiHC8ugo5BR701/D/bZaNsqKCmgGK8+kygDpRjDAwxBCERW9AdoTqg73gW9m1MUhpNNgfg7EVhfpEEgU9QA==', // signature generated in step 3
                publicKeyId: 'SANDBOX-AGD5WXBVODNZLYLNPJJEQBUU'
            }
        });

    </script>
</body>
