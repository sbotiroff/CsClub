var opportunityModule = (function () {
    const opportunities = document.createElement("div");
    opportunities.setAttribute("class", "admin-opportunity");
    
    const opportunityAPI = {
        basePath: "https://chelan.highline.edu/~sbotiroff/csclub/api/opportunities",
    }

    function _getAllOpportunities(payload, error) {
        if (error !== null) {
            // do something with the error
            return;
        }

        const opportunitiesData = payload;

        function _render() {
            opportunities.innerHTML = "";
            opportunities.appendChild(_renderForm());
            for (let i = 0; i < opportunitiesData.length; i++) {
                opportunities.appendChild(_createOpportunityElement(opportunitiesData[i]));
            }
            root.innerHTML = "";
            root.appendChild(opportunities);
        }

        _render();
    }

    function _createOpportunityElement(opportunityData) {
        const div = helpers.createElement("div", null, {
            "id": opportunityData.id,
            "class":"single-div"
        });

        let opportunity = `
            <ul>
                <li>Type: <span name="type" contenteditable="true">${opportunityData.type}</span></li>
                <li>Title: <span name="title" contenteditable="true">${opportunityData.title}</span></li>
                <li>Description: <span name="description" contenteditable="true">${opportunityData.description}</span></li>
                <li>Url: <span name="url" contenteditable="true">${opportunityData.url}</span></li>
            </ul>
        `;

        const updateButton = helpers.createElement("button", "Update", {
            "class": "update-button"
        });

        const deleteButton = helpers.createElement("button", "Delete", {
            "class": "delete-button"
        });

        updateButton.addEventListener("click", _updateOpportunity);
        deleteButton.addEventListener("click", _deleteOpportunity);

        div.insertAdjacentHTML('afterbegin', opportunity);
        div.appendChild(updateButton);
        div.appendChild(deleteButton);

        return div;
    }

    function _updateOpportunity(event) {
        const cachedOpportunityDom = this.parentElement;
        const opportunityId = cachedOpportunityDom.getAttribute("id");
        const requestUrl = `${opportunityAPI.basePath}/${opportunityId}`;
        const requestBody = {};
        const allSpans = cachedOpportunityDom.querySelectorAll("li span");

        for (let i = 0; i < allSpans.length; i++) {
            let key = allSpans[i].getAttribute("name");
            let value = allSpans[i].innerText;
            requestBody[key] = value;
        }

        fetch.put(requestUrl, requestBody, cachedOpportunityDom, function (payload, error) {
            if (error !== null) {
                // TODO: handle error on UI
                return;
            }
            render();
        });
    }

    function _deleteOpportunity() {
        const cachedOpportunityDom = this.parentElement;
        const opportunityId = cachedOpportunityDom.getAttribute("id");
        const requestUrl = `${opportunityAPI.basePath}/${opportunityId}`;

        fetch.delete(requestUrl, cachedOpportunityDom, function (payload, error) {
            if (error !== null) {
                // TODO: handle error on UI
                console.log(error);
                return;
            }

            render();
        });
    }

    function _addOpportunity(){
        const cachedOpportunityDom = this.parentElement;
        const newOpportunity = {};
        const errors = [];

        const typeElem = cachedOpportunityDom.querySelector("#type");
        const titleElem = cachedOpportunityDom.querySelector("#title");
        const urlElem = cachedOpportunityDom.querySelector("#url");
        const descriptionElem = cachedOpportunityDom.querySelector("#description");

        (typeElem.value !== "") ? newOpportunity["type"] = typeElem.value : errors.push(`Make sure "type" is entered.`);
        (titleElem.value !== "") ? newOpportunity["title"] = titleElem.value : errors.push(`Make sure "title" is entered.`);
        (descriptionElem.value !== "") ? newOpportunity["description"] = descriptionElem.value : errors.push(`Make sure "description" is entered.`);
        (urlElem.value !== "") ? newOpportunity["url"] = urlElem.value : null;

        if (errors.length === 0) {
            fetch.post(opportunityAPI.basePath, newOpportunity, cachedOpportunityDom, function(payload, error) {
                if (error !== null) {
                    // TODO: display errors on UI as list
                    console.log(error);
                    return;
                }

                console.log(payload);
                render();
            });
            return;
        }
        
        for(let i=0; i<errors.length; i++) {
            alert(errors[i]);
        }
    }

    function _cancelOpportunity(){
        render();
    }

    function _renderForm() {
        const div = helpers.createElement("div", null, {
            "class": "admin-form"
        });
        
        const form = `
            <h3>Add Opportunity</h3>
            <input type="text" id="type" placeholder="Type">
            <input type="text" id="title" placeholder="title">
            <textarea rows="4" cols="50" id="description"></textarea>
            <input type="text" id="url" placeholder="url">`;

        const addButton = helpers.createElement("button", "Add", {
            "class": "add-button"
        });

        const cancelButton = helpers.createElement("button", "Cancel", {
            "class": "cancel-button"
        });

        addButton.addEventListener("click", _addOpportunity);
        cancelButton.addEventListener("click", _cancelOpportunity);

        div.insertAdjacentHTML('afterbegin', form);
        div.appendChild(addButton);
        div.appendChild(cancelButton);

        return div;
    }

    // fetch all opportunity
    function render() {
        fetch.get(opportunityAPI.basePath, opportunities, _getAllOpportunities);
    }

    return {
        render: render
    }
})()