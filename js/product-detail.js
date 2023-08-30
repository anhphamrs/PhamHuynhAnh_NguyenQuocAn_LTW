function getAllUrlParams(url) {
    var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

    var obj = {};

    if (queryString) {

        queryString = queryString.split('#')[0];

        var arr = queryString.split('&');

        for (var i = 0; i < arr.length; i++) {
            var a = arr[i].split('=');

            var paramName = a[0];
            var paramValue = typeof (a[1]) === 'undefined' ? true : a[1];

            paramName = paramName.toLowerCase();
            if (typeof paramValue === 'string') paramValue = paramValue.toLowerCase();

            if (paramName.match(/\[(\d+)?\]$/)) {

                var key = paramName.replace(/\[(\d+)?\]/, '');
                if (!obj[key]) obj[key] = [];

                if (paramName.match(/\[\d+\]$/)) {
                    var index = /\[(\d+)\]/.exec(paramName)[1];
                    obj[key][index] = paramValue;
                } else {
                    obj[key].push(paramValue);
                }
            } else {
                if (!obj[paramName]) {
                    obj[paramName] = paramValue;
                } else if (obj[paramName] && typeof obj[paramName] === 'string'){
                    obj[paramName] = [obj[paramName]];
                    obj[paramName].push(paramValue);
                } else {
                    obj[paramName].push(paramValue);
                }
            }
        }
    }

    return obj;
}

function loadproduct() {
    url = location.href;
    var product = getAllUrlParams(url).id;

    var total =[];
    total = localStorage.getItem("cart")

    if(total){
        productlist = JSON.parse(localStorage.getItem('cart'));
        var carttotal = productlist.map(row => row["quantity"]).reduce((partialSum, a) => partialSum + a, 0)
        document.getElementById("cart").innerHTML = ("(" + carttotal + ") sản phẩm");

    }else{
        document.getElementById("cart").innerHTML = "(0) sản phẩm"
    }

    fetch("../product.json")
        .then(response => {
            return response.json();
        })
        .then(jsondata => {
            for (let i = 0; i < jsondata.length; i++) {
                if (product == jsondata[i].id) {
                    console.log(jsondata[i])
                    var target = document.getElementById('product-detail');
                    var str = '<div id="' + jsondata[i].id + '" class="product-detail-wraper">'+
                    '<div class="product-detail-left"><img class="product-img" src="' +'../'+ jsondata[i].img + '"/ ></div>'+
                    '<div class="product-detail-right"><h1 class="product-name">' + jsondata[i].name + '</h1>'+
                    '<div class="product-brand">Thương hiệu :' + jsondata[i].brand + '</div>'+
                    '<p class="product-price">' + Number(jsondata[i].price).toLocaleString('en-GB') + ' đ</p><div class="flex"><p class="product-afterdiscount">' + jsondata[i].afterdiscount + '</p><p class="product-discountpecent">' + jsondata[i].discountpecent + '</p>'+
                    '</div><div class="product-des">- ' + jsondata[i].description + '</div>'+
                    '<div class="flex"><button class="btn btn-buy">MUA NGAY</button><button onclick="addtocart(' + jsondata[i].id + ')" class="btn btn-addtocart">THÊM VÀO GIỎ HÀNG</button><div></div>';

                    var temp = document.createElement('div');
                    temp.innerHTML = str;
                    while (temp.firstChild) {
                        target.appendChild(temp.firstChild);
                    }
                }
            }
        }
        );
};
window.onload = loadproduct;

function addtocart(val){
    var total = localStorage.getItem('cart')
    if(total){
        var productlist = []
        productlist = JSON.parse(localStorage.getItem('cart'));
        var checked = Boolean = false
        for(let i = 0 ; i < productlist.length ; i++){
            if(productlist[i].id === val){
              
                productlist[i].quantity = productlist[i].quantity + 1
                console.log(productlist)
                localStorage.setItem("cart", JSON.stringify(productlist));
                checked = true;
                break;
            }
           
        }
       if(checked != true)
        {
   
            productlist.push({"id":val,"quantity":1});
            localStorage.setItem("cart", JSON.stringify(productlist));
        }
        var carttotal = productlist.map(row => row["quantity"]).reduce((partialSum, a) => partialSum + a, 0)
        document.getElementById("cart").innerHTML = ("("+carttotal+") sản phẩm")
    }else{
        var productarray = []
        productarray.push({"id":val,"quantity":1});
        localStorage.setItem("cart", JSON.stringify(productarray));
        document.getElementById("cart").innerHTML = "(1) sản phẩm"
    }

}

