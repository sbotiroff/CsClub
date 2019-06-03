var eventsModule = (function () {
    //event 
    const events = document.createElement("div");
    events.setAttribute("class", "admin-event");
    const eventAPI = {
        basePath: "https://chelan.highline.edu/~sbotiroff/csclub/api/events",
    }

    function _getAllEvents(payload, error) {
        if (error !== null) {
            // do something with the error
            return;
        }

        const eventsData = payload;

        function _render() {
            events.innerHTML= "";
            events.appendChild(_renderForm())
            for (let i = 0; i < eventsData.length; i++) {
                events.appendChild(_createEventElement(eventsData[i]));
            }

            root.innerHTML = "";
            root.appendChild(events);
        }

        _render();
    }

    function _createEventElement(eventObject) {
        const div = helpers.createElement("div", null, {
            "id": eventObject.id,
            "class":"single-div"
        });

        let event = `
            <ul>
                <li>Title: <span name="title" contenteditable="true">${eventObject.title}</span></li>
                <li>Timestamp: <span name="timestamp" contenteditable="true">${eventObject.timestamp}</span></li>
                <li>Description: <span name="description" contenteditable="true">${eventObject.description}</span></li>
            </ul>
        `;

        const updateButton = helpers.createElement("button", "Update", {
            "class": "update-button"
        });

        const deleteButton = helpers.createElement("button", "Delete", {
            "class": "delete-button"
        });

        updateButton.addEventListener("click", _updateEvent);
        deleteButton.addEventListener("click", _deleteEvent);

        div.insertAdjacentHTML('afterbegin', event);
        div.appendChild(updateButton);
        div.appendChild(deleteButton);

        return div;
    }

    function _updateEvent(event) {
        const cachedEventDom = this.parentElement;
        const eventId = cachedEventDom.getAttribute("id");
        const requestUrl = `${eventAPI.basePath}/${eventId}`;
        const requestBody = {};
        const allSpans = cachedEventDom.querySelectorAll("li span");

        for (let i = 0; i < allSpans.length; i++) {
            let key = allSpans[i].getAttribute("name");
            let value = allSpans[i].innerText;
            requestBody[key] = value;
            
        }

        console.log(requestUrl);
        console.log(requestBody);

        // TODO: unexpected < JSON @position 0
        fetch.put(requestUrl, requestBody, cachedEventDom, function (payload, error) {
            if (error !== null) {
                // TODO: handle error on UI
                console.log(error);
                return;
            }

            console.log(payload);
            render();
        });
    }

    function _deleteEvent() {
        const cachedEventDom = this.parentElement;
        const EventId = cachedEventDom.getAttribute("id");
        const requestUrl = `${eventAPI.basePath}/${EventId}`;

        fetch.delete(requestUrl, cachedEventDom, function (payload, error) {
            if (error !== null) {
                // TODO: handle error on UI
                console.log(error);
                return;
            }

            render();
        });
    }

    function _addEvent(){
        const cachedEventDom = this.parentElement;
        const newEvent = {};
        const errors = [];

        const titleElem = cachedEventDom.querySelector("#title");
        const timeStampElem = cachedEventDom.querySelector("#timestamp");
        const imageElem = cachedEventDom.querySelector("#image");
        const descriptionElem = cachedEventDom.querySelector("#description");
        (titleElem.value !== "") ? newEvent["title"] = titleElem.value : errors.push(`Make sure "title" is entered.`);
        (timeStampElem.value !== "") ? newEvent["timeStamp"] = timeStampElem.value : errors.push(`Make sure "timeStamp" is entered.`);
        (imageElem.value !== "") ? newEvent["image"] = imageElem.value : null;
        (descriptionElem.value !== "") ? newEvent["description"] = descriptionElem.value : errors.push(`Make sure "description" is entered.`);
        console.log(newEvent)
        if (errors.length === 0) {
            fetch.post(eventAPI.basePath, newEvent, cachedEventDom, function(payload, error) {
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

    function _cancelEvent(){
        render();
    }

    function _renderForm() {
        const div = helpers.createElement("div", null, {
            "class": "admin-form"
        });
        
        const form = `<form class='form'>
            <h3>Add Event</h3>
            <input type="text" id="title" placeholder="title">
            <input type="datetime-local" id="timestamp" placeholder="timeStamp">
            <input type="file" id="image" placeholder="image">
            <input id="description" ></form>`;

        const addButton = helpers.createElement("button", "Add", {
            "class": "add-button"
        });

        const cancelButton = helpers.createElement("button", "Cancel", {
            "class": "cancel-button"
        });

        addButton.addEventListener("click", _addEvent);
        cancelButton.addEventListener("click", _cancelEvent);

        div.insertAdjacentHTML('afterbegin', form);
        div.appendChild(addButton);
        div.appendChild(cancelButton);

        return div;
    }
    
    // fetch all event
    function render() {
        fetch.get(eventAPI.basePath, events, _getAllEvents);
    }

    return {
        render: render
    }
})()


