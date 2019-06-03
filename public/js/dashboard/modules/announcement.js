var announcementsModule = (function () {
    //announcement 
    const announcements = document.createElement("div");
    announcements.setAttribute("class", "admin-announcement");
    const announcementAPI = {
        basePath: "https://chelan.highline.edu/~sbotiroff/csclub/api/announcements",
    }

    // fetch all announcement
    function render() {
        fetch.get(announcementAPI.basePath, announcements, _getAllAnnouncements);
    }

    function _getAllAnnouncements(payload, error) {
        if (error !== null) {
            // do something with the error
            return;
        }

        const announcementsData = payload;
        console.log(announcementsData);
        function render() {
            announcements.innerHTML= "";
             announcements.appendChild(_renderForm());
            for (let i = 0; i < announcementsData.length; i++) {
                announcements.appendChild(_createAnnouncementElement(announcementsData[i]));
            }

            root.innerHTML = "";
            root.appendChild(announcements);
        }

        render();
    }


    function _createAnnouncementElement(announcementObject) {
        const div = helpers.createElement("div", null, {
            "id": announcementObject.id,
            "class":"single-div"
        });
        
        let  announcement = `
    <ul>
        <li>Title: <span name="title" contenteditable="true"> ${announcementObject.title}</span></li>
        <li>timestamp: <span type="datetime-local" name="timestamp" contenteditable="true"> ${announcementObject.timestamp}</span></li>
        <li>description: <span name="description" contenteditable="true"> ${announcementObject.description}</span></li>
    </ul>
`;

        const updateButton = helpers.createElement("button", "Update", {
            "class": "update-button"
        });

        const deleteButton = helpers.createElement("button", "Delete", {
            "class": "delete-button"
        });

        updateButton.addEventListener("click", _updateAnnouncement);
        deleteButton.addEventListener("click", _deleteAnnouncement);

        div.insertAdjacentHTML('afterbegin',  announcement);
        div.appendChild(updateButton);
        div.appendChild(deleteButton);

        return div;
    }


    function _updateAnnouncement(event) {
        const cachedAnnouncementDom = this.parentElement;
        const  announcementId = cachedAnnouncementDom.getAttribute("id");
        const requestUrl = `${ announcementAPI.basePath}/${ announcementId}`;
        const requestBody = {};
        const allInput = cachedAnnouncementDom.querySelectorAll("li span");

        for (let i = 0; i < allInput.length; i++) {
            let key = allInput[i].getAttribute("name");
            let value = allInput[i].innerText;
            requestBody[key] = value;
        }

        fetch.put(requestUrl, requestBody, cachedAnnouncementDom, function (payload, error) {
            if (error !== null) {
                // TODO: handle error on UI
                return;
            }
            render();
        });
    }

    function _deleteAnnouncement() {
        const cachedAnnouncementDom = this.parentElement;
        const  announcementId = cachedAnnouncementDom.getAttribute("id");
        const requestUrl = `${ announcementAPI.basePath}/${ announcementId}`;

        fetch.delete(requestUrl, cachedAnnouncementDom, function (payload, error) {
            if (error !== null) {
                // TODO: handle error on UI
                console.log(error);
                return;
            }

            render();
        });
    }

    function _addAnnouncement(){
        const cachedAnnouncementDom = this.parentElement;
        const newAnnouncement = {};
        const errors = [];
        const lastName = cachedAnnouncementDom.querySelector("#title");
        const timestamp = cachedAnnouncementDom.querySelector("#timestamp");
        const description = cachedAnnouncementDom.querySelector("#description");

        (lastName.value !== "") ? newAnnouncement["title"] = lastName.value : errors.push(`Make sure "Last Name" is entered.`);
        (timestamp.value !== "") ? newAnnouncement["timestamp"] = timestamp.value : errors.push(`Make sure "timestamp" is entered.`);
        (description.value !== "") ? newAnnouncement["description"] = description.value : errors.push(`Make sure "description" is entered.`);
        console.log(newAnnouncement);
        

        if (errors.length === 0) {
            fetch.post( announcementAPI.basePath, newAnnouncement, cachedAnnouncementDom, function(payload, error) {
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

    function _cancelAnnouncement(){
        render();
    }

    function _renderForm() {
        const div = helpers.createElement("div", null, {
            "class": "admin-form"
        });
     
                const form = `
            <h3>Add Announcement</h3>
            <input type="text" id="title" placeholder="title"/>
            <input type="datetime-local" id="timestamp" placeholder="timestamp"/>
            <input type="text" id="description" placeholder="description"/>`;

        const addButton = helpers.createElement("button", "Add", {
            "class": "add-button"
        });

        const cancelButton = helpers.createElement("button", "Cancel", {
            "class": "cancel-button"
        });

        
        addButton.addEventListener("click", _addAnnouncement);
        cancelButton.addEventListener("click", _cancelAnnouncement);

        div.insertAdjacentHTML('afterbegin', form);
        div.appendChild(addButton);
        div.appendChild(cancelButton);

        return div;
    }

    
console.log(announcements);
    return {
        render: render
    }
})()


