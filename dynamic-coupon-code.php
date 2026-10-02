<?php

add_action('woocommerce_applied_coupon', 'add_product_when_coupon_is_applied', 10, 1);

function add_product_when_coupon_is_applied($coupon_code) {
    // Define the coupon code and the product ID you want to add
    $target_coupon = 'simplified'; // Replace with your coupon code
    $product_id_to_add = 416; // Replace with the product ID you want to add to the cart
    $quantity = 2;

    // Check if the applied coupon matches the target coupon
    if (strcasecmp($coupon_code, $target_coupon) === 0) {

        // Get the cart object
        $cart = WC()->cart;

        // Check if the product is already in the cart
        $is_already_in_cart = false;
        foreach ($cart->get_cart() as $cart_item) {
            if ((int) $cart_item['product_id'] === $product_id_to_add) {
                $is_already_in_cart = true;
                break;
            }
        }

        // If the product is not already in the cart, add it
        if (!$is_already_in_cart) {

            for ($i=0; $quantity > $i; $quantity--) {
                $cart->add_to_cart($product_id_to_add);
            }

            // Optional: Add a notice to let the user know the product has been added
            wc_add_notice(__('A special product has been added to your cart!', 'your-text-domain'), 'success');
        }
    }
}


add_action('woocommerce_removed_coupon', 'remove_product_when_coupon_is_removed', 10, 1);

function remove_product_when_coupon_is_removed($coupon_code) {
    // Define the coupon code and the product ID you want to remove
    $target_coupon = 'simplified'; // Replace with your coupon code
    $product_id_to_remove = 416; // Replace with the product ID you want to remove

    // Check if the removed coupon matches the target coupon
    if (strcasecmp($coupon_code, $target_coupon) === 0) {
        // Get the cart object
        $cart = WC()->cart;

        // Loop through the cart and remove the product if it matches
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            if ((int) $cart_item['product_id'] === $product_id_to_remove) {
                $cart->remove_cart_item($cart_item_key);

                // Optional: Add a notice to inform the user
                wc_add_notice(__('A special product has been removed from your cart.', 'your-text-domain'), 'notice');
                break;
            }
        }
    }
}
