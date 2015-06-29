<li id="listItem_{ProductID}">{$Admin}
	{ProductNew}{ProductOffer}
	<a href="{URLName}" class="ViewProduct" title="{ProductName}">	
	<img class="item_foto"  src="/_FileSystems/images/{ProductImage}" alt="{ProductName}" />
	</a>
	<div class="ProductInfo">
		<h4 class="item_name">{ProductName}</h4>
		<span class="item_price">{ProductPrice}</span>
	  <form action="{RenderURL}?cart=stock_continue" method="post">
		<input type="text" name="new_amount" size="5" value="1"  class="item_quantity">
		<input type="hidden" name="price" value="{ProductPrice}">
		<input type="hidden" name="art_no" value="{ProductRef}">
		<input type="hidden" name="stock" value="{ProductStock}">
		<input type="hidden" name="product" value="{ProductName}">
		<input type="submit" name="submit" value="Agregar al carrito" class="item_add">
	  </form>
  </div>
</li>