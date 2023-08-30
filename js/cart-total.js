function loadcart() {
    var totalcart = []
    var total = [];
    total = localStorage.getItem("cart")
    productlist = JSON.parse(localStorage.getItem('cart'));
    fetch("../product.json")
        .then(response => {
            return response.json();
        })
        .then(jsondata => {
            for (let i = 0; i < jsondata.length; i++) {
                for (let a = 0; a < productlist.length; a++) {
                    if (productlist[a].id == jsondata[i].id) {
                        var target = document.getElementById('table-body');
                        var str = '<div class="table-row">' +
                            '<div class="flex"><img src="' +'../'+ jsondata[i].img + '"/><div><p class="product-name">' + jsondata[i].name + '</p></div></div>' +
                            '<div><p><strong>' + Number(jsondata[i].price).toLocaleString('en-GB') + ' đ</strong></p><p class="afterdiscount">' + jsondata[i].afterdiscount + '</p></div>' +
                            '<div class="number-input"><div class="number-input-wraper">' +
                            '<button class="minus"><i class="fa fa-minus" aria-hidden="true"></i></button>' +
                            '<input class="quantity" min="0" name="quantity" value="'+ productlist[a].quantity +'" type="number">' +
                            '<button class="plus"><i class="fa fa-plus" aria-hidden="true"></i></button>' +
                            '</div></div>' +
                            '<div><p><strong>' +  Number(jsondata[i].price*productlist[a].quantity).toLocaleString('en-GB') +' đ</strong></p></div>' +
                            '</div>'
                            totalcart.push(Number(jsondata[i].price*productlist[a].quantity))
                        var temp = document.createElement('div');
                        temp.innerHTML = str;
                        while (temp.firstChild) {
                            target.appendChild(temp.firstChild);
                        }
                    }
                }
            }
            var text = document.getElementById('total')
            var all = totalcart.reduce((pv, cv) => pv + cv, 0)

            console.log(all.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
            text.innerHTML = all.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +' đ';
        }
        );
        
        
};
window.onload = loadcart;