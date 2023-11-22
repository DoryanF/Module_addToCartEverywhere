{extends file='modules/ps_crossselling/views/templates/hook/ps_crossselling.tpl'}
{assign var="MyHoverColor" value={$btnColorHover}}

<style type="text/css">
    .btnAddToCart:hover {ldelim}
    background-color: {$MyHoverColor} !important;
    {rdelim}
</style>
    <div class="blockBtnAddAndQuantity">
    {if $btnDisplayQuantity == 0}
        <div class="divBtnAddToCart">
            <a href="{$links->getAddToCartURL($product.id_product,$product.id_product_attribute)}">
                <button type="submit" class="btnAddToCart" style="background-color: {$btnColorBackground}; color: {$btnColorText};">{$btnText}</button>
            </a>
        </div>
    {/if}

    {if $btnDisplayQuantity == 1}

        <div class="product-actions js-product-actions">
              <form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
                <input type="hidden" name="token" value="{$static_token}">
                <input type="hidden" name="id_product" value="{$product.id}" id="product_page_product_id">
                <input type="hidden" name="id_customization" value="{$product.id_customization}" id="product_customization_id" class="js-product-customization-id">
                {if !$configuration.is_catalog}
                
                    {block name='product_quantity'}
                      <div class="product-quantity clearfix divFormQtyBtn">
                        <div class="qty">
                          <div class="input-group bootstrap-touchspin">
                            <span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
                            <input
                              type="number"
                              name="qty"
                              id="quantity_wanted"
                              inputmode="numeric"
                              pattern="[0-9]*"
                              {if $product.quantity}
                                value="{$product.minimal_quantity}"
                                min="{$product.minimal_quantity}"
                              {else}
                                value="1"
                                min="1"
                              {/if}
                              class="input-group"
                              aria-label="{l s='Quantity' d='Shop.Theme.Actions'}"
                            >
                            <span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>

                            <span class="input-group-btn-vertical">
                              <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-up" type="button"><i class="material-icons touchspin-up"></i></button>
                              <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-down" type="button"><i class="material-icons touchspin-down"></i></button>
                            </span>

                          </div>
                        </div>
        
                        <div class="add">
                          <button
                            class="btn btn-primary add-to-cart btnAddToCart"
                            data-button-action="add-to-cart"
                            type="submit"
                            {if !$product.add_to_cart_url}
                              disabled
                            {/if}
                            style="background-color: {$btnColorBackground}; color: {$btnColorText};"
                          >
                            <i class="material-icons shopping-cart">&#xE547;</i>
                            {l s={$btnText} d='Shop.Theme.Actions'}
                          </button>
                        </div>
                
                        {hook h='displayProductActions' product=$product}
                      </div>
                    {/block}
                
                    {block name='product_availability'}
                      <span id="product-availability" class="js-product-availability">
                        {if $product.show_availability && $product.availability_message}
                          {if $product.availability == 'available'}
                            <i class="material-icons rtl-no-flip product-available">&#xE5CA;</i>
                          {elseif $product.availability == 'last_remaining_items'}
                            <i class="material-icons product-last-items">&#xE002;</i>
                          {else}
                            <i class="material-icons product-unavailable">&#xE14B;</i>
                          {/if}
                          {$product.availability_message}
                        {/if}
                      </span>
                    {/block}
                
                    {block name='product_minimal_quantity'}
                      <p class="product-minimal-quantity js-product-minimal-quantity">
                        {if $product.minimal_quantity > 1}
                          {l
                          s='The minimum purchase order quantity for the product is %quantity%.'
                          d='Shop.Theme.Checkout'
                          sprintf=['%quantity%' => $product.minimal_quantity]
                          }
                        {/if}
                      </p>
                    {/block}
                  {/if}
            </form>
          </div>
        
    {/if}
</div>