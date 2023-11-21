{*dump($btnColorHover)*}
{assign var="MyHoverColor" value={$btnColorHover}}

<style type="text/css">
    .btnAddToCart:hover {ldelim}
    background-color: {$MyHoverColor} !important;
    {rdelim}
</style>

<div class="blockBtnAddAndQuantity">
    <div class="divBtnAddToCart">
        <a href="{$links->getAddToCartURL($product.id_product,$product.id_product_attribute)}">
            <button type="submit" class="btnAddToCart" style="background-color: {$btnColorBackground}; color: {$btnColorText};">{$btnText}</button>
        </a>
    </div>

    {if $btnDisplayQuantity == 1}
        <div class="divBtnQuantity">
            <div class="input-group bootstrap-touchspin">

                <span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
                    <input id="quantity_wanted" class="input-group form-control" type="number" name="qty" inputmode="numeric" pattern="[0-9]*" 
                    {if $product.quantity_wanted}
                        value="{$product.quantity_wanted}"
                        min="{$product.minimal_quantity}"
                    {else}
                        value="1" min="1" 
                    {/if}
                        aria-label="Quantité" style="display: block;">
                <span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>

                <span class="input-group-btn-vertical">
                    <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-up" type="button"><i class="material-icons arrow-up js-arrow-up">&#xE316;</i>
                
                    <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-down" type="button"><i class="material-icons arrow-down js-arrow-down">&#xE313;</i></button></button>
                </span>
            </div>
        </div>
    {/if}
</div>