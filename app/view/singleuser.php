<div class="user-content">

    <div class="headline">
        <h1>User Details</h1>
    </div>
    <div class="user-container">
    </div>

</div>

<script>
    const userContainer = document.querySelector(".user-container");
    const hashValue = window.location.hash.substr(1);
    const userFormData = new FormData();
    userFormData.append("user_id", hashValue);
    userFormData.append("get_single_user", true);
    fetch("./api.php", {
        method: "post", 
        body: userFormData
    })
    .then(res=>res.json())
    .then(data=>{
        userContainer.insertAdjacentHTML('afterbegin', singleUserMarkup(data))
    })
    .catch(err=>showSnackbar(err));

    const singleUserMarkup = (data) => {
        return `
        <div class="user-tile">
            <h3>Username:</h3>
            <span>${data.username}</span>
        </div>
        <div class="user-tile">
            <h3>Status:</h3>
            <span>${data.status}</span>
        </div>
        <div class="user-tile">
            <h3>Role:</h3>
            <span>${data.role}
        </div>
        ${customerMarkup(data)}
        `;
    }

    const customerMarkup = (data) => {
        if(data.role == "customer"){
            return `
                <div class="user-tile">
                    <h3>Name:</h3>
                    <span>${data.name}
                </div>
                <div class="user-tile">
                    <h3>Gender:</h3>
                    <span>${data.gender}
                </div>
                <div class="user-tile">
                    <h3>Email:</h3>
                    <span>${data.email}
                </div>
                <div class="user-tile">
                    <h3>Phone:</h3>
                    <span>${data.phone}
                </div>
        `
        }
        else {
            return '';
        }

    }

</script>