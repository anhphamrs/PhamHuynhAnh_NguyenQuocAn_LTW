window.onload = carttotal()

function carttotal(){
    var total =[];
    total = localStorage.getItem("cart")
    productlist = JSON.parse(localStorage.getItem('cart'));
    var carttotal = productlist.map(row => row["quantity"]).reduce((partialSum, a) => partialSum + a, 0)
    if(total){
        document.getElementById("cart").innerHTML = ("(" + carttotal + ") sản phẩm");
    }else{
        document.getElementById("cart").innerHTML = "(0) sản phẩm"
    }
}