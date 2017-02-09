const angular = require('angular');

/**
 * @license AngularJS v1.5.8
 * (c) 2010-2016 Google, Inc. http://angularjs.org
 * License: MIT
 */
(function(window, angular) {'use strict';

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *     Any commits to this file should be reviewed with security in mind.  *
     *   Changes to this file can potentially create security vulnerabilities. *
     *          An approval from 2 Core members with history of modifying      *
     *                         this file is required.                          *
     *                                                                         *
     *  Does the change somehow allow for arbitrary javascript to be executed? *
     *    Or allows for someone to change the prototype of built-in objects?   *
     *     Or gives undesired access to variables likes document or window?    *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    var $sanitizeMinErr = angular.$$minErr('$sanitize');
    var bind;
    var extend;
    var forEach;
    var isDefined;
    var lowercase;
    var noop;
    var htmlParser;
    var htmlSanitizeWriter;

    /**
     * @ngdoc module
     * @name ngSanitize
     * @description
     *
     * # ngSanitize
     *
     * The `ngSanitize` module provides functionality to sanitize HTML.
     *
     *
     * <div doc-module-components="ngSanitize"></div>
     *
     * See {@link ngSanitize.$sanitize `$sanitize`} for usage.
     */

    /**
     * @ngdoc service
     * @name $sanitize
     * @kind function
     *
     * @description
     *   Sanitizes an html string by stripping all potentially dangerous tokens.
     *
     *   The input is sanitized by parsing the HTML into tokens. All safe tokens (from a whitelist) are
     *   then serialized back to properly escaped html string. This means that no unsafe input can make
     *   it into the returned string.
     *
     *   The whitelist for URL sanitization of attribute values is configured using the functions
     *   `aHrefSanitizationWhitelist` and `imgSrcSanitizationWhitelist` of {@link ng.$compileProvider
 *   `$compileProvider`}.
     *
     *   The input may also contain SVG markup if this is enabled via {@link $sanitizeProvider}.
     *
     * @param {string} html HTML input.
     * @returns {string} Sanitized HTML.
     *
     * @example
     <example module="sanitizeExample" deps="angular-sanitize.js">
     <file name="index.html">
     <script>
     angular.module('sanitizeExample', ['ngSanitize'])
     .controller('ExampleController', ['$scope', '$sce', function($scope, $sce) {
             $scope.snippet =
               '<p style="color:blue">an html\n' +
               '<em onmouseover="this.textContent=\'PWN3D!\'">click here</em>\n' +
               'snippet</p>';
             $scope.deliberatelyTrustDangerousSnippet = function() {
               return $sce.trustAsHtml($scope.snippet);
             };
           }]);
     </script>
     <div ng-controller="ExampleController">
     Snippet: <textarea ng-model="snippet" cols="60" rows="3"></textarea>
     <table>
     <tr>
     <td>Directive</td>
     <td>How</td>
     <td>Source</td>
     <td>Rendered</td>
     </tr>
     <tr id="bind-html-with-sanitize">
     <td>ng-bind-html</td>
     <td>Automatically uses $sanitize</td>
     <td><pre>&lt;div ng-bind-html="snippet"&gt;<br/>&lt;/div&gt;</pre></td>
     <td><div ng-bind-html="snippet"></div></td>
     </tr>
     <tr id="bind-html-with-trust">
     <td>ng-bind-html</td>
     <td>Bypass $sanitize by explicitly trusting the dangerous value</td>
     <td>
     <pre>&lt;div ng-bind-html="deliberatelyTrustDangerousSnippet()"&gt;
     &lt;/div&gt;</pre>
     </td>
     <td><div ng-bind-html="deliberatelyTrustDangerousSnippet()"></div></td>
     </tr>
     <tr id="bind-default">
     <td>ng-bind</td>
     <td>Automatically escapes</td>
     <td><pre>&lt;div ng-bind="snippet"&gt;<br/>&lt;/div&gt;</pre></td>
     <td><div ng-bind="snippet"></div></td>
     </tr>
     </table>
     </div>
     </file>
     <file name="protractor.js" type="protractor">
     it('should sanitize the html snippet by default', function() {
       expect(element(by.css('#bind-html-with-sanitize div')).getInnerHtml()).
         toBe('<p>an html\n<em>click here</em>\nsnippet</p>');
     });

     it('should inline raw snippet if bound to a trusted value', function() {
       expect(element(by.css('#bind-html-with-trust div')).getInnerHtml()).
         toBe("<p style=\"color:blue\">an html\n" +
              "<em onmouseover=\"this.textContent='PWN3D!'\">click here</em>\n" +
              "snippet</p>");
     });

     it('should escape snippet without any filter', function() {
       expect(element(by.css('#bind-default div')).getInnerHtml()).
         toBe("&lt;p style=\"color:blue\"&gt;an html\n" +
              "&lt;em onmouseover=\"this.textContent='PWN3D!'\"&gt;click here&lt;/em&gt;\n" +
              "snippet&lt;/p&gt;");
     });

     it('should update', function() {
       element(by.model('snippet')).clear();
       element(by.model('snippet')).sendKeys('new <b onclick="alert(1)">text</b>');
       expect(element(by.css('#bind-html-with-sanitize div')).getInnerHtml()).
         toBe('new <b>text</b>');
       expect(element(by.css('#bind-html-with-trust div')).getInnerHtml()).toBe(
         'new <b onclick="alert(1)">text</b>');
       expect(element(by.css('#bind-default div')).getInnerHtml()).toBe(
         "new &lt;b onclick=\"alert(1)\"&gt;text&lt;/b&gt;");
     });
     </file>
     </example>
     */


    /**
     * @ngdoc provider
     * @name $sanitizeProvider
     *
     * @description
     * Creates and configures {@link $sanitize} instance.
     */
    function $SanitizeProvider() {
        var svgEnabled = false;

        this.$get = ['$$sanitizeUri', function($$sanitizeUri) {
            if (svgEnabled) {
                extend(validElements, svgElements);
            }
            return function(html) {
                var buf = [];
                htmlParser(html, htmlSanitizeWriter(buf, function(uri, isImage) {
                    return !/^unsafe:/.test($$sanitizeUri(uri, isImage));
                }));
                return buf.join('');
            };
        }];


        /**
         * @ngdoc method
         * @name $sanitizeProvider#enableSvg
         * @kind function
         *
         * @description
         * Enables a subset of svg to be supported by the sanitizer.
         *
         * <div class="alert alert-warning">
         *   <p>By enabling this setting without taking other precautions, you might expose your
         *   application to click-hijacking attacks. In these attacks, sanitized svg elements could be positioned
         *   outside of the containing element and be rendered over other elements on the page (e.g. a login
         *   link). Such behavior can then result in phishing incidents.</p>
         *
         *   <p>To protect against these, explicitly setup `overflow: hidden` css rule for all potential svg
         *   tags within the sanitized content:</p>
         *
         *   <br>
         *
         *   <pre><code>
         *   .rootOfTheIncludedContent svg {
   *     overflow: hidden !important;
   *   }
         *   </code></pre>
         * </div>
         *
         * @param {boolean=} flag Enable or disable SVG support in the sanitizer.
         * @returns {boolean|ng.$sanitizeProvider} Returns the currently configured value if called
         *    without an argument or self for chaining otherwise.
         */
        this.enableSvg = function(enableSvg) {
            if (isDefined(enableSvg)) {
                svgEnabled = enableSvg;
                return this;
            } else {
                return svgEnabled;
            }
        };

        //////////////////////////////////////////////////////////////////////////////////////////////////
        // Private stuff
        //////////////////////////////////////////////////////////////////////////////////////////////////

        bind = angular.bind;
        extend = angular.extend;
        forEach = angular.forEach;
        isDefined = angular.isDefined;
        lowercase = angular.lowercase;
        noop = angular.noop;

        htmlParser = htmlParserImpl;
        htmlSanitizeWriter = htmlSanitizeWriterImpl;

        // Regular Expressions for parsing tags and attributes
        var SURROGATE_PAIR_REGEXP = /[\uD800-\uDBFF][\uDC00-\uDFFF]/g,
        // Match everything outside of normal chars and " (quote character)
            NON_ALPHANUMERIC_REGEXP = /([^\#-~ |!])/g;


        // Good source of info about elements and attributes
        // http://dev.w3.org/html5/spec/Overview.html#semantics
        // http://simon.html5.org/html-elements

        // Safe Void Elements - HTML5
        // http://dev.w3.org/html5/spec/Overview.html#void-elements
        var voidElements = toMap("area,br,col,hr,img,wbr");

        // Elements that you can, intentionally, leave open (and which close themselves)
        // http://dev.w3.org/html5/spec/Overview.html#optional-tags
        var optionalEndTagBlockElements = toMap("colgroup,dd,dt,li,p,tbody,td,tfoot,th,thead,tr"),
            optionalEndTagInlineElements = toMap("rp,rt"),
            optionalEndTagElements = extend({},
                optionalEndTagInlineElements,
                optionalEndTagBlockElements);

        // Safe Block Elements - HTML5
        var blockElements = extend({}, optionalEndTagBlockElements, toMap("address,article," +
            "aside,blockquote,caption,center,del,dir,div,dl,figure,figcaption,footer,h1,h2,h3,h4,h5," +
            "h6,header,hgroup,hr,ins,map,menu,nav,ol,pre,section,table,ul"));

        // Inline Elements - HTML5
        var inlineElements = extend({}, optionalEndTagInlineElements, toMap("a,abbr,acronym,b," +
            "bdi,bdo,big,br,cite,code,del,dfn,em,font,i,img,ins,kbd,label,map,mark,q,ruby,rp,rt,s," +
            "samp,small,span,strike,strong,sub,sup,time,tt,u,var"));

        // SVG Elements
        // https://wiki.whatwg.org/wiki/Sanitization_rules#svg_Elements
        // Note: the elements animate,animateColor,animateMotion,animateTransform,set are intentionally omitted.
        // They can potentially allow for arbitrary javascript to be executed. See #11290
        var svgElements = toMap("circle,defs,desc,ellipse,font-face,font-face-name,font-face-src,g,glyph," +
            "hkern,image,linearGradient,line,marker,metadata,missing-glyph,mpath,path,polygon,polyline," +
            "radialGradient,rect,stop,svg,switch,text,title,tspan");

        // Blocked Elements (will be stripped)
        var blockedElements = toMap("script,style");

        var validElements = extend({},
            voidElements,
            blockElements,
            inlineElements,
            optionalEndTagElements);

        //Attributes that have href and hence need to be sanitized
        var uriAttrs = toMap("background,cite,href,longdesc,src,xlink:href");

        var htmlAttrs = toMap('abbr,align,alt,axis,bgcolor,border,cellpadding,cellspacing,class,clear,' +
            'color,cols,colspan,compact,coords,dir,face,headers,height,hreflang,hspace,' +
            'ismap,lang,language,nohref,nowrap,rel,rev,rows,rowspan,rules,' +
            'scope,scrolling,shape,size,span,start,summary,tabindex,target,title,type,' +
            'valign,value,vspace,width');

        // SVG attributes (without "id" and "name" attributes)
        // https://wiki.whatwg.org/wiki/Sanitization_rules#svg_Attributes
        var svgAttrs = toMap('accent-height,accumulate,additive,alphabetic,arabic-form,ascent,' +
            'baseProfile,bbox,begin,by,calcMode,cap-height,class,color,color-rendering,content,' +
            'cx,cy,d,dx,dy,descent,display,dur,end,fill,fill-rule,font-family,font-size,font-stretch,' +
            'font-style,font-variant,font-weight,from,fx,fy,g1,g2,glyph-name,gradientUnits,hanging,' +
            'height,horiz-adv-x,horiz-origin-x,ideographic,k,keyPoints,keySplines,keyTimes,lang,' +
            'marker-end,marker-mid,marker-start,markerHeight,markerUnits,markerWidth,mathematical,' +
            'max,min,offset,opacity,orient,origin,overline-position,overline-thickness,panose-1,' +
            'path,pathLength,points,preserveAspectRatio,r,refX,refY,repeatCount,repeatDur,' +
            'requiredExtensions,requiredFeatures,restart,rotate,rx,ry,slope,stemh,stemv,stop-color,' +
            'stop-opacity,strikethrough-position,strikethrough-thickness,stroke,stroke-dasharray,' +
            'stroke-dashoffset,stroke-linecap,stroke-linejoin,stroke-miterlimit,stroke-opacity,' +
            'stroke-width,systemLanguage,target,text-anchor,to,transform,type,u1,u2,underline-position,' +
            'underline-thickness,unicode,unicode-range,units-per-em,values,version,viewBox,visibility,' +
            'width,widths,x,x-height,x1,x2,xlink:actuate,xlink:arcrole,xlink:role,xlink:show,xlink:title,' +
            'xlink:type,xml:base,xml:lang,xml:space,xmlns,xmlns:xlink,y,y1,y2,zoomAndPan', true);

        var validAttrs = extend({},
            uriAttrs,
            svgAttrs,
            htmlAttrs);

        function toMap(str, lowercaseKeys) {
            var obj = {}, items = str.split(','), i;
            for (i = 0; i < items.length; i++) {
                obj[lowercaseKeys ? lowercase(items[i]) : items[i]] = true;
            }
            return obj;
        }

        var inertBodyElement;
        (function(window) {
            var doc;
            if (window.document && window.document.implementation) {
                doc = window.document.implementation.createHTMLDocument("inert");
            } else {
                throw $sanitizeMinErr('noinert', "Can't create an inert html document");
            }
            var docElement = doc.documentElement || doc.getDocumentElement();
            var bodyElements = docElement.getElementsByTagName('body');

            // usually there should be only one body element in the document, but IE doesn't have any, so we need to create one
            if (bodyElements.length === 1) {
                inertBodyElement = bodyElements[0];
            } else {
                var html = doc.createElement('html');
                inertBodyElement = doc.createElement('body');
                html.appendChild(inertBodyElement);
                doc.appendChild(html);
            }
        })(window);

        /**
         * @example
         * htmlParser(htmlString, {
   *     start: function(tag, attrs) {},
   *     end: function(tag) {},
   *     chars: function(text) {},
   *     comment: function(text) {}
   * });
         *
         * @param {string} html string
         * @param {object} handler
         */
        function htmlParserImpl(html, handler) {
            if (html === null || html === undefined) {
                html = '';
            } else if (typeof html !== 'string') {
                html = '' + html;
            }
            inertBodyElement.innerHTML = html;

            //mXSS protection
            var mXSSAttempts = 5;
            do {
                if (mXSSAttempts === 0) {
                    throw $sanitizeMinErr('uinput', "Failed to sanitize html because the input is unstable");
                }
                mXSSAttempts--;

                // strip custom-namespaced attributes on IE<=11
                if (window.document.documentMode) {
                    stripCustomNsAttrs(inertBodyElement);
                }
                html = inertBodyElement.innerHTML; //trigger mXSS
                inertBodyElement.innerHTML = html;
            } while (html !== inertBodyElement.innerHTML);

            var node = inertBodyElement.firstChild;
            while (node) {
                switch (node.nodeType) {
                    case 1: // ELEMENT_NODE
                        handler.start(node.nodeName.toLowerCase(), attrToMap(node.attributes));
                        break;
                    case 3: // TEXT NODE
                        handler.chars(node.textContent);
                        break;
                }

                var nextNode;
                if (!(nextNode = node.firstChild)) {
                    if (node.nodeType == 1) {
                        handler.end(node.nodeName.toLowerCase());
                    }
                    nextNode = node.nextSibling;
                    if (!nextNode) {
                        while (nextNode == null) {
                            node = node.parentNode;
                            if (node === inertBodyElement) break;
                            nextNode = node.nextSibling;
                            if (node.nodeType == 1) {
                                handler.end(node.nodeName.toLowerCase());
                            }
                        }
                    }
                }
                node = nextNode;
            }

            while (node = inertBodyElement.firstChild) {
                inertBodyElement.removeChild(node);
            }
        }

        function attrToMap(attrs) {
            var map = {};
            for (var i = 0, ii = attrs.length; i < ii; i++) {
                var attr = attrs[i];
                map[attr.name] = attr.value;
            }
            return map;
        }


        /**
         * Escapes all potentially dangerous characters, so that the
         * resulting string can be safely inserted into attribute or
         * element text.
         * @param value
         * @returns {string} escaped text
         */
        function encodeEntities(value) {
            return value.
            replace(/&/g, '&amp;').
            replace(SURROGATE_PAIR_REGEXP, function(value) {
                var hi = value.charCodeAt(0);
                var low = value.charCodeAt(1);
                return '&#' + (((hi - 0xD800) * 0x400) + (low - 0xDC00) + 0x10000) + ';';
            }).
            replace(NON_ALPHANUMERIC_REGEXP, function(value) {
                return '&#' + value.charCodeAt(0) + ';';
            }).
            replace(/</g, '&lt;').
            replace(/>/g, '&gt;');
        }

        /**
         * create an HTML/XML writer which writes to buffer
         * @param {Array} buf use buf.join('') to get out sanitized html string
         * @returns {object} in the form of {
   *     start: function(tag, attrs) {},
   *     end: function(tag) {},
   *     chars: function(text) {},
   *     comment: function(text) {}
   * }
         */
        function htmlSanitizeWriterImpl(buf, uriValidator) {
            var ignoreCurrentElement = false;
            var out = bind(buf, buf.push);
            return {
                start: function(tag, attrs) {
                    tag = lowercase(tag);
                    if (!ignoreCurrentElement && blockedElements[tag]) {
                        ignoreCurrentElement = tag;
                    }
                    if (!ignoreCurrentElement && validElements[tag] === true) {
                        out('<');
                        out(tag);
                        forEach(attrs, function(value, key) {
                            var lkey = lowercase(key);
                            var isImage = (tag === 'img' && lkey === 'src') || (lkey === 'background');
                            if (validAttrs[lkey] === true &&
                                (uriAttrs[lkey] !== true || uriValidator(value, isImage))) {
                                out(' ');
                                out(key);
                                out('="');
                                out(encodeEntities(value));
                                out('"');
                            }
                        });
                        out('>');
                    }
                },
                end: function(tag) {
                    tag = lowercase(tag);
                    if (!ignoreCurrentElement && validElements[tag] === true && voidElements[tag] !== true) {
                        out('</');
                        out(tag);
                        out('>');
                    }
                    if (tag == ignoreCurrentElement) {
                        ignoreCurrentElement = false;
                    }
                },
                chars: function(chars) {
                    if (!ignoreCurrentElement) {
                        out(encodeEntities(chars));
                    }
                }
            };
        }


        /**
         * When IE9-11 comes across an unknown namespaced attribute e.g. 'xlink:foo' it adds 'xmlns:ns1' attribute to declare
         * ns1 namespace and prefixes the attribute with 'ns1' (e.g. 'ns1:xlink:foo'). This is undesirable since we don't want
         * to allow any of these custom attributes. This method strips them all.
         *
         * @param node Root element to process
         */
        function stripCustomNsAttrs(node) {
            if (node.nodeType === window.Node.ELEMENT_NODE) {
                var attrs = node.attributes;
                for (var i = 0, l = attrs.length; i < l; i++) {
                    var attrNode = attrs[i];
                    var attrName = attrNode.name.toLowerCase();
                    if (attrName === 'xmlns:ns1' || attrName.lastIndexOf('ns1:', 0) === 0) {
                        node.removeAttributeNode(attrNode);
                        i--;
                        l--;
                    }
                }
            }

            var nextNode = node.firstChild;
            if (nextNode) {
                stripCustomNsAttrs(nextNode);
            }

            nextNode = node.nextSibling;
            if (nextNode) {
                stripCustomNsAttrs(nextNode);
            }
        }
    }

    function sanitizeText(chars) {
        var buf = [];
        var writer = htmlSanitizeWriter(buf, noop);
        writer.chars(chars);
        return buf.join('');
    }


// define ngSanitize module and register $sanitize service
    angular.module('ngSanitize', []).provider('$sanitize', $SanitizeProvider);

    /**
     * @ngdoc filter
     * @name linky
     * @kind function
     *
     * @description
     * Finds links in text input and turns them into html links. Supports `http/https/ftp/mailto` and
     * plain email address links.
     *
     * Requires the {@link ngSanitize `ngSanitize`} module to be installed.
     *
     * @param {string} text Input text.
     * @param {string} target Window (`_blank|_self|_parent|_top`) or named frame to open links in.
     * @param {object|function(url)} [attributes] Add custom attributes to the link element.
     *
     *    Can be one of:
     *
     *    - `object`: A map of attributes
     *    - `function`: Takes the url as a parameter and returns a map of attributes
     *
     *    If the map of attributes contains a value for `target`, it overrides the value of
     *    the target parameter.
     *
     *
     * @returns {string} Html-linkified and {@link $sanitize sanitized} text.
     *
     * @usage
     <span ng-bind-html="linky_expression | linky"></span>
     *
     * @example
     <example module="linkyExample" deps="angular-sanitize.js">
     <file name="index.html">
     <div ng-controller="ExampleController">
     Snippet: <textarea ng-model="snippet" cols="60" rows="3"></textarea>
     <table>
     <tr>
     <th>Filter</th>
     <th>Source</th>
     <th>Rendered</th>
     </tr>
     <tr id="linky-filter">
     <td>linky filter</td>
     <td>
     <pre>&lt;div ng-bind-html="snippet | linky"&gt;<br>&lt;/div&gt;</pre>
     </td>
     <td>
     <div ng-bind-html="snippet | linky"></div>
     </td>
     </tr>
     <tr id="linky-target">
     <td>linky target</td>
     <td>
     <pre>&lt;div ng-bind-html="snippetWithSingleURL | linky:'_blank'"&gt;<br>&lt;/div&gt;</pre>
     </td>
     <td>
     <div ng-bind-html="snippetWithSingleURL | linky:'_blank'"></div>
     </td>
     </tr>
     <tr id="linky-custom-attributes">
     <td>linky custom attributes</td>
     <td>
     <pre>&lt;div ng-bind-html="snippetWithSingleURL | linky:'_self':{rel: 'nofollow'}"&gt;<br>&lt;/div&gt;</pre>
     </td>
     <td>
     <div ng-bind-html="snippetWithSingleURL | linky:'_self':{rel: 'nofollow'}"></div>
     </td>
     </tr>
     <tr id="escaped-html">
     <td>no filter</td>
     <td><pre>&lt;div ng-bind="snippet"&gt;<br>&lt;/div&gt;</pre></td>
     <td><div ng-bind="snippet"></div></td>
     </tr>
     </table>
     </file>
     <file name="script.js">
     angular.module('linkyExample', ['ngSanitize'])
     .controller('ExampleController', ['$scope', function($scope) {
           $scope.snippet =
             'Pretty text with some links:\n'+
             'http://angularjs.org/,\n'+
             'mailto:us@somewhere.org,\n'+
             'another@somewhere.org,\n'+
             'and one more: ftp://127.0.0.1/.';
           $scope.snippetWithSingleURL = 'http://angularjs.org/';
         }]);
     </file>
     <file name="protractor.js" type="protractor">
     it('should linkify the snippet with urls', function() {
         expect(element(by.id('linky-filter')).element(by.binding('snippet | linky')).getText()).
             toBe('Pretty text with some links: http://angularjs.org/, us@somewhere.org, ' +
                  'another@somewhere.org, and one more: ftp://127.0.0.1/.');
         expect(element.all(by.css('#linky-filter a')).count()).toEqual(4);
       });

     it('should not linkify snippet without the linky filter', function() {
         expect(element(by.id('escaped-html')).element(by.binding('snippet')).getText()).
             toBe('Pretty text with some links: http://angularjs.org/, mailto:us@somewhere.org, ' +
                  'another@somewhere.org, and one more: ftp://127.0.0.1/.');
         expect(element.all(by.css('#escaped-html a')).count()).toEqual(0);
       });

     it('should update', function() {
         element(by.model('snippet')).clear();
         element(by.model('snippet')).sendKeys('new http://link.');
         expect(element(by.id('linky-filter')).element(by.binding('snippet | linky')).getText()).
             toBe('new http://link.');
         expect(element.all(by.css('#linky-filter a')).count()).toEqual(1);
         expect(element(by.id('escaped-html')).element(by.binding('snippet')).getText())
             .toBe('new http://link.');
       });

     it('should work with the target property', function() {
        expect(element(by.id('linky-target')).
            element(by.binding("snippetWithSingleURL | linky:'_blank'")).getText()).
            toBe('http://angularjs.org/');
        expect(element(by.css('#linky-target a')).getAttribute('target')).toEqual('_blank');
       });

     it('should optionally add custom attributes', function() {
        expect(element(by.id('linky-custom-attributes')).
            element(by.binding("snippetWithSingleURL | linky:'_self':{rel: 'nofollow'}")).getText()).
            toBe('http://angularjs.org/');
        expect(element(by.css('#linky-custom-attributes a')).getAttribute('rel')).toEqual('nofollow');
       });
     </file>
     </example>
     */
    angular.module('ngSanitize').filter('linky', ['$sanitize', function($sanitize) {
        var LINKY_URL_REGEXP =
                /((ftp|https?):\/\/|(www\.)|(mailto:)?[A-Za-z0-9._%+-]+@)\S*[^\s.;,(){}<>"\u201d\u2019]/i,
            MAILTO_REGEXP = /^mailto:/i;

        var linkyMinErr = angular.$$minErr('linky');
        var isDefined = angular.isDefined;
        var isFunction = angular.isFunction;
        var isObject = angular.isObject;
        var isString = angular.isString;

        return function(text, target, attributes) {
            if (text == null || text === '') return text;
            if (!isString(text)) throw linkyMinErr('notstring', 'Expected string but received: {0}', text);

            var attributesFn =
                isFunction(attributes) ? attributes :
                    isObject(attributes) ? function getAttributesObject() {return attributes;} :
                        function getEmptyAttributesObject() {return {};};

            var match;
            var raw = text;
            var html = [];
            var url;
            var i;
            while ((match = raw.match(LINKY_URL_REGEXP))) {
                // We can not end in these as they are sometimes found at the end of the sentence
                url = match[0];
                // if we did not match ftp/http/www/mailto then assume mailto
                if (!match[2] && !match[4]) {
                    url = (match[3] ? 'http://' : 'mailto:') + url;
                }
                i = match.index;
                addText(raw.substr(0, i));
                addLink(url, match[0].replace(MAILTO_REGEXP, ''));
                raw = raw.substring(i + match[0].length);
            }
            addText(raw);
            return $sanitize(html.join(''));

            function addText(text) {
                if (!text) {
                    return;
                }
                html.push(sanitizeText(text));
            }

            function addLink(url, text) {
                var key, linkAttributes = attributesFn(url);
                html.push('<a ');

                for (key in linkAttributes) {
                    html.push(key + '="' + linkAttributes[key] + '" ');
                }

                if (isDefined(target) && !('target' in linkAttributes)) {
                    html.push('target="',
                        target,
                        '" ');
                }
                html.push('href="',
                    url.replace(/"/g, '&quot;'),
                    '">');
                addText(text);
                html.push('</a>');
            }
        };
    }]);


})(window, window.angular);


//emoji
/*! jquery.emojiarea.js | https://github.com/diy/jquery-emojiarea | Apache License (v2) *//**
 * emojiarea - A rich textarea control that supports emojis, WYSIWYG-style.
 * Copyright (c) 2012 DIY Co
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
 * file except in compliance with the License. You may obtain a copy of the License at:
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under
 * the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF
 * ANY KIND, either express or implied. See the License for the specific language
 * governing permissions and limitations under the License.
 *
 * @author Brian Reavis <brian@diy.org>
 */

(function($, window, document) {

    var ELEMENT_NODE = 1;
    var TEXT_NODE = 3;
    var TAGS_BLOCK = ['p', 'div', 'pre', 'form'];
    var KEY_ESC = 27;
    var KEY_TAB = 9;

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    $.emojiarea = {
        path: '',
        icons: {},
        defaults: {
            button: null,
            buttonLabel: 'Emojis',
            buttonPosition: 'after'
        }
    };

    $.fn.emojiarea = function(options) {
        options = $.extend({}, $.emojiarea.defaults, options);
        return this.each(function() {
            var $textarea = $(this);
            if ('contentEditable' in document.body && options.wysiwyg !== false) {
                new EmojiArea_WYSIWYG($textarea, options);
            } else {
                new EmojiArea_Plain($textarea, options);
            }
        });
    };

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    var util = {};

    util.restoreSelection = (function() {
        if (window.getSelection) {
            return function(savedSelection) {
                var sel = window.getSelection();
                sel.removeAllRanges();
                for (var i = 0, len = savedSelection.length; i < len; ++i) {
                    sel.addRange(savedSelection[i]);
                }
            };
        } else if (document.selection && document.selection.createRange) {
            return function(savedSelection) {
                if (savedSelection) {
                    savedSelection.select();
                }
            };
        }
    })();

    util.saveSelection = (function() {
        if (window.getSelection) {
            return function() {
                var sel = window.getSelection(), ranges = [];
                if (sel.rangeCount) {
                    for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                        ranges.push(sel.getRangeAt(i));
                    }
                }
                return ranges;
            };
        } else if (document.selection && document.selection.createRange) {
            return function() {
                var sel = document.selection;
                return (sel.type.toLowerCase() !== 'none') ? sel.createRange() : null;
            };
        }
    })();

    util.replaceSelection = (function() {
        if (window.getSelection) {
            return function(content) {
                var range, sel = window.getSelection();
                var node = typeof content === 'string' ? document.createTextNode(content) : content;
                if (sel.getRangeAt && sel.rangeCount) {
                    range = sel.getRangeAt(0);
                    range.deleteContents();
                    range.insertNode(document.createTextNode(' '));
                    range.insertNode(node);
                    range.setStart(node, 0);

                    window.setTimeout(function() {
                        range = document.createRange();
                        range.setStartAfter(node);
                        range.collapse(true);
                        sel.removeAllRanges();
                        sel.addRange(range);
                    }, 0);
                }
            }
        } else if (document.selection && document.selection.createRange) {
            return function(content) {
                var range = document.selection.createRange();
                if (typeof content === 'string') {
                    range.text = content;
                } else {
                    range.pasteHTML(content.outerHTML);
                }
            }
        }
    })();

    util.insertAtCursor = function(text, el) {
        text = ' ' + text;
        var val = el.value, endIndex, startIndex, range;
        if (typeof el.selectionStart != 'undefined' && typeof el.selectionEnd != 'undefined') {
            startIndex = el.selectionStart;
            endIndex = el.selectionEnd;
            el.value = val.substring(0, startIndex) + text + val.substring(el.selectionEnd);
            el.selectionStart = el.selectionEnd = startIndex + text.length;
        } else if (typeof document.selection != 'undefined' && typeof document.selection.createRange != 'undefined') {
            el.focus();
            range = document.selection.createRange();
            range.text = text;
            range.select();
        }
    };

    util.extend = function(a, b) {
        if (typeof a === 'undefined' || !a) { a = {}; }
        if (typeof b === 'object') {
            for (var key in b) {
                if (b.hasOwnProperty(key)) {
                    a[key] = b[key];
                }
            }
        }
        return a;
    };

    util.escapeRegex = function(str) {
        return (str + '').replace(/([.?*+^$[\]\\(){}|-])/g, '\\$1');
    };

    util.htmlEntities = function(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    };

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    var EmojiArea = function() {};

    EmojiArea.prototype.setup = function() {
        var self = this;

        this.$editor.on('focus', function() { self.hasFocus = true; });
        this.$editor.on('blur', function() { self.hasFocus = false; });

        this.setupButton();
    };

    EmojiArea.prototype.setupButton = function() {
        var self = this;
        var $button;

        if (this.options.button) {
            $button = $(this.options.button);
        } else if (this.options.button !== false) {
            $button = $('<a href="javascript:void(0)">');
            $button.html(this.options.buttonLabel);
            $button.addClass('emoji-button');
            $button.attr({title: this.options.buttonLabel});
            this.$editor[this.options.buttonPosition]($button);
        } else {
            $button = $('');
        }

        $button.on('click', function(e) {
            EmojiMenu.show(self);
            e.stopPropagation();
        });

        this.$button = $button;
    };

    EmojiArea.createIcon = function(emoji) {
        var filename = $.emojiarea.icons[emoji];
        var path = $.emojiarea.path || '';
        if (path.length && path.charAt(path.length - 1) !== '/') {
            path += '/';
        }
        return '<img src="' + path + filename + '" alt="' + util.htmlEntities(emoji) + '">';
    };

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Editor (plain-text)
     *
     * @constructor
     * @param {object} $textarea
     * @param {object} options
     */

    var EmojiArea_Plain = function($textarea, options) {
        this.options = options;
        this.$textarea = $textarea;
        this.$editor = $textarea;
        this.setup();
    };

    EmojiArea_Plain.prototype.insert = function(emoji) {
        if (!$.emojiarea.icons.hasOwnProperty(emoji)) return;
        util.insertAtCursor(emoji, this.$textarea[0]);
        this.$textarea.trigger('change');
    };

    EmojiArea_Plain.prototype.val = function() {
        return this.$textarea.val();
    };

    util.extend(EmojiArea_Plain.prototype, EmojiArea.prototype);

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Editor (rich)
     *
     * @constructor
     * @param {object} $textarea
     * @param {object} options
     */

    var EmojiArea_WYSIWYG = function($textarea, options) {
        var self = this;

        this.options = options;
        this.$textarea = $textarea;
        this.$editor = $('<div>').addClass('emoji-wysiwyg-editor');
        this.$editor.text($textarea.val());
        this.$editor.attr({contenteditable: 'true'});
        this.$editor.on('blur keyup paste', function() { return self.onChange.apply(self, arguments); });
        this.$editor.on('mousedown focus', function() { document.execCommand('enableObjectResizing', false, false); });
        this.$editor.on('blur', function() { document.execCommand('enableObjectResizing', true, true); });

        var html = this.$editor.html();
        var emojis = $.emojiarea.icons;
        for (var key in emojis) {
            if (emojis.hasOwnProperty(key)) {
                html = html.replace(new RegExp(util.escapeRegex(key), 'g'), EmojiArea.createIcon(key));
            }
        }
        this.$editor.html(html);

        $textarea.hide().after(this.$editor);

        this.setup();

        this.$button.on('mousedown', function() {
            if (self.hasFocus) {
                self.selection = util.saveSelection();
            }
        });
    };

    EmojiArea_WYSIWYG.prototype.onChange = function() {
        this.$textarea.val(this.val()).trigger('change');
    };

    EmojiArea_WYSIWYG.prototype.insert = function(emoji) {
        var content;
        var $img = $(EmojiArea.createIcon(emoji));
        if ($img[0].attachEvent) {
            $img[0].attachEvent('onresizestart', function(e) { e.returnValue = false; }, false);
        }

        this.$editor.trigger('focus');
        if (this.selection) {
            util.restoreSelection(this.selection);
        }
        try { util.replaceSelection($img[0]); } catch (e) {}
        this.onChange();
    };

    EmojiArea_WYSIWYG.prototype.val = function() {
        var lines = [];
        var line  = [];

        var flush = function() {
            lines.push(line.join(''));
            line = [];
        };

        var sanitizeNode = function(node) {
            if (node.nodeType === TEXT_NODE) {
                line.push(node.nodeValue);
            } else if (node.nodeType === ELEMENT_NODE) {
                var tagName = node.tagName.toLowerCase();
                var isBlock = TAGS_BLOCK.indexOf(tagName) !== -1;

                if (isBlock && line.length) flush();

                if (tagName === 'img') {
                    var alt = node.getAttribute('alt') || '';
                    if (alt) line.push(alt);
                    return;
                } else if (tagName === 'br') {
                    flush();
                }

                var children = node.childNodes;
                for (var i = 0; i < children.length; i++) {
                    sanitizeNode(children[i]);
                }

                if (isBlock && line.length) flush();
            }
        };

        var children = this.$editor[0].childNodes;
        for (var i = 0; i < children.length; i++) {
            sanitizeNode(children[i]);
        }

        if (line.length) flush();
        return lines.join('<br>');
    };

    util.extend(EmojiArea_WYSIWYG.prototype, EmojiArea.prototype);

    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    /**
     * Emoji Dropdown Menu
     *
     * @constructor
     * @param {object} emojiarea
     */
    var EmojiMenu = function() {
        var self = this;
        var $body = $(document.body);
        var $window = $(window);

        this.visible = false;
        this.emojiarea = null;
        this.$menu = $('<div>');
        this.$menu.addClass('emoji-menu');
        this.$menu.hide();
        this.$items = $('<div>').appendTo(this.$menu);

        $body.append(this.$menu);

        $body.on('keydown', function(e) {
            if (e.keyCode === KEY_ESC || e.keyCode === KEY_TAB) {
                self.hide();
            }
        });

        $body.on('mouseup', function() {
            self.hide();
        });

        $window.on('resize', function() {
            if (self.visible) self.reposition();
        });

        this.$menu.on('mouseup', 'a', function(e) {
            e.stopPropagation();
            return false;
        });

        this.$menu.on('click', 'a', function(e) {
            var emoji = $('.label', $(this)).text();
            window.setTimeout(function() {
                self.onItemSelected.apply(self, [emoji]);
            }, 0);
            e.stopPropagation();
            return false;
        });

        this.load();
    };

    EmojiMenu.prototype.onItemSelected = function(emoji) {
        this.emojiarea.insert(emoji);
        this.hide();
    };

    EmojiMenu.prototype.load = function() {
        var html = [];
        var options = $.emojiarea.icons;
        var path = $.emojiarea.path;
        if (path.length && path.charAt(path.length - 1) !== '/') {
            path += '/';
        }

        for (var key in options) {
            if (options.hasOwnProperty(key)) {
                var filename = options[key];
                html.push('<a href="javascript:void(0)" title="' + util.htmlEntities(key) + '">' + EmojiArea.createIcon(key) + '<span class="label">' + util.htmlEntities(key) + '</span></a>');
            }
        }

        this.$items.html(html.join(''));
    };

    EmojiMenu.prototype.reposition = function() {
        var $button = this.emojiarea.$button;
        var offset = $button.offset();
        offset.top += $button.outerHeight();
        offset.left += Math.round($button.outerWidth() / 2);

        this.$menu.css({
            top: offset.top,
            left: offset.left
        });
    };

    EmojiMenu.prototype.hide = function(callback) {
        if (this.emojiarea) {
            this.emojiarea.menu = null;
            this.emojiarea.$button.removeClass('on');
            this.emojiarea = null;
        }
        this.visible = false;
        this.$menu.hide();
    };

    EmojiMenu.prototype.show = function(emojiarea) {
        if (this.emojiarea && this.emojiarea === emojiarea) return;
        this.emojiarea = emojiarea;
        this.emojiarea.menu = this;

        this.reposition();
        this.$menu.show();
        this.visible = true;
    };

    EmojiMenu.show = (function() {
        var menu = null;
        return function(emojiarea) {
            menu = menu || new EmojiMenu();
            menu.show(emojiarea);
        };
    })();

})(jQuery, window, document);

/**
 * Bunch of useful filters for angularJS(with no external dependencies!)
 * @version v0.5.9 - 2016-07-15 * @link https://github.com/a8m/angular-filter
 * @author Ariel Mashraki <ariel@mashraki.co.il>
 * @license MIT License, http://www.opensource.org/licenses/MIT
 */!function (a, b, c) {
    "use strict";
    function d(a) {
        return D(a) ? a : Object.keys(a).map(function (b) {
            return a[b]
        })
    }

    function e(a) {
        return null === a
    }

    function f(a, b) {
        var d = Object.keys(a);
        return d.map(function (d) {
                return b[d] !== c && b[d] == a[d]
            }).indexOf(!1) == -1
    }

    function g(a, b) {
        if ("" === b)return a;
        var c = a.indexOf(b.charAt(0));
        return c !== -1 && g(a.substr(c + 1), b.substr(1))
    }

    function h(a, b, c) {
        var d = 0;
        return a.filter(function (a) {
            var e = x(c) ? d < b && c(a) : d < b;
            return d = e ? d + 1 : d, e
        })
    }

    function i(a, b, c) {
        return c.round(a * c.pow(10, b)) / c.pow(10, b)
    }

    function j(a, b, c) {
        b = b || [];
        var d = Object.keys(a);
        return d.forEach(function (d) {
            if (C(a[d]) && !D(a[d])) {
                var e = c ? c + "." + d : c;
                j(a[d], b, e || d)
            } else {
                var f = c ? c + "." + d : d;
                b.push(f)
            }
        }), b
    }

    function k(a) {
        return a && a.$evalAsync && a.$watch
    }

    function l() {
        return function (a, b) {
            return a > b
        }
    }

    function m() {
        return function (a, b) {
            return a >= b
        }
    }

    function n() {
        return function (a, b) {
            return a < b
        }
    }

    function o() {
        return function (a, b) {
            return a <= b
        }
    }

    function p() {
        return function (a, b) {
            return a == b
        }
    }

    function q() {
        return function (a, b) {
            return a != b
        }
    }

    function r() {
        return function (a, b) {
            return a === b
        }
    }

    function s() {
        return function (a, b) {
            return a !== b
        }
    }

    function t(a) {
        return function (b, c) {
            return b = C(b) ? d(b) : b, !(!D(b) || y(c)) && b.some(function (b) {
                return A(c) && C(b) || z(c) ? a(c)(b) : b === c
            })
        }
    }

    function u(a, b) {
        return b = b || 0, b >= a.length ? a : D(a[b]) ? u(a.slice(0, b).concat(a[b], a.slice(b + 1)), b) : u(a, b + 1)
    }

    function v(a) {
        return function (b, c) {
            function e(a, b) {
                return !y(b) && a.some(function (a) {
                        return H(a, b)
                    })
            }

            if (b = C(b) ? d(b) : b, !D(b))return b;
            var f = [], g = a(c);
            return y(c) ? b.filter(function (a, b, c) {
                return c.indexOf(a) === b
            }) : b.filter(function (a) {
                var b = g(a);
                return !e(f, b) && (f.push(b), !0)
            })
        }
    }

    function w(a, b, c) {
        return b ? a + c + w(a, --b, c) : a
    }

    var x = b.isDefined, y = b.isUndefined, z = b.isFunction, A = b.isString, B = b.isNumber, C = b.isObject, D = b.isArray, E = b.forEach, F = b.extend, G = b.copy, H = b.equals;
    String.prototype.contains || (String.prototype.contains = function () {
        return String.prototype.indexOf.apply(this, arguments) !== -1
    }), b.module("a8m.angular", []).filter("isUndefined", function () {
        return function (a) {
            return b.isUndefined(a)
        }
    }).filter("isDefined", function () {
        return function (a) {
            return b.isDefined(a)
        }
    }).filter("isFunction", function () {
        return function (a) {
            return b.isFunction(a)
        }
    }).filter("isString", function () {
        return function (a) {
            return b.isString(a)
        }
    }).filter("isNumber", function () {
        return function (a) {
            return b.isNumber(a)
        }
    }).filter("isArray", function () {
        return function (a) {
            return b.isArray(a)
        }
    }).filter("isObject", function () {
        return function (a) {
            return b.isObject(a)
        }
    }).filter("isEqual", function () {
        return function (a, c) {
            return b.equals(a, c)
        }
    }), b.module("a8m.conditions", []).filter({
        isGreaterThan: l,
        ">": l,
        isGreaterThanOrEqualTo: m,
        ">=": m,
        isLessThan: n,
        "<": n,
        isLessThanOrEqualTo: o,
        "<=": o,
        isEqualTo: p,
        "==": p,
        isNotEqualTo: q,
        "!=": q,
        isIdenticalTo: r,
        "===": r,
        isNotIdenticalTo: s,
        "!==": s
    }), b.module("a8m.is-null", []).filter("isNull", function () {
        return function (a) {
            return e(a)
        }
    }), b.module("a8m.after-where", []).filter("afterWhere", function () {
        return function (a, b) {
            if (a = C(a) ? d(a) : a, !D(a) || y(b))return a;
            var c = a.map(function (a) {
                return f(b, a)
            }).indexOf(!0);
            return a.slice(c === -1 ? 0 : c)
        }
    }), b.module("a8m.after", []).filter("after", function () {
        return function (a, b) {
            return a = C(a) ? d(a) : a, D(a) ? a.slice(b) : a
        }
    }), b.module("a8m.before-where", []).filter("beforeWhere", function () {
        return function (a, b) {
            if (a = C(a) ? d(a) : a, !D(a) || y(b))return a;
            var c = a.map(function (a) {
                return f(b, a)
            }).indexOf(!0);
            return a.slice(0, c === -1 ? a.length : ++c)
        }
    }), b.module("a8m.before", []).filter("before", function () {
        return function (a, b) {
            return a = C(a) ? d(a) : a, D(a) ? a.slice(0, b ? --b : b) : a
        }
    }), b.module("a8m.chunk-by", ["a8m.filter-watcher"]).filter("chunkBy", ["filterWatcher", function (a) {
        return function (b, c, d) {
            function e(a, b) {
                for (var c = []; a--;)c[a] = b;
                return c
            }

            function f(a, b, c) {
                return D(a) ? a.map(function (a, d, f) {
                    return d *= b, a = f.slice(d, d + b), !y(c) && a.length < b ? a.concat(e(b - a.length, c)) : a
                }).slice(0, Math.ceil(a.length / b)) : a
            }

            return a.isMemoized("chunkBy", arguments) || a.memoize("chunkBy", arguments, this, f(b, c, d))
        }
    }]), b.module("a8m.concat", []).filter("concat", [function () {
        return function (a, b) {
            if (y(b))return a;
            if (D(a))return C(b) ? a.concat(d(b)) : a.concat(b);
            if (C(a)) {
                var c = d(a);
                return C(b) ? c.concat(d(b)) : c.concat(b)
            }
            return a
        }
    }]), b.module("a8m.contains", []).filter({
        contains: ["$parse", t],
        some: ["$parse", t]
    }), b.module("a8m.count-by", []).filter("countBy", ["$parse", function (a) {
        return function (b, c) {
            var e, f = {}, g = a(c);
            return b = C(b) ? d(b) : b, !D(b) || y(c) ? b : (b.forEach(function (a) {
                e = g(a), f[e] || (f[e] = 0), f[e]++
            }), f)
        }
    }]), b.module("a8m.defaults", []).filter("defaults", ["$parse", function (a) {
        return function (b, c) {
            if (b = C(b) ? d(b) : b, !D(b) || !C(c))return b;
            var e = j(c);
            return b.forEach(function (b) {
                e.forEach(function (d) {
                    var e = a(d), f = e.assign;
                    y(e(b)) && f(b, e(c))
                })
            }), b
        }
    }]), b.module("a8m.every", []).filter("every", ["$parse", function (a) {
        return function (b, c) {
            return b = C(b) ? d(b) : b, !(D(b) && !y(c)) || b.every(function (b) {
                return C(b) || z(c) ? a(c)(b) : b === c
            })
        }
    }]), b.module("a8m.filter-by", []).filter("filterBy", ["$parse", function (a) {
        return function (b, e, f, g) {
            var h;
            return f = A(f) || B(f) ? String(f).toLowerCase() : c, b = C(b) ? d(b) : b, !D(b) || y(f) ? b : b.filter(function (b) {
                return e.some(function (c) {
                    if (~c.indexOf("+")) {
                        var d = c.replace(/\s+/g, "").split("+");
                        h = d.map(function (c) {
                            return a(c)(b)
                        }).join(" ")
                    } else h = a(c)(b);
                    return !(!A(h) && !B(h)) && (h = String(h).toLowerCase(), g ? h === f : h.contains(f))
                })
            })
        }
    }]), b.module("a8m.first", []).filter("first", ["$parse", function (a) {
        return function (b) {
            var e, f, g;
            return b = C(b) ? d(b) : b, D(b) ? (g = Array.prototype.slice.call(arguments, 1), e = B(g[0]) ? g[0] : 1, f = B(g[0]) ? B(g[1]) ? c : g[1] : g[0], g.length ? h(b, e, f ? a(f) : f) : b[0]) : b
        }
    }]), b.module("a8m.flatten", []).filter("flatten", function () {
        return function (a, b) {
            return b = b || !1, a = C(a) ? d(a) : a, D(a) ? b ? [].concat.apply([], a) : u(a, 0) : a
        }
    }), b.module("a8m.fuzzy-by", []).filter("fuzzyBy", ["$parse", function (a) {
        return function (b, c, e, f) {
            var h, i, j = f || !1;
            return b = C(b) ? d(b) : b, !D(b) || y(c) || y(e) ? b : (i = a(c), b.filter(function (a) {
                return h = i(a), !!A(h) && (h = j ? h : h.toLowerCase(), e = j ? e : e.toLowerCase(), g(h, e) !== !1)
            }))
        }
    }]), b.module("a8m.fuzzy", []).filter("fuzzy", function () {
        return function (a, b, c) {
            function e(a, b) {
                var c, d, e = Object.keys(a);
                return 0 < e.filter(function (e) {
                        return c = a[e], !!d || !!A(c) && (c = f ? c : c.toLowerCase(), d = g(c, b) !== !1)
                    }).length
            }

            var f = c || !1;
            return a = C(a) ? d(a) : a, !D(a) || y(b) ? a : (b = f ? b : b.toLowerCase(), a.filter(function (a) {
                return A(a) ? (a = f ? a : a.toLowerCase(), g(a, b) !== !1) : !!C(a) && e(a, b)
            }))
        }
    }), b.module("a8m.group-by", ["a8m.filter-watcher"]).filter("groupBy", ["$parse", "filterWatcher", function (a, b) {
        return function (c, d) {
            function e(a, b) {
                var c, d = {};
                return E(a, function (a) {
                    c = b(a), d[c] || (d[c] = []), d[c].push(a)
                }), d
            }

            return !C(c) || y(d) ? c : b.isMemoized("groupBy", arguments) || b.memoize("groupBy", arguments, this, e(c, a(d)))
        }
    }]), b.module("a8m.is-empty", []).filter("isEmpty", function () {
        return function (a) {
            return C(a) ? !d(a).length : !a.length
        }
    }), b.module("a8m.join", []).filter("join", function () {
        return function (a, b) {
            return y(a) || !D(a) ? a : (y(b) && (b = " "), a.join(b))
        }
    }), b.module("a8m.last", []).filter("last", ["$parse", function (a) {
        return function (b) {
            var e, f, g, i = G(b);
            return i = C(i) ? d(i) : i, D(i) ? (g = Array.prototype.slice.call(arguments, 1), e = B(g[0]) ? g[0] : 1, f = B(g[0]) ? B(g[1]) ? c : g[1] : g[0], g.length ? h(i.reverse(), e, f ? a(f) : f).reverse() : i[i.length - 1]) : i
        }
    }]), b.module("a8m.map", []).filter("map", ["$parse", function (a) {
        return function (b, c) {
            return b = C(b) ? d(b) : b, !D(b) || y(c) ? b : b.map(function (b) {
                return a(c)(b)
            })
        }
    }]), b.module("a8m.omit", []).filter("omit", ["$parse", function (a) {
        return function (b, c) {
            return b = C(b) ? d(b) : b, !D(b) || y(c) ? b : b.filter(function (b) {
                return !a(c)(b)
            })
        }
    }]), b.module("a8m.pick", []).filter("pick", ["$parse", function (a) {
        return function (b, c) {
            return b = C(b) ? d(b) : b, !D(b) || y(c) ? b : b.filter(function (b) {
                return a(c)(b)
            })
        }
    }]), b.module("a8m.range", []).filter("range", function () {
        return function (a, b, c, d, e) {
            c = c || 0, d = d || 1;
            for (var f = 0; f < parseInt(b); f++) {
                var g = c + f * d;
                a.push(z(e) ? e(g) : g)
            }
            return a
        }
    }), b.module("a8m.remove-with", []).filter("removeWith", function () {
        return function (a, b) {
            return y(b) ? a : (a = C(a) ? d(a) : a, a.filter(function (a) {
                return !f(b, a)
            }))
        }
    }), b.module("a8m.remove", []).filter("remove", function () {
        return function (a) {
            a = C(a) ? d(a) : a;
            var b = Array.prototype.slice.call(arguments, 1);
            return D(a) ? a.filter(function (a) {
                return !b.some(function (b) {
                    return H(b, a)
                })
            }) : a
        }
    }), b.module("a8m.reverse", []).filter("reverse", [function () {
        return function (a) {
            return a = C(a) ? d(a) : a, A(a) ? a.split("").reverse().join("") : D(a) ? a.slice().reverse() : a
        }
    }]), b.module("a8m.search-field", []).filter("searchField", ["$parse", function (a) {
        return function (b) {
            var c, e;
            b = C(b) ? d(b) : b;
            var f = Array.prototype.slice.call(arguments, 1);
            return D(b) && f.length ? b.map(function (b) {
                return e = f.map(function (d) {
                    return (c = a(d))(b)
                }).join(" "), F(b, {searchField: e})
            }) : b
        }
    }]), b.module("a8m.to-array", []).filter("toArray", function () {
        return function (a, b) {
            return C(a) ? b ? Object.keys(a).map(function (b) {
                return F(a[b], {$key: b})
            }) : d(a) : a
        }
    }), b.module("a8m.unique", []).filter({
        unique: ["$parse", v],
        uniq: ["$parse", v]
    }), b.module("a8m.where", []).filter("where", function () {
        return function (a, b) {
            return y(b) ? a : (a = C(a) ? d(a) : a, a.filter(function (a) {
                return f(b, a)
            }))
        }
    }), b.module("a8m.xor", []).filter("xor", ["$parse", function (a) {
        return function (b, c, e) {
            function f(b, c) {
                var d = a(e);
                return c.some(function (a) {
                    return e ? H(d(a), d(b)) : H(a, b)
                })
            }

            return e = e || !1, b = C(b) ? d(b) : b, c = C(c) ? d(c) : c, D(b) && D(c) ? b.concat(c).filter(function (a) {
                return !(f(a, b) && f(a, c))
            }) : b
        }
    }]), b.module("a8m.math.byteFmt", ["a8m.math"]).filter("byteFmt", ["$math", function (a) {
        return function (b, c) {
            return B(c) && isFinite(c) && c % 1 === 0 && c >= 0 && B(b) && isFinite(b) ? b < 1024 ? i(b, c, a) + " B" : b < 1048576 ? i(b / 1024, c, a) + " KB" : b < 1073741824 ? i(b / 1048576, c, a) + " MB" : i(b / 1073741824, c, a) + " GB" : "NaN"
        }
    }]), b.module("a8m.math.degrees", ["a8m.math"]).filter("degrees", ["$math", function (a) {
        return function (b, c) {
            if (B(c) && isFinite(c) && c % 1 === 0 && c >= 0 && B(b) && isFinite(b)) {
                var d = 180 * b / a.PI;
                return a.round(d * a.pow(10, c)) / a.pow(10, c)
            }
            return "NaN"
        }
    }]), b.module("a8m.math.kbFmt", ["a8m.math"]).filter("kbFmt", ["$math", function (a) {
        return function (b, c) {
            return B(c) && isFinite(c) && c % 1 === 0 && c >= 0 && B(b) && isFinite(b) ? b < 1024 ? i(b, c, a) + " KB" : b < 1048576 ? i(b / 1024, c, a) + " MB" : i(b / 1048576, c, a) + " GB" : "NaN"
        }
    }]), b.module("a8m.math", []).factory("$math", ["$window", function (a) {
        return a.Math
    }]), b.module("a8m.math.max", ["a8m.math"]).filter("max", ["$math", "$parse", function (a, b) {
        function c(c, d) {
            var e = c.map(function (a) {
                return b(d)(a)
            });
            return e.indexOf(a.max.apply(a, e))
        }

        return function (b, d) {
            return D(b) ? y(d) ? a.max.apply(a, b) : b[c(b, d)] : b
        }
    }]), b.module("a8m.math.min", ["a8m.math"]).filter("min", ["$math", "$parse", function (a, b) {
        function c(c, d) {
            var e = c.map(function (a) {
                return b(d)(a)
            });
            return e.indexOf(a.min.apply(a, e))
        }

        return function (b, d) {
            return D(b) ? y(d) ? a.min.apply(a, b) : b[c(b, d)] : b
        }
    }]), b.module("a8m.math.percent", ["a8m.math"]).filter("percent", ["$math", "$window", function (a, b) {
        return function (c, d, e) {
            var f = A(c) ? b.Number(c) : c;
            return d = d || 100, e = e || !1, !B(f) || b.isNaN(f) ? c : e ? a.round(f / d * 100) : f / d * 100
        }
    }]), b.module("a8m.math.radians", ["a8m.math"]).filter("radians", ["$math", function (a) {
        return function (b, c) {
            if (B(c) && isFinite(c) && c % 1 === 0 && c >= 0 && B(b) && isFinite(b)) {
                var d = 3.14159265359 * b / 180;
                return a.round(d * a.pow(10, c)) / a.pow(10, c)
            }
            return "NaN"
        }
    }]), b.module("a8m.math.radix", []).filter("radix", function () {
        return function (a, b) {
            var c = /^[2-9]$|^[1-2]\d$|^3[0-6]$/;
            return B(a) && c.test(b) ? a.toString(b).toUpperCase() : a
        }
    }), b.module("a8m.math.shortFmt", ["a8m.math"]).filter("shortFmt", ["$math", function (a) {
        return function (b, c) {
            return B(c) && isFinite(c) && c % 1 === 0 && c >= 0 && B(b) && isFinite(b) ? b < 1e3 ? b : b < 1e6 ? i(b / 1e3, c, a) + " K" : b < 1e9 ? i(b / 1e6, c, a) + " M" : i(b / 1e9, c, a) + " B" : "NaN"
        }
    }]), b.module("a8m.math.sum", []).filter("sum", function () {
        return function (a, b) {
            return D(a) ? a.reduce(function (a, b) {
                return a + b
            }, b || 0) : a
        }
    }), b.module("a8m.ends-with", []).filter("endsWith", function () {
        return function (a, b, c) {
            var d, e = c || !1;
            return !A(a) || y(b) ? a : (a = e ? a : a.toLowerCase(), d = a.length - b.length, a.indexOf(e ? b : b.toLowerCase(), d) !== -1)
        }
    }), b.module("a8m.latinize", []).filter("latinize", [function () {
        function a(a) {
            return a.replace(/[^\u0000-\u007E]/g, function (a) {
                return c[a] || a
            })
        }

        for (var b = [{base: "A", letters: "AⒶＡÀÁÂẦẤẪẨÃĀĂẰẮẴẲȦǠÄǞẢÅǺǍȀȂẠẬẶḀĄȺⱯ"}, {
            base: "AA",
            letters: "Ꜳ"
        }, {base: "AE", letters: "ÆǼǢ"}, {base: "AO", letters: "Ꜵ"}, {base: "AU", letters: "Ꜷ"}, {
            base: "AV",
            letters: "ꜸꜺ"
        }, {base: "AY", letters: "Ꜽ"}, {base: "B", letters: "BⒷＢḂḄḆɃƂƁ"}, {
            base: "C",
            letters: "CⒸＣĆĈĊČÇḈƇȻꜾ"
        }, {base: "D", letters: "DⒹＤḊĎḌḐḒḎĐƋƊƉꝹ"}, {base: "DZ", letters: "ǱǄ"}, {base: "Dz", letters: "ǲǅ"}, {
            base: "E",
            letters: "EⒺＥÈÉÊỀẾỄỂẼĒḔḖĔĖËẺĚȄȆẸỆȨḜĘḘḚƐƎ"
        }, {base: "F", letters: "FⒻＦḞƑꝻ"}, {base: "G", letters: "GⒼＧǴĜḠĞĠǦĢǤƓꞠꝽꝾ"}, {
            base: "H",
            letters: "HⒽＨĤḢḦȞḤḨḪĦⱧⱵꞍ"
        }, {base: "I", letters: "IⒾＩÌÍÎĨĪĬİÏḮỈǏȈȊỊĮḬƗ"}, {base: "J", letters: "JⒿＪĴɈ"}, {
            base: "K",
            letters: "KⓀＫḰǨḲĶḴƘⱩꝀꝂꝄꞢ"
        }, {base: "L", letters: "LⓁＬĿĹĽḶḸĻḼḺŁȽⱢⱠꝈꝆꞀ"}, {base: "LJ", letters: "Ǉ"}, {
            base: "Lj",
            letters: "ǈ"
        }, {base: "M", letters: "MⓂＭḾṀṂⱮƜ"}, {base: "N", letters: "NⓃＮǸŃÑṄŇṆŅṊṈȠƝꞐꞤ"}, {
            base: "NJ",
            letters: "Ǌ"
        }, {base: "Nj", letters: "ǋ"}, {base: "O", letters: "OⓄＯÒÓÔỒỐỖỔÕṌȬṎŌṐṒŎȮȰÖȪỎŐǑȌȎƠỜỚỠỞỢỌỘǪǬØǾƆƟꝊꝌ"}, {
            base: "OI",
            letters: "Ƣ"
        }, {base: "OO", letters: "Ꝏ"}, {base: "OU", letters: "Ȣ"}, {base: "OE", letters: "Œ"}, {
            base: "oe",
            letters: "œ"
        }, {base: "P", letters: "PⓅＰṔṖƤⱣꝐꝒꝔ"}, {base: "Q", letters: "QⓆＱꝖꝘɊ"}, {
            base: "R",
            letters: "RⓇＲŔṘŘȐȒṚṜŖṞɌⱤꝚꞦꞂ"
        }, {base: "S", letters: "SⓈＳẞŚṤŜṠŠṦṢṨȘŞⱾꞨꞄ"}, {base: "T", letters: "TⓉＴṪŤṬȚŢṰṮŦƬƮȾꞆ"}, {
            base: "TZ",
            letters: "Ꜩ"
        }, {base: "U", letters: "UⓊＵÙÚÛŨṸŪṺŬÜǛǗǕǙỦŮŰǓȔȖƯỪỨỮỬỰỤṲŲṶṴɄ"}, {base: "V", letters: "VⓋＶṼṾƲꝞɅ"}, {
            base: "VY",
            letters: "Ꝡ"
        }, {base: "W", letters: "WⓌＷẀẂŴẆẄẈⱲ"}, {base: "X", letters: "XⓍＸẊẌ"}, {
            base: "Y",
            letters: "YⓎＹỲÝŶỸȲẎŸỶỴƳɎỾ"
        }, {base: "Z", letters: "ZⓏＺŹẐŻŽẒẔƵȤⱿⱫꝢ"}, {
            base: "a",
            letters: "aⓐａẚàáâầấẫẩãāăằắẵẳȧǡäǟảåǻǎȁȃạậặḁąⱥɐ"
        }, {base: "aa", letters: "ꜳ"}, {base: "ae", letters: "æǽǣ"}, {base: "ao", letters: "ꜵ"}, {
            base: "au",
            letters: "ꜷ"
        }, {base: "av", letters: "ꜹꜻ"}, {base: "ay", letters: "ꜽ"}, {base: "b", letters: "bⓑｂḃḅḇƀƃɓ"}, {
            base: "c",
            letters: "cⓒｃćĉċčçḉƈȼꜿↄ"
        }, {base: "d", letters: "dⓓｄḋďḍḑḓḏđƌɖɗꝺ"}, {base: "dz", letters: "ǳǆ"}, {
            base: "e",
            letters: "eⓔｅèéêềếễểẽēḕḗĕėëẻěȅȇẹệȩḝęḙḛɇɛǝ"
        }, {base: "f", letters: "fⓕｆḟƒꝼ"}, {base: "g", letters: "gⓖｇǵĝḡğġǧģǥɠꞡᵹꝿ"}, {
            base: "h",
            letters: "hⓗｈĥḣḧȟḥḩḫẖħⱨⱶɥ"
        }, {base: "hv", letters: "ƕ"}, {base: "i", letters: "iⓘｉìíîĩīĭïḯỉǐȉȋịįḭɨı"}, {
            base: "j",
            letters: "jⓙｊĵǰɉ"
        }, {base: "k", letters: "kⓚｋḱǩḳķḵƙⱪꝁꝃꝅꞣ"}, {base: "l", letters: "lⓛｌŀĺľḷḹļḽḻſłƚɫⱡꝉꞁꝇ"}, {
            base: "lj",
            letters: "ǉ"
        }, {base: "m", letters: "mⓜｍḿṁṃɱɯ"}, {base: "n", letters: "nⓝｎǹńñṅňṇņṋṉƞɲŉꞑꞥ"}, {
            base: "nj",
            letters: "ǌ"
        }, {base: "o", letters: "oⓞｏòóôồốỗổõṍȭṏōṑṓŏȯȱöȫỏőǒȍȏơờớỡởợọộǫǭøǿɔꝋꝍɵ"}, {base: "oi", letters: "ƣ"}, {
            base: "ou",
            letters: "ȣ"
        }, {base: "oo", letters: "ꝏ"}, {base: "p", letters: "pⓟｐṕṗƥᵽꝑꝓꝕ"}, {base: "q", letters: "qⓠｑɋꝗꝙ"}, {
            base: "r",
            letters: "rⓡｒŕṙřȑȓṛṝŗṟɍɽꝛꞧꞃ"
        }, {base: "s", letters: "sⓢｓßśṥŝṡšṧṣṩșşȿꞩꞅẛ"}, {base: "t", letters: "tⓣｔṫẗťṭțţṱṯŧƭʈⱦꞇ"}, {
            base: "tz",
            letters: "ꜩ"
        }, {base: "u", letters: "uⓤｕùúûũṹūṻŭüǜǘǖǚủůűǔȕȗưừứữửựụṳųṷṵʉ"}, {base: "v", letters: "vⓥｖṽṿʋꝟʌ"}, {
            base: "vy",
            letters: "ꝡ"
        }, {base: "w", letters: "wⓦｗẁẃŵẇẅẘẉⱳ"}, {base: "x", letters: "xⓧｘẋẍ"}, {
            base: "y",
            letters: "yⓨｙỳýŷỹȳẏÿỷẙỵƴɏỿ"
        }, {
            base: "z",
            letters: "zⓩｚźẑżžẓẕƶȥɀⱬꝣ"
        }], c = {}, d = 0; d < b.length; d++)for (var e = b[d].letters.split(""), f = 0; f < e.length; f++)c[e[f]] = b[d].base;
        return function (b) {
            return A(b) ? a(b) : b
        }
    }]), b.module("a8m.ltrim", []).filter("ltrim", function () {
        return function (a, b) {
            var c = b || "\\s";
            return A(a) ? a.replace(new RegExp("^" + c + "+"), "") : a
        }
    }), b.module("a8m.match", []).filter("match", function () {
        return function (a, b, c) {
            var d = new RegExp(b, c);
            return A(a) ? a.match(d) : null
        }
    }), b.module("a8m.repeat", []).filter("repeat", [function () {
        return function (a, b, c) {
            var d = ~~b;
            return A(a) && d ? w(a, --b, c || "") : a
        }
    }]), b.module("a8m.rtrim", []).filter("rtrim", function () {
        return function (a, b) {
            var c = b || "\\s";
            return A(a) ? a.replace(new RegExp(c + "+$"), "") : a
        }
    }), b.module("a8m.slugify", []).filter("slugify", [function () {
        return function (a, b) {
            var c = y(b) ? "-" : b;
            return A(a) ? a.toLowerCase().replace(/\s+/g, c) : a
        }
    }]), b.module("a8m.starts-with", []).filter("startsWith", function () {
        return function (a, b, c) {
            var d = c || !1;
            return !A(a) || y(b) ? a : (a = d ? a : a.toLowerCase(), !a.indexOf(d ? b : b.toLowerCase()))
        }
    }), b.module("a8m.stringular", []).filter("stringular", function () {
        return function (a) {
            var b = Array.prototype.slice.call(arguments, 1);
            return a.replace(/{(\d+)}/g, function (a, c) {
                return y(b[c]) ? a : b[c]
            })
        }
    }), b.module("a8m.strip-tags", []).filter("stripTags", function () {
        return function (a) {
            return A(a) ? a.replace(/<\S[^><]*>/g, "") : a
        }
    }), b.module("a8m.test", []).filter("test", function () {
        return function (a, b, c) {
            var d = new RegExp(b, c);
            return A(a) ? d.test(a) : a
        }
    }), b.module("a8m.trim", []).filter("trim", function () {
        return function (a, b) {
            var c = b || "\\s";
            return A(a) ? a.replace(new RegExp("^" + c + "+|" + c + "+$", "g"), "") : a
        }
    }), b.module("a8m.truncate", []).filter("truncate", function () {
        return function (a, b, c, d) {
            return b = y(b) ? a.length : b, d = d || !1, c = c || "", !A(a) || a.length <= b ? a : a.substring(0, d ? a.indexOf(" ", b) === -1 ? a.length : a.indexOf(" ", b) : b) + c
        }
    }), b.module("a8m.ucfirst", []).filter("ucfirst", [function () {
        return function (a) {
            return A(a) ? a.split(" ").map(function (a) {
                return a.charAt(0).toUpperCase() + a.substring(1)
            }).join(" ") : a
        }
    }]), b.module("a8m.uri-component-encode", []).filter("uriComponentEncode", ["$window", function (a) {
        return function (b) {
            return A(b) ? a.encodeURIComponent(b) : b
        }
    }]), b.module("a8m.uri-encode", []).filter("uriEncode", ["$window", function (a) {
        return function (b) {
            return A(b) ? a.encodeURI(b) : b
        }
    }]), b.module("a8m.wrap", []).filter("wrap", function () {
        return function (a, b, c) {
            return A(a) && x(b) ? [b, a, c || b].join("") : a
        }
    }), b.module("a8m.filter-watcher", []).provider("filterWatcher", function () {
        this.$get = ["$window", "$rootScope", function (a, b) {
            function c(b, c) {
                function d() {
                    var b = [];
                    return function (c, d) {
                        if (C(d) && !e(d)) {
                            if (~b.indexOf(d))return "[Circular]";
                            b.push(d)
                        }
                        return a == d ? "$WINDOW" : a.document == d ? "$DOCUMENT" : k(d) ? "$SCOPE" : d
                    }
                }

                return [b, JSON.stringify(c, d())].join("#").replace(/"/g, "")
            }

            function d(a) {
                var b = a.targetScope.$id;
                E(l[b], function (a) {
                    delete j[a]
                }), delete l[b]
            }

            function f() {
                m(function () {
                    b.$$phase || (j = {})
                }, 2e3)
            }

            function g(a, b) {
                var c = a.$id;
                return y(l[c]) && (a.$on("$destroy", d), l[c] = []), l[c].push(b)
            }

            function h(a, b) {
                var d = c(a, b);
                return j[d]
            }

            function i(a, b, d, e) {
                var h = c(a, b);
                return j[h] = e, k(d) ? g(d, h) : f(), e
            }

            var j = {}, l = {}, m = a.setTimeout;
            return {isMemoized: h, memoize: i}
        }]
    }), b.module("angular.filter", ["a8m.ucfirst", "a8m.uri-encode", "a8m.uri-component-encode", "a8m.slugify", "a8m.latinize", "a8m.strip-tags", "a8m.stringular", "a8m.truncate", "a8m.starts-with", "a8m.ends-with", "a8m.wrap", "a8m.trim", "a8m.ltrim", "a8m.rtrim", "a8m.repeat", "a8m.test", "a8m.match", "a8m.to-array", "a8m.concat", "a8m.contains", "a8m.unique", "a8m.is-empty", "a8m.after", "a8m.after-where", "a8m.before", "a8m.before-where", "a8m.defaults", "a8m.where", "a8m.reverse", "a8m.remove", "a8m.remove-with", "a8m.group-by", "a8m.count-by", "a8m.chunk-by", "a8m.search-field", "a8m.fuzzy-by", "a8m.fuzzy", "a8m.omit", "a8m.pick", "a8m.every", "a8m.filter-by", "a8m.xor", "a8m.map", "a8m.first", "a8m.last", "a8m.flatten", "a8m.join", "a8m.range", "a8m.math", "a8m.math.max", "a8m.math.min", "a8m.math.percent", "a8m.math.radix", "a8m.math.sum", "a8m.math.degrees", "a8m.math.radians", "a8m.math.byteFmt", "a8m.math.kbFmt", "a8m.math.shortFmt", "a8m.angular", "a8m.conditions", "a8m.is-null", "a8m.filter-watcher"])
}(window, window.angular);

$.emojiarea.path = '/images';
$.emojiarea.icons = {
    ':smile:': 'smile.png',
    ':sad:': 'sad.png',
    ':heart:': 'heart.png',
    ':broken:': 'broken.png',
    ':laughing:': 'laughing.png'
};

var UNITS = {
    year: 31557600000,
    month: 2629800000,
    week: 604800000,
    day: 86400000,
    hour: 3600000,
    minute: 60000,
    second: 1000,
    millisecond: 1
};

var languages = {
    ar: {
        year: function (c) {
            return ((c === 1) ? "سنة" : "سنوات");
        },
        month: function (c) {
            return ((c === 1) ? "شهر" : "أشهر");
        },
        week: function (c) {
            return ((c === 1) ? "أسبوع" : "أسابيع");
        },
        day: function (c) {
            return ((c === 1) ? "يوم" : "أيام");
        },
        hour: function (c) {
            return ((c === 1) ? "ساعة" : "ساعات");
        },
        minute: function (c) {
            return ((c === 1) ? "دقيقة" : "دقائق");
        },
        second: function (c) {
            return ((c === 1) ? "ثانية" : "ثواني");
        },
        millisecond: function (c) {
            return ((c === 1) ? "جزء من الثانية" : "أجزاء من الثانية");
        }
    },
    ca: {
        year: function (c) {
            return "any" + ((c !== 1) ? "s" : "");
        },
        month: function (c) {
            return "mes" + ((c !== 1) ? "os" : "");
        },
        week: function (c) {
            return "setman" + ((c !== 1) ? "es" : "a");
        },
        day: function (c) {
            return "di" + ((c !== 1) ? "es" : "a");
        },
        hour: function (c) {
            return "hor" + ((c !== 1) ? "es" : "a");
        },
        minute: function (c) {
            return "minut" + ((c !== 1) ? "s" : "");
        },
        second: function (c) {
            return "segon" + ((c !== 1) ? "s" : "");
        },
        millisecond: function (c) {
            return "milisegon" + ((c !== 1) ? "s" : "" );
        }
    },
    da: {
        year: "år",
        month: function (c) {
            return "måned" + ((c !== 1) ? "er" : "");
        },
        week: function (c) {
            return "uge" + ((c !== 1) ? "r" : "");
        },
        day: function (c) {
            return "dag" + ((c !== 1) ? "e" : "");
        },
        hour: function (c) {
            return "time" + ((c !== 1) ? "r" : "");
        },
        minute: function (c) {
            return "minut" + ((c !== 1) ? "ter" : "");
        },
        second: function (c) {
            return "sekund" + ((c !== 1) ? "er" : "");
        },
        millisecond: function (c) {
            return "millisekund" + ((c !== 1) ? "er" : "");
        }
    },
    de: {
        year: function (c) {
            return "Jahr" + ((c !== 1) ? "e" : "");
        },
        month: function (c) {
            return "Monat" + ((c !== 1) ? "e" : "");
        },
        week: function (c) {
            return "Woche" + ((c !== 1) ? "n" : "");
        },
        day: function (c) {
            return "Tag" + ((c !== 1) ? "e" : "");
        },
        hour: function (c) {
            return "Stunde" + ((c !== 1) ? "n" : "");
        },
        minute: function (c) {
            return "Minute" + ((c !== 1) ? "n" : "");
        },
        second: function (c) {
            return "Sekunde" + ((c !== 1) ? "n" : "");
        },
        millisecond: function (c) {
            return "Millisekunde" + ((c !== 1) ? "n" : "");
        }
    },
    en: {
        year: function (c) {
            return "year" + ((c !== 1) ? "s" : "");
        },
        month: function (c) {
            return "month" + ((c !== 1) ? "s" : "");
        },
        week: function (c) {
            return "week" + ((c !== 1) ? "s" : "");
        },
        day: function (c) {
            return "day" + ((c !== 1) ? "s" : "");
        },
        hour: function (c) {
            return "hour" + ((c !== 1) ? "s" : "");
        },
        minute: function (c) {
            return "minute" + ((c !== 1) ? "s" : "");
        },
        second: function (c) {
            return "second" + ((c !== 1) ? "s" : "");
        },
        millisecond: function (c) {
            return "millisecond" + ((c !== 1) ? "s" : "");
        }
    },
    es: {
        year: function (c) {
            return "año" + ((c !== 1) ? "s" : "");
        },
        month: function (c) {
            return "mes" + ((c !== 1) ? "es" : "");
        },
        week: function (c) {
            return "semana" + ((c !== 1) ? "s" : "");
        },
        day: function (c) {
            return "día" + ((c !== 1) ? "s" : "");
        },
        hour: function (c) {
            return "hora" + ((c !== 1) ? "s" : "");
        },
        minute: function (c) {
            return "minuto" + ((c !== 1) ? "s" : "");
        },
        second: function (c) {
            return "segundo" + ((c !== 1) ? "s" : "");
        },
        millisecond: function (c) {
            return "milisegundo" + ((c !== 1) ? "s" : "" );
        }
    },
    fr: {
        year: function (c) {
            return "an" + ((c !== 1) ? "s" : "");
        },
        month: "mois",
        week: function (c) {
            return "semaine" + ((c !== 1) ? "s" : "");
        },
        day: function (c) {
            return "jour" + ((c !== 1) ? "s" : "");
        },
        hour: function (c) {
            return "heure" + ((c !== 1) ? "s" : "");
        },
        minute: function (c) {
            return "minute" + ((c !== 1) ? "s" : "");
        },
        second: function (c) {
            return "seconde" + ((c !== 1) ? "s" : "");
        },
        millisecond: function (c) {
            return "milliseconde" + ((c !== 1) ? "s" : "");
        }
    },
    hu: {
        year: "év",
        month: "hónap",
        week: "hét",
        day: "nap",
        hour: "óra",
        minute: "perc",
        second: "másodperc",
        millisecond: "ezredmásodperc"
    },
    it: {
        year: function (c) {
            return "ann" + ((c !== 1) ? "i" : "o");
        },
        month: function (c) {
            return "mes" + ((c !== 1) ? "i" : "e");
        },
        week: function (c) {
            return "settiman" + ((c !== 1) ? "e" : "a");
        },
        day: function (c) {
            return "giorn" + ((c !== 1) ? "i" : "o");
        },
        hour: function (c) {
            return "or" + ((c !== 1) ? "e" : "a");
        },
        minute: function (c) {
            return "minut" + ((c !== 1) ? "i" : "o");
        },
        second: function (c) {
            return "second" + ((c !== 1) ? "i" : "o");
        },
        millisecond: function (c) {
            return "millisecond" + ((c !== 1) ? "i" : "o" );
        }
    },
    ja: {
        year: "年",
        month: "月",
        week: "週",
        day: "日",
        hour: "時間",
        minute: "分",
        second: "秒",
        millisecond: "ミリ秒"
    },
    ko: {
        year: "년",
        month: "개월",
        week: "주일",
        day: "일",
        hour: "시간",
        minute: "분",
        second: "초",
        millisecond: "밀리 초"
    },
    nl: {
        year: "jaar",
        month: function (c) {
            return (c === 1) ? "maand" : "maanden";
        },
        week: function (c) {
            return (c === 1) ? "week" : "weken";
        },
        day: function (c) {
            return (c === 1) ? "dag" : "dagen";
        },
        hour: "uur",
        minute: function (c) {
            return (c === 1) ? "minuut" : "minuten";
        },
        second: function (c) {
            return (c === 1) ? "seconde" : "seconden";
        },
        millisecond: function (c) {
            return (c === 1) ? "milliseconde" : "milliseconden";
        }
    },
    nob: {
        year: "år",
        month: function (c) {
            return "måned" + ((c !== 1) ? "er" : "");
        },
        week: function (c) {
            return "uke" + ((c !== 1) ? "r" : "");
        },
        day: function (c) {
            return "dag" + ((c !== 1) ? "er" : "");
        },
        hour: function (c) {
            return "time" + ((c !== 1) ? "r" : "");
        },
        minute: function (c) {
            return "minutt" + ((c !== 1) ? "er" : "");
        },
        second: function (c) {
            return "sekund" + ((c !== 1) ? "er" : "");
        },
        millisecond: function (c) {
            return "millisekund" + ((c !== 1) ? "er" : "");
        }
    },
    pl: {
        year: function (c) {
            return ["rok", "roku", "lata", "lat"][getPolishForm(c)];
        },
        month: function (c) {
            return ["miesiąc", "miesiąca", "miesiące", "miesięcy"][getPolishForm(c)];
        },
        week: function (c) {
            return ["tydzień", "tygodnia", "tygodnie", "tygodni"][getPolishForm(c)];
        },
        day: function (c) {
            return ["dzień", "dnia", "dni", "dni"][getPolishForm(c)];
        },
        hour: function (c) {
            return ["godzina", "godziny", "godziny", "godzin"][getPolishForm(c)];
        },
        minute: function (c) {
            return ["minuta", "minuty", "minuty", "minut"][getPolishForm(c)];
        },
        second: function (c) {
            return ["sekunda", "sekundy", "sekundy", "sekund"][getPolishForm(c)];
        },
        millisecond: function (c) {
            return ["milisekunda", "milisekundy", "milisekundy", "milisekund"][getPolishForm(c)];
        }
    },
    pt: {
        year: function (c) {
            return "ano" + ((c !== 1) ? "s" : "");
        },
        month: function (c) {
            return (c !== 1) ? "meses" : "mês";
        },
        week: function (c) {
            return "semana" + ((c !== 1) ? "s" : "");
        },
        day: function (c) {
            return "dia" + ((c !== 1) ? "s" : "");
        },
        hour: function (c) {
            return "hora" + ((c !== 1) ? "s" : "");
        },
        minute: function (c) {
            return "minuto" + ((c !== 1) ? "s" : "");
        },
        second: function (c) {
            return "segundo" + ((c !== 1) ? "s" : "");
        },
        millisecond: function (c) {
            return "milissegundo" + ((c !== 1) ? "s" : "");
        }
    },
    ru: {
        year: function (c) {
            return ["лет", "год", "года"][getRussianForm(c)];
        },
        month: function (c) {
            return ["месяцев", "месяц", "месяца"][getRussianForm(c)];
        },
        week: function (c) {
            return ["недель", "неделя", "недели"][getRussianForm(c)];
        },
        day: function (c) {
            return ["дней", "день", "дня"][getRussianForm(c)];
        },
        hour: function (c) {
            return ["часов", "час", "часа"][getRussianForm(c)];
        },
        minute: function (c) {
            return ["минут", "минута", "минуты"][getRussianForm(c)];
        },
        second: function (c) {
            return ["секунд", "секунда", "секунды"][getRussianForm(c)];
        },
        millisecond: function (c) {
            return ["миллисекунд", "миллисекунда", "миллисекунды"][getRussianForm(c)];
        }
    },
    sv: {
        year: "år",
        month: function (c) {
            return "månad" + ((c !== 1) ? "er" : "");
        },
        week: function (c) {
            return "veck" + ((c !== 1) ? "or" : "a");
        },
        day: function (c) {
            return "dag" + ((c !== 1) ? "ar" : "");
        },
        hour: function (c) {
            return "timm" + ((c !== 1) ? "ar" : "e");
        },
        minute: function (c) {
            return "minut" + ((c !== 1) ? "er" : "");
        },
        second: function (c) {
            return "sekund" + ((c !== 1) ? "er" : "");
        },
        millisecond: function (c) {
            return "millisekund" + ((c !== 1) ? "er" : "");
        }
    },
    tr: {
        year: "yıl",
        month: "ay",
        week: "hafta",
        day: "gün",
        hour: "saat",
        minute: "dakika",
        second: "saniye",
        millisecond: "milisaniye"
    },
    "zh-CN": {
        year: "年",
        month: "个月",
        week: "周",
        day: "天",
        hour: "小时",
        minute: "分钟",
        second: "秒",
        millisecond: "毫秒"
    },
    "zh-TW": {
        year: "年",
        month: "個月",
        week: "周",
        day: "天",
        hour: "小時",
        minute: "分鐘",
        second: "秒",
        millisecond: "毫秒"
    }
};

// You can create a humanizer, which returns a function with defaults
// parameters.
function humanizer(passedOptions) {

    var result = function humanizer(ms, humanizerOptions) {
        var options = extend({}, result, humanizerOptions || {});
        return doHumanization(ms, options);
    };

    return extend(result, {
        language: "en",
        delimiter: ", ",
        spacer: " ",
        units: ["year", "month", "week", "day", "hour", "minute", "second"],
        languages: {},
        halfUnit: true,
        round: false
    }, passedOptions);

}

// The main function is just a wrapper around a default humanizer.
var defaultHumanizer = humanizer({});
function humanizeDuration() {
    return defaultHumanizer.apply(defaultHumanizer, arguments);
}

// doHumanization does the bulk of the work.
function doHumanization(ms, options) {

    // Make sure we have a positive number.
    // Has the nice sideffect of turning Number objects into primitives.
    ms = Math.abs(ms);

    if (ms === 0) {
        return "0";
    }

    var dictionary = options.languages[options.language] || languages[options.language];
    if (!dictionary) {
        throw new Error("No language " + dictionary + ".");
    }

    var result = [];

    // Start at the top and keep removing units, bit by bit.
    var unitName, unitMS, unitCount, mightBeHalfUnit;
    for (var i = 0, len = options.units.length; i < len; i++) {

        unitName = options.units[i];
        if (unitName[unitName.length - 1] === "s") { // strip plurals
            unitName = unitName.substring(0, unitName.length - 1);
        }
        unitMS = UNITS[unitName];

        // If it's a half-unit interval, we're done.
        if (result.length === 0 && options.halfUnit) {
            mightBeHalfUnit = (ms / unitMS) * 2;
            if (mightBeHalfUnit === Math.floor(mightBeHalfUnit)) {
                return render(mightBeHalfUnit / 2, unitName, dictionary, options.spacer);
            }
        }

        // What's the number of full units we can fit?
        if ((i + 1) === len) {
            unitCount = ms / unitMS;
            if (options.round) {
                unitCount = Math.round(unitCount);
            }
        } else {
            unitCount = Math.floor(ms / unitMS);
        }

        // Add the string.
        if (unitCount) {
            result.push(render(unitCount, unitName, dictionary, options.spacer));
        }

        // Remove what we just figured out.
        ms -= unitCount * unitMS;

    }

    return result.join(options.delimiter);

}

function render(count, type, dictionary, spacer) {
    var dictionaryValue = dictionary[type];
    var word;
    if (typeof dictionaryValue === "function") {
        word = dictionaryValue(count);
    } else {
        word = dictionaryValue;
    }
    return count + spacer + word;
}

function extend(destination) {
    var source;
    for (var i = 1; i < arguments.length; i++) {
        source = arguments[i];
        for (var prop in source) {
            if (source.hasOwnProperty(prop)) {
                destination[prop] = source[prop];
            }
        }
    }
    return destination;
}

// Internal helper function for Polish language.
function getPolishForm(c) {
    if (c === 1) {
        return 0;
    } else if (Math.floor(c) !== c) {
        return 1;
    } else if (2 <= c % 10 && c % 10 <= 4 && !(10 < c % 100 && c % 100 < 20)) {
        return 2;
    } else {
        return 3;
    }
}

// Internal helper function for Russian language.
function getRussianForm(c) {
    if (Math.floor(c) !== c) {
        return 2;
    } else if (c === 0 || (c >= 5 && c <= 20) || (c % 10 >= 5 && c % 10 <= 9) || (c % 10 === 0)) {
        return 0;
    } else if (c === 1 || c % 10 === 1) {
        return 1;
    } else if (c > 1) {
        return 2;
    } else {
        return 0;
    }
}

function getSupportedLanguages() {
    var result = [];
    for (var language in languages) {
        if (languages.hasOwnProperty(language)) {
            result.push(language);
        }
    }
    return result;
}

humanizeDuration.humanizer = humanizer;
humanizeDuration.getSupportedLanguages = getSupportedLanguages;

if (typeof define === "function" && define.amd) {
    define(function () {
        return humanizeDuration;
    });
} else if (typeof module !== "undefined" && module.exports) {
    module.exports = humanizeDuration;
} else {
    this.humanizeDuration = humanizeDuration;
}
/**
 * angular-timer - v1.3.4 - 2016-05-01 9:52 PM
 * https://github.com/siddii/angular-timer
 *
 * Copyright (c) 2016 Siddique Hameed
 * Licensed MIT <https://github.com/siddii/angular-timer/blob/master/LICENSE.txt>
 */
var timerModule=angular.module("timer",[]).directive("timer",["$compile",function(a){return{restrict:"EA",replace:!1,scope:{interval:"=interval",startTimeAttr:"=startTime",endTimeAttr:"=endTime",countdownattr:"=countdown",finishCallback:"&finishCallback",autoStart:"&autoStart",language:"@?",fallback:"@?",maxTimeUnit:"=",seconds:"=?",minutes:"=?",hours:"=?",days:"=?",months:"=?",years:"=?",secondsS:"=?",minutesS:"=?",hoursS:"=?",daysS:"=?",monthsS:"=?",yearsS:"=?"},controller:["$scope","$element","$attrs","$timeout","I18nService","$interpolate","progressBarService",function(b,c,d,e,f,g,h){function i(){b.timeoutId&&clearTimeout(b.timeoutId)}function j(){var a={};void 0!==d.startTime&&(b.millis=moment().diff(moment(b.startTimeAttr))),a=k.getTimeUnits(b.millis),b.maxTimeUnit&&"day"!==b.maxTimeUnit?"second"===b.maxTimeUnit?(b.seconds=Math.floor(b.millis/1e3),b.minutes=0,b.hours=0,b.days=0,b.months=0,b.years=0):"minute"===b.maxTimeUnit?(b.seconds=Math.floor(b.millis/1e3%60),b.minutes=Math.floor(b.millis/6e4),b.hours=0,b.days=0,b.months=0,b.years=0):"hour"===b.maxTimeUnit?(b.seconds=Math.floor(b.millis/1e3%60),b.minutes=Math.floor(b.millis/6e4%60),b.hours=Math.floor(b.millis/36e5),b.days=0,b.months=0,b.years=0):"month"===b.maxTimeUnit?(b.seconds=Math.floor(b.millis/1e3%60),b.minutes=Math.floor(b.millis/6e4%60),b.hours=Math.floor(b.millis/36e5%24),b.days=Math.floor(b.millis/36e5/24%30),b.months=Math.floor(b.millis/36e5/24/30),b.years=0):"year"===b.maxTimeUnit&&(b.seconds=Math.floor(b.millis/1e3%60),b.minutes=Math.floor(b.millis/6e4%60),b.hours=Math.floor(b.millis/36e5%24),b.days=Math.floor(b.millis/36e5/24%30),b.months=Math.floor(b.millis/36e5/24/30%12),b.years=Math.floor(b.millis/36e5/24/365)):(b.seconds=Math.floor(b.millis/1e3%60),b.minutes=Math.floor(b.millis/6e4%60),b.hours=Math.floor(b.millis/36e5%24),b.days=Math.floor(b.millis/36e5/24),b.months=0,b.years=0),b.secondsS=1===b.seconds?"":"s",b.minutesS=1===b.minutes?"":"s",b.hoursS=1===b.hours?"":"s",b.daysS=1===b.days?"":"s",b.monthsS=1===b.months?"":"s",b.yearsS=1===b.years?"":"s",b.secondUnit=a.seconds,b.minuteUnit=a.minutes,b.hourUnit=a.hours,b.dayUnit=a.days,b.monthUnit=a.months,b.yearUnit=a.years,b.sseconds=b.seconds<10?"0"+b.seconds:b.seconds,b.mminutes=b.minutes<10?"0"+b.minutes:b.minutes,b.hhours=b.hours<10?"0"+b.hours:b.hours,b.ddays=b.days<10?"0"+b.days:b.days,b.mmonths=b.months<10?"0"+b.months:b.months,b.yyears=b.years<10?"0"+b.years:b.years}"function"!=typeof String.prototype.trim&&(String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g,"")}),b.autoStart=d.autoStart||d.autostart,b.language=b.language||"en",b.fallback=b.fallback||"en",b.$watch("language",function(a){void 0!==a&&k.init(a,b.fallback)});var k=new f;k.init(b.language,b.fallback),b.displayProgressBar=0,b.displayProgressActive="active",c.append(0===c.html().trim().length?a("<span>"+g.startSymbol()+"millis"+g.endSymbol()+"</span>")(b):a(c.contents())(b)),b.startTime=null,b.endTime=null,b.timeoutId=null,b.countdown=angular.isNumber(b.countdownattr)&&parseInt(b.countdownattr,10)>=0?parseInt(b.countdownattr,10):void 0,b.isRunning=!1,b.$on("timer-start",function(){b.start()}),b.$on("timer-resume",function(){b.resume()}),b.$on("timer-stop",function(){b.stop()}),b.$on("timer-clear",function(){b.clear()}),b.$on("timer-reset",function(){b.reset()}),b.$on("timer-set-countdown",function(a,c){b.countdown=c}),b.$watch("startTimeAttr",function(a,c){a!==c&&b.isRunning&&b.start()}),b.$watch("endTimeAttr",function(a,c){a!==c&&b.isRunning&&b.start()}),b.start=c[0].start=function(){b.startTime=b.startTimeAttr?moment(b.startTimeAttr):moment(),b.endTime=b.endTimeAttr?moment(b.endTimeAttr):null,angular.isNumber(b.countdown)||(b.countdown=angular.isNumber(b.countdownattr)&&parseInt(b.countdownattr,10)>0?parseInt(b.countdownattr,10):void 0),i(),l(),b.isRunning=!0},b.resume=c[0].resume=function(){i(),b.countdownattr&&(b.countdown+=1),b.startTime=moment().diff(moment(b.stoppedTime).diff(moment(b.startTime))),l(),b.isRunning=!0},b.stop=b.pause=c[0].stop=c[0].pause=function(){var a=b.timeoutId;b.clear(),b.$emit("timer-stopped",{timeoutId:a,millis:b.millis,seconds:b.seconds,minutes:b.minutes,hours:b.hours,days:b.days})},b.clear=c[0].clear=function(){b.stoppedTime=moment(),i(),b.timeoutId=null,b.isRunning=!1},b.reset=c[0].reset=function(){b.startTime=b.startTimeAttr?moment(b.startTimeAttr):moment(),b.endTime=b.endTimeAttr?moment(b.endTimeAttr):null,b.countdown=angular.isNumber(b.countdownattr)&&parseInt(b.countdownattr,10)>0?parseInt(b.countdownattr,10):void 0,i(),l(),b.isRunning=!1,b.clear()},c.bind("$destroy",function(){i(),b.isRunning=!1}),b.countdownattr?(b.millis=1e3*b.countdownattr,b.addCDSeconds=c[0].addCDSeconds=function(a){b.countdown+=a,b.$digest(),b.isRunning||b.start()},b.$on("timer-add-cd-seconds",function(a,c){e(function(){b.addCDSeconds(c)})}),b.$on("timer-set-countdown-seconds",function(a,c){b.isRunning||b.clear(),b.countdown=c,b.millis=1e3*c,j()})):b.millis=0,j();var l=function m(){var a=null;b.millis=moment().diff(b.startTime);var d=b.millis%1e3;return b.endTimeAttr&&(a=b.endTimeAttr,b.millis=moment(b.endTime).diff(moment()),d=b.interval-b.millis%1e3),b.countdownattr&&(a=b.countdownattr,b.millis=1e3*b.countdown),b.millis<0?(b.stop(),b.millis=0,j(),void(b.finishCallback&&b.$eval(b.finishCallback))):(j(),b.timeoutId=setTimeout(function(){m(),b.$digest()},b.interval-d),b.$emit("timer-tick",{timeoutId:b.timeoutId,millis:b.millis,timerElement:c[0]}),b.countdown>0?b.countdown--:b.countdown<=0&&(b.stop(),b.finishCallback&&b.$eval(b.finishCallback)),void(null!==a&&(b.progressBar=h.calculateProgressBar(b.startTime,b.millis,b.endTime,b.countdownattr),100===b.progressBar&&(b.displayProgressActive=""))))};(void 0===b.autoStart||b.autoStart===!0)&&b.start()}]}}]);"undefined"!=typeof module&&"undefined"!=typeof exports&&module.exports===exports&&(module.exports=timerModule);var app=angular.module("timer");app.factory("I18nService",function(){var a=function(){};return a.prototype.language="en",a.prototype.fallback="en",a.prototype.timeHumanizer={},a.prototype.init=function(a,b){var c=humanizeDuration.getSupportedLanguages();this.fallback=void 0!==b?b:"en",-1===c.indexOf(b)&&(this.fallback="en"),this.language=a,-1===c.indexOf(a)&&(this.language=this.fallback),moment.locale(this.language),this.timeHumanizer=humanizeDuration.humanizer({language:this.language,halfUnit:!1})},a.prototype.getTimeUnits=function(a){var b=1e3*Math.round(a/1e3),c={};return"undefined"!=typeof this.timeHumanizer?c={millis:this.timeHumanizer(b,{units:["milliseconds"]}),seconds:this.timeHumanizer(b,{units:["seconds"]}),minutes:this.timeHumanizer(b,{units:["minutes","seconds"]}),hours:this.timeHumanizer(b,{units:["hours","minutes","seconds"]}),days:this.timeHumanizer(b,{units:["days","hours","minutes","seconds"]}),months:this.timeHumanizer(b,{units:["months","days","hours","minutes","seconds"]}),years:this.timeHumanizer(b,{units:["years","months","days","hours","minutes","seconds"]})}:console.error('i18nService has not been initialized. You must call i18nService.init("en") for example'),c},a});var app=angular.module("timer");app.factory("progressBarService",function(){var a=function(){};return a.prototype.calculateProgressBar=function(a,b,c,d){var e,f,g=0;return b/=1e3,null!==c?(e=moment(c),f=e.diff(a,"seconds"),g=100*b/f):g=100*b/d,g=100-g,g=Math.round(10*g)/10,g>100&&(g=100),g},new a});

!function(e){function n(r){if(t[r])return t[r].exports;var o=t[r]={exports:{},id:r,loaded:!1};return e[r].call(o.exports,o,o.exports,n),o.loaded=!0,o.exports}var t={};return n.m=e,n.c=t,n.p="",n(0)}([function(e,n){"use strict";!function(){var e=angular.module("angularModalService",[]);e.factory("ModalService",["$animate","$document","$compile","$controller","$http","$rootScope","$q","$templateRequest","$timeout",function(e,n,t,r,o,l,c,u,a){function i(){var o=this,i=function(e,n){var t=c.defer();return e?t.resolve(e):n?u(n,!0).then(function(e){t.resolve(e)},function(e){t.reject(e)}):t.reject("No template or templateUrl has been specified."),t.promise},s=function(n,t){var r=n.children();return r.length>0?e.enter(t,n,r[r.length-1]):e.enter(t,n)};o.showModal=function(o){var u=angular.element(n[0].body),p=c.defer(),d=o.controller;return d?(i(o.template,o.templateUrl).then(function(n){function i(n){m.resolve(n),e.leave(g).then(function(){v.resolve(n),d.$destroy(),$.close=null,p=null,m=null,S=null,$=null,g=null,d=null}),f&&f()}var d=(o.scope||l).$new(),f=l.$on("$locationChangeSuccess",i),m=c.defer(),v=c.defer(),$={$scope:d,close:function(e,n){void 0!==n&&null!==n||(n=0),a(function(){i(e)},n)}};o.inputs&&angular.extend($,o.inputs);var h=t(n),g=h(d);$.$element=g;var x=d[o.controllerAs],j=r(o.controller,$,!1,o.controllerAs);o.controllerAs&&x&&angular.extend(j,x),o.appendElement?s(o.appendElement,g):s(u,g);var S={controller:j,scope:d,element:g,close:m.promise,closed:v.promise};p.resolve(S)}).then(null,function(e){p.reject(e)}),p.promise):(p.reject("No controller has been specified."),p.promise)}}return new i}])}()}]);
//# sourceMappingURL=./dst/angular-modal-service.min.js.map

var app = angular.module('app', [
        'timer',
        'ngSanitize',
        'angularModalService',
        require('angular-ui-router'),
        require('./customers'),
        require('./agents')
    ], function ($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })

    .config([
        '$stateProvider',
        '$urlRouterProvider',
        function setupRoutes($stateProvider, $urlRouterProvider) {

            $urlRouterProvider.rule(function ($injector, $location) {
                var absUrl = $location.absUrl();

            //    console.log('INFO',$injector,$location,$stateProvider, $urlRouterProvider);

                var str = absUrl;
                var n = str.lastIndexOf('/');
                var newStr = str.substring(n + 1);

                if (absUrl.indexOf('/chat-advisor') > -1) {
                    return '/agents';
                }

                // No otherwise allowed until we merge the routers
                $urlRouterProvider.otherwise('/customers/'+newStr);

            });

        }])
    .run(function ($rootScope, $http, $location) {
        $rootScope
            .$on('$stateChangeStart',
                function (event, toState, toParams, fromState, fromParams) {
                    //console.log(event, toState, toParams, fromState, fromParams);
                    if (fromState.name != "" && toState.name == 'customers-rooms') {
                        var config = require('./config');
                        const socket = require('socket.io-client')(config.SOCKET_URI);

                        var time = $("#tim span").html().split(':');
                        if(time[2] != "00") {
                            var end_chat_url = $location.protocol() + '://' + $location.host() + '/dashboard/end-chat/' + fromParams.agent_id + '/' + fromParams.client_id + '/' + time[0] + '/' + time[1] + '/' + time[2];
                            socket.emit('customer.disconnect', fromParams.client_id, fromParams.room, end_chat_url , function(room) {
                                window.location.reload();
                            });
                            /*
                            $http.get($location.protocol() + '://' + $location.host() + '/dashboard/end-chat/' + fromParams.agent_id + '/' + fromParams.client_id + '/' + time[0] + '/' + time[1] + '/' + time[2]).then(function (responce) {
                                $('#total_tim').html(responce.data);

                                socket.emit('chat.message.short.customer', fromParams.client_id, fromParams.room);

                            }, function () {
                                alert('error');
                            });
                            */
                        }
                    }
                    $("#ui-view").html("");
                    $(".page-loading").removeClass("hidden");
                });

        $rootScope
            .$on('$stateChangeSuccess',
                function (event, toState, toParams, fromState, fromParams) {
                    if (fromState.name != "" && toState.name == 'customers-rooms') {
                        $(".livechat-wrapper").html("");
                        $(".page-loading2").removeClass("hidden");
                    } else {
                        $(".page-loading2").addClass("hidden");
                        $(".page-loading").addClass("hidden");
                    }
                });

    }).directive('ngScrollBottom', ['$timeout', function ($timeout) {
        return {
            scope: {
                messages: "=",
                typing: "="
            },
            link: function ($scope, $element) {
                $element.scrollTop($element[0].scrollHeight);
                $scope.$watchCollection('messages', function (newValue) {
                    if (newValue) {
                        $timeout(function () {
                            $element.scrollTop($element[0].scrollHeight);

                        }, 0);
                    }
                });
                $scope.$watch('typing', function (newValue) {
                    if (newValue === true || newValue === 'User is typing...') {
                        $timeout(function () {
                            $element.scrollTop($element[0].scrollHeight+40);

                        }, 0);
                    }
                });
            }
        }
            }]).directive('clickOff', function($parse, $document) {
                var dir = {
                    compile: function($element, attr) {
                      // Parse the expression to be executed
                      // whenever someone clicks _off_ this element.
                      var fn = $parse(attr["clickOff"]);
                      return function(scope, element, attr) {
                        // add a click handler to the element that
                        // stops the event propagation.
                        element.bind("mousemove", function(event) {
                          event.stopPropagation();
                        });
                        angular.element($document[0].body).bind("mousemove",                                                                 function(event) {
                            scope.$apply(function() {
                                fn(scope, {$event:event});
                            });
                        });
                      };
                    }
                  };
                return dir;
            }).filter('emoji', function () {
                return function (message) {
                    var icons = {
                        'smile': 'smile.png',
                        'sad': 'sad.png',
                        'heart': 'heart.png',
                        'broken': 'broken.png',
                        'laughing': 'laughing.png'
                    };
                    return message.replace(/\:(\w+)\:/g, function (s, key) {
                        return '<img src="/images/' + icons[key] + '"/>' || s;
                    });

    }
});


