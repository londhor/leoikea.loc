Vue.filter('price', function(price){
    // console.log('vf');
    return formatMoney(price,0, " ", " ");
});

Vue.component('qtcounter', {
    template:'#qtcounter',
    props: {
        count: {
            type: Number,
            default: 1,
        }
    },
    data: function() {
        return {
            qt: this.count,
        }
    },
    methods: {
        up: function() {
            if (this.qt<9999999) {
                this.qt++;
            }
        },
        down: function() {
            if (this.qt>1) {
                this.qt = this.qt-1 ;
            }
        },
    },
    watch: {
        qt: function() {
            this.$emit('update-count-in-cart', this.qt);
        },
    },
});

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

var vCartItem = Vue.component('vCartItem', {
    template: '#v-cart-item',
    props: {
        item: {
            type: Object,
            default: false,
        },
        itemid: {
            type: String,
            default: false,
        },
    },
    data: function() {
        return {

        }
    },
    methods: {
        itemTotalPrice: function() {
            return this.item.price * this.item.count;
        },
        removeitemfromcart: function() {
            this.$emit('removeitemfromcart', this.itemid);
        },
        updateCountInCart: function(qt) {
            if (qt) {
                this.$emit('update-count-in-cart', this.itemid, qt);
            }
        },
    },
});

var vCart = Vue.component('vCart', {
    template: '#v-cart',
    data: function() {
        return {
            firstName: 'Foo',
            cart: {
                23: {
                    img: '../img/demo/item.png',
                    title: 'Massangeana',
                    header: 'Диван розкладной. Серебро. Бронза. Золото.',
                    price: 150,
                    count: 103,
                    options: {
                        0: {
                            name: 'артикль',
                            value: '193.88.190',
                        },
                        1: {
                            name: 'цвет',
                            value: 'Голубой',
                        },
                        2: {
                            name: 'размер',
                            value: '153х200х130',
                        },
                        3: {
                            name: 'Опция',
                            value: 'Опция-1',
                        },
                        
                    },
                },
                24: {
                    img: '../img/demo/item.png',
                    title: 'Milano',
                    header: 'Деревянный стол',
                    price: 130,
                    count: 1,
                    options: {
                        0: {
                            name: 'артикль',
                            value: '193.8203.190',
                        },
                        1: {
                            name: 'цвет',
                            value: 'Серый',
                        },
                        2: {
                            name: 'размер',
                            value: '220х140х30',
                        },
                        3: {
                            name: 'Опция',
                            value: 'Опция-2',
                        },
                        
                    },
                },
                33: {
                    img: '../img/demo/item.png',
                    title: 'Milano33',
                    header: 'Деревянный стол33',
                    price: 130,
                    count: 33,
                    options: {
                        0: {
                            name: 'артикль',
                            value: '193.8203.190',
                        },
                        1: {
                            name: 'цвет',
                            value: 'Серый',
                        },
                        2: {
                            name: 'размер',
                            value: '220х140х30',
                        },
                        3: {
                            name: 'Опция',
                            value: 'Опция-2',
                        },
                        
                    },
                },
            }, 
            // cart
        }
    },
    methods: {
        updateCountInCart: function(id ,qt) {
            console.log(id, qt);
            if (qt && id) {
                this.cart[id].count = qt;
            }
            
        },
        itemInCart: function(id) {
            if (id && this.cart[id]) {
                return true;
            }
            return false;
        },
        itemsInCart: function() {
            try {
                return Object.keys(this.cart).length;
            } catch {
                return 0;
            }
        },
        cartHasItems: function() {
            if (this.itemsInCart()>0) {
                return true;
            } else {
                return false;
            }
        },
        totalCartPrice: function() {
            price = 0;

            if (typeof(this.cart===Object)) {
                for (item in this.cart) {
                    price+=this.getItemTotalPrice(item);
                }
            }
            return price;
        },
        getItemTotalPrice:function(item) {
            itemPrice = 0;
            if (item && item!=null) {
                try {
                    itemPrice = this.cart[item].price * this.cart[item].count;
                } catch {
                    console.warn('cart.item is not ready');
                }
            }
            return itemPrice;
        },
        removeitemfromcart: function(id=null){
            if (id) {
                this.cart[id] = null;
                this.updateCartObject();
            }
        },
        updateCartObject: function(){
            console.log('updateCartObject');
            newCart = {};

            for (item in this.cart) {
                if (this.cart[item]) {
                    newCart[item] = this.cart[item];
                }                
            }
            // Vue.set(this.cart, newCart);
            this.cart = newCart;
        },

    },
    computed: {

    },
    watch: {
        cart: function() {
            // this.updateCartInLicalStorage();
        },
    },
    component: {
        cartItem: vCartItem,
    }
});

var app = new Vue({
    el: "#app",
    data: {
        pageScroll: 0,
        modalPageScroll: 0,
        searchString: '',
        menu: false,
        mobileMenu: false,
        menuSubCat: false,
        siTab: 1,
    },
    methods: {
        itemInCart: function(id) {
            if (this.$refs.cartItems) {
                if (id && this.$refs.cartItems.cart[id]) {
                    return true;
                }
            }
            return false;
        },
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
            console.log('ml');
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
    component: {
        vCart: vCart,
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


function formatMoney(n, c, d, t) {
  var c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;

  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

app.modal('cart');