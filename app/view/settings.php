<div class="settings-content">
    <div class="headline">
        <h1>Settings</h1>
    </div>

    <div class="settings-container">
        <div class="dashboard-tile">
            <form id="change-password-form">
                <div class="form_container">
                    <h3>Change Password</h3>
                    <label class="form_label">New Password:</label>
                    <input class="form_input" type="password" name="password" id="password1" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="Password must be atleast 8 letter contain a number and a letter"/>
                    <label class="form_label">Confirm Password:</label>
                    <input class="form_input" type="password" name="password2" id="password2" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="Password must be atleast 8 letter contain a number and a letter"/>
                    <input type="hidden" name="change_password">
                    <button class="form_button" >Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const passwordForm = document.querySelector("#change-password-form");
    passwordForm.addEventListener('submit', (e)=>{
        e.preventDefault();
        let password1 = document.querySelector("#password1").value;
        let password2 = document.querySelector("#password2").value;
        if (password1 !== password2) {
            return showSnackbar("Passwords do not match");
        }
        const passwordData = new FormData(e.target);
        passwordData.append("change_password", true);
        fetch("./api.php", {
            method:"post",
            body: passwordData
        })
        .then(res=>res.json())
        .then(data=>{
            if(data.error) {
                throw new Error(data.error);
            }
            showSnackbar(data.success);
        })
        .catch(err=>{
            showSnackbar(data.error);
        })
        
    })
</script>