{* Quicktime - Full view *}

<div class="content-view-full">
    <div class="class-quicktime">

    <div class="attribute-header">
        <h1>{$node.name|wash()}</h2>
    </div>
    
    <div class="attribute-short">
        {attribute_view_gui attribute=$node.data_map.description}
    </div>

    <div class="content-media">
    {def $attribute=$node.data_map.file}
        <object {section show=$attribute.content.width|gt( 0 )}width="{$attribute.content.width}"{/section} {section show=$attribute.content.height|gt( 0 )}height="{$attribute.content.height}"{/section} codebase="http://www.apple.com/qtactivex/qtplugin.cab">
        <param name="movie" value={concat("content/download/",$attribute.contentobject_id,"/",$attribute.content.contentobject_attribute_id,"/",$attribute.content.original_filename)|ezurl} />
        <param name="controller" value="{section show=$attribute.content.has_controller}true{/section}" />
        <param name="autoplay" value="{section show=$attribute.content.is_autoplay}true{/section}" />
        <param name="loop" value="{section show=$attribute.content.is_loop}true{/section}" />
        <embed src={concat("content/download/",$attribute.contentobject_id,"/",$attribute.content.contentobject_attribute_id,"/",$attribute.content.original_filename)|ezurl}
               type="video/quicktime"
               pluginspage="{$attribute.content.pluginspage}"
               {section show=$attribute.content.width|gt( 0 )}width="{$attribute.content.width}"{/section} {section show=$attribute.content.height|gt( 0 )}height="{$attribute.content.height}"{/section} play="{section show=$attribute.content.is_autoplay}true{/section}"
               loop="{section show=$attribute.content.is_loop}true{/section}" controller="{section show=$attribute.content.has_controller}true{/section}" >
        </embed>
        </object>
    </div>

    </div>
</div>
