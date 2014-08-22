(function () {
    tinymce.create ("tinymce.plugins.AdvancedLinkPlugin", {init: function (a, b) {
            this.editor = a;
            a.addCommand ("mceAdvLink", function () {
                var c = a.selection;
                if (c.isCollapsed () && ! a.dom.getParent (c.getNode (), "A")) {
                    return
                }
                a.windowManager.open ({file: b + "/link.htm", width: 480 + parseInt (a.getLang ("advlink.delta_width", 0)), height: 400 + parseInt (a.getLang ("advlink.delta_height", 0)), inline: 1}, {plugin_url: b})
            });
            a.addButton ("link", {title: "advlink.link_desc", cmd: "mceAdvLink"});
            a.addShortcut ("ctrl+k", "advlink.advlink_desc", "mceAdvLink");
            a.onNodeChange.add (function (d, c, f, e) {
                c.setDisabled ("link", e && f.nodeName != "A");
                c.setActive ("link", f.nodeName == "A" && ! f.name)
            })
        }, getInfo: function () {
            return{longname: "Advanced link", author: "Moxiecode Systems AB", authorurl: "http://tinymce.moxiecode.com", infourl: "http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/advlink", version: tinymce.majorVersion + "." + tinymce.minorVersion}
        }});
    tinymce.PluginManager.add ("advlink", tinymce.plugins.AdvancedLinkPlugin)
}) ();