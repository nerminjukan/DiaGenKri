/*
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/mit-license.php
 *
 */

(function() {
    Raphael.fn.toJSON = function(callback) {
        var
            data,
            elements = new Array,
            paper    = this
        ;

        for ( var el = paper.bottom; el != null; el = el.next ) {
            data = callback ? callback(el, new Object) : new Object;

            if ( data ){
                //alert('x pred spremembo transformacije: ' + el.attr('x'));
                /*el.matrix.a = 1;
                el.matrix.b = 0;
                el.matrix.c = 0;
                el.matrix.d = 1;
                el.matrix.e = 0;
                el.matrix.f = 0;
                let box = el.getBBox();
                if(el.type === 'text'){

                    el.attr({'x': box.cx});
                    el.attr({'y': box.cy});

                }else{
                    //alert('x po spremembi tranformacije' + el.attr('x'));
                    el.attr({'x': box.x});
                    el.attr({'y': box.y});
                    //alert('x po spremembi X: ' + el.attr('x') + " " + box.x);
                }*/
                elements.push({

                    data:      data,
                    type:      el.type,
                    attrs:     el.attrs,
                    transform: el.matrix.toTransformString(),
                    id:        el.id
                });
            }
        }

        var cache = [];
        var o = JSON.stringify(elements, function (key, value) {
            //http://stackoverflow.com/a/11616993/400048
            if (typeof value === 'object' && value !== null) {
                if (cache.indexOf(value) !== -1) {
                    // Circular reference found, discard key
                    return;
                }
                // Store value in our collection
                cache.push(value);
            }
            return value;
        });
        cache = null;
        return o;
    }

    Raphael.fn.fromJSON = function(json, callback) {
        var
            el,
            paper = this
        ;

        if ( typeof json === 'string' ) json = JSON.parse(json);

        for ( var i in json ) {
            // console.log("from json i:",json[i]);
            if ( json.hasOwnProperty(i) ) {
                el = paper[json[i].type]()
                    .attr(json[i].attrs)
                    .transform(json[i].transform);

                el.id = json[i].id;
                // console.log("in if", el);

                if ( callback ) el = callback(el, json[i].data);

                if ( el ) paper.set().push(el);
            }
        }
    }
})();