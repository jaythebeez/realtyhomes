
<div class="search-container">
    <form id="searchForm">
        <div class="search">
            <div class="filter-button"><img src="./assets/icons/filter.svg"></div>
            <input type="text" class="search-bar" placeholder="Search keywords" name="keyword">
            <input type="submit" class="search-btn" value="submit">
            <div id="filterModal">
                <div class="contents">
                    <div>
                        <label for="max" class="form_label">Max Price:</label>
                        <input type="range" name="max" min="0" max="1000000000" step="5000000" value="1000000000" oninput="this.nextElementSibling.value = this.value">
                        <output>1000000000</output>
                    </div>
                    <div>
                        <label for="category" class="form_label">Category:</label>
                        <input type="radio" name="category_id" value="234567">
                        <label>Land</label>
                        <input type="radio" name="category_id" value="123456">
                        <label>House</label>
                    </div>
                    <div>
                        <label for="states" class="form_label" >State</label>
                        <select name="states" id="stateSelect" class="state">
                            <option value="none" selected>-none-</option>
                        </select>
                        <label for="city" class="form_label" >City</label>
                        <select name="city" id="stateSelect" class="city">
                            <option value="none" selected>-none-</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="main-content">
    <div class="properties-container">
        
    </div>
</div>
