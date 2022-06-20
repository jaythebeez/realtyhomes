<div class="main-content">
    <div class="property-container">
        
    </div>
</div>

<script>
    const propertyConatiner = document.querySelector(".property-container");
    const hashValue = window.location.hash.substr(1);
    console.log(hashValue);
    const propFormData = new FormData();
    propFormData.append("property_id", hashValue);
    propFormData.append("get_single_property", true);
    fetch("./api.php", {
        method: "post", 
        body: propFormData
    })
    .then(res=>res.json())
    .then(data=>{
        console.log(data);
        propertyConatiner.innerHTML = singlePropsMarkup(data);
    })
    .catch(err=>console.log(err));



    const singlePropsMarkup = (data) => {
    const markup = 
    `<div class="property-card">
        <div class="property-image">
            <img src="${data.image_path}" alt="">
        </div>
        <div class="property-details">
            <h3>${data.title}</h3>
            <div class="property-details">
            <span class="property-details-title">city: </span> <span class="property-details-value">${data.city}</span><br/>
            <span class="property-details-title">state: </span> <span class="property-details-value">${data.state}</span><br/>
            <span class="property-details-title">address: </span> <span class="property-details-value">${data.address}</span><br/>
            <span class="property-details-title">market price: </span><span class="property-details-value">${data.market_price}</span><br/>
            <span class="property-details-title">No of Rooms: </span><span class="property-details-value">${data.total_room}</span><br/>
            <span class="property-details-title">Furnished: </span><span class="property-details-value">${data.furnished}</span><br/>
            </div>
        </div>
    </div>`
    return markup;
}
</script>