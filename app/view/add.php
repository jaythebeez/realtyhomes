<?php

if($_SESSION['role'] != 'agent') {
    header('Location: /realtyhomes/app/');
}

?>


<div class="main-content">
    <h1>Add Property</h1>
    <form name="add-form" class="add-form" id="addForm" enctype="multipart/form-data" method="POST">
        <div class="form_container">
            <label for="title" class="form_label" >Desc:</label>
            <input type="text" class="form_input" name="title" id="title"required>
            <label for="category"  class="form_label">Category:</label>
            <select name="category" class="form_input" id="category-select" required>
                <option value="123456">House</option>
                <option value="234567">Land</option>
            </select>
            <div class="house-selected">
                <label for="furnished" class="form_label" >Furnished:</label>
                <select name="furnished" class="form_input">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <label for="rooms" class="form_label">No of Rooms</label>
                <input type="number" name="rooms" class="form_input">
            </div>
            <label for="state" class="form_label">State:</label>
            <select name="state" class="states form_input" id="state" required></select>
            <label for="city" class="form_label">City:</label>
            <select name="city" class="city form_input" id="city" required></select>
            <label for="price" class="form_label">Market price:</label>
            <input name="price" class="form_input" id="price" type="number" required>
            <label for="address" class="form_label">Address:</label>
            <input name="address" class="form_input" id="address" required>
            <label for="image" class="form_label">Add Image: </label>
            <input type="file" name="image" id="image">
            <input type="hidden" name="add">
            <button class="form_button">Add Property</button>
        </div>
    </form>
</div>