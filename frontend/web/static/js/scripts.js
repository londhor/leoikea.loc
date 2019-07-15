var ssSelect = false;

Vue.filter('price', function(price){
    return formatMoney(price,0, " ", " ");
});

Vue.component('mtoggle', {
    template:'#mtoggle',
    data: function() {
        return {
            isActive: false,
        }
    },
});

Vue.component('preloader', {
    template:'#preloader',
});

Vue.component('qtcounter', {
    template:'#qtcounter',
    props: {
        count: {
            type: Number | String,
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
        count: function() {
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

            try {
                bodyScrollLock.clearAllBodyScrollLocks();
            } catch {
                console.log('bodyScrollLock error');
            }

            self = this;
            setTimeout(function() {
                self.leave_class = false;
            }, 300);
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
            cart: {
                // 23: {
                //     img: '../img/demo/item.png',
                //     title: 'Massangeana',
                //     header: 'Диван розкладной. Серебро. Бронза. Золото.',
                //     price: 150,
                //     count: 103,
                //     options: {
                //         0: {
                //             name: 'артикль',
                //             value: '193.88.190',
                //         },
                //         1: {
                //             name: 'цвет',
                //             value: 'Голубой',
                //         },
                //         2: {
                //             name: 'размер',
                //             value: '153х200х130',
                //         },
                //         3: {
                //             name: 'Опция',
                //             value: 'Опция-1',
                //         },
                //     },
                // },
            }, 
            // cart
        }
    },
    methods: {
        fbp: function(action=null, data=null) {
            if (action) {
                this.$root.fbp(action, data);
            }
        },
        clearCart: function() {
            localStorage.removeItem('cart');
            this.cart = {};
            this.updateCartObject();
        },
        addToCartItem: function(id, item) {
            if (id&&item) {
                this.cart[id] = item;
                this.updateCartObject();
            }
        },
        updateCountInCart: function(id ,qt) {
            if (qt && id) {
                this.cart[id].count = qt;
                this.updateCartObject();
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
            newCart = {};

            for (item in this.cart) {
                if (this.cart[item]) {
                    newCart[item] = this.cart[item];
                }                
            }
            // Vue.set(this.cart, newCart);
            this.cart = newCart;
        },
        pushCartToLocalStorage: function() {
            localStorage.setItem('cart', JSON.stringify(this.cart));
        },
        pullCartFromLocalStorage: function() {
            cart = localStorage.getItem('cart');
            if (cart) {
                cart = JSON.parse(cart);
                this.cart = cart;
            }
        },
        openBookingModal: function() {
            app.modalClose('cart');
            app.modal('booking');
        },
    },
    computed: {

    },
    watch: {
        cart: function() {
            this.pushCartToLocalStorage();
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
        menuSubCat: 1,
        siTab: 1,

        //// bonuses
        useBonus: false,
        bonus: false,
        paymentType: 'card',
        /////////////////

        //// hadrcode
        optionsData: false,
        ssSelect: false,
        pageSlug: false,
        //// hadrcode - end
    },
    methods: {
        // Bonuses ///////////////////////
        getUserBonus: function(el) {
            try {
                phone = el.target.value;
                if (phone.length>=17) {
                    data=new FormData();
                    data.set('action', 'getBonus');
                    data.set('phone', phone);
                    ajax('getBonus',data);
                }
            } catch {

            }
        },
        getBonus: function() {
            try {
                return this.bonus.bonus;
            } catch {
                return false;
            }
        },
        bonusToEat: function() {
            if (this.totalCartPrice()>this.getBonus()) {
                return this.getBonus();
            } else {
                return this.getBonus() - (this.getBonus()-this.totalCartPrice());
            }
        },
        //////////////////////////////////
        // cart price ///////////////////////
        totalCartPriceToPayment: function() {
            if (this.useBonus) {
                return this.totalCartPrice() - this.bonusToEat();
            } else {
                return this.totalCartPrice();
            }
        },
        totalCartPrice: function() {
            try {
                return this.$refs.cartItems.totalCartPrice();
            } catch {

            }
        },
        //////////////////////////////////
        cartHasItems: function() {
            try {
                return this.$refs.cartItems.cartHasItems();
            } catch {
                return false;
            }
        },
        initFormPreloader: function(el, div) {
            try {
                if (!div) {
                    el = el.target;
                    el.classList.add('activePreloader');
                } else {
                    wp = document.querySelector(div);
                    wp.classList.add('activePreloader');
                }
            } catch {

            }
        },
        mobileMenuChangeStatus: function() {
            if (this.mobileMenu) {
                try {
                    bodyScrollLock.clearAllBodyScrollLocks();
                } catch {
                    console.log('bodyScrollLock error');
                }

                parrentEl = document.querySelector('.mobile-menu');
                parrentEl.classList.add('leave');
                self = this;
                setTimeout(function() {
                    parrentEl.classList.remove('leave');
                    self.mobileMenu=false;
                }, 150);

            } else {
                try {
                    bodyScrollLock.disableBodyScroll(document.querySelector("body"));
                    bodyScrollLock.disableBodyScroll(document.querySelector('.mm-menu'));
                } catch {
                    console.log('bodyScrollLock error');
                }
                this.mobileMenu=true;
            }
        },
        cartHaveItems: function() {
            try {
                return this.$refs.cartItems.cartHasItems();
            } catch {
                return false;
            }
        },
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
        // addToCart //////////////////////////////////////////////////////////////////////////
        addToCart: function(item, el) {

            //////////////////////////////////////////////////////
            var form = el.target;
            var data = formToObject(form);
            console.log(data);
            //////////////////////////////////////////////////////

            objId = Object.keys(item)[0];
            var itemObject = item[objId];

            itemObject.count = data.qt;
            if (data.options) {
                itemObject.options = [];
                itemObject.options[0] = {
                    name: 'Параметры',
                    value: data.options,
                };
            }

            try {
                this.$refs.cartItems.addToCartItem(objId, itemObject);
            } catch {

            }

            formTnxEl = form.querySelector(".form_tnx");
            if (formTnxEl) { formTnxEl.classList.add("active"); }
        },
        // addToCart - END //////////////////////////////////////////////////////////////////////////
        // modal //////////////////////////////////////////////////////////////////////////
        modal: function(name) {
            if (name) {
                this.$refs[name].showModal();
                this.modalPageScroll = this.pageScroll;
                setTimeout(function() {
                    try {
                        bodyScrollLock.disableBodyScroll(document.querySelector("body"));
                        bodyScrollLock.disableBodyScroll(document.querySelector('#modal_'+name+''));
                    } catch {
                        console.log('bodyScrollLock error');
                    }
                    document.body.classList.add("body_fixed");
                }, 300);
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
            var form = el.target;
            data = new FormData(form);
            data.set('action',action);

            if (action=='booking') {
                data.set('cart', this.getCartJson());
            }

            formTnxEl = form.querySelector(".form_tnx");
            if (formTnxEl) {
               formTnxEl.classList.add("active");
            }

            setTimeout(function() {
                if (action!='booking') {
                    form.reset();
                }
            }, 500);

            ajax(action, data);
            return false;
        },
        getCartJson: function() {
            try {
                return JSON.stringify(this.$refs.cartItems.cart);
            } catch {
                return "{}";
            }   
        },
        ///// PIXEL ///////////////////////////////////////////////////////////////////////
        fbp: function(action=false, data=null) {
            if (action) {

                switch(action) {
                    case 'AddPaymentInfo':
                    case 'AddToCart':
                    case 'AddToWishlist':
                    case 'CompleteRegistration':
                    case 'Contact':
                    case 'CustomizeProduct':
                    case 'Donate':
                    case 'FindLocation':
                    case 'InitiateCheckout':
                    case 'Lead':
                    case 'PageView':
                    case 'Purchase':
                    case 'Schedule':
                    case 'Search':
                    case 'StartTrial':
                    case 'SubmitApplication':
                    case 'Subscribe':
                    case 'ViewContent':

                    typeOfEvent = 'track';break;

                    default: typeOfEvent = 'trackCustom';
                }

                // console.log(typeof(data));
                // console.log(data,'data');

                try {
                    fbq(typeOfEvent, action, data);
                } catch {
                    console.warn('FBP is not ready');
                }
            }
        },
        ///////////////////////////////////////////////////////////////////////////////////
        //// hardcode..............................................................................................................
        getProductOptions: function(id=false) {
            if (id&&!this.optionsData) {
                d = new FormData;
                d.set('action','getProductOptions');
                d.set('id', id);
                ajax('getProductOptions',d);
            }
        },
        getProductOptions_callback: function(req) {
            if (req) {
                try {
                    reqFilteredData = req.replace(/\\n/g, '');
                    dataArr = JSON.parse(reqFilteredData);
                    // Vue.set(this.optionsData, dataArr);
                    this.optionsData = dataArr;
                    setTimeout(function() {
                        createInputSelect();
                    }, 100);
                } catch {
                    dataArr = false;
                }
            }
        },
        //// hardcode -- END ..............................................................................................................
    },
    watch: {
        useBonus: function() {
            if (this.totalCartPriceToPayment()==0) {
                this.paymentType = 'cash';
            }
        },
        optionsData: function() {
            createInputSelect();
        },
    },
    component: {
        vCart: vCart,
    },
    computed: {

    },
    created: function() {
        window.addEventListener("scroll", this.headerFix);
        this.searchString = this.getParameterByName('query');
        // this.pageSlug = this.getParameterByName('page-slug');
    },
    mounted: function() {
        // this.getProductOptions();

        this.pageScroll++; // hardcode
        try {
            this.$refs.cartItems.pullCartFromLocalStorage();
        } catch {
            
        }
        initSliders();
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
                if (action=='getProductOptions') {
                    app.getProductOptions_callback(req.response);
                }
                if (action=='booking') {
                    if (app.paymentType!='card') {
                        app.modalClose('booking');
                        app.modal('tnx');
                    }
                    setTimeout(function() {
                        // app.$refs.cartItems.clearCart();
                    }, 1000)
                }
                if (action=='getBonus') {
                    bonus={
                        'bonus':req.response,
                    };
                    Object.freeze(bonus);
                    if (Object.isFrozen(bonus) && bonus.bonus == req.response) {
                        app.bonus = bonus;
                    }
                }
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

createInputSelect();
function createInputSelect() {
    var sSelectInput = document.querySelector('#ssselect');
    if (sSelectInput) {
        ssSelect = new SlimSelect({
            select: sSelectInput,
            closeOnSelect: true,
            showSearch: false,
            valuesUseText: true,
            showContent: 'down',
            placeholder: 'Выберите опцию...',
            onChange: (info) => {
                if (app.getParameterByName('page-slug') != info.value && app.pageSlug!=app.getParameterByName('page-slug')) {
                    //window.location.href = window.location.protocol + "//" + window.location.hostname+'/single-item.php?page-slug='+ info.value +'';
                }
            },
            valuesUseText: false, 
            data: app.optionsData,
        });
        if (app.getParameterByName('page-slug')) {
            ssSelect.set(app.pageSlug);
        }
    }
}


var formToObject = function (form) {

    // Setup our serialized data
    var serialized = {};

    // Loop through each field in the form
    for (var i = 0; i < form.elements.length; i++) {

        var field = form.elements[i];

        // Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields
        if (!field.name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') continue;

        // If a multi-select, get all selections
        if (field.type === 'select-multiple') {
            for (var n = 0; n < field.options.length; n++) {
                if (!field.options[n].selected) continue;
                serialized[field.name] = field.options[n].value;
            }
        }
        // Convert field data to a query string
        else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
            serialized[field.name] = field.value;
        }
    }

    return serialized;

};


// var f = new FormData();
// f.set('action','booking');
// f.set('data','bookingData');
// ajax('booking',f);

function initSliders() {
    try {
        var swiper = new Swiper('.our-clients-slider', {
            slidesPerView: 7,
            slidesPerColumn: 2,
            spaceBetween: 16,
            pagination: {
              el: '.swiper-pagination',
              clickable: true,
            },
            breakpoints: {
                1400: {
                    slidesPerView: 6,
                    spaceBetween: 10,
                },
                980: {
                    slidesPerView: 4,
                    spaceBetween: 8,
                },
                420: {
                    slidesPerView: 2,
                    spaceBetween: 8,
                },
            },
        });
    } catch {
        console.log('.our-clients-slider is empty');
    }
    
    try {
        var swiper = new Swiper('.feedback-slider', {
            slidesPerView: 'auto',
            // centeredSlides: false,
            spaceBetween: 10,
            pagination: {
              el: '.swiper-pagination',
              clickable: true,
            },
            navigation: {
                nextEl: '.swiper-pagi-btn-next',
                prevEl: '.swiper-pagi-btn-prev',
            },
            breakpoints: {
                980: {
                    // slidesPerView: 3,
                    // centeredSlides: true,
                },
                420: {
                    // slidesPerView: 1,
                    // centeredSlides: true,
                },
            },
        });
    } catch {
        console.log('.feedback-slider is empty');
    }
    
    var itemSlirers = document.querySelectorAll('.items-slider');
    if (itemSlirers) {
        for (slider in itemSlirers) {
            try {
                new Swiper(itemSlirers[slider], {
                    slidesPerView: 'auto',
                    spaceBetween: 10,
                    pagination: {
                      el: '.swiper-pagination',
                      clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-pagi-btn-next',
                        prevEl: '.swiper-pagi-btn-prev',
                    },
                });
            } catch {
                console.warn('.items-slider is empty');
            }
        }
    }
    
    try {
        var siThumbs = new Swiper('.si-thumbs', {
            spaceBetween: 8,
            slidesPerView: 'auto',
            watchSlidesVisibility: true,
        });
    
        var swiper = new Swiper('.si-slider', {
            slidesPerView: 'auto',
            centeredSlides: true,
            spaceBetween: 5,
            thumbs: {
                swiper: siThumbs,
            },
        });
    } catch {
        console.log('.feedback-slider is empty');
    }
}

function inputsInit() {
    var phoneinputs = document.querySelectorAll('.phonenumber');
    if (phoneinputs) {
        for (i=0;i<phoneinputs.length;i++) {
            phoneinputs[i].n = new Cleave(phoneinputs[i], {
                prefix: '+380',
                delimiters: ['-','-', '-', '-'],
                blocks: [4,2, 2, 2, 3],
            });
        }
    }
}

// app.modal('booking');

window.onload = function() {
    inputsInit();
}