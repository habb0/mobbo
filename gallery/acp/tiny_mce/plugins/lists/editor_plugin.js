(function () {
    var e = tinymce.each, r = tinymce.dom.Event, g;
    function p (t, s) {
        while (t && (t.nodeType === 8 || (t.nodeType === 3 && /^[ \t\n\r]*$/.test (t.nodeValue)))) {
            t = s (t)
        }
        return t
    }
    function b (s) {
        return p (s, function (t) {
            return t.previousSibling
        })
    }
    function i (s) {
        return p (s, function (t) {
            return t.nextSibling
        })
    }
    function d (s, u, t) {
        return s.dom.getParent (u, function (v) {
            return tinymce.inArray (t, v) !== - 1
        })
    }
    function n (s) {
        return s && (s.tagName === "OL" || s.tagName === "UL")
    }
    function c (u, v) {
        var t, w, s;
        t = b (u.lastChild);
        while (n (t)) {
            w = t;
            t = b (w.previousSibling)
        }
        if (w) {
            s = v.create ("li", {style: "list-style-type: none;"});
            v.split (u, w);
            v.insertAfter (s, w);
            s.appendChild (w);
            s.appendChild (w);
            u = s.previousSibling
        }
        return u
    }
    function m (t, s, u) {
        t = a (t, s, u);
        return o (t, s, u)
    }
    function a (u, s, v) {
        var t = b (u.previousSibling);
        if (t) {
            return h (t, u, s ? t : false, v)
        } else {
            return u
        }
    }
    function o (u, t, v) {
        var s = i (u.nextSibling);
        if (s) {
            return h (u, s, t ? s : false, v)
        } else {
            return u
        }
    }
    function h (u, s, t, v) {
        if (l (u, s, ! ! t, v)) {
            return f (u, s, t)
        } else {
            if (u && u.tagName === "LI" && n (s)) {
                u.appendChild (s)
            }
        }
        return s
    }
    function l (u, t, s, v) {
        if (! u || ! t) {
            return false
        } else {
            if (u.tagName === "LI" && t.tagName === "LI") {
                return t.style.listStyleType === "none" || j (t)
            } else {
                if (n (u)) {
                    return(u.tagName === t.tagName && (s || u.style.listStyleType === t.style.listStyleType)) || q (t)
                } else {
                    if (v && u.tagName === "P" && t.tagName === "P") {
                        return true
                    } else {
                        return false
                    }
                }
            }
        }
    }
    function q (t) {
        var s = i (t.firstChild), u = b (t.lastChild);
        return s && u && n (t) && s === u && (n (s) || s.style.listStyleType === "none" || j (s))
    }
    function j (u) {
        var t = i (u.firstChild), s = b (u.lastChild);
        return t && s && t === s && n (t)
    }
    function f (w, v, s) {
        var u = b (w.lastChild), t = i (v.firstChild);
        if (w.tagName === "P") {
            w.appendChild (w.ownerDocument.createElement ("br"))
        }
        while (v.firstChild) {
            w.appendChild (v.firstChild)
        }
        if (s) {
            w.style.listStyleType = s.style.listStyleType
        }
        v.parentNode.removeChild (v);
        h (u, t, false);
        return w
    }
    function k (t, u) {
        var s;
        if (! u.is (t, "li,ol,ul")) {
            s = u.getParent (t, "li");
            if (s) {
                t = s
            }
        }
        return t
    }
    tinymce.create ("tinymce.plugins.Lists", {init: function (A, y) {
            var w = 0;
            var t = 1;
            var H = 2;
            var J = 3;
            var z = J;
            function C (M) {
                return M.keyCode === 9 && (A.queryCommandState ("InsertUnorderedList") || A.queryCommandState ("InsertOrderedList"))
            }
            function x () {
                var M = B ();
                var O = M.parentNode.parentNode;
                var N = M.parentNode.lastChild === M;
                return N && ! u (O) && K (M)
            }
            function u (M) {
                if (n (M)) {
                    return M.parentNode && M.parentNode.tagName === "LI"
                } else {
                    return M.tagName === "LI"
                }
            }
            function D () {
                return A.selection.isCollapsed () && K (B ())
            }
            function B () {
                var M = A.selection.getStart ();
                return((M.tagName == "BR" || M.tagName == "") && M.parentNode.tagName == "LI") ? M.parentNode : M
            }
            function K (M) {
                var N = M.childNodes.length;
                if (M.tagName === "LI") {
                    return N == 0 ? true : N == 1 && (M.firstChild.tagName == "" || F (M) || G (M))
                }
                return false
            }
            function F (M) {
                return tinymce.isWebKit && M.firstChild.nodeName == "BR"
            }
            function G (M) {
                var N = tinymce.grep (M.parentNode.childNodes, function (Q) {
                    return Q.nodeName == "LI"
                });
                var O = M == N[N.length - 1];
                var P = M.firstChild;
                return tinymce.isIE9 && O && (P.nodeValue == String.fromCharCode (160) || P.nodeValue == String.fromCharCode (32))
            }
            function L (M) {
                return M.keyCode === 13
            }
            function I (M) {
                if (C (M)) {
                    return w
                } else {
                    if (L (M) && x ()) {
                        return H
                    } else {
                        if (L (M) && D ()) {
                            return t
                        } else {
                            return J
                        }
                    }
                }
            }
            function s (M, N) {
                if (z == w || z == t) {
                    return r.cancel (N)
                }
            }
            function v (P, R) {
                var U;
                if (! tinymce.isGecko) {
                    return
                }
                var N = P.selection.getStart ();
                if (R.keyCode != 8 || N.tagName !== "IMG") {
                    return
                }
                function O (Y) {
                    var Z = Y.firstChild;
                    var X = null;
                    do {
                        if (! Z) {
                            break
                        }
                        if (Z.tagName === "LI") {
                            X = Z
                        }
                    } while (Z = Z.nextSibling);
                    return X
                }
                function W (Y, X) {
                    while (Y.childNodes.length > 0) {
                        X.appendChild (Y.childNodes[0])
                    }
                }
                U = N.parentNode.previousSibling;
                if (! U) {
                    return
                }
                var S;
                if (U.tagName === "UL" || U.tagName === "OL") {
                    S = U
                } else {
                    if (U.previousSibling && (U.previousSibling.tagName === "UL" || U.previousSibling.tagName === "OL")) {
                        S = U.previousSibling
                    } else {
                        return
                    }
                }
                var V = O (S);
                var M = P.dom.createRng ();
                M.setStart (V, 1);
                M.setEnd (V, 1);
                P.selection.setRng (M);
                P.selection.collapse (true);
                var Q = P.selection.getBookmark ();
                var T = N.parentNode.cloneNode (true);
                if (T.tagName === "P" || T.tagName === "DIV") {
                    W (T, V)
                } else {
                    V.appendChild (T)
                }
                N.parentNode.parentNode.removeChild (N.parentNode);
                P.selection.moveToBookmark (Q)
            }
            function E (M) {
                var N = A.dom.getParent (M, "ol,ul");
                if (N != null) {
                    var O = N.lastChild;
                    O.appendChild (A.getDoc ().createElement (""));
                    A.selection.setCursorLocation (O, 0)
                }
            }
            this.ed = A;
            A.addCommand ("Indent", this.indent, this);
            A.addCommand ("Outdent", this.outdent, this);
            A.addCommand ("InsertUnorderedList", function () {
                this.applyList ("UL", "OL")
            }, this);
            A.addCommand ("InsertOrderedList", function () {
                this.applyList ("OL", "UL")
            }, this);
            A.onInit.add (function () {
                A.editorCommands.addCommands ({outdent: function () {
                        var N = A.selection, O = A.dom;
                        function M (P) {
                            P = O.getParent (P, O.isBlock);
                            return P && (parseInt (A.dom.getStyle (P, "margin-left") || 0, 10) + parseInt (A.dom.getStyle (P, "padding-left") || 0, 10)) > 0
                        }
                        return M (N.getStart ()) || M (N.getEnd ()) || A.queryCommandState ("InsertOrderedList") || A.queryCommandState ("InsertUnorderedList")
                    }}, "state")
            });
            A.onKeyUp.add (function (N, O) {
                if (z == w) {
                    N.execCommand (O.shiftKey ? "Outdent" : "Indent", true, null);
                    z = J;
                    return r.cancel (O)
                } else {
                    if (z == t) {
                        var M = B ();
                        var Q = N.settings.list_outdent_on_enter === true || O.shiftKey;
                        N.execCommand (Q ? "Outdent" : "Indent", true, null);
                        if (tinymce.isIE) {
                            E (M)
                        }
                        return r.cancel (O)
                    } else {
                        if (z == H) {
                            if (tinymce.isIE8) {
                                var P = N.getDoc ().createTextNode ("\uFEFF");
                                N.selection.getNode ().appendChild (P)
                            } else {
                                if (tinymce.isIE9) {
                                    N.execCommand ("Outdent");
                                    return r.cancel (O)
                                }
                            }
                        }
                    }
                }
            });
            A.onKeyDown.add (function (M, N) {
                z = I (N)
            });
            A.onKeyDown.add (s);
            A.onKeyDown.add (v);
            A.onKeyPress.add (s)
        }, applyList: function (y, v) {
            var C = this, z = C.ed, I = z.dom, s = [], H = false, u = false, w = false, B, G = z.selection.getSelectedBlocks ();
            function E (t) {
                if (t && t.tagName === "BR") {
                    I.remove (t)
                }
            }
            function F (M) {
                var N = I.create (y), t;
                function L (O) {
                    if (O.style.marginLeft || O.style.paddingLeft) {
                        C.adjustPaddingFunction (false) (O)
                    }
                }
                if (M.tagName === "LI") {
                } else {
                    if (M.tagName === "P" || M.tagName === "DIV" || M.tagName === "BODY") {
                        K (M, function (P, O, Q) {
                            J (P, O, M.tagName === "BODY" ? null : P.parentNode);
                            t = P.parentNode;
                            L (t);
                            E (O)
                        });
                        if (M.tagName === "P" || G.length > 1) {
                            I.split (t.parentNode.parentNode, t.parentNode)
                        }
                        m (t.parentNode, true);
                        return
                    } else {
                        t = I.create ("li");
                        I.insertAfter (t, M);
                        t.appendChild (M);
                        L (M);
                        M = t
                    }
                }
                I.insertAfter (N, M);
                N.appendChild (M);
                m (N, true);
                s.push (M)
            }
            function J (Q, L, O) {
                var t, P = Q, N, M;
                while (! I.isBlock (Q.parentNode) && Q.parentNode !== I.getRoot ()) {
                    Q = I.split (Q.parentNode, Q.previousSibling);
                    Q = Q.nextSibling;
                    P = Q
                }
                if (O) {
                    t = O.cloneNode (true);
                    Q.parentNode.insertBefore (t, Q);
                    while (t.firstChild) {
                        I.remove (t.firstChild)
                    }
                    t = I.rename (t, "li")
                } else {
                    t = I.create ("li");
                    Q.parentNode.insertBefore (t, Q)
                }
                while (P && P != L) {
                    N = P.nextSibling;
                    t.appendChild (P);
                    P = N
                }
                if (t.childNodes.length === 0) {
                    t.innerHTML = '<br _mce_bogus="1" />'
                }
                F (t)
            }
            function K (Q, T) {
                var N, R, O = 3, L = 1, t = "br,ul,ol,p,div,h1,h2,h3,h4,h5,h6,table,blockquote,address,pre,form,center,dl";
                function P (X, U) {
                    var V = I.createRng (), W;
                    g.keep = true;
                    z.selection.moveToBookmark (g);
                    g.keep = false;
                    W = z.selection.getRng (true);
                    if (! U) {
                        U = X.parentNode.lastChild
                    }
                    V.setStartBefore (X);
                    V.setEndAfter (U);
                    return ! (V.compareBoundaryPoints (O, W) > 0 || V.compareBoundaryPoints (L, W) <= 0)
                }
                function S (U) {
                    if (U.nextSibling) {
                        return U.nextSibling
                    }
                    if (! I.isBlock (U.parentNode) && U.parentNode !== I.getRoot ()) {
                        return S (U.parentNode)
                    }
                }
                N = Q.firstChild;
                var M = false;
                e (I.select (t, Q), function (V) {
                    var U;
                    if (V.hasAttribute && V.hasAttribute ("_mce_bogus")) {
                        return true
                    }
                    if (P (N, V)) {
                        I.addClass (V, "_mce_tagged_br");
                        N = S (V)
                    }
                });
                M = (N && P (N, undefined));
                N = Q.firstChild;
                e (I.select (t, Q), function (V) {
                    var U = S (V);
                    if (V.hasAttribute && V.hasAttribute ("_mce_bogus")) {
                        return true
                    }
                    if (I.hasClass (V, "_mce_tagged_br")) {
                        T (N, V, R);
                        R = null
                    } else {
                        R = V
                    }
                    N = U
                });
                if (M) {
                    T (N, undefined, R)
                }
            }
            function D (t) {
                K (t, function (M, L, N) {
                    J (M, L);
                    E (L);
                    E (N)
                })
            }
            function A (t) {
                if (tinymce.inArray (s, t) !== - 1) {
                    return
                }
                if (t.parentNode.tagName === v) {
                    I.split (t.parentNode, t);
                    F (t);
                    o (t.parentNode, false)
                }
                s.push (t)
            }
            function x (M) {
                var O, N, L, t;
                if (tinymce.inArray (s, M) !== - 1) {
                    return
                }
                M = c (M, I);
                while (I.is (M.parentNode, "ol,ul,li")) {
                    I.split (M.parentNode, M)
                }
                s.push (M);
                M = I.rename (M, "p");
                L = m (M, false, z.settings.force_br_newlines);
                if (L === M) {
                    O = M.firstChild;
                    while (O) {
                        if (I.isBlock (O)) {
                            O = I.split (O.parentNode, O);
                            t = true;
                            N = O.nextSibling && O.nextSibling.firstChild
                        } else {
                            N = O.nextSibling;
                            if (t && O.tagName === "BR") {
                                I.remove (O)
                            }
                            t = false
                        }
                        O = N
                    }
                }
            }
            e (G, function (t) {
                t = k (t, I);
                if (t.tagName === v || (t.tagName === "LI" && t.parentNode.tagName === v)) {
                    u = true
                } else {
                    if (t.tagName === y || (t.tagName === "LI" && t.parentNode.tagName === y)) {
                        H = true
                    } else {
                        w = true
                    }
                }
            });
            if (w || u || G.length === 0) {
                B = {LI: A, H1: F, H2: F, H3: F, H4: F, H5: F, H6: F, P: F, BODY: F, DIV: G.length > 1 ? F : D, defaultAction: D}
            } else {
                B = {defaultAction: x}
            }
            this.process (B)
        }, indent: function () {
            var u = this.ed, w = u.dom, x = [];
            function s (z) {
                var y = w.create ("li", {style: "list-style-type: none;"});
                w.insertAfter (y, z);
                return y
            }
            function t (B) {
                var y = s (B), D = w.getParent (B, "ol,ul"), C = D.tagName, E = w.getStyle (D, "list-style-type"), A = {}, z;
                if (E !== "") {
                    A.style = "list-style-type: " + E + ";"
                }
                z = w.create (C, A);
                y.appendChild (z);
                return z
            }
            function v (z) {
                if (! d (u, z, x)) {
                    z = c (z, w);
                    var y = t (z);
                    y.appendChild (z);
                    m (y.parentNode, false);
                    m (y, false);
                    x.push (z)
                }
            }
            this.process ({LI: v, defaultAction: this.adjustPaddingFunction (true)})
        }, outdent: function () {
            var v = this, u = v.ed, w = u.dom, s = [];
            function x (t) {
                var z, y, A;
                if (! d (u, t, s)) {
                    if (w.getStyle (t, "margin-left") !== "" || w.getStyle (t, "padding-left") !== "") {
                        return v.adjustPaddingFunction (false) (t)
                    }
                    A = w.getStyle (t, "text-align", true);
                    if (A === "center" || A === "right") {
                        w.setStyle (t, "text-align", "left");
                        return
                    }
                    t = c (t, w);
                    z = t.parentNode;
                    y = t.parentNode.parentNode;
                    if (y.tagName === "P") {
                        w.split (y, t.parentNode)
                    } else {
                        w.split (z, t);
                        if (y.tagName === "LI") {
                            w.split (y, t)
                        } else {
                            if (! w.is (y, "ol,ul")) {
                                w.rename (t, "p")
                            }
                        }
                    }
                    s.push (t)
                }
            }
            this.process ({LI: x, defaultAction: this.adjustPaddingFunction (false)});
            e (s, m)
        }, process: function (y) {
            var D = this, w = D.ed.selection, z = D.ed.dom, C, u;
            function x (s) {
                z.removeClass (s, "_mce_act_on");
                if (! s || s.nodeType !== 1) {
                    return
                }
                s = k (s, z);
                var t = y[s.tagName];
                if (! t) {
                    t = y.defaultAction
                }
                t (s)
            }
            function v (s) {
                D.splitSafeEach (s.childNodes, x)
            }
            function B (s, t) {
                return t >= 0 && s.hasChildNodes () && t < s.childNodes.length && s.childNodes[t].tagName === "BR"
            }
            C = w.getSelectedBlocks ();
            if (C.length === 0) {
                C = [z.getRoot ()]
            }
            u = w.getRng (true);
            if (! u.collapsed) {
                if (B (u.endContainer, u.endOffset - 1)) {
                    u.setEnd (u.endContainer, u.endOffset - 1);
                    w.setRng (u)
                }
                if (B (u.startContainer, u.startOffset)) {
                    u.setStart (u.startContainer, u.startOffset + 1);
                    w.setRng (u)
                }
            }
            if (tinymce.isIE8) {
                var E = D.ed.selection.getNode ();
                if (E.tagName === "LI" && ! (E.parentNode.lastChild === E)) {
                    var A = D.ed.getDoc ().createTextNode ("\uFEFF");
                    E.appendChild (A)
                }
            }
            g = w.getBookmark ();
            y.OL = y.UL = v;
            D.splitSafeEach (C, x);
            w.moveToBookmark (g);
            g = null;
            D.ed.execCommand ("mceRepaint")
        }, splitSafeEach: function (t, s) {
            if (tinymce.isGecko && (/Firefox\/[12]\.[0-9]/.test (navigator.userAgent) || /Firefox\/3\.[0-4]/.test (navigator.userAgent))) {
                this.classBasedEach (t, s)
            } else {
                e (t, s)
            }
        }, classBasedEach: function (v, u) {
            var w = this.ed.dom, s, t;
            e (v, function (x) {
                w.addClass (x, "_mce_act_on")
            });
            s = w.select ("._mce_act_on");
            while (s.length > 0) {
                t = s.shift ();
                w.removeClass (t, "_mce_act_on");
                u (t);
                s = w.select ("._mce_act_on")
            }
        }, adjustPaddingFunction: function (u) {
            var s, v, t = this.ed;
            s = t.settings.indentation;
            v = /[a-z%]+/i.exec (s);
            s = parseInt (s, 10);
            return function (w) {
                var y, x;
                y = parseInt (t.dom.getStyle (w, "margin-left") || 0, 10) + parseInt (t.dom.getStyle (w, "padding-left") || 0, 10);
                if (u) {
                    x = y + s
                } else {
                    x = y - s
                }
                t.dom.setStyle (w, "padding-left", "");
                t.dom.setStyle (w, "margin-left", x > 0 ? x + v : "")
            }
        }, getInfo: function () {
            return{longname: "Lists", author: "Moxiecode Systems AB", authorurl: "http://tinymce.moxiecode.com", infourl: "http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/lists", version: tinymce.majorVersion + "." + tinymce.minorVersion}
        }});
    tinymce.PluginManager.add ("lists", tinymce.plugins.Lists)
} ());