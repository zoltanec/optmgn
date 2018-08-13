<{foreach item=category from=Store_Category::getChildCategories($pcategory->category_id, 0, true)}>
		<optgroup label="<{if $category->offset}>&nbsp;&nbsp;&nbsp;&nbsp;|-<{/if}><{$category->category_name}>">
		<{foreach item=product from=Store_Product::getProductsByCategoryy($category->category_id)}>
			<option value="<{$product->prod_id}>">|-<{$product->prod_name}></option>
		<{/foreach}>
		</optgroup>
<{/foreach}>