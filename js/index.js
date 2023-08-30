window.addEventListener("DOMContentLoaded", (event) => {
    filter = document.getElementById("filter-dropdown");
    if (filter) {
        filter.addEventListener('click', dropdown);

    }



});

function dropdown() {
    filter = document.getElementById("filter-dropdown-menu");
    icon = document.getElementById("filter-dropdown");
    if (filter.classList.contains("hidden")) {
        filter.classList.remove("hidden");
        icon.classList.add("active");

    } else {
        filter.classList.add("hidden");
        icon.classList.remove("active");

    }
}



fetch("./product.json")
    .then(response => {
        return response.json();
    })
    .then(jsondata => {
        for (let i = 0; i < jsondata.length; i++) {
            var target = document.getElementById('product');
            var str = '<div id="' + jsondata[i].id + '" onclick="productdetail(' + jsondata[i].id + ')" class="product-wraper"><img class="product-img" src="' + jsondata[i].img + '"/><p class="product-brand">' + jsondata[i].brand + '</p><p class="product-description">' + jsondata[i].name + '</p><p class="product-price">' + Number(jsondata[i].price).toLocaleString('en-GB') + ' đ</p><div class="flex"><p class="product-afterdiscount">' + jsondata[i].afterdiscount + '</p><p class="product-discountpecent">' + jsondata[i].discountpecent + '</p></div></div>';

            var temp = document.createElement('div');
            temp.innerHTML = str;
            while (temp.firstChild) {
                target.appendChild(temp.firstChild);
            }
        }
    }
    );

function productdetail(val) {
    url = "page/product-detail.php?id="+val;
    document.location.href = url;
}