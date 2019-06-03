var faqModule = (function () {
    //faq 
    const faqs = document.createElement("div");
    faqs.setAttribute("class", "admin-faq");
    const faqAPI = {
        basePath: "https://chelan.highline.edu/~sbotiroff/csclub/api/faqs",
    }

    // fetch all faq
    function render() {
        fetch.get(faqAPI.basePath, faqs, _getAllFaqs);
    }

    function _getAllFaqs(payload, error) {
        if (error !== null) {
            // do something with the error
            return;
        }

        const faqsData =payload;
        console.log(faqsData);
        function render() {
            faqs.innerHTML= "";
            faqs.appendChild(_renderForm());
            for (let i = 0; i < faqsData.length; i++) {
                faqs.appendChild(_createUserElement(faqsData[i]));
            }

            root.innerHTML = "";
            root.appendChild(faqs);
        }

        render();
    }


    function _createUserElement(faqObject) {
        const div = helpers.createElement("div", null, {
            "id": faqObject.id,
            "class":"single-div"
        });

        let faq = `
    <ul>
        <li>Q:<span name="questions"  contenteditable="true">${faqObject.questions}</span></li>
        <li>A:<span name="answers" contenteditable="true">${faqObject.answers}</span></li>
    </ul>
`;

        const updateButton = helpers.createElement("button", "Update", {
            "class": "update-button"
        });

        const deleteButton = helpers.createElement("button", "Delete", {
            "class": "delete-button"
        });

        updateButton.addEventListener("click", _updateFaq);
        deleteButton.addEventListener("click", _deleteFaq);

        div.insertAdjacentHTML('afterbegin', faq);
        div.appendChild(updateButton);
        div.appendChild(deleteButton);

        return div;
    }
    function _updateFaq(event) {
        const cachedFaqDom = this.parentElement;
        const faqId = cachedFaqDom.getAttribute("id");
        const requestUrl = `${faqAPI.basePath}/${faqId}`;
        const requestBody = {};
        const allSpan = cachedFaqDom.querySelectorAll("li span");

        for (let i = 0; i < allSpan.length; i++) {
            let key = allSpan[i].getAttribute("name");
            let value = allSpan[i].innerText;
            requestBody[key] = value;
        }

        fetch.put(requestUrl, requestBody, cachedFaqDom, function (payload, error) {
            if (error !== null) {
                // TODO: handle error on UI
                return;
            }
            render();
        });
    }

    function _deleteFaq() {
        const cachedFaqDom = this.parentElement;
        const faqId = cachedFaqDom.getAttribute("id");
        const requestUrl = `${faqAPI.basePath}/${faqId}`;

        fetch.delete(requestUrl, cachedFaqDom, function (payload, error) {
            if (error !== null) {
                // TODO: handle error on UI
                console.log(error);
                return;
            }

            render();
        });
    }

    function _addFaq(){
        const cachedFaqDom = this.parentElement;
        const newFaq = {};
        const errors = [];

        const questions = cachedFaqDom.querySelector("#questions");
        const answers = cachedFaqDom.querySelector("#answers");
       

        (questions.value !== "") ? newFaq["questions"] = questions.value : errors.push(`Make sure "Question" is entered.`);
        (answers.value !== "") ? newFaq["answers"] = answers.value : errors.push(`Make sure "Answer" is entered.`);

        if (errors.length === 0) {
            fetch.post(faqAPI.basePath, newFaq, cachedFaqDom, function(payload, error) {
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

    function _cancelFaq(){
        render();
    }

    function _renderForm() {
        const div = helpers.createElement("div", null, {
            "class": "admin-form"
        });
     
                const form = `
            <h3>Add Faq</h3>
            <input type="text" id="questions" placeholder="Questions"/>
            <input type="text" id="answers" placeholder="Answers"/>`;

        const addButton = helpers.createElement("button", "Add", {
            "class": "add-button"
        });

        const cancelButton = helpers.createElement("button", "Cancel", {
            "class": "cancel-button"
        });

        
        addButton.addEventListener("click", _addFaq);
        cancelButton.addEventListener("click", _cancelFaq);

        div.insertAdjacentHTML('afterbegin', form);
        div.appendChild(addButton);
        div.appendChild(cancelButton);

        return div;
    }
    return {
        render: render
    }
})()


