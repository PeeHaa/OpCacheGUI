/**
 * A simple library to eas working with the DOM
 *
 * @author Pieter Hordijk <http://github.com/PeeHaa>
 */
'use strict';

function DomHandler(domElement) {
    this.domElement = null;
    if (typeof domElement !== 'undefined') {
        this.domElement = domElement;
    }

    return this;
}

DomHandler.prototype.contains = function(childElement) {
     var currentNode = childElement.parentNode;

     while (currentNode != null) {
         if (currentNode == this.domElement) {
             return true;
         }

         currentNode = currentNode.parentNode;
     }

     return false;
};

DomHandler.prototype.containsOrIs = function(childElement) {
    return (this.domElement == childElement || this.contains(childElement));
};

DomHandler.prototype.getViewport = function() {
    if (typeof window.innerWidth != 'undefined') {
        return {
            width: window.innerWidth,
            height: window.innerHeight
        };
    } else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) {
        return {
            width: document.documentElement.clientWidth,
            height: document.documentElement.clientHeight
        };
    } else {
        return {
            width: document.getElementsByTagName('body')[0].clientWidth,
            height: document.getElementsByTagName('body')[0].clientHeight
        };
    }
};

DomHandler.prototype.addClass = function(className) {
    if ($(this.domElement).hasClass(className)) {
        return;
    }

    if (this.domElement.className) {
        this.domElement.className += ' ';
    }

    this.domElement.className += className;
};

DomHandler.prototype.removeClass = function(className) {
    var pattern = new RegExp('\\b' + className + '\\b');

    this.domElement.className = this.domElement.className.replace(pattern, '');
};

DomHandler.prototype.hasClass = function(className) {
    var pattern = new RegExp('\\b' + className + '\\b');

    return pattern.test(this.domElement.className);
};

DomHandler.prototype.center = function() {
    var offset = {
        left: (this.getViewport().width - this.domElement.offsetWidth) / 2,
        top: (this.getViewport().height - this.domElement.offsetHeight) / 2
    };

    this.domElement.style.left = offset.left + 'px';
    this.domElement.style.top = offset.top + 'px';
};

DomHandler.prototype.getFormValues = function() {
    var params = [];
    for (var i = 0, length = this.domElement.elements.length; i < length; i++) {
        var element = this.domElement.elements[i];

        if (element.tagName == 'TEXTAREA' || element.tagName == 'SELECT') {
            params[element.name] = element.value;
        } else if (element.tagName == 'INPUT') {
            if (element.type == 'text' || element.type == 'hidden' || element.type == 'password') {
                params[element.name] = element.value;
            } else if (element.type == 'radio' && element.checked) {
                if (!element.value) {
                    params[element.name] = 'on';
                } else {
                    params[element.name] = element.value;
                }
            } else if (element.type == 'checkbox' && element.checked) {
                if (!element.value) {
                    params[element.name] = 'on';
                } else {
                    params[element.name] = element.value;
                }
            }
        }
    }

    return params;
};

DomHandler.prototype.serialize = function() {
    var params = this.getFormValues();

    var str = [];
    for(var key in params) {
        if (!params.hasOwnProperty(key)) {
            continue;
        }

        str.push(encodeURIComponent(key) + '=' + encodeURIComponent(params[key]));
    }

    return str.join('&');
};

DomHandler.prototype.closestByTagName = function(tagName) {
    var element = this.domElement;
    tagName = tagName.toUpperCase();

    if (element.tagName == tagName) {
        return element;
    }

    while(element.parentNode) {
        element = element.parentNode;

        if (element.tagName == tagName) {
            return element;
        }
    }
};

DomHandler.prototype.closestByDataAttribute = function(dataAttribute, value) {
    var element = this.domElement;

    if (element.getAttribute('data-' + dataAttribute) !== null) {
        if (typeof value === 'undefined' || element.getAttribute('data-' + dataAttribute) === value) {
            return element;
        }
    }

    while(element.parentNode) {
        element = element.parentNode;

        if (typeof element.getAttribute !== 'undefined' && element.getAttribute('data-' + dataAttribute) !== null) {
            if (typeof value === 'undefined' || element.getAttribute('data-' + dataAttribute) === value) {
                return element;
            }
        }
    }
};

DomHandler.prototype.fadeOut = function(callback, timeout) {
    var opacity = this.domElement.style.opacity;

    if (!this.domElement.style.opacity) {
        opacity = 1;
    }

    opacity = Math.round(opacity * 100 ) / 100;

    opacity -= 0.05;
    if (opacity < 0) {
        opacity = 0;
    }

    this.domElement.style.opacity = opacity;

    if (opacity == 0) {
        callback();
        return;
    }

    setTimeout(function() {
        this.fadeOut(callback, timeout);
    }.bind(this), timeout);
};

/**
 * Crossbrowser event handler.
 * Inspired by the eventhandler script created by Martins Teresko (https://github.com/teresko)
 */
DomHandler.prototype.on = function(type, callback) {
    var fix = {
        'focus':    'focusin',
        'blur':     'focusout'
    };

    if (window.addEventListener) {
        this.domElement.addEventListener(type, callback, typeof fix[type] !== undefined);
    } else {
        this.domElement.attachEvent('on' + type, callback);
    }
};

var $ = function(element) {
    return new DomHandler(element);
};
