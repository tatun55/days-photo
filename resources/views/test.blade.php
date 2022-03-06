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
            buttonColor: 'LightGray', // Gold,DarkGray,LightGray
            // configure Create Checkout Session request
            createCheckoutSessionConfig: {
                payloadJSON: '{"scopes": ["name", "email", "phoneNumber", "billingAddress"],"storeId":"amzn1.application-oa2-client.9f751aa7eed74bcaab087e055526b188","webCheckoutDetails":{"checkoutReviewReturnUrl":"https://days.photo/amazon-pay/review"}}', // string generated in step 2
                signature: 'GnsqNealsbT3tWCzt2gz2tI/bafLvyex5yrNJyJyxSQOoh4ot5qHaNHIe58a0HEio76ONOKzjRu3+3WGqY3rbulOrXIB7k3sXwSCQ16AvlV3joZcelnTl5e8fbHpYoK4oe/AhY+BRZCd83e5/Vb+BOESaUHZeIORCSpq1ww3n9IkqVbTOnXA1jhwOo6eo0VDU5WHoYpRFUEa2zvPNS7ivLu48XmdIdpMZeVZ8e/g7P0f8I9Ro360+aQi2GTs6uyKn8fDjG5CujGnY5+4s3HGL8FcWCCdIGP7QsGGaI+zsEhC7/tMON1RSJMRrdMSNiut/XaTDJp13uzU79Rf/nQvCg==', // signature generated in step 3
                publicKeyId: 'SANDBOX-AGD5WXBVODNZLYLNPJJEQBUU'
            }
        });

    </script>
</body>
