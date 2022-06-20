<div class="headline">
    <h1>Administrator</h1>
</div>

<div class="dashboard-container">
    <div class="add-agent dashboard-tile">
        <form class="add-agent-form">
            <div class="form_container">
                <h3>Add Agent</h3>
                <label class="form_label">Username:</label>
                <input class="form_input" type="text" name="username" required pattern="[a-zA-Z0-9]{8,}$" title="At least 8 characters" />
                <label class="form_label">Password:</label>
                <input class="form_input" type="password" name="password" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="Password must be atleast 8 letter contain a number and a letter"/>
                <input type="hidden" name="add_agent">
                <button class="form_button" >Add Agent</button>
            </div>
        </form>
    </div>

    <div class="user-list dashboard-tile">
        <form class="manage-users">
            <div class="form_container">
                <h3>Manage Users</h3>
                <label class="form_label">Username:</label>
                <input class="form_input" type="text" name="username" required maxlength="10" />
                <input type="hidden" name="manage_users">
                <button class="form_button" >Find User</button>
            </div>
        </form>
    </div>

    <div class="table-container">
        <div class="table-content">
            <table id="user-table" class="dashboard-table"></table>
        </div>
    </div>

    <div class="dashboard-tile">
        <form class="add-news">
            <div class="form_container">
                <h3>Add News</h3>
                <label class="form_label" for="news">News: </label>
                <input class="form_input" type="text" name="news" id="news" required maxlength="100" />
                <input type="hidden" name="add_news">
                <button class="form_button" >Post News</button>
            </div>
        </form>
    </div>
    <div class="dashboard-tile">
        <form class="search-news">
            <div class="form_container">
                <h3>Search News</h3>
                <label class="form_label" for="news">News: </label>
                <input class="form_input" type="text" name="news" id="news" maxlength="10" />
                <input type="hidden" name="search_news">
                <button class="form_button" >Search News</button>
            </div>
        </form>
    </div>

    <div class="table-container">
        <div class="table-content">
            <table id="news-table" class="news-table dashboard-table"></table>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h3>Bids For Approval</h3>
        </div>
        <div class="table-content">
        <table id="bids-approval-table"  class="feedback-table dashboard-table">
            <tr>
                <th>Agent</th>
                <th>Customer</th>
                <th>Property</th>
                <th>Market Price</th>
                <th>Accepted Price</th>
                <th>Action</th>
            </tr>
        </table>
        </div>
    </div>
    
</div>