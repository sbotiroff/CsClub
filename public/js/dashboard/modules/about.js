var aboutModule = (function () {
    //About 
    const aboutTable = document.createElement("div");
    aboutTable.setAttribute("class", "admin-about");
    const aboutAPI = {
        basePath: "https://chelan.highline.edu/~sbotiroff/csclub/api/about",
    }

    // fetch all about
    function render() {
        fetch.get(aboutAPI.basePath, aboutTable, _getAllAboutTable);
    }

    function _getAllAboutTable(payload, error) {
        if (error !== null) {
            // do something with the error
            return;
        }

        const aboutTableData = payload;
        console.log(aboutTableData);
        function render() {
            aboutTable.innerHTML= "";
            for (let i = 0; i < aboutTableData.length; i++) {
                aboutTable.appendChild(_createAboutElement(aboutTableData[i]));
            }

            root.innerHTML = "";
            root.appendChild(aboutTable);
        }

        render();
    }


    function _createAboutElement(aboutObject) {
        const div = helpers.createElement("div", null, {
            "id": aboutObject.id
        });

        let about = `
            <ul>
                <li>Title: <input type="text" name="title" value="${aboutObject.title}" /></li>
                <li>Description: <input type="text" name="description" value="${aboutObject.description}" /></li>
            </ul>
        `;

        const updateButton = helpers.createElement("button", "Update", {
            "class": "update-button"
        });


        updateButton.addEventListener("click", _updateAbout);

        div.insertAdjacentHTML('afterbegin', about);
        div.appendChild(updateButton);


        return div;


    }
    

    function _updateAbout(event) {
        const cachedAboutDom = this.parentElement;
        const aboutId = cachedAboutDom.getAttribute("id");
        const requestUrl = `${aboutAPI.basePath}/${aboutId}`;
        const requestBody = {};
        const allSpans = cachedAboutDom.querySelectorAll("li input");

        for (let i = 0; i < allSpans.length; i++) {
            let key = allSpans[i].getAttribute("name");
            let value = allSpans[i].value;
            requestBody[key] = value;
        }

        fetch.put(requestUrl, requestBody, cachedAboutDom, function (payload, error) {
            if (error !== null) {
                // TODO: handle error on UI
                return;
            }
            render();
        });
    }
    
console.log(aboutTable);
    return {
        render: render
    }
})()