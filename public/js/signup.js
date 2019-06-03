var $form = $("form"),
$successMsg = $(".alert");
$.validator.addMethod("letters", function(value, element) {
  return this.optional(element) || value == value.match(/^[a-zA-Z ]*$/);
});
$form.validate({
  rules: {
    firstName: {
      required: true,
      minlength: 2,
      letters: true
    },
    lastName: {
      required: true,
      minlength: 2,
      letters: true
    },
    email: {
      required: true,
      email: true
    }
  },
  messages: {
    firstName: "Please Enter your last name (only letters and spaces are allowed)",
    lastName: "Please Enter your last name (only letters and spaces are allowed)",
    email:"Please enter valid email",
    datetime:"please peak valid date"
    
  },
});

var signup = (function () {

    function signupAddAvailabilityTime() {
        var today = new Date();

        var hh = today.getHours();
        var mm = today.getMinutes();
        hh = hh < 10 ? '0' + hh : hh;
        mm = mm < 10 ? '0' + mm : mm;
        var time = hh + ":" + mm;
        var today = new Date().toISOString().split('T')[0];
        var dateTime = today + 'T' + time;
        let i = Date.now();
        let e = document.getElementById("availability");
        let fragment = document.createDocumentFragment();
        let inputDateTime = document.createElement("input");
        let btn = document.createElement("button");


        _setAttributes(inputDateTime, {
            "type": "datetime-local",
            "name": "availability[]",
            "value": `${dateTime}`

        });

        _setAttributes(btn, {
            "data-parent-id": `${i}`,
            "name": `${i}`,
            "id": `close${i}`
        });
        btn.innerHTML = " X ";

        let div = document.createElement("div");
        div.setAttribute(`id`, `${i}`);
        div.setAttribute(`class`, `datetime`);
        div.appendChild(inputDateTime);
        div.appendChild(btn);
        fragment.appendChild(div);
        e.appendChild(fragment);

        let elem = document.getElementById(`close${i}`);
        _addClickEvent(elem, _removeAvailability);
    }

    function _addClickEvent(elem, func) {
        elem.addEventListener("click", func);
    }

    function _removeAvailability() {
        const parentElementId = this.getAttribute("data-parent-id");
        const parentElement = document.getElementById(parentElementId);
        parentElement.parentNode.removeChild(parentElement);
    }

    function _setAttributes(el, attrs) {
        for (var key in attrs) {
            el.setAttribute(key, attrs[key]);
        }
    }

    return {
        signupAddAvailabilityTime: signupAddAvailabilityTime,
    }
})();