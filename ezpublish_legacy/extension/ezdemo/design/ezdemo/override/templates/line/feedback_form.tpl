{* Feedback form - Line view *}

<div class="content-view-line">
    <div class="class-feedback-form">

        <h2><a href={$node.url_alias|ezurl}>{$node.name|wash()}</a></h2>

        <div class="attribute-short">
                {attribute_view_gui attribute=$node.data_map.description}
        </div>

    </div>
</div>