NetgenTagsBundle (eZTags) mit CJWPublish verwenden
==================================================

[Confluence-Link](https://team.in-mv.com/confluence/display/CJWPUB/NetgenTagsBundle+%28eZTags%29+mit+CJWPublish+verwenden)

Da sich die alte eZTags-Extension nicht so ohne weiteres mit eZPublish 5 benutzen lässt, benötigen wir ein Bundle, dass das für uns erledigt. *Netgen* hat dazu ein Bundle geschrieben, dass die notwendigen Funktionalitäten in eZPublish 5 bereit stellt.

Bundle einrichten
-----------------

Bevor das Bundle ordnungsgemäß genutzt werden kann, muss es erst in unserem SiteBundle aktiviert werden, das Routing zu den Funktionen eingetragen werden und das Standard-Template für die Tags überschrieben werden.

### Bundle aktivieren

Um das Bundle zu aktivieren, müssen wir es dem **$bundles** array hinzufügen. Das machen wir in unserer *app/config/JacSiteSITENAMEKernel.php*-Datei, indem wir der **registerBundles**-Funktion folgende Zeile hinzufügen

```php
<?php
    $bundles[] = new Netgen\TagsBundle\NetgenTagsBundle();
?>
```

Damit haben wir das Bundle unserem SiteBundle bekannt gemacht und es aktiviert.

### Routing eintragen

Nun müssen wir unserem SiteBundle die Funktionalitäten des *NetgenTagBundle*s bekannt machen. Dazu erweitern wir entweder die *app/config/routing.yml* oder (besser) die *Resource/config/routing.yml* mit folgender Zeile:

```yaml
_eztagsRoutes:
    resource: "@NetgenTagsBundle/Resources/config/routing.yml"
```

Damit können nun die Routen des TagBundles genutzt werden, um z.B. eine gefilterte Liste nach einem bestimmten Tag zu erhalten.

### NetgenTagsBundle Template(s) überschreiben

Als letztes müssen wir noch das Standard-View-Tempalte des *NetgenTagBundle*s überschreiben, da dieses auf das *eZDemoBundle* verweist, welches wir aber nicht nutzen wollen. Außerdem müssen wir ein Field-Template für das **ez_tags**-Field erstellen oder das Field-Template aus dem *NetgenTagsBundle* in unserer **override.yml** eintragen.

Um das Standard-View-Template zu überschreiben, kopieren wir es von *Netgen/TagsBundle/Resources/views/tag/view.html* in unseren SiteBundle-Ordner nach *app/Resources/NetgenTagsBundle/views/tag/view.html*. Alternativ kann auch der ganze *views*-Ordner kopiert werden. Wichtig ist, dass der Pfad exakt erhalten bleibt.