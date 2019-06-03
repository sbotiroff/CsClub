var fetch = (function () {
    const xhr = new XMLHttpRequest();

    function get(url, loadingElement, callback) {
        _request("GET", url, null, loadingElement, callback);
    }

    function post(url, body, loadingElement, callback) {
        _request("POST", url, body, loadingElement, callback);
    }

    function put(url, body, loadingElement, callback) {
        _request("PUT", url, body, loadingElement, callback);
    }

    function remove(url, loadingElement, callback) {
        _request("DELETE", url, null, loadingElement, callback);
    }

    function _onreadyStateHandler(loadingElement, callback) {
        return function () {
            if (this.readyState === 1) {
                loadingElement.insertAdjacentHTML("afterbegin", '<p id="loader">loading..</p>');
            } else {
                // const loader = loadingElement.querySelector('#loader');
                // loadingElement.removeChild(loader);

                if (this.readyState == 4 && this.status == 200) {
                    let response = this.responseText;
                    
                    try {
                        response = JSON.parse(this.responseText);
                    } catch (e) {
                        response = {
                            "error": e
                        }
                    }

                    callback(response, null);
                    return;
                }

                if (this.readyState == 4 && this.status == 400) {
                    let response = this.responseText;
                    
                    try {
                        response = JSON.parse(this.responseText);
                    } catch (e) {
                        response = {
                            "error": e,
                            "serverError":this.responseText.toString()
                        }
                    }
                    callback(null,response);
                    return;
                }
            }
        }
    }

    function _request(method, url, body, loadingElement, callback) {
        xhr.onreadystatechange = _onreadyStateHandler.call(this, loadingElement, callback);

        xhr.open(method, url, true);

        if (body !== null) {
            xhr.send(JSON.stringify(body));
            return;
        }
        xhr.send();
    }

    return {
        get: get,
        post: post,
        put: put,
        delete: remove
    }
})();