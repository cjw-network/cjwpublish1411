<form action={concat($module.functions.edit.uri,"/",$userID)|ezurl} method="post" name="Edit">

<div class="user-edit">

<div class="attribute-header">
  <h1 class="long">{"User profile"|i18n("design/ezdemo/user/edit")}</h1>
</div>

<div class="block">
  <label>{"Username"|i18n("design/ezdemo/user/edit")}</label><div class="labelbreak"></div>
  <p class="box">{$userAccount.login|wash}</p>
</div>

<div class="block">
  <label>{"Email"|i18n("design/ezdemo/user/edit")}</label><div class="labelbreak"></div>
  <p class="box">{$userAccount.email|wash(email)}</p>
</div>

<div class="block">
  <label>{"Name"|i18n("design/ezdemo/user/edit")}</label><div class="labelbreak"></div>
  <p class="box">{$userAccount.contentobject.name|wash}</p>
</div>

{if fetch( 'user', 'has_access_to', hash( 'module', 'content',
                                          'function', 'edit' ) )}
<p><a href={"content/draft"|ezurl}>{"My drafts"|i18n("design/ezdemo/user/edit")}</a></p>
{/if}
{if fetch( 'user', 'has_access_to', hash( 'module', 'shop',
                                          'function', 'administrate' ) )}
<p><a href={concat("/shop/customerorderview/", $userID, "/", $userAccount.email)|ezurl}>{"My orders"|i18n("design/ezdemo/user/edit")}</a></p>
{/if}
{if fetch( 'user', 'has_access_to', hash( 'module', 'content',
                                          'function', 'pendinglist' ) )}
<p><a href={"/content/pendinglist"|ezurl}>{"My pending items"|i18n("design/ezdemo/user/edit")}</a></p>
{/if}
{if fetch( 'user', 'has_access_to', hash( 'module', 'notification',
                                          'function', 'use' ) )}
<p><a href={"notification/settings"|ezurl}>{"My notification settings"|i18n("design/ezdemo/user/edit")}</a></p>
{/if}
{if fetch( 'user', 'has_access_to', hash( 'module', 'shop',
                                          'function', 'buy' ) )}
<p><a href={"/shop/wishlist"|ezurl}>{"My wish list"|i18n("design/ezdemo/user/edit")}</a></p>
{/if}

<div class="buttonblock">
<input class="button" type="submit" name="EditButton" value="{'Edit profile'|i18n('design/ezdemo/user/edit')}" />
<input class="button" type="submit" name="ChangePasswordButton" value="{'Change password'|i18n('design/ezdemo/user/edit')}" />
</div>

</div>

</form>
