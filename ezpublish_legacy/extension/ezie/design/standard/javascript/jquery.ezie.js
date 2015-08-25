// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Image Editor extension for eZ Publish
// SOFTWARE RELEASE: 0.1 (preview only)
// COPYRIGHT NOTICE: Copyright (C) 1999-2014 eZ Systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##

(function($) {
    $.log = function(msg) {
        if ( window.console !== undefined )
            console.log( msg );
    }

    $.fn.ezie = function() {
        this.each(function() {
            $(this).click(function() {
                var url = $(this).attr('name');

                if (url.indexOf('ezieEdit[') != 0) {
                    return;
                }

                url = url.substring(9, url.lastIndexOf(']'));
                e = ezie.gui.eziegui.getInstance();
                // opening ui with the url to call to prepare the image to be
                // edited
                e.open(url, this);
            });
        });
        return this;
    };

    $.fn.freeze = function (opacity) {
        var params = $.extend({
            opacity:0.6
        },
        opacity
        );
        function freeze(j) {
            j.css("opacity", params.opacity);
        }
        return this.each(function() {
            freeze($(this));
        })
    }

    $.fn.unfreeze = function (opacity) {
        var params = $.extend({
            opacity:1
        },
        opacity
        );
        function unfreeze(j) {
            j.css("opacity", params.opacity);
        }
        return this.each(function() {
            unfreeze($(this));
        })
    }

})(jQuery);
