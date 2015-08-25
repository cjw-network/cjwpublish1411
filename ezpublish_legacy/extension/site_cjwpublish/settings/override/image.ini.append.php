<?php /* #?ini charset="utf-8"?

#
#  ext-siteaccess-override
#

[AliasSettings]
# Defines a list of aliases that are available to
# the template engine and other clients.
# The alias must be defined as a separate INI block.
AliasList[]
#AliasList[]=crop_reference
#AliasList[]=crop_preview
AliasList[]=reference
AliasList[]=small
AliasList[]=medium
AliasList[]=large

[ImageMagick]
# Filters[]=filter/sharpen=-sharpen 0x1#Filters[]=strip=-strip
# alle exif daten löschen um bildgröße zu minimieren
Filters[]=strip=+profile "*" +comment

# originalbild verkleinern
# um speicherplatz zu sparen
#[original]
#Filters[]
#Filters[]=geometry/scaledownonly=1280;1280

# referencebild vom original erstellen ohne exif daten => spart ca 10kbyte pro bild
# alle variationen brauchen diese daten nicht mehr
# über eigenen strip= filter
[reference]
Filters[]
Filters[]=strip=
Filters[]=geometry/scaledownonly=1024;1280

#[crop_reference]
#Reference=original
#Filters[]
#Filters[]=strip=
#Filters[]=jacimagemanipulation/crop=

#[crop_preview]
#Reference=original
#Filters[]
#Filters[]=strip=
#Filters[]=geometry/scaledownonly=320;320

[small]
Reference=reference
Filters[]
Filters[]=geometry/scalewidthdownonly=120;120

[medium]
Reference=reference
Filters[]
Filters[]=geometry/scaledownonly=320;320

[large]
Reference=reference
Filters[]
Filters[]=geometry/scaledownonly=640;480

*/ ?>
