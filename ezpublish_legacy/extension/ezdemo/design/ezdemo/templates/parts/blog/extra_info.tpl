<h2>{"Tag cloud"|i18n("design/ezdemo/blog/extra_info")}</h2>
<article>
    <div class="attribute-tag-cloud">
    <p>
        {eztagcloud( hash( 'class_identifier', 'blog_post',
                           'parent_node_id', $used_node.node_id ) )}
    </p>
    </div>
</article>

{if $used_node.object.data_map.description.has_content}
<h2>{"Description"|i18n("design/ezdemo/blog/extra_info")}</h2>
<article>
    <div class="attribute-description">
        {attribute_view_gui attribute=$used_node.object.data_map.description}
    </div>
</article>
{/if}

<h2>{"Tags"|i18n("design/ezdemo/blog/extra_info")}</h2>
<article>
    <div class="attribute-tags">
        <ul>
        {foreach ezkeywordlist( 'blog_post', $used_node.node_id ) as $keyword}
            <li><a href={concat( $used_node.url_alias, "/(tag)/", $keyword.keyword|rawurlencode )|ezurl} title="{$keyword.keyword}">{$keyword.keyword} ({fetch( 'content', 'keyword_count', hash( 'alphabet', $keyword.keyword, 'classid', 'blog_post','parent_node_id', $used_node.node_id ) )})</a></li>
        {/foreach}
        </ul>
    </div>
</article>

<h2>{"Archive"|i18n("design/ezdemo/blog/extra_info")}</h2>
<article>
    <div class="attribute-archive">
        <ul>
        {foreach ezarchive( 'blog_post', $used_node.node_id ) as $archive}
            <li><a href={concat( $used_node.url_alias, "/(month)/", $archive.month, "/(year)/", $archive.year )|ezurl} title="">{$archive.timestamp|datetime( 'custom', '%F %Y' )}</a></li>
        {/foreach}
        </ul>
    </div>
</article>

{include uri='design:parts/blog/calendar.tpl'}
