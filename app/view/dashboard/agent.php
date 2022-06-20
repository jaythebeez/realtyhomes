<div class="headline">
    <h1>Agent</h1>
</div>

<div class="dashboard-container">

    <div class="search-bid dashboard-tile">
        <form class="search-bid-form">
            <div class="form_container">
                <h3>Search Bids</h3>
                <label class="form_label">My Properties: </label>
                <select name="property" class="form_input" id="prop-select">
                    <option value="">All</option>
                </select>
                <label class="form_label">Status</label>
                <select name="status" class="form_input" id="">
                    <option value="all">All</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
                    <option value="accepted">Accepted</option>
                    <option value="approved">Approved</option>
                </select>
                <input type="hidden" name="search_bid">
                <button class="form_button" >Search Bids</button>
            </div>
        </form>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h3>Bids Table</h3>
        </div>
        <div class="table-content">
            <table id="bids-table" class="feedback-table dashboard-table">
                <tr>
                    <th>Username</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </table>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h3>My Properties</h3>
        </div>
        <div class="table-content">
            <table id="props-table" class="feedback-table dashboard-table"></table>
        </div>
    </div>

</div>