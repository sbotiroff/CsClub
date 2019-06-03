var leadersModule = (function () {
    //leader 
    const leaders = document.createElement("div");
    leaders.setAttribute("class", "admin-leader");
    const leaderAPI = {
        basePath: "https://chelan.highline.edu/~sbotiroff/csclub/api/leaders",
    }

    // fetch all leader
    function render() {
        fetch.get(leaderAPI.basePath, leaders, _getAllLeaders);
    }

    function _getAllLeaders(payload, error) {
        if (error !== null) {
            // do something with the error
            return;
        }

        const leadersData = payload;
        console.log(leadersData);

        function render() {
            leaders.innerHTML = "";
            leaders.appendChild(_renderForm());
            for (let i = 0; i < leadersData.length; i++) {
                leaders.appendChild(_createLeadersElement(leadersData[i]));
            }

            root.innerHTML = "";
            root.appendChild(leaders);
        }

        render();
    }


    function _createLeadersElement(leaderObject) {
        const div = helpers.createElement("div", null, {
            "id": leaderObject.id,
            "class":"single-div"
        });

        let leader = `
    <ul>
        <li>Type: <span name="first_name" contenteditable="true">${leaderObject.first_name}</span></li>
        <li>Title: <span name="last_name" contenteditable="true">${leaderObject.last_name}</span></li>
        <li>email: <span name="email" contenteditable="true">${leaderObject.email}</span></li>
        <li>position: <span name="position" contenteditable="true">${leaderObject.position}</span></li>
        <li>major: <span name="major" contenteditable="true">${leaderObject.major}</span></li>
        <li>contact: <span name="contact" contenteditable="true">${leaderObject.contact}</span></li>
        <li>image: <img name="image" src="data:image/png;base64,${btoa(leaderObject.image)}" width="100px"/></li>
    </ul>
`;

        const updateButton = helpers.createElement("button", "Update", {
            "class": "update-button"
        });

        const deleteButton = helpers.createElement("button", "Delete", {
            "class": "delete-button"
        });

        updateButton.addEventListener("click", _updateLeader);
        deleteButton.addEventListener("click", _deleteLeader);

        div.insertAdjacentHTML('afterbegin', leader);
        div.appendChild(updateButton);
        div.appendChild(deleteButton);

        return div;
    }

    function _updateLeader(event) {
        const cachedLeaderDom = this.parentElement;
        const leaderId = cachedLeaderDom.getAttribute("id");
        const requestUrl = `${leaderAPI.basePath}/${leaderId}`;
        const requestBody = {};
        const allSpan = cachedLeaderDom.querySelectorAll("li span");

        for (let i = 0; i < allSpan.length; i++) {
            let key = allSpan[i].getAttribute("name");
            let value = allSpan[i].innerText;
            requestBody[key] = value;
        }

        fetch.put(requestUrl, requestBody, cachedLeaderDom, function (payload, error) {
            if (error !== null) {
                // TODO: handle error on UI
                return;
            }
            render();
        });
    }

    function _deleteLeader() {
        const cachedLeaderDom = this.parentElement;
        const leaderId = cachedLeaderDom.getAttribute("id");
        const requestUrl = `${leaderAPI.basePath}/${leaderId}`;

        fetch.delete(requestUrl, cachedLeaderDom, function (payload, error) {
            if (error !== null) {
                // TODO: handle error on UI
                console.log(error);
                return;
            }

            render();
        });
    }

    function _addLeader(){
        const cachedLeaderDom = this.parentElement;
        const newLeader = {};
        const errors = [];

        const firstName = cachedLeaderDom.querySelector("#first_name");
        const lastName = cachedLeaderDom.querySelector("#last_name");
        const email = cachedLeaderDom.querySelector("#email");
        const image = cachedLeaderDom.querySelector("#image");
        const position = cachedLeaderDom.querySelector("#position");
        const major = cachedLeaderDom.querySelector("#major");
        const contact = cachedLeaderDom.querySelector("#contact");

        (firstName.value !== "") ? newLeader["first_name"] = firstName.value : errors.push(`Make sure "First Name" is entered.`);
        (lastName.value !== "") ? newLeader["last_name"] = lastName.value : errors.push(`Make sure "Last Name" is entered.`);
        (email.value !== "") ? newLeader["email"] = email.value : errors.push(`Make sure "Email" is entered.`);
        (image.value !== "") ? newLeader["image"] = atob(image.value): newLeader["image"] = null;
        (position.value !== "") ? newLeader["position"] = position.value : errors.push(`Make sure "Position" is entered.`);
        (major.value !== "") ? newLeader["major"] = major.value : errors.push(`Make sure "Major" is entered.`);
        (contact.value !== "") ? newLeader["contact"] = contact.value : newLeader["contact"] = null;
        console.log(newLeader);
        

        if (errors.length === 0) {
            fetch.post(leaderAPI.basePath, newLeader, cachedLeaderDom, function(payload, error) {
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

    function _cancelLeader(){
        render();
    }

    function _renderForm() {
        const div = helpers.createElement("div", null, {
            "class": "admin-form"
        });
     
                const form = `
            <h3>Add leader</h3>
            <input type="text" id="first_name" placeholder="First name"/>
            <input type="text" id="last_name" placeholder="Last name"/>
            <input type="email" id="email" placeholder="email"/>
            <input type="text" id="position" placeholder="Position"/>
            <input type="text" id="major" placeholder="Major"/>
            <input type="text" id="contact" placeholder="Contact"/>
            <input type="file" id="image" />`;

        const addButton = helpers.createElement("button", "Add", {
            "class": "add-button"
        });

        const cancelButton = helpers.createElement("button", "Cancel", {
            "class": "cancel-button"
        });

        
        addButton.addEventListener("click", _addLeader);
        cancelButton.addEventListener("click", _cancelLeader);

        div.insertAdjacentHTML('afterbegin', form);
        div.appendChild(addButton);
        div.appendChild(cancelButton);

        return div;
    }

    console.log(leaders);
    return {
        render: render
    }
})()