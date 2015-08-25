{* Quicktime - Line view *}

<div class="content-view-line">
    <div class="class-quicktime">

    <h2>{$node.name|wash}</h2>

    <div class="attribute-short">
        {attribute_view_gui attribute=$node.data_map.description}
    </div>

    <div class="attribute-link">
        <p><a href={$node.url_alias|ezurl}>{"View movie"|i18n("design/ezdemo/line/quicktime")}</a></p>
    </div>

    </div>
</div>
