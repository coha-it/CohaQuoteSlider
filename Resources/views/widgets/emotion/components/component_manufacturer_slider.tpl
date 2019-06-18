{extends file="parent:widgets/emotion/components/component_manufacturer_slider.tpl"}

{block name="frontend_widgets_manufacturer_slider"}
    <div class="emotion--manufacturer {if !$Data.no_border} has--border{/if}">

        {* Manufacturer Content *}
        {block name="frontend_widgets_manufacturer_slider_content"}
            <div class="manufacturer--content">

                {block name="frontend_widgets_manufacturer_slider_container"}
                    <div class="manufacturer--slider product-slider"
                         data-product-slider="true"
                         data-itemMinWidth="280"
                         data-arrowControls="{if $Data.manufacturer_slider_arrows == 1}true{else}false{/if}"
                         data-autoSlide="{if $Data.manufacturer_slider_rotation == 1}true{else}false{/if}"
                         {if $Data.manufacturer_slider_scrollspeed}data-animationSpeed="{$Data.manufacturer_slider_scrollspeed}"{/if}
                         {if $Data.manufacturer_slider_rotatespeed}data-autoSlideSpeed="{$Data.manufacturer_slider_rotatespeed / 1000}"{/if}>

                        <div class="product-slider--container">
                            {foreach $Data.values as $supplier}
                                {if !$supplier.link}
                                    {$supplier.link = {url module=frontend controller=listing action=manufacturer sSupplier=$supplier.id}}
                                {/if}

                                {block name="frontend_widgets_manufacturer_slider_item"}
                                    {$coha_is_quote_person      = $supplier.attributes.core->get('coha_is_quote_person')}
                                    {if $coha_is_quote_person}

                                        {$coha_quote_content        = $supplier.attributes.core->get('coha_quote_content')}
                                        {$coha_quote_content        = $supplier.attributes.core->get('coha_quote_content')}
                                        {$coha_quote_content        = $supplier.attributes.core->get('coha_quote_content')}
                                        {$coha_quote_classes        = $supplier.attributes.core->get('coha_quote_classes')}
                                        {$coha_quote_html_tags      = $supplier.attributes.core->get('coha_quote_html_tags')}

                                        <div class="manufacturer--item product-slider--item quote--item" style="width: 100%;">
                                            {block name="frontend_widgets_manufacturer_slider_item_link"}
                                                <div class="quote--inner {if $coha_quote_classes}{$coha_quote_classes}{/if}" {if $coha_quote_html_tags} {$coha_quote_html_tags} {/if}>
                                                    {if $supplier.image}
                                                        {block name="frontend_widgets_manufacturer_slider_item_quote_image"}
                                                            <img class="quote--image" src="{$supplier.image}" alt="{$supplier.name|escape}" />
                                                        {/block}
                                                    {/if}

                                                    {block name="frontend_widgets_manufacturer_slider_item_quote_content"}
                                                        <div class="quote--content" title="{$supplier.name|escape}">
                                                            {if $coha_quote_content}
                                                                {$coha_quote_content}
                                                            {else}
                                                                {$supplier.description}
                                                            {/if}
                                                        </div>
                                                    {/block}
                                                </div>
                                            {/block}
                                        </div>

                                    {else}
                                        <div class="manufacturer--item product-slider--item">
                                            {block name="frontend_widgets_manufacturer_slider_item_link"}
                                                <a href="{$supplier.link}" title="{$supplier.name|escape}" class="manufacturer--link">
                                                    {if $supplier.image}
                                                        {block name="frontend_widgets_manufacturer_slider_item_image"}
                                                            <img class="manufacturer--image" src="{$supplier.image}" alt="{$supplier.name|escape}" />
                                                        {/block}
                                                    {else}
                                                        {block name="frontend_widgets_manufacturer_slider_item_text"}
                                                            <span class="manufacturer--name">{$supplier.name}</span>
                                                        {/block}
                                                    {/if}
                                                </a>
                                            {/block}
                                        </div>
                                    {/if}
                                {/block}

                            {/foreach}
                        </div>
                    </div>
                {/block}
            </div>
        {/block}
    </div>
{/block}



