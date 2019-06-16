Vue.component("vModal", {
    template: "#v-modal",
    props: {
        name: {
            type: String,
            default: ""
        }
    },
    data: function() {
        return {
            show: false,
            class_name: this.name,
            leave_class: false
        };
    },
    methods: {
        showModal: function() {
            this.show = true;
        },
        close: function() {
            this.show = false;
            this.leave_class = true;
            document.body.classList.remove("body_fixed");
            window.scrollTo(0, app.modalPageScroll);
            self = this;
            setTimeout(function() {
                self.leave_class = false;
            }, 500);
        }
    }
});

var app = new Vue({
    el: "#app",
    data: {
        pageScroll: 0,
        modalPageScroll: 0,
        search: false,
        searchString: '',
        menu: false,
        menuSubCat: false,
        siTab: 1,
    },
    methods: {
        headerFix: function() {
            this.pageScroll = window.pageYOffset || document.documentElement.scrollTop;
        },
        // modal //////////////////////////////////////////////////////////////////////////
        modal: function(name) {
            if (name) {
                this.$refs[name].showModal();
                this.modalPageScroll = this.pageScroll;
                setTimeout(function() {
                    document.body.classList.add("body_fixed");
                }, 500);
            }
        },
        modalClose: function(name) {
            if (name) {
                this.$refs[name].close();
                document.body.classList.remove("body_fixed");
                window.scrollTo(0, app.modalPageScroll);
            }
        },
        ///////////////////////////////////////////////////////////////////////////////////
        getParameterByName: function(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        },
        ajaxForm: function(action, el) {
            var form = document.querySelector("#" + el + "");
            var data = new FormData(form);
            formTnxEl = form.querySelector(".form_tnx");
            if (formTnxEl) {
                formTnxEl.classList.add("active");
            }
            setTimeout(function() {
                form.reset();
            }, 500);
            ajax(action, data);
            return false;
        },
    },
    computed: {

    },
    created: function() {
        window.addEventListener("scroll", this.headerFix);
        this.headerFix();
        this.searchString = this.getParameterByName('query');
    },
    mounted: function() {

    },
    destroyed: function() {
        window.removeEventListener("scroll", this.headerFix);
    }
});

// function ajaxForm(action, el) {
//     var form = document.querySelector("#" + el + "");
//     var data = new FormData(form);
//     formTnxEl = form.querySelector(".form_tnx");
//     if (formTnxEl) {
//         formTnxEl.classList.add("active");
//     }
//     setTimeout(function() {
//         form.reset();
//     }, 500);
//     ajax(action, data);
//     return false;
// }

function ajax(action, data) {
    var req = new XMLHttpRequest();

    req.onreadystatechange = function() {
        if (req.readyState == XMLHttpRequest.DONE) {
            // XMLHttpRequest.DONE == 4
            if (req.status == 200) {

            }
        }
    };

    req.open("POST", "" + window.location.protocol + "//" + window.location.hostname + "/js/ajax/main.php", true);
    req.send(data);
}

app.modal('cart');