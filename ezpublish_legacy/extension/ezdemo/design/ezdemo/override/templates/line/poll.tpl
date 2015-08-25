{* Poll - Line view *}
{set-block scope=root variable=cache_ttl}900{/set-block}

<div class="content-view-line">
    <div class="class-poll">
        <h2><a href={$node.url_alias|ezurl}>{$node.name|wash()}</a></h2>

        <div class="attribute-byline">
            <p class="date">{$node.object.published|l10n(date)}</p>
            <p class="count">{"%count votes"|i18n( 'design/ezdemo/line/poll',, hash( '%count', fetch( content, collected_info_count, hash( object_id, $node.object.id ) ) ) )}</p>
            <div class="break"></div>
        </div>

        <div class="attribute-short">
        {attribute_view_gui attribute=$node.data_map.description}
        </div>


        <div class="attribute-link">
            <p><a href={$node.url_alias|ezurl}>{"Vote"|i18n("design/ezdemo/line/poll")}</a></p>
        </div>

    </div>
</div>
