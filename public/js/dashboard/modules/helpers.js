var helpers = (function(){
    function createElement(element, textNode, attrs) {
        var elm = document.createElement(element);
        
        if (textNode !== null) {
            var text = document.createTextNode(textNode);
            elm.appendChild(text);
        }

        if (attrs !== null) {
            _setAttributes(elm, attrs);
        }

        return elm;
    }

    function isJsonString(str) {
        try {
            JSON.parse(str);
            return true;
        } catch (e) {
            return false;
        }
    }


function timeConverter(UNIX_timestamp){
    var a = new Date(UNIX_timestamp * 1000);
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var year = a.getFullYear();
    var month = months[a.getMonth()];
    var date = a.getDate();
    var hour = a.getHours();
    var min = a.getMinutes();
    var sec = a.getSeconds();
    var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min ;
    return time;
  }

    function _setAttributes(el, attrs) {
        for (var key in attrs) {
            el.setAttribute(key, attrs[key]);
        }
    }
    return {
        createElement:createElement,
        isJsonString: isJsonString,
        timeConverter:timeConverter
    }
})();