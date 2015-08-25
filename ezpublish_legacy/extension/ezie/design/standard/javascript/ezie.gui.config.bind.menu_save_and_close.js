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
var b;

ezie.gui.config.bind.reload_saved = function(new_block) {
    var button = ezie.gui.eziegui.getInstance().button();
    b = button;
    var ez_edit_block = button.closest('fieldset');

    ez_edit_block.find('div.block').remove();

    ez_edit_block.find('legend:first').after(new_block);

    ez_edit_block.find(".ezieEditButton").ezie();
}

ezie.gui.config.bind.menu_save_and_close = function() {
    if (!ezie.gui.eziegui.isInstanciated()) {
        return;
    }

    $.log('starting save + close');

    ezie.gui.config.zoom().reset();

    ezie.ezconnect.connect.instance().action({
        'action': 'save_and_quit',
        'success': function(response) {
            ezie.gui.config.bind.reload_saved(response);
            $('#main_image, #miniature').empty();
            ezie.gui.eziegui.getInstance().close();

            $('#ezieToolsWindow').find('.current').removeClass('current');
            $('#ezie_zoom').parent().addClass('current');

            ezie.gui.eziegui.getInstance().desactivateUndo();
            ezie.gui.eziegui.getInstance().desactivateRedo();
        },
        dataType: 'html'
    });
}
