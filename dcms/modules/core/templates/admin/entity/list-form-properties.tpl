<{foreach item=block from=Core_Entity_iBlock::getBlocksByParent(get_class($object))}>
	<{if $object->sid==$block->sid}>
		<{foreach item=property from=Core_Entity_Property::getProperties($block->block_id)}>
			<{if !$property->prop_key}>
				<{if D::getContext()=="admin"}>
				<tr>
					<td><{$property->prop_name}></td>
					<td><{include file="core;admin/entity/form-property.tpl"}></td>
				</tr>
				<{else}>
					<table>
						<tr><td><{$property->prop_name}></td>
						<td><{include file="core;admin/entity/form-property.tpl"}></td>
						</tr>
					</table>
				<{/if}>
			<{/if}>
		<{/foreach}>
	<{/if}>
<{/foreach}>