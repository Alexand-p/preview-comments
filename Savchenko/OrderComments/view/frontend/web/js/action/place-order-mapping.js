define([
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/url-builder',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/place-order',
    'uiRegistry',

], function (quote, urlBuilder, customer, placeOrderService, uiRegistry) {
    'use strict';

    return function (paymentData, messageContainer) {
        var serviceUrl, payload;

        payload = {
            cartId: quote.getQuoteId(),
            billingAddress: quote.billingAddress(),
            paymentMethod: paymentData,
        };

        if(uiRegistry.get("index = Order_Comments")){
            payload.paymentMethod.extension_attributes = {
                order_comments: uiRegistry.get("index = Order_Comments").value(),
            };
        }

        if (customer.isLoggedIn()) {
            serviceUrl = urlBuilder.createUrl('/carts/mine/payment-information', {});
        } else {
            serviceUrl = urlBuilder.createUrl('/guest-carts/:quoteId/payment-information', {
                quoteId: quote.getQuoteId()
            });
            payload.email = quote.guestEmail;
        }
        return placeOrderService(serviceUrl, payload, messageContainer);
    };
});


