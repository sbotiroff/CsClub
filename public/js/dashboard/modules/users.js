/*
    TODO: 
                a. if 200 ok keep changes
                b. if 400 show error as a list in front end, revert back changes
        3. Add a button for creating new user:
            1. add a button fragment.
            2. onclick button fragment show user form.(add, cancel buttons)
            3. front end validation for required fields.
            4. if add send request to back end 
            5. if cancel remove form.
            6. if error list all the errors and remove form.
*/

var usersModule = (function () {
    const users = document.createElement("div");
    users.setAttribute("class", "admin-users");
    const userAPI = {
        basePath: "https://chelan.highline.edu/~sbotiroff/csclub/api/users",
    }

 

    function _getAllUsers(payload, error) {
        if (error !== null) {
            // do something with the error
            return;
        }

        const usersData = payload;
        console.log(usersData);

        function render() {
            users.innerHTML = "";
            for (let i = 0; i < usersData.length; i++) {
                users.appendChild(_createUserElement(usersData[i]));
            }

            root.innerHTML = "";
            root.appendChild(users);
        }

        render();
    }

    function _createUserElement(userObject) {
        const div = helpers.createElement("div", null, {
            "id": userObject.id,
            "class":"single-div"
        });
        let user = `
            <ul>
                <li>First name: <span name="firstName" contenteditable="true" >${userObject.firstName}</span></li>
                <li>Last name: <span name="lastName"  contenteditable="true" >${userObject.lastName}</span></li>
                <li>Email name: <span name="email"  contenteditable="true" >${userObject.email}</span></li>
                <li>Email updates: <span type="checkbox" name="emailUpdates" contenteditable="true" >${userObject.emailUpdates}</span></li>
                <li>Future Club Leader <span type="checkbox" name="futureClubLeader" contenteditable="true" >${userObject.futureClubLeader}</span></li>
            </ul>
        `;
        const availabilityDiv = helpers.createElement("div", null, {
            "class": "availability"});
        for(let i=0; i<userObject.availability.length; i++){
            let availabilities = `<li>${helpers.timeConverter(userObject.availability[i])}</li>`;
            availabilityDiv.innerHTML +=availabilities;
        }

        const updateButton = helpers.createElement("button", "Update", {
            "class": "update-button"
        });
        const deleteButton = helpers.createElement("button", "Delete", {
            "class": "delete-button"
        });

        updateButton.addEventListener("click", _updateUser);
        deleteButton.addEventListener("click", _deleteUser);

        div.insertAdjacentHTML('afterbegin', user);
        div.appendChild(availabilityDiv)
        div.appendChild(updateButton);
        div.appendChild(deleteButton);

        return div;
    }

    function _updateUser(user) {
        const cachedUserDom = this.parentElement;
        const userId = cachedUserDom.getAttribute("id");
        const requestBody = {};
        const requestUrl = value=`${userAPI.basePath}/${userId}`;
        const allSpans = cachedUserDom.querySelectorAll("li span");

        for (let i = 0; i < allSpans.length; i++) {
            let key = allSpans[i].getAttribute("name");
            requestBody[key] = allSpans[i].innerText;
        }

        fetch.put(requestUrl, requestBody, cachedUserDom, function (payload, error) {
            if (error !== null) {
                return;
            }
            render();
        });
    }

    function _deleteUser() {
        const cachedUserDom = this.parentElement;
        const userId = cachedUserDom.getAttribute("id");
        const requestUrl = `${userAPI.basePath}/${userId}`;

        fetch.delete(requestUrl, cachedUserDom, function(payload, error) {
            if (error !== null) {
                // TODO: handle error on UI
                console.log(error);
                return;
            }

            render();
        });
    }
    
    // fetch all users
    function render() {
        fetch.get(userAPI.basePath, users, _getAllUsers);
    }

    return {
        render: render
    }
})()